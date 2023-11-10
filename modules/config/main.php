<?php 
namespace portal\modules;

class Config {

	public $config;
	public static $instance;

	public function __construct() {
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/config.json')) { 
			exit('ERROR CONFIG FILE NOT FOUND!!!'); 
		}
		$this->config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/config.json'), true);
	}

	
	public static function getInstance() {
        return 
            self::$instance===null
                ? self::$instance = new self() 
                : self::$instance;
      }

}

?>