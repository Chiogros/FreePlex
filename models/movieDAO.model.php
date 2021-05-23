<?php

class MovieDAO {

    private PDO $db;
    
    function __construct() {
        $dsn = "sqlite:../data/mmdb";
        try { 
            $this->db = new PDO($dsn); 
        } catch(PDOException $e) { 
            echo "The database cannot be opened : " . $e->getMessage(); 
        }
    }

    public function add_Movie(Movie $movie) {
	    try {
		    $this->get_Movie($movie->imdb_id);
		    throw new Exception("A movie with this imdb_id is already in database");
	    
	    } catch (Exception $ex) {
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
	        $request = $this->db->prepare($sql);
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
        }
    }
    
    public function get_Movie(string $imdb_id) : Movie {
        $sql = "SELECT * FROM Movies WHERE imdb_id = :imdb_id";
        $request = $this->db->prepare($sql);
        $request->bindValue(':imdb_id', $imdb_id, PDO::PARAM_STR);
        $request->execute();
        $dataFetched = $request->fetchAll()[0]; // [0] because data are already stored in an array
        if (count($dataFetched) == 0)
	        throw new Exception("This imdb_id doesn't exist in database.");
        return Movie::constructorForDAO($dataFetched);
    }
    
    public function get_all_imdb_ids() : array {
        $sql = "SELECT * FROM Movies";
        $request = $this->db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_COLUMN, 17);
    }
    
    public function get_number_of_movies() : int {
	    $sql = "SELECT COUNT(imdb_id) FROM Movies";
        $request = $this->db->prepare($sql);
        return $request->fetchColumn();
    }
    
    public function remove_Movie(string $imdb_id) : bool {
        $sql = "DELETE FROM Movies WHERE imdb_id = :imdb_id";
        $request = $this->db->prepare($sql);
        $request->bindValue(':imdb_id', $imdb_id, PDO::PARAM_STR);
        return $request->execute();
    }
}
