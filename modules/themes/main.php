<?php
namespace portal\modules;

class Themes {
    public static $instance;
    public function current() {
        return ['name' => 'daisyui', 'path' => 'themes\daisyui'];
    }

    public function admin() {
        return ['name' => 'daisyui', 'path' => 'themes\daisyui_admin'];
    }

    public static function getInstance() {
        return 
            self::$instance===null
                ? self::$instance = new self() 
                : self::$instance;
      }

}