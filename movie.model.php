<?php

class Movie {

    private string $title;
    private int $year;
    private string $classification;
    private DateTime $realease_date;
    private string $runtime;
    private string $genre;
    private Person $director;
    private Person[] $writers;
    private Person[] $actors;
    private string $synopsis;
    private string $languages;
    private string $countries;
    private string $awards;
    private string $poster_url;
    private int $metascore;
    private float $imdb_rating;
    private float $imdb_votes;
    private string $imdb_id;
    private string $type;
    
    function __construct(
        string $title, 
        int $year,
        string $classification,
        DateTime $release_date,
        string $runtime,
        string $genre,
        Person $director,
        Person[] $writers
        Person[] $actors,
        string $synopsis,
        string $languages,
        string $countries,
        string $awards,
        string $poster_url,
        string $metascore,
        string $imdb_rating,
        float $imdb_votes,
        string $imdb_id,
        string $type) 
    {
        $this->title = $title;
        $this->year = $year;
        $this->classification = $classification;
        $this->release_date = $release_date;
        $this->runtime = $runtime;
        $this->genre = $genre;
        $this->director = $director;
        $this->writer = $writers;
        $this->actors = $actors;
        $this->synopsis = $synopsis;
        $this->languages = $languages;
        $this->countries = $coutries;
        $this->awards = $awards;
        $this->poster_url = $poster_url;
        $this->metascore = $metascore;
        $this->imdb_rating = $imdb_rating;
        $this->imdb_votes = $imdb_votes;
        $this->imdb_id = $imdb_id;
        $this->type = $type
    }
    
    public function __get(string $attribute_name) : mixed {
        return $this->$attribute_name;
    }
    
    public function __set(string $attribute_name, mixed $attribute_value) : bool {
        return $this->$attribute_name = $attribute_value;
    }

}
