<?php

namespace edge\form\element;

class Hidden extends Element {
	protected $attr = array(
		'type' => 'hidden'
	);

	public function render() {
		return '<input' . $this->renderAttr() . '/>';
	}
}

