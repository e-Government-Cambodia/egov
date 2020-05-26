<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class PostViewCount
{
    public function register() {
        add_action( 'wp_head', array( $this, 'callBackFunction') );
        // add_filter( 'egov-meta-value-num', function( $args ) { return 'post-view-count'; } );
    }

    public function callBackFunction() {
        global $post;
        if ( is_singular() ) {
            $meta_key = 'post_view_count';
            (int)$count = get_post_meta( $post->ID, $meta_key, true ) ?: 0;
            if ( ! $count ) {
                add_post_meta( $post->ID, $meta_key, '0' );
            }
            $count ++;
            update_post_meta( $post->ID, $meta_key, $count );
        }
    }    
}
