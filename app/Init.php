<?php
/**
 * @package EgovBlock
 */

namespace App;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Init
{
    function __construct() {

    }

    public static function getServices() {
        return array(
            Settings\CMB2::class,
            Settings\CustomPostType::class,
            Settings\CustomTaxonomy::class,
            Settings\RegisterNavMenu::class,
            Settings\CustomizeLogo::class,
            Settings\RegisterSidebar::class,
            Settings\AdminMenu::class,
            Settings\WalkerTerm::class,
            Settings\PostViewCount::class,
            Settings\RegisterRestRoute::class,
            Settings\FilterPostTypeByTaxonomy::class
           
        );
    }

    public static function registerServices() {
        foreach( self::getServices() as $class ) {
            $service = self::instantiate( $class );
            if( method_exists( $service, "register" ) ) {
                $service->register();
            }
        }
    }

    private static function instantiate( $class ) {
        $service = new $class();
        return $service;
    }
}