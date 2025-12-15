<?php

namespace Origamiez\Engine\Customizer;

use Origamiez\Engine\Customizer\Builders\PanelBuilder;
use Origamiez\Engine\Customizer\Builders\SectionBuilder;
use Origamiez\Engine\Customizer\Builders\SettingBuilder;
use Origamiez\Engine\Customizer\Settings\SettingsInterface;
use WP_Customize_Manager;

class CustomizerService {

	private array $panels = [];
	private array $sections = [];
	private array $settings = [];
	private array $modifiedSettings = [];
	private array $settingsClasses = [];

	public function registerPanel( string $id, array $args ): self {
		$defaultArgs = [
			'title'       => $id,
			'description' => '',
			'priority'    => 160,
		];

		$args = array_merge( $defaultArgs, $args );
		$this->panels[ $id ] = $args;

		return $this;
	}

	public function registerSection( string $id, array $args ): self {
		$defaultArgs = [
			'title'       => $id,
			'description' => '',
			'panel'       => '',
			'priority'    => 160,
		];

		$args = array_merge( $defaultArgs, $args );
		$this->sections[ $id ] = $args;

		return $this;
	}

	public function registerSetting( string $id, array $args ): self {
		$defaultArgs = [
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		];

		$args = array_merge( $defaultArgs, $args );

		if ( ! isset( $args['sanitize_callback'] ) || empty( $args['sanitize_callback'] ) ) {
			$args['sanitize_callback'] = 'sanitize_text_field';
		}

		$this->settings[ $id ] = $args;

		return $this;
	}

	public function modifySetting( string $id, array $args ): self {
		$this->modifiedSettings[ $id ] = $args;

		return $this;
	}

	public function addSettingsClass( SettingsInterface $settingsClass ): void {
		$this->settingsClasses[] = $settingsClass;
	}

	public function register(): void {
		add_action( 'customize_register', [ $this, 'processRegistration' ] );
	}

	public function processRegistration( WP_Customize_Manager $wp_customize ): void {
		// Initialize Builders
		$panelBuilder   = new PanelBuilder( $wp_customize );
		$sectionBuilder = new SectionBuilder( $wp_customize );
		$controlFactory = new ControlFactory();
		$settingBuilder = new SettingBuilder( $wp_customize, $controlFactory );

		// Load settings from registered classes
		foreach ( $this->settingsClasses as $settingsClass ) {
			$settingsClass->register( $this );
		}

		// Build Panels
		foreach ( $this->panels as $id => $args ) {
			$panelBuilder->build( $id, $args );
		}

		// Build Sections
		foreach ( $this->sections as $id => $args ) {
			$sectionBuilder->build( $id, $args );
		}

		// Build Settings & Controls
		foreach ( $this->settings as $id => $args ) {
			$settingBuilder->build( $id, $args );
		}

		// Modify Existing Settings
		foreach ( $this->modifiedSettings as $id => $args ) {
			$setting = $wp_customize->get_setting( $id );
			if ( $setting ) {
				foreach ( $args as $key => $value ) {
					$setting->$key = $value;
				}
			}
		}
	}

	public function getPanel( string $id ): ?array {
		return $this->panels[ $id ] ?? null;
	}

	public function getSection( string $id ): ?array {
		return $this->sections[ $id ] ?? null;
	}

	public function getSetting( string $id ): ?array {
		return $this->settings[ $id ] ?? null;
	}

	public function getAllPanels(): array {
		return $this->panels;
	}

	public function getAllSections(): array {
		return $this->sections;
	}

	public function getAllSettings(): array {
		return $this->settings;
	}
}
