<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class RegisterNavMenu
{
    public function register() {
        add_action( 'after_setup_theme', array( $this, 'registerMenu') );
    }

    public function registerMenu() {
        register_nav_menu( 'main_menu', __( 'Main Menu', 'egov' ) );
        register_nav_menu( 'footer_menu', __( 'Footer Menu', 'egov' ) );
        register_nav_menu( 'social_menu', __( 'Social Menu', 'egov' ) );
    }    
}