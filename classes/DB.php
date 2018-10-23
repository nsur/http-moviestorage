<?php
class DB {
	private $mysql;
	private $host;
	private $database;
	private $user;
	private $password;

	public function __construct($host, $user, $password, $database) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
	}

	public function dbConnect($install = false) {
		if(empty($this->mysql)) {
			if(!empty($install)) {
				$this->mysql = mysqli_connect($this->host, $this->user, $this->password);
			} else {
				$this->mysql = mysqli_connect($this->host, $this->user, $this->password, $this->database);
			}
			if(empty($this->mysql)) {
				throw new Exception(mysqli_error($this->mysql));
			}
		}
		return $this->mysql;
	}

	public function dbDisconnect() {
		if(!empty($this->mysql)) {
			$result = mysqli_close($this->mysql);
			if(!empty($result)) {
				$this->mysql = null;
			} else {
				throw new Exception(mysqli_error($this->mysql));
			}
		}
	}

	public function dbCheckTableExists($table) {
		$result = $this->dbQuery("SELECT *
FROM information_schema.tables
WHERE table_schema = '".$this->database."'
AND table_name = '".$table."'
LIMIT 1");
		return mysqli_num_rows($result);
	}

	public function dbCheckTableEmpty($table) {
		$result = $this->dbQuery("SELECT COUNT(id) FROM ".$table);
		$row = mysqli_fetch_row($result);
		$notEmpty = (int)$row[0];
		return !$notEmpty;
	}

	public function dbQuery($query, $return = 0) {
		$resultData = null;
		try {
			$result = mysqli_query($this->mysql, $query);
			if(!mysqli_error($this->mysql)) {
				if(!empty($result)) {
					$resultData = array();
					$iter = 0;
					switch($return) {
						case 1:
							$resultData = mysqli_fetch_row($result);
							$resultData = !empty($resultData) ? $resultData[0] : $resultData;
							break;
						case 2:
							while($res = mysqli_fetch_array($result)) {
								$resultData[$iter] = $res;
								$iter++;
							}
							break;
						case 3:
							$resultData = mysqli_fetch_all($result);
							break;
						case 4:
							while($res = mysqli_fetch_assoc($result)) {
								$resultData[$iter] = $res;
								$iter++;
							}
							if(count($resultData) == 1) {
								$resultData = $resultData[0];
							}
							break;
						case 5:
							while($res = mysqli_fetch_assoc($result)) {
								$resultData[$iter] = $res;
								$iter++;
							}
							break;
						default:
							$resultData = $result;
							break;
					}
				}
			} else {
				throw new Exception(mysqli_error($this->mysql));
			}
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
		return $resultData;
	}

	public function install() {
		try {
			$this->dbConnect(true);
			$this->dbQuery("CREATE DATABASE IF NOT EXISTS ".$this->database);
			$this->dbQuery("USE ".$this->database);
			if(!$this->dbCheckTableExists('movies')) {
				$this->dbQuery("CREATE TABLE IF NOT EXISTS movies (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
release_year INTEGER(10) NOT NULL,
format INTEGER(10)
)");
			}
			if(!$this->dbCheckTableExists('formats')) {
				$this->dbQuery("CREATE TABLE IF NOT EXISTS formats (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
format VARCHAR(255) NOT NULL
)");
			}
			if($this->dbCheckTableEmpty('formats')) {
				$this->dbQuery("INSERT INTO formats (id, format)
VALUES (1, 'VHS');");
				$this->dbQuery("INSERT INTO formats (id, format)
VALUES (2, 'DVD');");
				$this->dbQuery("INSERT INTO formats (id, format)
VALUES (3, 'Blu-Ray');");
			}
			if(!$this->dbCheckTableExists('stars')) {
				$this->dbQuery("CREATE TABLE IF NOT EXISTS stars (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
star VARCHAR(255) NOT NULL
)");
			}
			if(!$this->dbCheckTableExists('movies_stars')) {
				$this->dbQuery("CREATE TABLE IF NOT EXISTS movies_stars (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
movie INTEGER(10),
star INTEGER(10)
)");
			}
			$this->dbDisconnect();
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}
}