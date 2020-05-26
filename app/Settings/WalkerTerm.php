<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class WalkerTerm
{
    public function register() {
        // add_filter( 'wp_terms_checklist_args', array( $this, 'callBackFunction') );
    }

    public function callBackFunction( $defaults ) {
        $defaults = array(
            'descendants_and_self' => 0,
            'selected_cats'        => false,
            'popular_cats'         => false,
            'walker'               => null,
            'taxonomy'             => 'service-group',
            'checked_ontop'        => false,
            'echo'                 => false,
        );
        return $defaults;
    }   

      
}