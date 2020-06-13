<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'egov');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'egov'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'egov');
        }
        return get_the_title();
    }

    public static function getPostTerms( string $fields = 'slugs' ) {
        global $post;
        $taxonomies = get_post_taxonomies( $post->ID );
        $terms_id = wp_get_post_terms( $post->ID, $taxonomies, array(
            'fields' => $fields
        ) );
        return $terms_id;
    }

    public static function postViewCount() {
        $post_view_count = get_post_meta( get_the_ID(), 'post_view_count', true );
        
        if( ! $post_view_count ) {
            return 0;
        }

        $value = self::formatKMG( $post_view_count );
        return $value;
    }

    // private static function getHierachy( array $terms, $parent = 0 ) {
    //     $hierachy = array();

    //     foreach ( $terms as $term ) 
    //     {
    //         if ( $term->parent == $parent ) {
    //             $children = App::getHierachy( $terms, $term->term_id );
                
    //             if ( $children ) {
    //                 $term->children = $children;
    //             }
                
    //             array_push( $hierachy, $term );
    //         }
    //     }

    //     return $hierachy;
    // }

    public static function formatKMG( $number ) {
        $number_format = number_format_i18n( $number );
        $exploded = explode( ',', $number_format );
        $count = count( $exploded );

        switch ( $count ) {
            case 2:
                $value = number_format_i18n( $number/1000, 1 ) . __( 'K', 'egov-block' );
                break;
            case 3:
                $value = number_format_i18n( $number/1000000, 1 ) . __( 'M', 'egov-block' );
                break;
            case 4:
                $value = number_format_i18n( $number/1000000000, 1 ) . __( 'G', 'egov-block' );
                break;
            default:
                $value = $number;
        }
        return $value;
    }

    public static function breadCrumb() {
        global $wp_query;
        // dd( $wp_query );
        // dd( get_queried_object() );


        $taxonomies = array(
            'service-for',
            'service-topic',
            'service-i-want-to',
            'category',
            'post_tag',
            'tourism-type',
            'tourism-location'
        );

        $home_url = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url();
        $home = '<i class="icofont-home"></i>';
        $home = '<a href="'.$home_url.'">'.$home.'</a>';
        $separator = '&nbsp;/&nbsp;';
        switch ( true ) {
            case is_single() :
                $post_terms = wp_get_post_terms( get_the_id(), $taxonomies );
                $post_term_relations = array();
                foreach( $post_terms as $term ) {
                    $last_child = true;
                    // Check if current term is last child that we can get term parents list
                    foreach( $post_terms as $sub_term ) {
                        if ( $term->term_id === $sub_term->parent ) {
                            $last_child = false;
                            break;
                        }
                    }
                    if( $last_child ) {
                        array_push( $post_term_relations, $term );
                    }
                }
                foreach ( $post_term_relations as $key => $value ) {
                    echo '<div>'.$home.$separator.get_term_parents_list( $value->term_id, $value->taxonomy, array( 'separator' => $separator, 'inclusive' => true ) ).'</div>';
                }
                break;
            case is_page() :
                echo 'is_page()';
                break;
            case $wp_query->query_vars_changed :
                $breadcrumb = '';
                $terms = array();
                foreach( $taxonomies as $tax ) {
                    $value =  get_query_var( $tax );
                    if ( $value ) {
                       array_push( $terms, get_term_by( 'slug', $value, $tax ) );
                    }
                }
                foreach( $terms as $term ) {
                    if ( reset( $terms ) == $term ) {
                        $breadcrumb .= '<a href="'.get_term_link( $term->term_id ).'">'.$term->name.'</a>';
                    } else {
                        $breadcrumb .= $separator.'<a href="'.get_term_link( $term->term_id ).'">'.$term->name.'</a>';
                    }
                }
                echo $home.$separator.$breadcrumb;
                break;
            case is_archive() :
                echo $home.$separator.get_term_parents_list( get_queried_object()->term_id, get_queried_object()->taxonomy, array( 'separator' => $separator, 'inclusive' => false ) ).get_queried_object()->name;
                break;
            default:
                echo 'default';
                break;
        }
    }
}
