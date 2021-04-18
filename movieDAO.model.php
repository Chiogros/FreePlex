<?php

class MovieDAO {

    private string $API_key;
    
    function __construct(string $API_key) {
        $this->API_key = $API_key;
        // db4ee98f
    }

    public function add_Movie(Movie $movie) {
    
    }
    
    public function get_Movie(string $imdb_id) : Movie {
        
    }
    
    public function get_all_movies_value(string $column_name) : array {
    
    }
    
    public function exists(string $imdb_id) : bool {
    
    }
    
    public function remove_Movie(string $imdb_id) : bool {
    
    }
}
