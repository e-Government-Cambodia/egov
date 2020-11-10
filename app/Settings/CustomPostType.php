<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class CustomPostType
{
    public function register() {
        add_action( 'init', array( $this, 'registerCustomPostype') );
        // Display archive for author
        add_action( 'pre_get_posts', array( $this, 'addCPTAuthor') );

        // Add custom post type wp_block capability args
        add_filter( 'register_post_type_args', array( $this, 'registerPostTypeArgs' ), 10, 2 );
    }

    public function registerPostTypeArgs( $args, $post_type ) {
        
        if ( $post_type == 'wp_block' ) {
            $args['capability_type'] = 'wp_block';
            $cap = array(
                'read' => 'edit_wp_blocks',
                'create_posts' => 'publish_wp_blocks',
                'edit_posts' => 'edit_wp_blocks',
                'edit_published_posts' => 'edit_published_wp_blocks',
                'delete_published_posts' => 'delete_published_wp_blocks',
                'edit_others_posts' => 'edit_others_wp_blocks',
                'delete_others_posts' => 'delete_others_wp_blocks'
            );
            $args['capabilities'] = $cap;
        }
     
        return $args;
    }

    public function addCPTAuthor( $query ) {
        if ( !is_admin() && $query->is_author() && $query->is_main_query() ) {
            $query->set( 'post_type', array( 'post', 'service', 'tourism' ) );
        }
    }

    public function registerCustomPostype() {
        $args = array(

            /**
             * (string) Name of the post type shown in the menu. Usually plural. 
             * Default is value of $labels['name'].
             */
            'label' => __( 'Tourism', 'egov' ), 
            
            /**
             * (array) An array of labels for this post type. 
             * If not set, post labels are inherited for non-hierarchical types and page labels for hierarchical ones. 
             * See get_post_type_labels() for a full list of supported labels.
             */
            // 'labels' => array(), 
            
            /**
             * (string) A short descriptive summary of what the post type is.
             */
            'description' => __( 'This post type is create for display tourism sector each provincial and type in Cambodia.', 'egov' ), 
            
            /**
             * (bool) Whether a post type is intended for use publicly either via the admin interface or by front-end users. 
             * While the default settings of $exclude_from_search, $publicly_queryable, $show_ui, 
             * and $show_in_nav_menus are inherited from public, each does not rely on this relationship and controls a very specific intention. 
             * Default false.
             */
            'public' => true, 
            
            /**
             * (bool) Whether the post type is hierarchical (e.g. page). Default false.
             */
            'hierarchical' => true, 
            
            /**
             * (bool) Whether to exclude posts with this post type from front end search results. 
             * Default is the opposite value of $public.
             */
            'exclude_from_search' => false,
            
            /**
             * (bool) Whether queries can be performed on the front end for the post type as part of parse_request(). 
             * Endpoints would include:
            * ?post_type={post_type_key}
            * ?{post_type_key}={single_post_slug}
            * ?{post_type_query_var}={single_post_slug} If not set, the default is inherited from $public.
             */
            'publicly_queryable' => true,
            
            /**
             * (bool) Whether to generate and allow a UI for managing this post type in the admin. 
             * Default is value of $public. 
             */
            'show_ui' => true,
            
            /**
             * (bool|string) Where to show the post type in the admin menu. 
             * To work, $show_ui must be true. 
             * If true, the post type is shown in its own top level menu. 
             * If false, no menu is shown. If a string of an existing top level menu (eg. 'tools.php' or 'edit.php?post_type=page'), 
             * the post type will be placed as a sub-menu of that. 
             * Default is value of $show_ui.
             */
            'show_in_menu' => true,
            
            /**
             * (bool) Makes this post type available for selection in navigation menus. 
             * Default is value of $public.
             */
            'show_in_nav_menus' => true, 
            
            /**
             * (bool) Makes this post type available via the admin bar. 
             * Default is value of $show_in_menu.
             */
            'show_in_admin_bar' => true,
            
            /**
             * (bool) Whether to include the post type in the REST API. 
             * Set this to true for the post type to be available in the block editor.
             */
            'show_in_rest' => true,
            
            /**
             * (string) To change the base url of REST API route. 
             * Default is $post_type.
             */
            'rest_base' => 'tourism',
            
            /**
             * (string) REST API Controller class name. 
             * Default is 'WP_REST_Posts_Controller'.
             */
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            
            /**
             * (int) The position in the menu order the post type should appear. 
             * To work, $show_in_menu must be true. Default null (at the bottom).
             */
            // 'menu_position' => null,

            /**
             * https://developer.wordpress.org/resource/dashicons/
             */
            'menu_icon' => 'dashicons-admin-page', 
            
            /**
             * (string) The string to use to build the read, edit, and delete capabilities. 
             * May be passed as an array to allow for alternative plurals when using this argument as a base to construct the capabilities, 
             * e.g. array('story', 'stories'). 
             * Default 'post'.
             */
            'capability_type' => 'tourism', 

            /**
             * (array) Array of capabilities for this post type. 
             * $capability_type is used as a base to construct capabilities by default. 
             * See get_post_type_capabilities().
             */
            // 'capability' => array(), 
            
            /**
             * (bool) Whether to use the internal default meta capability handling. 
             * Default false.
             */
            'map_meta_cap' => true,
            
            /**
             * Example: array( 'my_feature', array( 'field' => 'value' ) ). 
             * Default is an array containing 'title' and 'editor'.
             */
            'supports' => array( 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'thumbnail', 'custom-fields', 'post-formats' ),

            /**
             * (callable) Provide a callback function that sets up the meta boxes for the edit form. 
             * Do remove_meta_box() and add_meta_box() calls in the callback. 
             * Default null.
             */
            // 'register_meta_box_cb' => array( $this, 'function' ),
            
            /**
             * (array) An array of taxonomy identifiers that will be registered for the post type. 
             * Taxonomies can be registered later with register_taxonomy() or register_taxonomy_for_object_type().
             */
            'taxonomies' => array( 'tourism-type' ),
            
            /**
             * (bool|string) Whether there should be post type archives, or if a string, the archive slug to use. 
             * Will generate the proper rewrite rules if $rewrite is enabled. 
             * Default false.
             */
            'has_archive' => false,
            
            /**
             * (bool|array) Triggers the handling of rewrites for this post type. 
             * To prevent rewrite, set to false. Defaults to true, using $post_type as slug. 
             * To specify rewrite rules, an array can be passed with any of these keys:
             */            
            'rewrite' => true,
            
            /**
             * (string) Customize the permastruct slug. 
             * Defaults to $post_type key.
             */
            'slug' => 'tourism',
            
            /**
             * (bool) Whether the permastruct should be prepended with WP_Rewrite::$front. 
             * Default true.
             */
            'with_front' => true,
            
            /**
             * (bool) Whether the feed permastruct should be built for this post type. 
             * Default is value of $has_archive.
             */
            'feeds' => true,
            
            /**
             * (bool) Whether the permastruct should provide for pagination. 
             * Default true.
             */
            'pages' => true,
            
            /**
             * (const) Endpoint mask to assign. 
             * If not specified and permalink_epmask is set, inherits from $permalink_epmask. 
             * If not specified and permalink_epmask is not set, defaults to EP_PERMALINK.
             */
            'ep_mask' => EP_PERMALINK,
                
            /**
             * (string|bool) Sets the query_var key for this post type. 
             * Defaults to $post_type key. If false, a post type cannot be loaded at ?{query_var}={post_slug}. 
             * If specified as a string, the query ?{query_var_string}={post_slug} will be valid.
             */
            'query_var' => 'tourism',
            
            /**
             * (bool) Whether to allow this post type to be exported. 
             * Default true.
             */
            'can_export' => true,
            
            /**
             * (bool) Whether to delete posts of this type when deleting a user. 
             * If true, posts of this type belonging to the user will be moved to Trash when then user is deleted. 
             * If false, posts of this type belonging to the user will *not* be trashed or deleted. 
             * If not set (the default), posts are trashed if post_type_supports('author'). 
             * Otherwise posts are not trashed or deleted. Default null.
             */
            // 'delete_with_user' => null,

            /**
             * (bool) FOR INTERNAL USE ONLY! True if this post type is a native or "built-in" post_type. 
             * Default false.
             */
            '_builtin' => false,

            /**
             * (string) FOR INTERNAL USE ONLY! URL segment to use for edit link of this post type. 
             * Default 'post.php?post=%d'.
             */
            // '_edit_link' => 'post.php?post=%d',
        );
        // (string) (Required) Post type key. Must not exceed 20 characters and may only contain lowercase alphanumeric characters, dashes, and underscores
        register_post_type( 'tourism', $args );

        $args = array(

            /**
             * (string) Name of the post type shown in the menu. Usually plural. 
             * Default is value of $labels['name'].
             */
            'label' => __( 'Service', 'egov' ), 
            
            /**
             * (array) An array of labels for this post type. 
             * If not set, post labels are inherited for non-hierarchical types and page labels for hierarchical ones. 
             * See get_post_type_labels() for a full list of supported labels.
             */
            // 'labels' => array(), 
            
            /**
             * (string) A short descriptive summary of what the post type is.
             */
            'description' => __( 'This post type is create for display government service of Cambodia.', 'egov' ), 
            
            /**
             * (bool) Whether a post type is intended for use publicly either via the admin interface or by front-end users. 
             * While the default settings of $exclude_from_search, $publicly_queryable, $show_ui, 
             * and $show_in_nav_menus are inherited from public, each does not rely on this relationship and controls a very specific intention. 
             * Default false.
             */
            'public' => true, 
            
            /**
             * (bool) Whether the post type is hierarchical (e.g. page). Default false.
             */
            'hierarchical' => true, 
            
            /**
             * (bool) Whether to exclude posts with this post type from front end search results. 
             * Default is the opposite value of $public.
             */
            'exclude_from_search' => false,
            
            /**
             * (bool) Whether queries can be performed on the front end for the post type as part of parse_request(). 
             * Endpoints would include:
            * ?post_type={post_type_key}
            * ?{post_type_key}={single_post_slug}
            * ?{post_type_query_var}={single_post_slug} If not set, the default is inherited from $public.
             */
            'publicly_queryable' => true,
            
            /**
             * (bool) Whether to generate and allow a UI for managing this post type in the admin. 
             * Default is value of $public. 
             */
            'show_ui' => true,
            
            /**
             * (bool|string) Where to show the post type in the admin menu. 
             * To work, $show_ui must be true. 
             * If true, the post type is shown in its own top level menu. 
             * If false, no menu is shown. If a string of an existing top level menu (eg. 'tools.php' or 'edit.php?post_type=page'), 
             * the post type will be placed as a sub-menu of that. 
             * Default is value of $show_ui.
             */
            'show_in_menu' => true,
            
            /**
             * (bool) Makes this post type available for selection in navigation menus. 
             * Default is value of $public.
             */
            'show_in_nav_menus' => true, 
            
            /**
             * (bool) Makes this post type available via the admin bar. 
             * Default is value of $show_in_menu.
             */
            'show_in_admin_bar' => true,
            
            /**
             * (bool) Whether to include the post type in the REST API. 
             * Set this to true for the post type to be available in the block editor.
             */
            'show_in_rest' => true,
            
            /**
             * (string) To change the base url of REST API route. 
             * Default is $post_type.
             */
            'rest_base' => 'service',
            
            /**
             * (string) REST API Controller class name. 
             * Default is 'WP_REST_Posts_Controller'.
             */
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            
            /**
             * (int) The position in the menu order the post type should appear. 
             * To work, $show_in_menu must be true. Default null (at the bottom).
             */
            // 'menu_position' => null,

            /**
             * https://developer.wordpress.org/resource/dashicons/
             */
            'menu_icon' => 'dashicons-admin-page', 
            
            /**
             * (string) The string to use to build the read, edit, and delete capabilities. 
             * May be passed as an array to allow for alternative plurals when using this argument as a base to construct the capabilities, 
             * e.g. array('story', 'stories'). 
             * Default 'post'.
             */
            'capability_type' => 'service', 

            /**
             * (array) Array of capabilities for this post type. 
             * $capability_type is used as a base to construct capabilities by default. 
             * See get_post_type_capabilities().
             */
            // 'capability' => array(), 
            
            /**
             * (bool) Whether to use the internal default meta capability handling. 
             * Default false.
             */
            'map_meta_cap' => true,
            
            /**
             * Example: array( 'my_feature', array( 'field' => 'value' ) ). 
             * Default is an array containing 'title' and 'editor'.
             */
            'supports' => array( 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'thumbnail', 'custom-fields', 'post-formats' ),

            /**
             * (callable) Provide a callback function that sets up the meta boxes for the edit form. 
             * Do remove_meta_box() and add_meta_box() calls in the callback. 
             * Default null.
             */
            // 'register_meta_box_cb' => array( $this, 'function' ),
            
            /**
             * (array) An array of taxonomy identifiers that will be registered for the post type. 
             * Taxonomies can be registered later with register_taxonomy() or register_taxonomy_for_object_type().
             */
            'taxonomies' => array( 'service-for, service-topic, service-i-want-to' ),
            
            /**
             * (bool|string) Whether there should be post type archives, or if a string, the archive slug to use. 
             * Will generate the proper rewrite rules if $rewrite is enabled. 
             * Default false.
             */
            'has_archive' => false,
            
            /**
             * (bool|array) Triggers the handling of rewrites for this post type. 
             * To prevent rewrite, set to false. Defaults to true, using $post_type as slug. 
             * To specify rewrite rules, an array can be passed with any of these keys:
             */            
            'rewrite' => true,
            
            /**
             * (string) Customize the permastruct slug. 
             * Defaults to $post_type key.
             */
            'slug' => 'service',
            
            /**
             * (bool) Whether the permastruct should be prepended with WP_Rewrite::$front. 
             * Default true.
             */
            'with_front' => false,
            
            /**
             * (bool) Whether the feed permastruct should be built for this post type. 
             * Default is value of $has_archive.
             */
            'feeds' => true,
            
            /**
             * (bool) Whether the permastruct should provide for pagination. 
             * Default true.
             */
            'pages' => true,
            
            /**
             * (const) Endpoint mask to assign. 
             * If not specified and permalink_epmask is set, inherits from $permalink_epmask. 
             * If not specified and permalink_epmask is not set, defaults to EP_PERMALINK.
             */
            'ep_mask' => EP_PERMALINK,
                
            /**
             * (string|bool) Sets the query_var key for this post type. 
             * Defaults to $post_type key. If false, a post type cannot be loaded at ?{query_var}={post_slug}. 
             * If specified as a string, the query ?{query_var_string}={post_slug} will be valid.
             */
            'query_var' => true,
            
            /**
             * (bool) Whether to allow this post type to be exported. 
             * Default true.
             */
            'can_export' => true,
            
            /**
             * (bool) Whether to delete posts of this type when deleting a user. 
             * If true, posts of this type belonging to the user will be moved to Trash when then user is deleted. 
             * If false, posts of this type belonging to the user will *not* be trashed or deleted. 
             * If not set (the default), posts are trashed if post_type_supports('author'). 
             * Otherwise posts are not trashed or deleted. Default null.
             */
            // 'delete_with_user' => null,

            /**
             * (bool) FOR INTERNAL USE ONLY! True if this post type is a native or "built-in" post_type. 
             * Default false.
             */
            '_builtin' => false,

            /**
             * (string) FOR INTERNAL USE ONLY! URL segment to use for edit link of this post type. 
             * Default 'post.php?post=%d'.
             */
            // '_edit_link' => 'post.php?post=%d',
        );
        // (string) (Required) Post type key. Must not exceed 20 characters and may only contain lowercase alphanumeric characters, dashes, and underscores
        register_post_type( 'service', $args );
    }    

}