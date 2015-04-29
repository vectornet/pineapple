<?php

/**
 * This class represents the contents of variables declared in the CSS file.
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
class PineappleVar
{

	/**
	 * Name of variable
	 * 
	 * @var string
	 */
	private $name;

	/**
	 * Value of variable
	 * 
	 * @var string
	 */
	private $value;

	/**
	 * Instance constructor
	 *
	 * @param string $name Name of variable
	 * @param string $value Value of variable
	 * @return void
	 */
	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

	/**
	 * Gets the name of variable
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Gets the value of variable
	 *
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}
}