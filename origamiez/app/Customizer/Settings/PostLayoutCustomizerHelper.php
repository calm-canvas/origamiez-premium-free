<?php
/**
 * Shared Customizer choices for post/taxonomy layout radios.
 *
 * @package Origamiez
 */

namespace Origamiez\Customizer\Settings;

/**
 * Class PostLayoutCustomizerHelper
 */
class PostLayoutCustomizerHelper {

	/**
	 * Three layout options used by blog archive and single-post layout settings.
	 *
	 * @return array<string, string>
	 */
	public static function get_three_column_layout_choices(): array {
		return array(
			'two-cols'       => esc_attr__( 'Two column', 'origamiez' ),
			'three-cols'     => esc_attr__( 'Three column - large : small : medium', 'origamiez' ),
			'three-cols-slm' => esc_attr__( 'Three column - small : large : medium', 'origamiez' ),
		);
	}
}
