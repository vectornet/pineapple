<?php

/**
 * This class represents the statements that comprise the CSS rule. Something like:
 * "margin: 0px;", "width: 900px;"...
 * The class, as well as statements, consists of two parts: property and value.
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
class PineappleCssDeclaration
{

	/**
	 * Property Name
	 * 
	 * @var string
	 */
	private $property;

	/**
	 * Property value
	 * 
	 * @var string
	 */
	private $value;

	//private $property_moz = array('binding', 'border-radius', 'border-radius-topleft', 'border-radius-topright', 'border-radius-bottomright', 'border-radius-bottomleft', 'border-top-colors', 'border-right-colors', 'border-bottom-colors', 'border-left-colors', 'opacity', 'outline', 'outline-color', 'outline-style', 'outline-width', 'user-focus', 'user-input', 'user-modify', 'user-select');

//	private $property_webkit = array('animation', 'animation-delay', 'animation-direction', 'animation-duration', 'animation-fill-mode', 'animation-iteration-count', 'animation-name', 'animation-play-state', 'animation-timing-function', 'appearance', 'backface-visibility', 'background-clip', 'background-composite', 'background-origin', 'background-size', 'border-bottom-left-radius', 'border-bottom-right-radius', 'border-horizontal-spacing', 'border-image', 'border-radius', 'border-top-left-radius', 'border-top-right-radius', 'border-vertical-spacing', 'box-align', 'box-direction', 'box-flex', 'box-flex-group', 'box-lines', 'box-ordinal-group', 'box-orient', 'box-pack', 'box-reflect', 'box-shadow', 'box-sizing', 'column-break-after', 'column-break-before', 'column-break-inside', 'column-count', 'column-gap', 'column-rule', 'column-rule-color', 'column-rule-style', 'column-rule-width', 'column-width', 'columns', 'dashboard-region', 'line-break', 'margin-bottom-collapse', 'margin-collapse', 'margin-start', 'margin-top-collapse', 'marquee', 'marquee-direction', 'marquee-increment', 'marquee-repetition', 'marquee-speed', 'marquee-style', 'mask', 'mask-attachment', 'mask-box-image', 'mask-clip', 'mask-composite', 'mask-image', 'mask-origin', 'mask-position', 'mask-position-x', 'mask-position-y', 'mask-repeat', 'mask-size', 'nbsp-mode', 'padding-start', 'perspective', 'perspective-origin', 'rtl-ordering', 'tap-highlight-color', 'text-fill-color', 'text-security', 'text-size-adjust', 'text-stroke', 'text-stroke-color', 'text-stroke-width', 'touch-callout', 'transform', 'transform-origin', 'transform-origin-x', 'transform-origin-y', 'transform-origin-z', 'transform-style', 'transition', 'transition-delay', 'transition-duration', 'transition-property', 'transition-timing-function', 'user-drag', 'user-modify', 'user-select');

	/**
	 * Instance constructor
	 *
	 * @param string $property Property string as it was found in the original CSS file. 
	 * @param string $value Value string as it was found in the original CSS file.Like: #4D926F
	 * @return void
	 */
	public function __construct($property, $value)
	{
		$this->property = $property;
		$this->value = $value;
			//		echo "<br>$property: $value<br>";
	}

	/**
	 * Returns the CSS code compiled, ie with all the dynamic changes already implemented.
	 * For this method receives the list of variables that must be replaced in their property values.
	 * 
	 * @todo In future versions this method will perform functions that are declared in the original CSS.
	 * @todo In future versions this method will automatically create specific properties for each browser when necessary.
	 * @param PineappleVar[] $vars PineappleVar list to replace the values
	 * @return string The CSS code compiled 
	 */
	public function getCssCompiled(array $vars = array())
	{
		$valor = $this->value;
		foreach($vars as $PineappleVar)/* @var $PineappleVar PineappleVar */
			$valor = str_replace($PineappleVar->getName(), $PineappleVar->getValue(), $valor, $count);
		return $this->property . ": $valor;";
	}

	public function getProperty()
	{
		return $this->property;
	}
}
