<?php

namespace edge\form\element;

class Button extends Element {
	protected $attr = array(
		'type' => 'button'
	);

	public function render() {
		$text = _( 'Submit' );
		if( isset($this->attr['text']) ) {
			$text = $this->attr['text'];
			unset( $this->attr['text'] );
		}
	
		return '<button' . $this->renderAttr() . '>' . htmlspecialchars( $text ) . '</button>';
	}
}
