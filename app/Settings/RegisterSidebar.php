<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class RegisterSidebar
{
    public function register() {
        add_action( 'widgets_init', array( $this, 'registerSidebar') );
    }

    public function registerSidebar() {
        $config = array(
            'before_widget' => '<section class="widget %1$s %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        );
        register_sidebar( 
            array(
                'name' => __( 'Primary', 'egov' ),
                'id' => 'sidebar-primary'
            ) + $config
        );
        register_sidebar( 
            array(
                'name' => __('Footer', 'sage'),
                'id' => 'sidebar-footer'
            ) + $config
        );
    }    
}