<?php

namespace edge\form\element;

class Checkbox extends Element {
	protected $attr = array(
		'type' => 'checkbox'
	);

	public function __construct( $name, $attr = array()) {
		$this->attr += array(
			'name' => $name,
		) + $attr;
	}

	public function render() {
		$tmp = $this->attr;

		if(!empty($this->attr['value'])){
			$tmp['checked'] = 'checked';
		}

		// unset($tmp['value']);

		return '<input' . HtmlElement::renderAttr( $tmp ) . '/>';
	}
}

