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
}
