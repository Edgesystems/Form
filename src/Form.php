<?php

namespace edge\form;

class Form {
	protected $attr = array();
	protected $data = array();
	protected $structure = array();

	public function __construct( array $attr = array(), array $data = NULL ) {
		$this->attr += $attr;

		if( $data === NULL ) {
			if( isset($attr['method']) ) {
				$data = ( $attr['method'] === 'post' ? $_POST : $_GET );
			} else {
				$data = $_GET;
			}
		}

		$this->setData( $data );
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

	public function setAction( $action ) {
		$this->setAttr( 'action', $action );
	}

	public function getAction() {
		return $this->getAttr( 'action' );
	}

	public function setData( array $data ) {
		$this->data = $data;
	}

	public function getData() {
		$return = array();
		foreach( $this->structure as $el ) {
			$return[$el->getAttr('name')] = $el->getAttr( 'value' );
		}

		return $return;
	}

	public function setMethod( $method ) {
		$this->setAttr( 'method', $method );
	}

	public function getMethod() {
		return $this->getAttr( 'method' );
	}

	public function setEnctype( $enctype ) {
		$this->setAttr( 'enctype', $enctype );
	}

	public function getEnctype() {
		return $this->getAttr( 'enctype' );
	}

	public function render() {
		$html = '';

		foreach( $this->structure as $el ) {
			$html .= $el->render();
		}

		return '
		<form' . element\HtmlElement::renderAttr( $this->attr ) . '>
			' . $html . '
		</form>';
	}

	public function isSubmitted() {
		if( empty($this->structure) ) {
			return false;
		}

		$return = true;
		foreach( $this->structure as $el ) {
			$return = $return && (!$el->isRequired() || $el->isSubmitted() );
		}

		return $return;
	}

	public function isValid() {
		$return = true;
		foreach( $this->structure as $el ) {
			$return = $return && $el->isValid();
		}

		return $return;
	}

	// Shorthands
	public function addColor( $name, array $attr = array() ) {
		$el = new element\Color( $name, $attr );
		return $this->addElement( $el );
	}

	public function addDate( $name, array $attr = array() ) {
		$el = new element\Date( $name, $attr );
		return $this->addElement( $el );
	}

	public function addDatetime( $name, array $attr = array() ) {
		$el = new element\Datetime( $name, $attr );
		return $this->addElement( $el );
	}

	public function addDatetimeLocal( $name, array $attr = array() ) {
		$el = new element\DatetimeLocal( $name, $attr );
		return $this->addElement( $el );
	}

	public function addEmail( $name, array $attr = array() ) {
		$el = new element\Email( $name, $attr );
		return $this->addElement( $el );
	}

	public function addMonth( $name, array $attr = array() ) {
		$el = new element\Month( $name, $attr );
		return $this->addElement( $el );
	}

	public function addNumber( $name, array $attr = array() ) {
		$el = new element\Number( $name, $attr );
		return $this->addElement( $el );
	}

	public function addRange( $name, array $attr = array() ) {
		$el = new element\Range( $name, $attr );
		return $this->addElement( $el );
	}

	public function addSearch( $name, array $attr = array() ) {
		$el = new element\Search( $name, $attr );
		return $this->addElement( $el );
	}

	public function addTel( $name, array $attr = array() ) {
		$el = new element\Tel( $name, $attr );
		return $this->addElement( $el );
	}

	public function addTime( $name, array $attr = array() ) {
		$el = new element\Time( $name, $attr );
		return $this->addElement( $el );
	}

	public function addUrl( $name, array $attr = array() ) {
		$el = new element\Url( $name, $attr );
		return $this->addElement( $el );
	}

	public function addWeek( $name, array $attr = array() ) {
		$el = new element\Week( $name, $attr );
		return $this->addElement( $el );
	}

	public function addTextarea( $name, array $attr = array() ) {
		$el = new element\Textarea( $name, $attr );
		return $this->addElement( $el );
	}

	public function addSubmit( $name, array $attr = array() ) {
		$el = new element\Submit( $name, $attr );
		return $this->addElement( $el );
	}

	public function addButton( $name, array $attr = array() ) {
		$el = new element\Button( $name, $attr );
		return $this->addElement( $el );
	}

	public function addReset( $el, array $attr = array() ) {
		$el = new element\Reset( $name, $attr );
		return $this->addElement( $el );
	}

	public function addText( $name, array $attr = array() ) {
		$el = new element\Text( $name, $attr );
		return $this->addElement( $el );
	}

	public function addHidden( $name, array $attr = array() ) {
		$el = new element\Hidden( $name, $attr );
		return $this->addElement( $el );
	}

	public function addFile( $name, array $attr = array() ) {
		$el = new element\File( $name, $attr );
		return $this->addElement( $el );
	}

	public function addPassword( $name, array $attr = array() ) {
		$el = new element\Password( $name, $attr );
		return $this->addElement( $el );
	}

	public function addSelect( $name, array $attr, array $options) {
		$el = new element\Select( $name, $attr, $options );
		return $this->addElement( $el );
	}

	public function addSelectOptGroup( $name, array $attr, array $options) {
		$el = new element\SelectOptGroup( $name, $attr, $options );
		return $this->addElement( $el );
	}

	public function addCheckbox( $name, array $attr = array() ) {
		$el = new element\Checkbox( $name, $attr );

		return $this->addElement( $el );
	}

	public function addElement( element\Element $el ) {
		$name = $el->getAttr( 'name' );

		if( isset($this->data[$name]) ) {
			$el->setAttr( 'value', $this->data[$name] );
		}

		return $this->structure[] = $el;
	}

	public function getElement($name){
		foreach ($this->structure as $el) {
			if($el->getName() == $name){
				return $el;
			}
		}

		return false;
	}

	public function getElements() {
		return $this->structure;
	}

	public function getErrors() {
		$return = [];

		foreach( $this->structure as $el ) {
			$tmp = $el->getErrors();

			if($tmp){
				$return[] = $tmp;
			}
		}

		return $return;
	}
}
