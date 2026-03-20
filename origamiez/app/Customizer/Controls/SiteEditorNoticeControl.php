<?php
/**
 * Customizer control: message + link to Appearance → Editor.
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Controls;

use WP_Customize_Control;

/**
 * Class SiteEditorNoticeControl
 */
class SiteEditorNoticeControl extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'origamiez_site_editor_notice';

	/**
	 * Render the control in Customizer (PHP; no live preview value).
	 *
	 * @return void
	 */
	public function render_content() {
		$url = apply_filters( 'origamiez_site_editor_admin_url', admin_url( 'site-editor.php' ) );
		?>
		<div class="origamiez-customizer-site-editor-notice">
			<?php if ( $this->label ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( $this->description ) : ?>
				<p class="description"><?php echo wp_kses_post( $this->description ); ?></p>
			<?php endif; ?>
			<p>
				<a href="<?php echo esc_url( $url ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Open Site Editor', 'origamiez' ); ?>
				</a>
			</p>
		</div>
		<?php
	}

	/**
	 * Suppress Underscore template (no live component for this control).
	 *
	 * @return void
	 */
	public function content_template() {
	}
}
