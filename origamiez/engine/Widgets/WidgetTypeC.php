<?php
/**
 * Widget Type C
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets;

/**
 * Class WidgetTypeC
 */
class WidgetTypeC extends WidgetTypeB {

	/**
	 * Offset.
	 *
	 * @var int
	 */
	private int $offset = 0;

	/**
	 * WidgetTypeC constructor.
	 *
	 * @param array $instance Widget instance.
	 */
	public function __construct( array $instance = array() ) {
		parent::__construct( $instance );
		$this->offset = (int) ( $instance['offset'] ?? 0 );
	}

	/**
	 * Get defaults.
	 *
	 * @return array
	 */
	public static function get_defaults(): array {
		$defaults           = parent::get_defaults();
		$defaults['offset'] = 0;
		return $defaults;
	}

	/**
	 * Get offset.
	 *
	 * @return int
	 */
	public function get_offset(): int {
		return $this->offset;
	}

	/**
	 * Set offset.
	 *
	 * @param int $offset Offset.
	 * @return self
	 */
	public function set_offset( int $offset ): self {
		$this->offset = $offset;
		return $this;
	}

	/**
	 * Get fields.
	 *
	 * @return array
	 */
	public function get_fields(): array {
		$fields           = parent::get_fields();
		$fields['offset'] = array(
			'label' => esc_html__( 'Offset. Number of post to displace or pass over.', 'origamiez' ),
			'type'  => 'number',
		);
		return $fields;
	}

	/**
	 * Apply offset to query.
	 *
	 * @param array $args Query arguments.
	 * @return array
	 */
	public function apply_offset_to_query( array $args ): array {
		if ( $this->offset > 0 ) {
			$args['offset'] = $this->offset;
		}
		return $args;
	}
}
