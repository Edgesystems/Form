<?php

namespace edge\form\element;

class File extends Element {
	protected $attr = array(
		'type' => 'file'
	);
	
	public function __construct( $name, array $attr = array() ) {
		parent::__construct( $name, $attr );
	}
	
	public function render() {
		return '<input' . $this->renderAttr() . ' />';
	}
}
