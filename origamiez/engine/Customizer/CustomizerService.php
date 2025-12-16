<?php
/**
 * Customizer Service
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Customizer;

use Origamiez\Engine\Customizer\Builders\PanelBuilder;
use Origamiez\Engine\Customizer\Builders\SectionBuilder;
use Origamiez\Engine\Customizer\Builders\SettingBuilder;
use Origamiez\Engine\Customizer\Settings\SettingsInterface;
use WP_Customize_Manager;

/**
 * Class CustomizerService
 */
class CustomizerService {

	/**
	 * Panels.
	 *
	 * @var array
	 */
	private array $panels = array();

	/**
	 * Sections.
	 *
	 * @var array
	 */
	private array $sections = array();

	/**
	 * Settings.
	 *
	 * @var array
	 */
	private array $settings = array();

	/**
	 * Modified settings.
	 *
	 * @var array
	 */
	private array $modified_settings = array();

	/**
	 * Settings classes.
	 *
	 * @var array
	 */
	private array $settings_classes = array();

	/**
	 * Register a panel.
	 *
	 * @param string $id The panel ID.
	 * @param array  $args The panel arguments.
	 *
	 * @return self
	 */
	public function register_panel( string $id, array $args ): self {
		$default_args = array(
			'title'       => $id,
			'description' => '',
			'priority'    => 160,
		);

		$args                = array_merge( $default_args, $args );
		$this->panels[ $id ] = $args;

		return $this;
	}

	/**
	 * Register a section.
	 *
	 * @param string $id The section ID.
	 * @param array  $args The section arguments.
	 *
	 * @return self
	 */
	public function register_section( string $id, array $args ): self {
		$default_args = array(
			'title'       => $id,
			'description' => '',
			'panel'       => '',
			'priority'    => 160,
		);

		$args                  = array_merge( $default_args, $args );
		$this->sections[ $id ] = $args;

		return $this;
	}

	/**
	 * Register a setting.
	 *
	 * @param string $id The setting ID.
	 * @param array  $args The setting arguments.
	 *
	 * @return self
	 */
	public function register_setting( string $id, array $args ): self {
		$default_args = array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		);

		$args = array_merge( $default_args, $args );

		if ( ! isset( $args['sanitize_callback'] ) || empty( $args['sanitize_callback'] ) ) {
			$args['sanitize_callback'] = 'sanitize_text_field';
		}

		$this->settings[ $id ] = $args;

		return $this;
	}

	/**
	 * Modify a setting.
	 *
	 * @param string $id The setting ID.
	 * @param array  $args The setting arguments.
	 *
	 * @return self
	 */
	public function modify_setting( string $id, array $args ): self {
		$this->modified_settings[ $id ] = $args;

		return $this;
	}

	/**
	 * Add a settings class.
	 *
	 * @param SettingsInterface $settings_class The settings class.
	 */
	public function add_settings_class( SettingsInterface $settings_class ): void {
		$this->settings_classes[] = $settings_class;
	}

	/**
	 * Register the customizer hooks.
	 */
	public function register(): void {
		add_action( 'customize_register', array( $this, 'process_registration' ) );
	}

	/**
	 * Process the registration of panels, sections, and settings.
	 *
	 * @param WP_Customize_Manager $wp_customize The customize manager.
	 */
	public function process_registration( WP_Customize_Manager $wp_customize ): void {
		// Initialize Builders.
		$panel_builder   = new PanelBuilder( $wp_customize );
		$section_builder = new SectionBuilder( $wp_customize );
		$control_factory = new ControlFactory();
		$setting_builder = new SettingBuilder( $wp_customize, $control_factory );

		// Load settings from registered classes.
		foreach ( $this->settings_classes as $settings_class ) {
			$settings_class->register( $this );
		}

		// Build Panels.
		foreach ( $this->panels as $id => $args ) {
			$panel_builder->build( $id, $args );
		}

		// Build Sections.
		foreach ( $this->sections as $id => $args ) {
			$section_builder->build( $id, $args );
		}

		// Build Settings & Controls.
		foreach ( $this->settings as $id => $args ) {
			$setting_builder->build( $id, $args );
		}

		// Modify Existing Settings.
		foreach ( $this->modified_settings as $id => $args ) {
			$setting = $wp_customize->get_setting( $id );
			if ( $setting ) {
				foreach ( $args as $key => $value ) {
					$setting->$key = $value;
				}
			}
		}
	}

	/**
	 * Get a panel.
	 *
	 * @param string $id The panel ID.
	 *
	 * @return array|null
	 */
	public function get_panel( string $id ): ?array {
		return $this->panels[ $id ] ?? null;
	}

	/**
	 * Get a section.
	 *
	 * @param string $id The section ID.
	 *
	 * @return array|null
	 */
	public function get_section( string $id ): ?array {
		return $this->sections[ $id ] ?? null;
	}

	/**
	 * Get a setting.
	 *
	 * @param string $id The setting ID.
	 *
	 * @return array|null
	 */
	public function get_setting( string $id ): ?array {
		return $this->settings[ $id ] ?? null;
	}

	/**
	 * Get all panels.
	 *
	 * @return array
	 */
	public function get_all_panels(): array {
		return $this->panels;
	}

	/**
	 * Get all sections.
	 *
	 * @return array
	 */
	public function get_all_sections(): array {
		return $this->sections;
	}

	/**
	 * Get all settings.
	 *
	 * @return array
	 */
	public function get_all_settings(): array {
		return $this->settings;
	}
}
