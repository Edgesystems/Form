<?php

namespace edge\form\element;

// Not int use...

class SelectDestination extends Element {
	protected $attr = array(
		'type' => 'select'
	);

	protected $html = '';

	public function __construct(array $options){
		\weblink\wlog::info(array(__FILE__, __CLASS__, __FUNCTION__, __LINE__), "Tjoho");
		foreach ((array) $options as $label => $rows) {
			$this->html .= '<optgroup label="' . $label . '">';

			foreach ((array) $rows as $value => $name) {
				\weblink\wlog::info(array(__FILE__, __CLASS__, __FUNCTION__, __LINE__), "value", $value);
				if(!empty($value)){
					$this->html .= '<option value="' . $value . '">' . $name . '</option>';
				}else{
					$this->html .= '<option value="' . $value . '" disabled="disabled">' . $name . '</option>';
				}
			}
		}
	}

	public function render() {
		return '<select' . $this->renderAttr() . '>' . $this->html . '</select>';
	}
}

