<?php

namespace edge\form\element;

class Password extends Element {
	protected $attr = array(
		'type' => 'password'
	);

	public function render() {
		// echo "<pre>" . print_r($this->renderAttr() , true) . "</pre>"; die();

		return '<input' . $this->renderAttr() . ' value=""/>';
	}
}

