<?php
/**
 * This class in this release has nothing to do, only represents the  comment blocks of CSS code.
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
class PineappleComment
{
	/**
	 * Original text unchanged.
	 *  
	 * @var string
	 */
	private $value;
	
	/**
	 * Instance constructor
	 *
	 * @param strin $value Original text
	 * @return void
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	/**
	 * Return the text of original comment.
	 *
	 * @return string Original text
	 */
	public function getCssCompiled()
	{
		return $this->value;
	}
}
