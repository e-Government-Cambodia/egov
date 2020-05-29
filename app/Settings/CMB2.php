<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class CMB2
{
    public function register() {
        add_action( 'cmb2_admin_init', array( $this, 'registerCMB2' ) );
        // Default is egov_service_topic_icon
        add_filter( 'egov_term_meta_key_icon_image', function( $args ) { return 'egov_service_topic_icon'; } );
    }

    public function registerCMB2() {
       
        $prefix = 'egov_service_topic_';

        /**
         * Metabox to add fields to categories and tags
         */
        $cmb = new_cmb2_box( array(
            'id'               => $prefix . 'edit',
            'title'            => esc_html__( 'Service Topic Metabox', 'egov' ),
            'object_types'     => array( 'term' ), 
            'taxonomies'       => array( 'service-topic', 'service-group', 'service-sector' ), 
        ) );

        $cmb->add_field( array(
            'name'    => 'Icon Image',
            'desc'    => 'Upload an image from your computer or brow choosing from media library.',
            'id'      => $prefix . 'icon',
            'type'    => 'file',
            // Optional:
            'options' => array(
                'url' => false, // Hide the text input for the url
            ),
            'text'    => array(
                'add_upload_file_text' => 'Add an Icon Image' // Change upload button text. Default: "Add or Upload File"
            ),
            // query_args are passed to wp.media's library query.
            'query_args' => array(
                // 'type' => 'application/pdf', // Make library only display PDFs.
                // Or only allow gif, jpg, or png images
                'type' => array(
                	'image/gif',
                	'image/jpeg',
                	'image/png',
                ),
            ),
            'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
        ) );

    }    

    
}
