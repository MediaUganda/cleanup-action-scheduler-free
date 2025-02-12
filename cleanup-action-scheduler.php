<?php

/**
 * Plugin Name:       Cleanup Action Scheduler
 * Plugin URI:        https://mediauganda.com/software/cleanup-action-scheduler
 * Description:       Cleanup rows of Action Scheduler or Woocommerce data recorded in your Database.
 * Author:            Media Uganda
 * Author URI:        https://mediauganda.com/
 * Version:           1.2.4
 * Text Domain:       cleanup-action-scheduler
 * Requires at least: 4.9
 * Requires PHP:      7.4
 * Tested up to:      6.7.1
 * 
 * @package Cleanup_Action_Scheduler
 */
// If this file is called firectly, abort!!!
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'cfas_fs' ) ) {
	cfas_fs()->set_basename( false, __FILE__ );
} else {
	
	if ( !function_exists( 'cfas_fs' ) ) {
		/**
		 * Create a helper function for easy SDK access.
		 *
		 * @return void
		 */
		function cfas_fs() {
			global  $cfas_fs ;
			if ( !isset( $cfas_fs ) ) {
				require_once dirname( __FILE__ ) . '/freemius/start.php';
                $cfas_fs = fs_dynamic_init( array(
                    'id'                  => '10041',
                    'slug'                => 'cleanup-action-scheduler',
                    'premium_slug'        => 'clean-action-scheduler-premium',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_ebc105f54c24fca14c71b712a565b',
                    'is_premium'          => true,
                    // If your plugin is a serviceware, set this option to false.
                    'has_premium_version' => true,
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'has_affiliation'     => 'selected',
                    'menu'                => array(
                        'slug'           => 'cleanup-as-plugin',
                        'first-path'     => 'tools.php?page=cleanup-as-plugin',
                        'support'        => false,
                        'parent'         => array(
                            'slug' => 'tools.php',
                        ),
                    ),
                ) );
			}
			return $cfas_fs;
		}

		cfas_fs();

		do_action( 'cfas_fs_loaded' );

		// Require once the Composer Autoload.
		if ( file_exists( dirname( __FILE__ ) . '/lib/autoload.php' ) ) {
			include_once dirname( __FILE__ ) . '/lib/autoload.php';
		}

		/**
		 * The code that runs during plugin activation.
		 *
		 * @return void
		 */
		function cleanup_action_scheduler_activate_plugin()
		{
			Cleanup_Action_Scheduler\Base\Activate::activate();
		}
		
		register_activation_hook( __FILE__, 'cleanup_action_scheduler_activate_plugin' );
		/**
		 * The code that runs during plugin deactivation.
		 *
		 * @return void
		 */
		function cleanup_action_scheduler_deactivate_plugin()
		{
			Cleanup_Action_Scheduler\Base\Deactivate::deactivate();
		}
		
		register_deactivation_hook( __FILE__, 'cleanup_action_scheduler_deactivate_plugin' );
		/**
		 * Initialize all the core classes of the plugin.
		 */
		if ( class_exists( 'Cleanup_Action_Scheduler\\Init' ) ) {
			Cleanup_Action_Scheduler\Init::register_services();
		}
	}

}

cfas_fs()->add_filter( 'pricing/show_annual_in_monthly', '__return_false' );