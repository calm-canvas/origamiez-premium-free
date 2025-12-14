<?php

namespace Origamiez\Engine\Customizer;

class CustomizerService {

	private array $panels = [];
	private array $sections = [];
	private array $settings = [];

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
		$this->settings[ $id ] = $args;

		return $this;
	}

	public function registerControl( string $settingId, array $args ): self {
		$defaultArgs = [
			'label'   => $settingId,
			'section' => '',
			'type'    => 'text',
			'setting' => $settingId,
		];

		$args = array_merge( $defaultArgs, $args );

		add_action( 'customize_register', function ( $wp_customize ) use ( $settingId, $args ) {
			$wp_customize->add_control( $settingId, $args );
		} );

		return $this;
	}

	public function register(): void {
		add_action( 'customize_register', [ $this, 'registerPanels' ] );
		add_action( 'customize_register', [ $this, 'registerSections' ] );
		add_action( 'customize_register', [ $this, 'registerSettings' ] );
	}

	public function registerPanels( $wp_customize ): void {
		foreach ( $this->panels as $id => $args ) {
			$wp_customize->add_panel( $id, $args );
		}
	}

	public function registerSections( $wp_customize ): void {
		foreach ( $this->sections as $id => $args ) {
			$wp_customize->add_section( $id, $args );
		}
	}

	public function registerSettings( $wp_customize ): void {
		foreach ( $this->settings as $id => $args ) {
			$wp_customize->add_setting( $id, $args );
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
