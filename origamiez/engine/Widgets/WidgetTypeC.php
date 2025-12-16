<?php

namespace Origamiez\Engine\Widgets;

class WidgetTypeC extends WidgetTypeB {

	private int $offset = 0;

	public function __construct( array $instance = [] ) {
		parent::__construct( $instance );
		$this->offset = (int) ( $instance['offset'] ?? 0 );
	}

	public static function getDefaults(): array {
		$defaults = parent::getDefaults();
		$defaults['offset'] = 0;
		return $defaults;
	}

	public function getOffset(): int {
		return $this->offset;
	}

	public function setOffset( int $offset ): self {
		$this->offset = $offset;
		return $this;
	}

	public function getFields(): array {
		$fields = parent::getFields();
		$fields['offset'] = [
			'label' => esc_html__( 'Offset. Number of post to displace or pass over.', 'origamiez' ),
			'type'  => 'number',
		];
		return $fields;
	}

	public function applyOffsetToQuery( array $args ): array {
		if ( $this->offset > 0 ) {
			$args['offset'] = $this->offset;
		}
		return $args;
	}
}
