<?php
class Model {
	private $db = null;

	private function getDb() {
		if(empty($this->db)) {
			$this->db = new DB(HOST, USER, PASSWORD, DATABASE);
		}
		return $this->db;
	}
	public function getAllMovies($search = false) {
		$query = "SELECT movies.*, formats.format as format_name FROM movies INNER JOIN formats ON movies.format = formats.id";
		if(!empty($search)) {
			$query .= " INNER JOIN movies_stars ON movies.id = movies_stars.movie INNER JOIN stars ON stars.id = movies_stars.star WHERE movies.title LIKE '%".$search."%' OR stars.star LIKE '%".$search."%' GROUP BY movies.id";
		}
		$query .= " ORDER BY movies.title ASC";
		$db = $this->getDb();
		$db->dbConnect();
		$movies = $db->dbQuery($query, 5);
		foreach($movies as $k => $v) {
			$stars = $db->dbQuery("SELECT stars.star FROM stars INNER JOIN movies_stars ON stars.id = movies_stars.star WHERE movies_stars.movie = ".$movies[$k]['id'], 3);
			$movies[$k]['stars'] = array_map(function($i) {
				return $i[0];
			}, $stars);
		}
		$db->dbDisconnect();
		return $movies;
	}
	public function getMovieById($id) {
		$db = $this->getDb();
		$db->dbConnect();
		$movie = $db->dbQuery("SELECT movies.*, formats.format as format_name FROM movies INNER JOIN formats ON movies.format = formats.id WHERE movies.id = ".$id, 4);
		$stars = $db->dbQuery("SELECT stars.star FROM stars INNER JOIN movies_stars ON stars.id = movies_stars.star WHERE movies_stars.movie = ".$id, 3);
		$movie['stars'] = array_map(function($i) {
			return $i[0];
		}, $stars);
		$db->dbDisconnect();
		return $movie;
	}
	public function saveMovie() {
		$id = !empty($_POST['id']) ? $_POST['id'] : 0;
		if(empty($_POST['title'])) {
			throw new Exception('Title is required!');
		}
		$movie = array(
			'title' => $_POST['title'],
			'release_year' => !empty($_POST['release_year']) ? $_POST['release_year'] : '',
			'format' => !empty($_POST['format']) ? $_POST['format'] : '',
		);
		$movie = array_filter(array_map('trim', $movie));
		$stars = !empty($_POST['stars']) ? array_filter(explode(',', $_POST['stars'])) : '';
		$db = $this->getDb();
		$db->dbConnect();
		$movie['title'] = "'".$movie['title']."'";
		$values = implode(',', $movie);
		if(!empty($id)) {
			$db->dbQuery("UPDATE movies SET title = ".$movie['title'].", release_year = ".$movie['release_year'].", format = ".$movie['format']." WHERE movies.id = ".$id);
		} else {
			$db->dbQuery("INSERT INTO movies (title, release_year, format) VALUES (".$values.")");
			$id = $db->dbQuery("SELECT LAST_INSERT_ID()", 1);
		}
		$this->_deleteMovieStars($id);
		if(!empty($stars)) {
			foreach($stars as $s) {
				$this->_setMovieStar($id, $s);
			}
		}
		$db->dbDisconnect();
		return $id;
	}
	public function deleteMovie($id) {
		$db = $this->getDb();
		$db->dbConnect();
		$db->dbQuery("DELETE FROM movies WHERE id = ".$id);
		$db->dbDisconnect();
		return true;
	}
	public function _setMovieStar($movieId, $star) {
		$starId = 0;
		$star = preg_replace('/\s+/', ' ', trim($star));
		if(!empty($star)) {
			$db = $this->getDb();
			$starId = $db->dbQuery("SELECT id FROM stars WHERE star = '".$star."'", 1);
			if(empty($starId)) {
				$db->dbQuery("INSERT INTO stars (star) VALUES ('".$star."')");
				$starId = $db->dbQuery("SELECT LAST_INSERT_ID()", 1);
			}
			$db->dbQuery("INSERT INTO movies_stars SET movie = ".$movieId.", star = ".$starId);
		}
		return $starId;
	}
	public function _deleteMovieStars($movieId) {
		$db = $this->getDb();
		$db->dbQuery("DELETE FROM movies_stars WHERE movie = ".$movieId);
		return true;

	}
	public function getFormats() {
		$db = $this->getDb();
		$db->dbConnect();
		$formats = $db->dbQuery("SELECT * FROM formats", 4);
		$db->dbDisconnect();
		return $formats;
	}
	public function uploadMovies() {
		if(!empty($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
			$fileUrl = $_FILES['file']['tmp_name'];
			$content = file_get_contents($fileUrl);

			if($content) {
				$movies = array_chunk(array_filter(preg_split('/\r\n|\r|\n/', $content)), 4);
				$moviesData = array();
				if(!empty($movies)) {
					foreach($movies as $k => $v) {
						$moviesData[$k] = array();
						foreach($v as $item) {
							$data = array_map('trim', explode(':', $item));

							if(!empty($data[0]) && !empty($data[1])) {
								$key = str_replace(' ', '_', strtolower($data[0]));
								$value = $data[1];
								if($key == 'stars') {
									$value = array_map('trim', explode(',', $value));
								}
								$moviesData[$k][$key] = $value;
							}
						}
					}
					$db = $this->getDb();
					$db->dbConnect();
					foreach($moviesData as $m) {
						$format = $db->dbQuery("SELECT id FROM formats WHERE format = '".$m['format']."'", 1);
						$db->dbQuery("INSERT INTO movies (title, release_year, format) VALUES ('".$m['title']."', '".$m['release_year']."', ".$format.")");
						$movieId = $db->dbQuery("SELECT LAST_INSERT_ID()", 1);
						foreach($m['stars'] as $s) {
							$star = $db->dbQuery("SELECT id FROM stars WHERE star = '".$s."'", 1);
							if(empty($star)) {
								$db->dbQuery("INSERT INTO stars (star) VALUES ('".$s."')");
								$star = $db->dbQuery("SELECT LAST_INSERT_ID()", 1);
							}
							$db->dbQuery("INSERT INTO movies_stars (movie, star) VALUES ('".$movieId."', '".$star."')");
						}
					}
					$db->dbDisconnect();
				}
			}
		}
	}
}