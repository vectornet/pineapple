<?php
/**
 * This class represents a CSS rule, ie, a selector and a block property. 
 * It enables to isolate this representation for ease of handling language 
 * features LESS that applies only to the rules.
 * 
 * Note that the naming of objects was based on the terms used W3Schools
 * to define each part of the syntax of CSS (http://www.w3schools.com/css/css_syntax.asp)
 *
 * Copyright 2012 Vector Internet (http://pineapple.vectornet.com.br)
 * This file is part of Pineapple CSS.
 *
 * Pineapple CSS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation or any later version.
 *
 * Pineapple CSS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Pineapple CSS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://pineapple.vectornet.com.br/>.
 *
 * @copyright Vector Internet (http://pineapple.vectornet.com.br)
 * @license http://www.opensource.org/licenses/lgpl-license.php GNU Public License
 * @author Rubens de Souza Silva <rubens21@gmail.com>
 * @package Pineapple CSS
 * @version $Date$
 * @since 23.07.2012
 */
class PineappleCssRule
{
	/**
	 * Selector as it was defined in the original CSS code.
	 *  
	 * @var string
	 */
	protected  $selector;
	
	/**
	 * List of pineapples that make up that rule.
	 *  
	 * @var PineappleCssDeclaration[]
	 */
	protected $lines = array();
	
	/**
	 * Instance constructor
	 *
	 * @param string $selector Element selector
	 * @param string $body Code block properties of this rule.
	 * @return void
	 */
	public function __construct($selector, $block)
	{
		$this->selector = trim($selector);
		$regex_rule = '(?<rule>(?<property>[\w\-]+)'.PineappleFile::RGX_WS."*:".PineappleFile::RGX_WS.'*(?<value>[^;]*);)';
		$regex_comment = '(?<comment>\/\*.*?\*\/)';
		$regex_mixins = '(?<mixin_name>\.\w[\w\-\d]*)'.PineappleFile::RGX_WS."*(\((?<parameters>[^)]*)\)){0,1};";
		$subregex_mixin_name = '';
		
		
		preg_match_all("/$regex_rule|$regex_comment|$regex_mixins/", $block, $matches);
		foreach($matches['property'] as $pos => $property)
			if($property)
				$this->lines[$pos] = new PineappleCssDeclaration($matches['property'][$pos], $matches['value'][$pos]);
		
		foreach($matches['comment'] as $pos => $body)
			if($body)
				$this->lines[$pos] = new PineappleComment($body);
				
		foreach($matches['mixin_name'] as $pos => $mixin_name)
		{
			if($mixin_name)
			{
				preg_match_all('/(?<param_value>[^,]+)/', trim($matches['parameters'][$pos]), $slices_param);
				$this->lines[$pos] =array($mixin_name, $slices_param['param_value']);
			}
		}
	}
	
	/**
	 * Returns the CSS code compiled, ie with all the dynamic changes already implemented.
	 * For this method receives the list of variables that must be replaced in their property values.
	 *  
	 * @param PineappleCssDeclaration[] $vars PineappleVar list to replace the values
	 * @param bool $order By default ordering properties in alphabetical order to make the code more readable.
	 * @return string The CSS code compiled 
	 */
	public function getCssCompiled(array $vars = array(), array $mixins = array(), $order = true)
	{
		return $this->selector."{\n\t".$this->getCssDeclararion($vars, $mixins, $order)."\n}";
	}
	
	public function getCssDeclararion(array $vars = array(), array $mixins = array(), $order = true)
	{
		$declarations = array();
		foreach ($this->lines as $Element)
		{
			if(is_array($Element))
			{
				if(!$mixins[$Element[0]] || get_class($mixins[$Element[0]]) != 'PineappleMixin')
					trigger_error("Mixin '".$Element[0]."' does not exist.", E_USER_WARNING);
				else
					$declarations[] = $mixins[$Element[0]]->getCssDeclararion($Element[1], $mixins);
			}elseif(get_class($Element) == 'PineappleCssDeclaration')/* @var $Element  PineappleCssDeclaration */
				$declarations[$Element->getProperty()] = $Element->getCssCompiled($vars);
			elseif(get_class($Element) == 'PineappleComment')
				$declarations[] = $Element->getCssCompiled();
		}
		if($order)
			sort($declarations);
		return implode("\n\t", $declarations); 
	}
}
