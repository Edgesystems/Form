<?php

namespace edge\form\element;

class SelectOptGroup extends Element {
	protected $attr = array(
		'type' => 'select'
	);

	protected $options = [];

	public function __construct($name, array $attr, array $options){
		$this->options = $options;

		parent::__construct($name, $attr);
	}

	public function render() {
		$selected_value = null;
		$html = '';

		if(!empty($this->attr['value'])){
			$selected_value = $this->attr['value'];

			unset($this->attr['value']);
		}

		foreach ($this->options as $label => $rows) {
			$required = false;

			if(in_array('required', $this->attr)){
				$required = true;
			}

			$html .= '<optgroup label="' . $label . '">';

			foreach ((array) $rows as $value => $option_name) {
				$html .= '<option value="' . $value . '"';

				if($selected_value == $value){
					$html .= ' selected';
				}

				if(!$value && $required){
					$html .= ' disabled="disabled" ';
				}

				$html .= '>' . $option_name . '</option>';
			}
		}

		return '<select' . $this->renderAttr() . '>' . $html . '</select>';
	}
}

