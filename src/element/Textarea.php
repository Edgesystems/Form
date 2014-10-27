<?php

namespace edge\form\element;

class Textarea extends Element{
	public function render() {
		$value = '';
		if( isset($this->attr['value']) ) {
			$value = $this->attr['value'];
			unset( $this->attr['value'] );
		}

		return '<textarea' . $this->renderAttr() . '>' . htmlspecialchars( $value ) . '</textarea>';
	}
}
