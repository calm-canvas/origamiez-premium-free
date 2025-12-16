<?php

namespace Origamiez\Engine\Assets;

use Origamiez\Engine\Config\ConfigManager;

class AssetManager {

	private StylesheetManager $stylesheetManager;
	private ScriptManager $scriptManager;
	private InlineStyleGenerator $inlineStyleGenerator;
	private FontManager $fontManager;
	private ConfigManager $configManager;
	private string $templateUri;

	public function __construct( ConfigManager $configManager ) {
		$this->configManager        = $configManager;
		$this->templateUri          = get_template_directory_uri();
		$this->stylesheetManager    = new StylesheetManager();
		$this->scriptManager        = new ScriptManager();
		$this->inlineStyleGenerator = new InlineStyleGenerator();
		$this->fontManager          = new FontManager( $this->templateUri );
	}

	public function register(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueAssets' ), 15 );
	}

	public function enqueueAssets(): void {
		$this->stylesheetManager->enqueue( $this->templateUri );
		$this->fontManager->enqueue();
		$this->inlineStyleGenerator->addInlineStyles( $this->stylesheetManager );
		$this->scriptManager->enqueue( $this->templateUri );
	}

	public function getStylesheetManager(): StylesheetManager {
		return $this->stylesheetManager;
	}

	public function getScriptManager(): ScriptManager {
		return $this->scriptManager;
	}

	public function getInlineStyleGenerator(): InlineStyleGenerator {
		return $this->inlineStyleGenerator;
	}

	public function getFontManager(): FontManager {
		return $this->fontManager;
	}
}
