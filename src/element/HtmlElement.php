<?php

namespace edge\form\element;

class HtmlElement {
	public static function renderAttr( array $attr ) {
		$html = '';

		foreach( $attr as $key => $value ) {
			$html .= ' ' . $key . '="' . htmlspecialchars( $value ) . '"';	
		}

		return $html; // Could use yield instead
	}
}
