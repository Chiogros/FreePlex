<?php

class MovieAPI {

    private string $url;
    private string $API_key;
    
    public function __construct(string $url, string $API_key = "") {
        $this->url = $url;
        $this->API_key = $API_key;
        // db4ee98f
    }
    
    public function search_by_title(string $title) : ?Movie {
        $request = $url . urlencode($title) . "&plot=full&r=xml&apikey=" . $this->API_key;
        if ($xml = simplexml_load_file($request)) {
            if ($xml->root['response']) {
                return new Movie($xml);
            }
        }
        return NULL;
    }

}
