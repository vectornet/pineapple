<?php

class PineappleMixin extends PineappleCssRule
{

	/**
	 * List of parameters of mixin
	 * 
	 * @var PineappleVar[]
	 */
	private $parameters = array();

	/**
	 * Instance constructor
	 *
	 * @param string $selector Element selector
	 * @param string $body Code block properties of this rule.
	 * @return void
	 */
	public function __construct($selector, $parameters, $block)
	{
		parent::__construct($selector, $block);
		preg_match_all('/(?<var_name>@\w[\w\-\d]*)' . PineappleFile::RGX_WS . "*:" . PineappleFile::RGX_WS . "*(?<var_value>[^,]+)" . PineappleFile::RGX_WS . "*/", $parameters, $slices);
		foreach($slices['var_name'] as $pos => $var_name)
			$this->parameters[] = new PineappleVar($var_name, $slices['var_value'][$pos]);
	}
	
	public function getCssDeclararion(array $params = array(), array $mixins = array())
	{
		if(count($params) > count($this->parameters))
			trigger_error('The mixin '.$this->selector.' only accepts '.count($this->parameters).' parameters.', E_USER_WARNING);
		$params_send = array();
		foreach($this->parameters as $position => $PineappleVar)/* @var $PineappleVar PineappleVar */
			$params_send[$position] = ($params[$position]) ? new PineappleVar($PineappleVar->getName(), $params[$position]): $PineappleVar;
		return parent::getCssDeclararion($params_send, $mixins);
	}
	
	public function getName()
	{
		return $this->selector;
	}
}