<?php 
	namespace portal\modules;
	use PDO;
	use portal\modules\Config;

	/**
	 * Summary of DB
	 */
	class DataBase
	{
		// Объект класса PDO
  /**
   * Summary of db
   * @var 
   */
  		public static $instance;
		private $db;

		// Соединение с БД
		/**
		 * Summary of __construct
		 */
		public function __construct()
		{
			$dbconf = Config::getInstance();
			$dbinfo = $dbconf->config['DataBase'];
			$this->db = new PDO('mysql:host=' . $dbinfo['host'] . ';dbname=' . $dbinfo['dbname'], $dbinfo['login'], $dbinfo['password']);
		}

		// Операции над БД
		/**
		 * Summary of query
		 * @param mixed $sql
		 * @param mixed $params
		 * @return mixed
		 */
		public function query($sql, $params = [])
		{
			// Подготовка запроса
			$stmt = $this->db->prepare($sql);
			
			// Обход массива с параметрами 
			// и подставляем значения
			if ( !empty($params) ) {
				foreach ($params as $key => $value) {
					$stmt->bindValue(":$key", $value);
				}
			}
			
			// Выполняя запрос
			$stmt->execute();
			// Возвращаем ответ
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		/**
		 * Summary of getAll
		 * @param mixed $table
		 * @param mixed $sql
		 * @param mixed $params
		 * @return mixed
		 */
		public function getAll($table, $sql = '', $params = [])
		{
			return $this->query("SELECT * FROM $table " . $sql, $params);
		}

		/**
		 * Summary of getRow
		 * @param mixed $table
		 * @param mixed $sql
		 * @param mixed $params
		 * @return mixed
		 */
		public function getRow($table, $sql = '', $params = [])
		{
			$result = $this->query("SELECT * FROM $table " . $sql, $params);
			if(empty($result)){
				return false;
			}
			return $result[0]; 
		}

		public static function getInstance() {
			return 
				self::$instance===null
					? self::$instance = new self() 
					: self::$instance;
		  }

	}

?>