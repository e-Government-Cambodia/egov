<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class FilterPostTypeByTaxonomy
{
    public function register() {
        add_action( 'restrict_manage_posts', array( $this, 'callBackFunction'), 99, 2 );
    }

    public function callBackFunction( $post_type, $which ) {
        // Apply this to a specific CPT
        if ( 'service' !== $post_type )
        return;

        // A list of custom taxonomy slugs to filter by
        $taxonomies = array( 'service-topic' );

        foreach ( $taxonomies as $taxonomy_slug ) {

        // Retrieve taxonomy data
        $taxonomy_obj = get_taxonomy( $taxonomy_slug );
        $taxonomy_name = $taxonomy_obj->labels->name;

        // Retrieve taxonomy terms
        $terms = get_terms( array( 'taxonomy' => $taxonomy_slug, 'hierarchical' => true ) );

        // Display filter HTML
        echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
        echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'egov' ), $taxonomy_name ) . '</option>';
        echo $this->getHierachy( $terms );
        echo '</select>';
        }
    } 
    
    private function getHierachy( array $terms, $parent = 0, $tab = '' ) {
        $hierachy = '';
        $space = '';
        foreach ( $terms as $term ) {
            if ( $term->parent == $parent ) {
                $hierachy .= '<option value="'.$term->slug.'" '.( ( isset( $_GET[$term->taxonomy] ) && ( $_GET[$term->taxonomy] == $term->slug ) ) ? ' selected="selected"' : '' ).'>'.$space.$term->name.'</option>';
                $hierachy .= $this->getHierachy( $terms, $term->term_id, $space );
            } else {
                $space = '&nbsp;&nbsp;&nbsp;&nbsp;'.$tab;
            }
        }

        return $hierachy;
    }
}