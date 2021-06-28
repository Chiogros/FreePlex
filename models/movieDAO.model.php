<?php

class MovieDAO {

	private PDO $db;
    
	function __construct() {
		$dsn = "sqlite:../data/mmdb";
		try { 
			$this->db = new PDO($dsn); 
		} catch(PDOException $e) { 
			$message = "The database cannot be opened : " . $e->getMessage();
			echo $message;
			throw new Exception($message);
		}
	}

	public function add_Movie(Movie $movie) {
		
		// Save poster
		try {
			$this->save_poster_to_local($movie->poster_url, $movie->imdb_id);
		} catch (Exception $ex) {
			error_log($ex->getMessage());
		}
	
		// Verify that Movie isn't already in db
		if ($this->exists_Movie($movie->imdb_id))
			throw new Exception("A movie with this imdb_id is already in database.");

		// Add Movie in db
		$sql = "INSERT INTO Movies VALUES (
			:title,
			:year,
			:classification,
			:release_date,
			:runtime,
			:genre,
			:director,
			:writers,
			:actors,
			:synopsis,
			:languages,
			:countries,
			:awards,
			:poster_url,
			:metascore,
			:imdb_rating,
			:imdb_votes,
			:imdb_id,
			:type)";
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':title',$movie->title , PDO::PARAM_STR);
			$request->bindValue(':year',$movie->year , PDO::PARAM_INT);
			$request->bindValue(':classification',$movie->classification , PDO::PARAM_STR);
			$request->bindValue(':release_date',$movie->release_date->format("d/m/Y") , PDO::PARAM_STR);
			$request->bindValue(':runtime',$movie->runtime , PDO::PARAM_INT);
			$request->bindValue(':genre',$movie->genre , PDO::PARAM_STR);
			$request->bindValue(':director',$movie->director , PDO::PARAM_STR);
			$request->bindValue(':writers',$movie->writers , PDO::PARAM_STR);
			$request->bindValue(':actors',$movie->actors , PDO::PARAM_STR);
			$request->bindValue(':synopsis',$movie->synopsis , PDO::PARAM_STR);
			$request->bindValue(':languages',$movie->languages , PDO::PARAM_STR);
			$request->bindValue(':countries',$movie->countries , PDO::PARAM_STR);
			$request->bindValue(':awards',$movie->awards , PDO::PARAM_STR);
			$request->bindValue(':poster_url',$movie->poster_url , PDO::PARAM_STR);
			$request->bindValue(':metascore',$movie->metascore , PDO::PARAM_INT);
			$request->bindValue(':imdb_rating',$movie->imdb_rating , PDO::PARAM_INT);
			$request->bindValue(':imdb_votes',$movie->imdb_votes , PDO::PARAM_INT);
			$request->bindValue(':imdb_id',$movie->imdb_id , PDO::PARAM_STR);
			$request->bindValue(':type',$movie->type , PDO::PARAM_STR);
			$request->execute();
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function exists_Movie(string $imdb_id) : bool {
		$sql = "SELECT COUNT(*) FROM Movies WHERE imdb_id = :imdb_id";
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':imdb_id', $imdb_id, PDO::PARAM_STR);
			$request->execute();
			return $request->fetch()[0];
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function get_Movie(string $imdb_id) : Movie {
		$sql = "SELECT * FROM Movies WHERE imdb_id = :imdb_id";

		if ($this->exists_Movie($imdb_id) === false)
			throw new Exception("This imdb_id isn't in database.");
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':imdb_id', $imdb_id, PDO::PARAM_STR);
			$request->execute();
			$dataFetched = $request->fetchAll()[0]; // [0] because data are already stored in an array
			return Movie::constructorForDAO($dataFetched);
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function get_all_imdb_ids() : array {
		$sql = "SELECT imdb_id FROM Movies";
		
		try {
			$request = $this->prepare_request($sql);
			$request->execute();
			return $request->fetchAll(PDO::FETCH_COLUMN, 0);
		} catch (Exception $ex) {
			throw $ex;
		}
	}
	
	public function get_all_movies() : array {
		$sql = "SELECT * FROM Movies";
		
		try {
			$request = $this->prepare_request($sql);
			$request->execute();
			$dataFetched = $request->fetchAll();
			$movies = array();
			foreach($dataFetched as $row) {
				array_push($movies, Movie::constructorForDAO($row));
			}
			return $movies;
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function get_number_of_movies() : int {
		$sql = "SELECT COUNT(*) FROM Movies";
		
		try {
			$request = $this->prepare_request($sql);
			$request->execute();
			return $request->fetch()[0];
		} catch (Exception $ex) {
			throw $ex;
		}
	}

	private function prepare_request(string $sql) : PDOStatement {
		$request = $this->db->prepare($sql);
		if ($request === false)
			throw new Exception("Cannot prepare request. Is database available?");
		
		return $request;
	}
	
	public function remove_Movie(string $imdb_id) : bool {
		$sql = "DELETE FROM Movies WHERE imdb_id = :imdb_id";
		
		if ($this->exists_Movie($imdb_id) === false)
			return false;
		
		try {
			$request = $this->prepare_request($sql);
			$request->bindValue(':imdb_id', $imdb_id, PDO::PARAM_STR);
			return $request->execute();
		} catch (Exception $ex) {
			throw $ex;
		}
	}
    
	public function save_poster_to_local(string $poster_url, string $imdb_id) : string {
		$poster_path = "../data/posters/" . $imdb_id . ".jpg";
		
		if (file_exists($poster_path))
			throw new Exception("Cannot save poster: " . $poster_path . " already exists.");
		
		$poster_data = file_get_contents($poster_url);
		if ($poster_data === false)
			throw new Exception("Cannot save poster: the poster url isn't available " . $poster_url);
		
		$poster_file = fopen($poster_path, "w");
		if ($poster_file === false)
			throw new Exception("Cannot save poster: are rights on the folder ./data/posters properly set?");
		
		if (fwrite($poster_file, $poster_data) === false)
			throw new Exception("Cannot save poster: unknown error.");
		
		return $poster_path;
	}
}
