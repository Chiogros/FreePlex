<?php

class MovieDAO {

    private PDO $db
    
    function __construct() {
        $dsn = "sqlite:";
        try { 
            $this->db = new PDO($dsn); 
        } catch(PDOException $e) { 
            echo "The database cannot be opened : " . $e->getMessage(); 
        }
    }

    public function add_Movie(Movie $movie) {
        $sql = "INSERT INTO Movies VALUES (
            :title,
            :year,
            :classification,
            :release_date,
            :runtime,
            :genre,
            :director
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
        $request->bindValue(':release_date',$movie->release_date , PDO::PARAM_STR);
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
    
    public function get_Movie(string $imdb_id) : ?Movie {
        $sql = "SELECT * FROM Movies WHERE imdb_id = :imdb_id";
        $request = $this->db->prepare($sql);
        $request->bindValue(':imdb_id', $imdb_id, PDO::PARAM_STR);
        $request->execute();
        return $request->fetchObject("Movie", PDO::FETCH_PROPS_LATE);
    }
    
    public function get_all_movies_value(string $column_name) : array {
        $sql = "SELECT * FROM Movies";
        $request = $this->db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_COLUMN, $column_name);
    }
    
    public function remove_Movie(string $imdb_id) : bool {
        $sql = "DELETE FROM Movies WHERE imdb_id = :imdb_id";
        $request = $this->db->prepare($sql);
        $request->bindValue(':imdb_id', $imdb_id, PDO::PARAM_STR);
        return $request->execute();
    }
}
