<?php
namespace portal\modules;

#module class with load and scan modules and construct function make autoload modules enabled in mysql database
class Load {

public static $instance;

function __construct(){
    foreach($this->modules_scan() as $module){
        $this->modules_load($module);
    }
}

#modules load function
public function modules_load($module, $file='main', $params=array()){
	$path = 'modules/'.$module.'/'.$file.'.php';
	if(file_exists($path)){
		include_once($path);
	}
}

#modules scan function
public function modules_scan($dir='modules'){
	$modules = array();
	$files = scandir($dir);
	foreach($files as $file){
		if(!in_array($file, array('.','..'))){
			$path = $dir.'/'.$file;
			if(is_dir($path)){
				$modules[] = $file;
			}
		}
	}
	return $modules;
}

public static function getInstance() {
	return 
		self::$instance===null
			? self::$instance = new self() 
			: self::$instance;
  }

}
?>