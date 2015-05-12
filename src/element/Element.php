<?php

namespace edge\form\element;

abstract class Element {
	const MIN_LENGTH = 1;
	const MAX_LENGTH = 2;
	const LENGTH = 3;
	const EMAIL = 4;
	const URL = 5;
	const REGEX = 6;
	const INTEGER = 7;
	const FLOAT = 8;
	const RANGE = 9;
	const REQUIRED = 10;
	const EQUAL = 11;
	const IS_IN = 12;
	const CLOSURE = 13;

	protected $attr = array();
	protected $rules = array();
	protected $errors = array();

	public function __construct( $name, $attr = array() ) {
		$this->attr += array(
			'name' => $name,
		) + $attr;
	}

	public function setAttr( $name, $value ) {
		$this->attr[$name] = $value;
	}

	public function getAttr( $name ) {
		return isset( $this->attr[$name] ) ? $this->attr[$name] : NULL;
	}

	public function setAttrs( array $attr ) {
		$this->attr = $attr;
	}

	public function getAttrs() {
		return $this->attr;
	}

	public function renderAttr() {
		return HtmlElement::renderAttr( $this->attr );
	}

	public function addRule( $type, $msg, $opt = NULL ) {
		// Could be refactored to separate classes..
		switch( $type ) {
			case static::MIN_LENGTH:
				if( !(is_int($opt) || ctype_digit($opt)) ) {
					throw new \Exception( 'Invalid params to min-length.' );
				}
				break;
			case static::MAX_LENGTH:
				if( !(is_int($opt) || ctype_digit($opt)) ) {
					throw new \Exception( 'Invalid params to max-length.' );
				}

				break;
			case static::LENGTH:
				if( !(is_int($opt) || ctype_digit($opt)) ) {
					throw new \Exception( 'Invalid params to length.' );
				}

				break;
			case static::RANGE:
				if( !(is_array($opt) && count($opt) === 2) ) {
					throw new \Exception( 'Invalid params to range.' );
				}

				if( !((is_int($opt[0]) || ctype_digit($opt[0])) || (is_int($opt[1]) || ctype_digit($opt[1]))) ) {
					throw new \Exception( 'Invalid params to min-length.' );
				}

				break;
			case static::CLOSURE:
				if( !$opt instanceof \Closure ) {
					throw new \Exception( 'Invalid closure' );
				}

				break;
			case static::EMAIL:
			case static::URL:
			case static::REGEX:
			case static::INTEGER:
			case static::FLOAT:
			default:
				if( !empty($opt) ) {
					throw new \Exception( 'Invalid params to url.' );
				}

				break;
				if( empty($opt) || !is_string($opt) ) {
					throw new \Exception( 'Invalid params to regex.' );
				}

				break;
		}

		$this->rules[$type] = array(
			'msg' => $msg,
			'opt' => $opt
		);
	}

	public function getRule( $type ) {
		return isset( $this->rules[$type] ) ? $this->rules[$type] : NULL;
	}

	public function setRules( array $rules ) {
		$this->rules = $rules;
	}

	public function getRules() {
		return $this->rules;
	}

	public function setError( $type, $msg ) {
		$this->errors[$type] = $msg;
	}

	public function getError( $type ) {
		return isset( $this->errors[$type] ) ? $this->errors[$type] : NULL;
	}

	public function setErrors( array $errors ) {
		$this->errors = $errors;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function isRequired(){
		return isset($this->attr['required']) || (bool) $this->getRule(static::REQUIRED);
	}

	public function isValid() {
		$return = true;
		$value = $this->getAttr( 'value' );

		if(empty($value) && !$this->isRequired()){
			return true;
		}

		foreach( $this->rules as $type => $args ) {
			$current = false;

			switch( $type ) {
				case static::MIN_LENGTH:
					if( strlen($value) < $args['opt'] ) {
						$current = true;
					}

					break;
				case static::MAX_LENGTH:
					if( strlen($value) > $args['opt'] ) {
						$current = true;
					}

					break;
				case static::LENGTH:
					if( strlen($value) != $args['opt'] ) {
						$current = true;
					}

					break;
				case static::EMAIL:
					if( \filter_var($value, FILTER_VALIDATE_EMAIL) === false ) {
						$current = true;
					}

					break;
				case static::URL:
					if( \filter_var($value, FILTER_VALIDATE_URL) === false ) {
						$current = true;
					}

					break;
				case static::REGEX:
					if( preg_match($args['opt'], $value) < 1 ) {
						$current = true;
					}

					break;
				case static::INTEGER:
					if( !(is_int($value) || ctype_digit($value)) ) {
						$current = true;
					}

					break;
				case static::FLOAT:
					if( !(is_float($value) || is_numeric($value)) ) {
						$current = true;
					}

					break;
				case static::RANGE:
					if( $value < $args['opt'][0] && $value > $args['opt'][1] ) {
						$current = true;
					}

					break;
				case static::CLOSURE:
					$ret = $args['opt']( $this );

					if( is_string($ret) ) {
						$args['msg'] = $ret;
					}

					$current = $ret !== true;

					break;
			}

			if( $current ) {
				$msg = str_replace( ':value', $value, $args['msg'] );

				if( $args['opt'] instanceof \Closure ) {
					//
				} else {
					foreach( (array) $args['opt'] as $key =>  $entry ) {
						$msg = str_replace( ':arg' . $key, $entry, $args['msg'] );
					}
				}

				$this->errors[$type] = $msg;
				$return = false;

				$class = $this->getAttr( 'class' );
				if( $class ) $class .= ' ';
				$class .= 'error';
				$this->setAttr( 'class', $class );
			}
		}

		return $return;
	}

	public function isSubmitted() {
		return isset( $this->attr['value'] );
	}

	public function getName(){
		return $this->attr['name'];
	}

	public function disabled(){
		$this->attr['disabled'] = 'disabled';
	}

	abstract public function render();
}
