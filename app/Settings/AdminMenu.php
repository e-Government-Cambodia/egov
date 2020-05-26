<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class AdminMenu
{
    public function register() {
        // add_action( 'admin_menu', array( $this, 'registerAdminMenu') );
    }

    public function registerAdminMenu( $args, $post_type ) {
        add_menu_page( 'Template', 'Template', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
    }    
}