<?php
namespace portal\modules;
use Exception;
use portal\modules\DataBase;

class Pages{

    public static $instance;
    public static $current;
    public $pages;
    private $db;

    public function __construct(){
        $this->db = DataBase::getInstance();
        $this->pages = $this->db->getAll('pages');
    }

    public function add($name, $rules = null){
        try {
            $this->db->query("INSERT INTO `portal`.`pages` (`name`) VALUES ('$name');");
            $this->pages = $this->db->getAll('pages');
            return True;
          } catch (Exception $e) {
            return False;
          }
    }

    public function get($url) {
        try {
            $this->current = $this->db->getRow('pages', "WHERE url = '" . $url . "'");
            return $this->current;
          } catch (Exception $e) {
            return False;
          }
    }

    public function delete($id) {
        try {
            $this->db->query("DELETE FROM `portal`.`pages` WHERE  `id`=$id;");
            $this->roles = $this->db->getAll('pages');
            return True;
          } catch (Exception $e) {
            return False;
          }
    }

    public static function getInstance() {
      return 
          self::$instance===null
              ? self::$instance = new self() 
              : self::$instance;
    }

}

?>