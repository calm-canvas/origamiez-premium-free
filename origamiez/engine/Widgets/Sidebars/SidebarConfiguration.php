<?php

namespace Origamiez\Engine\Widgets\Sidebars;

class SidebarConfiguration {

	private string $id;
	private string $name;
	private string $description  = '';
	private string $beforeWidget = '<div id="%1$s" class="widget %2$s">';
	private string $afterWidget  = '</div></div>';
	private string $beforeTitle  = '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">';
	private string $afterTitle   = '</span></h2><div class="origamiez-widget-content clearfix">';

	public function __construct( string $id, string $name, string $description = '' ) {
		$this->id          = $id;
		$this->name        = $name;
		$this->description = $description;
	}

	public function getId(): string {
		return $this->id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function setDescription( string $description ): self {
		$this->description = $description;
		return $this;
	}

	public function getBeforeWidget(): string {
		return $this->beforeWidget;
	}

	public function setBeforeWidget( string $beforeWidget ): self {
		$this->beforeWidget = $beforeWidget;
		return $this;
	}

	public function getAfterWidget(): string {
		return $this->afterWidget;
	}

	public function setAfterWidget( string $afterWidget ): self {
		$this->afterWidget = $afterWidget;
		return $this;
	}

	public function getBeforeTitle(): string {
		return $this->beforeTitle;
	}

	public function setBeforeTitle( string $beforeTitle ): self {
		$this->beforeTitle = $beforeTitle;
		return $this;
	}

	public function getAfterTitle(): string {
		return $this->afterTitle;
	}

	public function setAfterTitle( string $afterTitle ): self {
		$this->afterTitle = $afterTitle;
		return $this;
	}

	public function toArray(): array {
		return array(
			'id'            => $this->id,
			'name'          => $this->name,
			'description'   => $this->description,
			'before_widget' => $this->beforeWidget,
			'after_widget'  => $this->afterWidget,
			'before_title'  => $this->beforeTitle,
			'after_title'   => $this->afterTitle,
		);
	}

	public static function create( string $id, string $name, string $description = '' ): self {
		return new self( $id, $name, $description );
	}
}
