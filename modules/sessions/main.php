<?php
namespace portal\modules;

class Session
{
    public static $instance;

    public function __construct(){
        $this->tryLoadSession();
    }

    protected function tryLoadSession()
    {
        if (empty($_SESSION)) {
            session_start();
        }
    }
    
    public function get($name)
    {
        $this->tryLoadSession();
        
        if (empty($_SESSION[$name])) {
            return false;
        }
        
        return $_SESSION[$name];
    }
    
    public function set($name, $value)
    {
        $this->tryLoadSession();
        
        $_SESSION[$name] = $value;
    }

    public static function getInstance() {
        return 
            self::$instance===null
                ? self::$instance = new self() 
                : self::$instance;
      }
}