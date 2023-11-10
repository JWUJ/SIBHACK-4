<?php
namespace portal\modules;
use Exception;
use portal\modules\DataBase;
class Menu {
    public static $instance;
    private $db;

    public function __construct() {
        $this->db = DataBase::getInstance();
    }

    // Получить меню по ID
    public function getMenuById($menuId) {
        return $this->db->getRow('menus', "WHERE id = " . $menuId);
    }

    // Создать новое меню
    public function createMenu($name, $items) {
        try {
            $this->db->query('INSERT INTO menus (name, items) VALUES (' . $name . ', ' . json_encode($items) . ')');
            return $this->db->getRow('menus', "WHERE name = " . $name);
          } catch (Exception $e) {
            return False;
          }
    }

    // Редактировать существующее меню
    public function editMenu($menuId, $name, $items) {
        try {
            $this->db->query('UPDATE menus SET name = ' . $name . ', items = ' . json_encode($items) . ' WHERE id = ' . $menuId . '');
            return true;
          } catch (Exception $e) {
            return False;
          }

    }

    // Получить список всех меню
    public function getAllMenus() {
        return $this->db->getAll('menus');
    }

    public static function getInstance() {
        return 
            self::$instance===null
                ? self::$instance = new self() 
                : self::$instance;
      }
}
