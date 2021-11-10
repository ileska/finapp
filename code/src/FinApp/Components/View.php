<?php 

namespace FinApp\Components;

Class View
{
	public static function render($template, $args = [])
	{
		try {
		    $view = file_get_contents(__DIR__.('/../Views/'.$template.'.php'));

		    $trans = [];
		    foreach($args as $arg => $value){
		    	$trans['$'.$arg] = $value;
		    }

		    $compiledView = strtr($view , $trans);
		    echo $compiledView;
		    return true;

		} catch (Exception $e) {
		    echo 'Exeption: ',  $e->getMessage(), "\n";
		    die();
		}
	}
}