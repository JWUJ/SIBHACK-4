<?php
namespace portal\modules;
use portal\modules\DataBase;
use portal\modules\Session;

class Auth
{
    public static $instance;
    private $db;
    private $session;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
        $this->session = Session::getInstance();
    }

    // Функция для входа пользователя
    public function login($username, $password)
    {
        // Проверка наличия пользователя в базе данных
        $user = $this->db->getRow('users', "WHERE username = '" . $username . "'");

        if ($user && password_verify($password, $user['password'])) {
            // Успешная аутентификация - установить сессию или токен
            $this->session->set('user_id', $user['user_id']);
            $this->session->set('role', $user['role']);
            return true;
        }

        return false; // Неверные учетные данные
    }

    // Функция для проверки авторизации пользователя
    public function checkAuth()
    {
        // Проверьте, авторизован ли пользователь, например, по наличию сессии или токена
        if ($this->session->get('user_id')) return true;
        return false;
    }

    // Функция для регистрации нового пользователя
    public function register($username, $password)
    {
        // Хеширование пароля
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Добавление нового пользователя в базу данных
        $sql = 'INSERT INTO users (username, password) VALUES (:username, :password)';
        $params = [':username' => $username, ':password' => $hashedPassword];

        if ($this->db->query($sql, $params)) {
            // Регистрация прошла успешно
            return true;
        }

        return false; // Ошибка при регистрации
    }

    // Функция для выхода пользователя
    public function logout()
    {
        // Очистка сессии или удаление токена
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);
    }

    
    public static function getInstance() {
        return 
            self::$instance===null
                ? self::$instance = new self() 
                : self::$instance;
      }
}
