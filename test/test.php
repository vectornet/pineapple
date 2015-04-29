<?php
require '../src/class/PineappleFile.class.php';
require '../src/class/PineappleCssRule.class.php';
require '../src/class/PineappleCssDeclaration.class.php';
require '../src/class/PineappleVar.class.php';
require '../src/class/PineappleMixin.class.php';
require '../src/class/PineappleCssImport.class.php';
require '../src/class/PineappleComment.class.php';

function varDebug($var, $saida = "html")
{
	return "<pre>" . highlight_string("<?php\n " . var_export($var, true) . " \n?>", true) . "</pre>";
}
$P = new PineappleFile("exemple.css");
echo "<pre>";
echo $P->getCssCompiled();

