<?php

/**
 * This class handle the original CSS file to compile your code and generate the final source code.
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
class PineappleFile
{

	/**
	 * Content original CSS file
	 * 
	 * @var string
	 */
	private $file_content;

	/**
	 * List of objects that make up the CSS file. The elements are identified by 
	 * regular expression and instanced objects to work with your specific type of code.
	 * Exemple:
	 * array (
	 * 		0 =>
	 * 			PineappleCssImport::__set_state(array(...)),
	 * 		3 => 
	 * 			PineappleCssRule::__set_state(array(...)),
	 * 		2 =>
	 * 			PineappleCssDeclaration::__set_state(array(...))
	 * )
	 * 
	 * @var PineappleCssRule[]|PineappleCssImport[]|PineappleComment[]
	 */
	private $file_parsed;

	/**
	 * List of variables declared in the content of dynamic CSS.
	 * 
	 * @var PineappleVar[]
	 */
	private $vars = array();
	/**
	 * List of mixins declared in the content of dynamic CSS.
	 * 
	 * @var PineappleMixin[]
	 */
	private $mixins = array();
	/**
	 * Regular expression common to several cases. Used to identify blank spaces, changing lines and tabs.
	 */
	const RGX_WS = '[\s\n\t]';

	/**
	 * Instance constructor
	 *
	 * @param strin $path_css_file Path to the original file.
	 * @return void
	 */
	public function __construct($path_css_file)
	{
		if(!file_exists($path_css_file))
			trigger_error("I missed the lesson of magic, must enter the correct path of the file: $path_css_file", E_USER_ERROR);
		$this->file_content = file_get_contents($path_css_file);
		self::parseFIle($this->file_content);
	}

	/**
	 * Analyzes the content of the original CSS file and tries to identify each element separately. 
	 * For each element type is created a different kind of object and added to the list of elements.
	 * 
	 * @todo Still does not check if the syntax is correct, just picks up the pieces.
	 * @param string $file_content The original content of CSS file.
	 * @return void
	 */
	private function parseFIle($file_content)
	{
		$subregex_espace = self::RGX_WS;
		/**
		 * @todo This regular expression fails to "selectors" using parentheses, like :not(), :nth-last-of-type(n), :nth-of-type(n)
		 */
		$subregex_selector = '(?<selector>([#\.\\[:]{0,1}|::)[\*\w][^{};\/\)\(]+)';
		$subregex_mixin_name = '(?<mixin_name>\.\w[\w\-\d]*)';
		$subregex_declaration = "[^}]*";
		$subregex_var_name = '(?<var_name>@\w[\w\-\d]*)';
		$subregex_var_value = "(?<var_value>[^;]+)";
		$subregex_parameters = "(?<parameters>[^)]*)";
		
		$comboregex_selector_mixin = "$subregex_espace*(?<selector_selector_mixin>$subregex_mixin_name$subregex_espace*\($subregex_parameters\))$subregex_espace*";
		
		$regex_block = "$subregex_espace*(?<block>$subregex_espace*$subregex_selector$subregex_espace*\{$subregex_espace*(?<declaration>$subregex_declaration)$subregex_espace*})$subregex_espace*";
		$regex_mixin = "$subregex_espace*(?<mixin>$comboregex_selector_mixin\{$subregex_espace*(?<declaration_mixin>$subregex_declaration)$subregex_espace*})$subregex_espace*";
		$regex_import = "(?<import>@import$subregex_espace+(?<import_path>[^;\n]*);)";
		$regex_comment = '(?<comment>\/\*.*?\*\/)';
		$regex_var_definition = "(?<var_definition>$subregex_var_name$subregex_espace*:$subregex_espace*$subregex_var_value$subregex_espace*;)";
		
		$fullregex_css = "$regex_block|$regex_mixin|$regex_import|$regex_comment|$regex_var_definition";
		preg_match_all("/$fullregex_css/", $file_content, $slices);
		foreach($slices['block'] as $line => $body)
		{
			if($body)
				$this->file_parsed[$line] = new PineappleCssRule($slices['selector'][$line], $slices['declaration'][$line]);
		}
		foreach($slices['import'] as $line => $body)
		{
			if($body)
				$this->file_parsed[$line] = new PineappleCssImport($slices['import_path'][$line]);
		}
		foreach($slices['comment'] as $line => $body)
		{
			if($body)
				$this->file_parsed[$line] = new PineappleComment($body);
		}
		foreach($slices['var_definition'] as $line => $body)
		{
			if($body)
			{
				$Var = new PineappleVar($slices['var_name'][$line], $slices['var_value'][$line]);
				$this->vars[$Var->getName()] = $Var;
			}
		}
		foreach($slices['mixin'] as $line => $body)
		{
			if($body)
			{
				$Mixin = new PineappleMixin($slices['mixin_name'][$line], $slices['parameters'][$line], $slices['declaration_mixin'][$line]);
				$this->mixins[$Mixin->getName()] = $Mixin;
			}
		}
		ksort($this->file_parsed);
	}

	/**
	 * Returns the CSS code compiled, ie with all the dynamic changes already implemented.
	 *
	 * @return void
	 */
	public function getCssCompiled()
	{
		$return = "";
		foreach($this->file_parsed as $linha => $Element)
		{
			switch(get_class($Element))
			{
				case 'PineappleCssRule':/* @var $Element PineappleCssRule */
					$return .= "\n" . $Element->getCssCompiled($this->vars, $this->mixins);
				break;
				case 'PineappleCssImport':/* @var $Element PineappleCssImport */
					$return .= "\n" . $Element->getCssCompiled($this->vars);
				break;
				case 'PineappleComment':/* @var $Element PineappleComment */
					$return .= "\n" . $Element->getCssCompiled($this->vars);
				break;
				//case 'PineappleVar':/* @var $Element PineappleVar */
				//ok.. Nothing to do
				//break;
				default:
					trigger_error('Unknown class: ' . get_class($Element), E_USER_WARNING);
				break;
			}
		}
		return $return;
	}
}

