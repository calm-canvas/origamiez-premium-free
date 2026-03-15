<?php
/**
 * DI Definitions
 *
 * @package Origamiez
 */

use Origamiez\Assets\AssetManager;
use Origamiez\Config\BodyClassConfig;
use Origamiez\Config\ConfigManager;
use Origamiez\Config\FontConfig;
use Origamiez\Config\LayoutConfig;
use Origamiez\Config\SkinConfig;
use Origamiez\Customizer\CustomizerService;
use Origamiez\Display\Breadcrumb\BreadcrumbGenerator;
use Origamiez\Display\ReadMoreButton;
use Origamiez\Hooks\HookRegistry;
use Origamiez\Layout\BodyClassManager;
use Origamiez\Post\PostClassManager;
use Origamiez\Widgets\SidebarRegistry;
use Origamiez\Widgets\WidgetClassManager;
use Origamiez\Widgets\WidgetFactory;
use function DI\create;
use function DI\factory;
use function DI\get;

return array(
	'config_manager'       => factory( array( ConfigManager::class, 'get_instance' ) ),
	'skin_config'          => create( SkinConfig::class ),
	'layout_config'        => create( LayoutConfig::class ),
	'font_config'          => create( FontConfig::class ),
	'body_class_config'    => create( BodyClassConfig::class ),
	'hook_registry'        => factory( array( HookRegistry::class, 'get_instance' ) ),
	'asset_manager'        => create( AssetManager::class )->constructor( get( 'config_manager' ) ),
	'body_class_manager'   => create( BodyClassManager::class )->constructor( get( 'config_manager' ), get( 'body_class_config' ) ),
	'breadcrumb_generator' => create( BreadcrumbGenerator::class ),
	'customizer_service'   => create( CustomizerService::class ),
	'widget_factory'       => factory( array( WidgetFactory::class, 'get_instance' ) ),
	'sidebar_registry'     => factory( array( SidebarRegistry::class, 'get_instance' ) ),
	'widget_class_manager' => create( WidgetClassManager::class ),
	'post_class_manager'   => create( PostClassManager::class ),
	'read_more_button'     => create( ReadMoreButton::class ),
);
