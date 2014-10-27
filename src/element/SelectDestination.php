<?php

namespace edge\form\element;

class SelectOptGroup extends Element {
	protected $attr = array(
		'type' => 'select'
	);

	protected $html = '';

	public function __construct(array $options){
		foreach ((array) $options as $label => $rows) {
			$this->html .= '<optgroup label="' . $label . '">';

			foreach ((array) $rows as $value => $name) {
				$this->html .= '<option value="' . $value . '">' . $name . '</option>';
			}
		}
	}

	public function render() {
		return '<select' . $this->renderAttr() . '>' . $this->html . '</select>';
	}
}

