<?php

namespace edge\form\element;

class Text extends Element {
	protected $attr = array(
		'type' => 'text'
	);

	public function render() {
		return '<input' . $this->renderAttr() . '/>';
	}
}

