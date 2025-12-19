<?php
/**
 * Sidebar Configuration
 *
 * @package Origamiez
 */

namespace Origamiez\Engine\Widgets\Sidebars;

/**
 * Class SidebarConfiguration
 */
class SidebarConfiguration {

	/**
	 * The ID.
	 *
	 * @var string
	 */
	private string $id;

	/**
	 * The name.
	 *
	 * @var string
	 */
	private string $name;

	/**
	 * The description.
	 *
	 * @var string
	 */
	private string $description = '';

	/**
	 * The before widget.
	 *
	 * @var string
	 */
	private string $before_widget = ORIGAMIEZ_CONFIG['sidebars']['before_widget'];

	/**
	 * The after widget.
	 *
	 * @var string
	 */
	private string $after_widget = ORIGAMIEZ_CONFIG['sidebars']['after_widget'];

	/**
	 * The before title.
	 *
	 * @var string
	 */
	private string $before_title = ORIGAMIEZ_CONFIG['sidebars']['before_title'];

	/**
	 * The after title.
	 *
	 * @var string
	 */
	private string $after_title = ORIGAMIEZ_CONFIG['sidebars']['after_title'];

	/**
	 * SidebarConfiguration constructor.
	 *
	 * @param string $id The ID.
	 * @param string $name The name.
	 * @param string $description The description.
	 */
	public function __construct( string $id, string $name, string $description = '' ) {
		$this->id          = $id;
		$this->name        = $name;
		$this->description = $description;
	}

	/**
	 * Get the ID.
	 *
	 * @return string
	 */
	public function get_id(): string {
		return $this->id;
	}

	/**
	 * Get the name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * Get the description.
	 *
	 * @return string
	 */
	public function get_description(): string {
		return $this->description;
	}

	/**
	 * Set the description.
	 *
	 * @param string $description The description.
	 * @return $this
	 */
	public function set_description( string $description ): self {
		$this->description = $description;
		return $this;
	}

	/**
	 * Get the before widget.
	 *
	 * @return string
	 */
	public function get_before_widget(): string {
		return $this->before_widget;
	}

	/**
	 * Set the before widget.
	 *
	 * @param string $before_widget The before widget.
	 * @return $this
	 */
	public function set_before_widget( string $before_widget ): self {
		$this->before_widget = $before_widget;
		return $this;
	}

	/**
	 * Get the after widget.
	 *
	 * @return string
	 */
	public function get_after_widget(): string {
		return $this->after_widget;
	}

	/**
	 * Set the after widget.
	 *
	 * @param string $after_widget The after widget.
	 * @return $this
	 */
	public function set_after_widget( string $after_widget ): self {
		$this->after_widget = $after_widget;
		return $this;
	}

	/**
	 * Get the before title.
	 *
	 * @return string
	 */
	public function get_before_title(): string {
		return $this->before_title;
	}

	/**
	 * Set the before title.
	 *
	 * @param string $before_title The before title.
	 * @return $this
	 */
	public function set_before_title( string $before_title ): self {
		$this->before_title = $before_title;
		return $this;
	}

	/**
	 * Get the after title.
	 *
	 * @return string
	 */
	public function get_after_title(): string {
		return $this->after_title;
	}

	/**
	 * Set the after title.
	 *
	 * @param string $after_title The after title.
	 * @return $this
	 */
	public function set_after_title( string $after_title ): self {
		$this->after_title = $after_title;
		return $this;
	}

	/**
	 * To array.
	 *
	 * @return array
	 */
	public function to_array(): array {
		return array(
			'id'            => $this->id,
			'name'          => $this->name,
			'description'   => $this->description,
			'before_widget' => $this->before_widget,
			'after_widget'  => $this->after_widget,
			'before_title'  => $this->before_title,
			'after_title'   => $this->after_title,
		);
	}

	/**
	 * Create a new instance.
	 *
	 * @param string $id The ID.
	 * @param string $name The name.
	 * @param string $description The description.
	 * @return static
	 */
	public static function create( string $id, string $name, string $description = '' ): self {
		return new self( $id, $name, $description );
	}
}
