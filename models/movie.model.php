<?php

class Movie {

    private string $title;
    private ?int $year;
    private ?string $classification;
    private ?DateTime $realease_date;
    private int $runtime;   // in minutes
    private ?string $genre;
    private ?Person $director;
    private ?Person[] $writers;
    private ?Person[] $actors;
    private ?string $synopsis;
    private ?string $languages;
    private ?string $countries;
    private ?string $awards;
    private ?string $poster_url;
    private ?int $metascore;
    private ?float $imdb_rating;
    private ?float $imdb_votes;
    private ?string $imdb_id;
    private string $type;
    
    function __construct(
        string $title, 
        ?int $year,
        ?string $classification,
        ?DateTime $release_date,
        string $runtime,
        ?string $genre,
        ?Person $director,
        ?Person[] $writers
        ?Person[] $actors,
        ?string $synopsis,
        ?string $languages,
        ?string $countries,
        ?string $awards,
        ?string $poster_url,
        ?string $metascore,
        ?string $imdb_rating,
        ?float $imdb_votes,
        ?string $imdb_id,
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
        $this->type = $type;
    }
    
    function __construct(SimpleXMLElement $xml)  {
        $movie_xml = $xml->root->movie;
        $this->title = $movie_xml['title'];
        $this->year = $movie_xml['year'];
        $this->classification = $movie_xml['rated'];
        $this->release_date = createFromFormat("d M Y", $movie_xml['released']);
        $this->runtime = (int) strtok($movie_xml['runtime'], ' ');
        $this->genre = $movie_xml['genre'];
        $this->director = $movie_xml['director'];
        $this->writer = $movie_xml['writer'];
        $this->actors = $movie_xml['actors'];
        $this->synopsis = $movie_xml['plot'];
        $this->languages = $movie_xml['language'];
        $this->countries = $movie_xml['country'];
        $this->awards = $movie_xml['awards'];
        $this->poster_url = $movie_xml['poster'];
        $this->metascore = $movie_xml['metascore'];
        $this->imdb_rating = $movie_xml['imdbRating'];
        $this->imdb_votes = $movie_xml['imdbVotes'];
        $this->imdb_id = $movie_xml['imdbID'];
        $this->type = $movie_xml['type'];
    }
    
    public function __get(string $attribute_name) : mixed {
        return $this->$attribute_name;
    }
    
    public function __set(string $attribute_name, mixed $attribute_value) : bool {
        return $this->$attribute_name = $attribute_value;
    }

}
