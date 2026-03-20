<?php
/**
 * Admin-area hooks (Site Editor migration, notices).
 *
 * @package Origamiez
 */

namespace Origamiez\Hooks\Hooks;

use Origamiez\Hooks\HookProviderInterface;
use Origamiez\Hooks\HookRegistry;
use Origamiez\Migration\GlobalStylesCustomizerMigrator;

/**
 * Class AdminHooks
 */
class AdminHooks implements HookProviderInterface {

	/**
	 * Register.
	 *
	 * @param HookRegistry $registry The registry.
	 *
	 * @return void
	 */
	public function register( HookRegistry $registry ): void {
		$registry
			->add_action( 'admin_init', array( $this, 'maybe_migrate_global_styles' ), 30 )
			->add_action( 'admin_notices', array( $this, 'global_styles_migration_admin_notice' ) );
	}

	/**
	 * One-shot Customizer → user global styles migration (WordPress 5.9+).
	 *
	 * @return void
	 */
	public function maybe_migrate_global_styles(): void {
		$migrator = new GlobalStylesCustomizerMigrator();
		$migrator->maybe_migrate();
	}

	/**
	 * Surface migration failures to admins (shown once per error string).
	 *
	 * @return void
	 */
	public function global_styles_migration_admin_notice(): void {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		$error = get_option( GlobalStylesCustomizerMigrator::ERROR_OPTION_KEY );
		if ( ! is_string( $error ) || '' === $error ) {
			return;
		}
		printf(
			'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
			esc_html( $error )
		);
		delete_option( GlobalStylesCustomizerMigrator::ERROR_OPTION_KEY );
	}
}
