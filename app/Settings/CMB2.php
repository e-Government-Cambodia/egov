<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class CMB2
{
    public function register() {
        // add_action( 'cmb2_admin_init', array( $this, 'registerCMB2' ) );
    }

    public function registerCMB2() {
       
        $prefix = 'yourprefix_term_';

        /**
         * Metabox to add fields to categories and tags
         */
        $cmb_term = new_cmb2_box( array(
            'id'               => $prefix . 'edit',
            'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
            'object_types'     => array( 'post' ), // Tells CMB2 to use term_meta vs post_meta
            'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
            // 'new_term_section' => true, // Will display in the "Add New Category" section
        ) );

        $cmb_term->add_field( array(
            'name'     => esc_html__( 'Extra Info', 'cmb2' ),
            'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
            'id'       => $prefix . 'extra_info',
            'type'     => 'title',
            'on_front' => false,
        ) );

        $cmb_term->add_field( array(
            'name' => esc_html__( 'Term Image', 'cmb2' ),
            'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
            'id'   => $prefix . 'avatar',
            'type' => 'file',
        ) );

        $cmb_term->add_field( array(
            'name' => esc_html__( 'Arbitrary Term Field', 'cmb2' ),
            'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
            'id'   => $prefix . 'term_text_field',
            'type' => 'text',
        ) );

    }    

    
}
