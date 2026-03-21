<?php
/**
 * Manages theme assets.
 *
 * @package Origamiez
 * @subpackage Origamiez/Engine/Assets
 */

namespace Origamiez\Assets;

use Origamiez\Config\ConfigManager;

/**
 * Class AssetManager
 */
class AssetManager {

	/**
	 * The stylesheet manager.
	 *
	 * @var StylesheetManager
	 */
	private StylesheetManager $stylesheet_manager;
	/**
	 * The script manager.
	 *
	 * @var ScriptManager
	 */
	private ScriptManager $script_manager;
	/**
	 * The inline style generator.
	 *
	 * @var InlineStyleGenerator
	 */
	private InlineStyleGenerator $inline_style_generator;
	/**
	 * The font manager.
	 *
	 * @var FontManager
	 */
	private FontManager $font_manager;
	/**
	 * The config manager.
	 *
	 * @var ConfigManager
	 */
	private ConfigManager $config_manager;
	/**
	 * The template URI.
	 *
	 * @var string
	 */
	private string $template_uri;

	/**
	 * AssetManager constructor.
	 *
	 * @param ConfigManager $config_manager The config manager.
	 */
	public function __construct( ConfigManager $config_manager ) {
		$this->config_manager = $config_manager;
		$this->template_uri   = get_template_directory_uri();

		$appearance_bridge = new ThemeJsonAppearanceBridge();

		$this->stylesheet_manager     = new StylesheetManager( $appearance_bridge );
		$this->script_manager         = new ScriptManager();
		$this->inline_style_generator = new InlineStyleGenerator( $appearance_bridge );
		$this->font_manager           = new FontManager();
	}

	/**
	 * Registers the asset hooks.
	 */
	public function register(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 5 );
	}

	/**
	 * Enqueues all assets.
	 */
	public function enqueue_assets(): void {
		$this->stylesheet_manager->enqueue( $this->template_uri );
		$this->inline_style_generator->add_inline_styles( $this->stylesheet_manager );
		$this->script_manager->enqueue( $this->template_uri );
	}

	/**
	 * Gets the stylesheet manager.
	 *
	 * @return StylesheetManager The stylesheet manager.
	 */
	public function get_stylesheet_manager(): StylesheetManager {
		return $this->stylesheet_manager;
	}

	/**
	 * Gets the script manager.
	 *
	 * @return ScriptManager The script manager.
	 */
	public function get_script_manager(): ScriptManager {
		return $this->script_manager;
	}

	/**
	 * Gets the inline style generator.
	 *
	 * @return InlineStyleGenerator The inline style generator.
	 */
	public function get_inline_style_generator(): InlineStyleGenerator {
		return $this->inline_style_generator;
	}

	/**
	 * Gets the font manager.
	 *
	 * @return FontManager The font manager.
	 */
	public function get_font_manager(): FontManager {
		return $this->font_manager;
	}
}
