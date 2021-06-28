<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class RegisterRestRoute
{
    private $taxonomies = array( 'post', 'service', 'tourism' );
  
    public function register() {
        add_action( 'rest_api_init', array( $this, 'registerCallback') );
    }

    public function registerCallback() {
        register_rest_route( 'wp/v2', '/all-posts/(?P<lang>[a-zA-Z0-9-]+)', array(
            // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
            'methods'  => \WP_REST_Server::READABLE,
            'callback' => array( $this, 'custom_api_get_all_posts_callback' )
        ) );
    }    

    public function custom_api_get_all_posts_callback( $request ) {
        // Initialize the array that will receive the posts' data. 
        $posts_data = array();
     
        $locale = $request['lang'];
        if ( $locale == 'default' ) {
            $locale = '';
        }

        // Get the posts using the 'post' and 'news' post types
        $posts = get_posts( array(
                'post_type' => $this->taxonomies,
                'lang' => $locale,
                'posts_per_page' => 1000            
            )
        ); 

        // Loop through the posts and push the desired data to the array we've initialized earlier in the form of an object
        foreach( $posts as $post ) {
            $posts_data[] = $post->post_title;
        }                  
        return rest_ensure_response( $posts_data );                   
    } 
}