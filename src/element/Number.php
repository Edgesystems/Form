<?php

namespace edge\form\element;

class Number extends Element {
	protected $attr = array(
		'type' => 'number'
	);

	public function __construct( $name, array $attr = array() ) {
		parent::__construct( $name, $attr );

		// $this->addRule( static::EMAIL, _(':value is not a valid email.') );
	}

	public function render() {
		return '<input' . $this->renderAttr() . ' />';
	}
}
