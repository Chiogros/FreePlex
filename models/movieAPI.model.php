<?php

require_once("movie.model.php");

class MovieAPI {

    private string $url;
    private string $API_key;
    
    public function __construct(string $API_key = "") {
        $this->url = "http://www.omdbapi.com/";
        $this->API_key = $API_key;
        // db4ee98f
    }
    
    
    
    public function get(string $title) : Movie {
        $request = $this->url . "?t=" . urlencode($title) . "&plot=full&r=xml&apikey=" . $this->API_key;
        if ($xml = simplexml_load_file($request)) {
            if ($xml['response'] == "True") {
                return Movie::constructorFromXML($xml);
            }
            throw new Exception("Cannot find movie with this title.");
        }
    }
}
