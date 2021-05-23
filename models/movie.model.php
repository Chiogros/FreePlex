<?php

class Movie {

    private string $title;
    private ?int $year;
    private ?string $classification;
    private ?DateTime $release_date;
    private int $runtime;   // in minutes
    private ?string $genre;
    private ?string $director;
    private ?string $writers;
    private ?string $actors;
    private ?string $synopsis;
    private ?string $languages;
    private ?string $countries;
    private ?string $awards;
    private ?string $poster_url;
    private ?string $metascore;
    private ?float $imdb_rating;
    private ?int $imdb_votes;
    private ?string $imdb_id;
    private ?string $type;
    
    private function __construct(
        string $title, 
        ?int $year,
        ?string $classification,
        ?DateTime $release_date,
        int $runtime,
        ?string $genre,
        ?string $director,
        ?string $writers,
        ?string $actors,
        ?string $synopsis,
        ?string $languages,
        ?string $countries,
        ?string $awards,
        ?string $poster_url,
        ?string $metascore,
        ?float $imdb_rating,
        ?int $imdb_votes,
        ?string $imdb_id,
        ?string $type) 
    {
        $this->title = $title;
        $this->year = $year;
        $this->classification = $classification;
        $this->release_date = $release_date;
        $this->runtime = $runtime;
        $this->genre = $genre;
        $this->director = $director;
        $this->writers = $writers;
        $this->actors = $actors;
        $this->synopsis = $synopsis;
        $this->languages = $languages;
        $this->countries = $countries;
        $this->awards = $awards;
        $this->poster_url = $poster_url;
        $this->metascore = $metascore;
        $this->imdb_rating = $imdb_rating;
        $this->imdb_votes = $imdb_votes;
        $this->imdb_id = $imdb_id;
        $this->type = $type;
    }
    
    public static function constructorFromXML(SimpleXMLElement $xml)  {
        $movie_xml = $xml->movie;

        return new Movie(
	        $movie_xml['title'],
	        (int) $movie_xml['year'],
	        $movie_xml['rated'],
	        DateTime::createFromFormat("d M Y", $movie_xml['released']),
	        (int) strtok($movie_xml['runtime'], ' '),
	        $movie_xml['genre'],
	        $movie_xml['director'],
	        $movie_xml['writer'],
	        $movie_xml['actors'],
	        $movie_xml['plot'],
	        $movie_xml['language'],
	        $movie_xml['country'],
	        $movie_xml['awards'],
	        $movie_xml['poster'],
	        $movie_xml['metascore'],
	        (float) $movie_xml['imdbRating'],
	        (int) $movie_xml['imdbVotes'],
	        $movie_xml['imdbID'],
	        $movie_xml['type']
        );
    }
    
    public static function constructorFromParameters(
	    string $title, 
        ?int $year,
        ?string $classification,
        ?DateTime $release_date,
        int $runtime,
        ?string $genre,
        ?string $director,
        ?string $writers,
        ?string $actors,
        ?string $synopsis,
        ?string $languages,
        ?string $countries,
        ?string $awards,
        ?string $poster_url,
        ?string $metascore,
        ?float $imdb_rating,
        ?int $imdb_votes,
        ?string $imdb_id,
        ?string $type )
    {
	    return new Movie(
		    $title,
		    $year,
		    $classification,
		    $release_date,
		    $runtime,
		    $genre,
		    $director,
		    $writers,
		    $actors,
		    $synopsis,
		    $languages,
		    $countries,
			$awards,
	        $poster_url,
	        $metascore,
	        $imdb_rating,
	        $imdb_votes,
	        $imdb_id,
	        $type
	    );
    }
    
    public static function constructorForDAO(array $data) {
	    return new Movie(
		    $data['title'],
		    $data['year'],
		    $data['classification'],
		    DateTime::createFromFormat("d/m/Y", $data['release_date']),
		    $data['runtime'],
		    $data['genre'],
		    $data['director'],
		    $data['writers'],
		    $data['actors'],
		    $data['synopsis'],
		    $data['languages'],
		    $data['countries'],
			$data['awards'],
	        $data['poster_url'],
	        $data['metascore'],
	        $data['imdb_rating'],
	        $data['imdb_votes'],
	        $data['imdb_id'],
	        $data['type']
	    );
    }
    
    public function __get(string $attribute_name) {
        return $this->$attribute_name;
    }
    
    public function __set(string $attribute_name, $attribute_value) : bool {
        if (isset($this->$attribute_name)) {
	        $this->$attribute_name = $attribute_value;
	        return true;
        } else {
	        return false;
        }
    }

}
