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
    private ?string $path;
    public static array $arr;
    
    public function __construct(array $data) 
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
        $this->path = $path;
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
	        $movie_xml['type'],
	        null
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
        ?string $type,
        ?string $path )
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
	        $type,
	        $path
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
			$data['type'],
			$data['path']
		);
	}
    
	public function __get(string $attribute_name) {
		return $this->$attribute_name;
	}
    
    public static function get_sortable_attributes() : array {
	    return array("title", "year", "release_date", "runtime", "languages", "director", "coutries", "metascore", "imdb_rating", "imdb_votes", "type");
    }
    
	public function __set(string $attribute_name, $attribute_value) {
		/*if (isset($this->$attribute_name) === false)
			throw new Exception($attribute_name . " doesn't exist as attribute in " . __CLASS__ . ".");*/
		
		$this->$attribute_name = $attribute_value;
	}

	public static function sort_by(string $attribute_name, string $order, array &$movies) {
	    /*
	     *	Comparison functions
	     */
	    {
		    $string_and_int_comparison_function = function (Movie $m1, Movie $m2) use ($attribute_name) {
				return strcmp($m1->$attribute_name, $m2->$attribute_name);
			};
			
			$other_comparison_function = function (Movie $m1, Movie $m2) use ($attribute_name) {
				if ($m1->$attribute_name > $m2->$attribute_name) return 1;
				if ($m1->$attribute_name == $m2->$attribute_name) return 0;
				if ($m1->$attribute_name < $m2->$attribute_name) return -1;
			};
		}
		
		// Verify that the order is ASC or DESC
	    if ($order != "ASC" && $order != "DESC")
			throw new Exception("2nd parameter must be string ASC (for ascending order) or DESC (for descending order)");
	    
	    // Verify that attribute_name is allowed to be sorted
		if (in_array($attribute_name, Movie::get_sortable_attributes()) === false)
		    throw new Exception("Cannot order movies by $attribute_name");
	    
	    // Choose comparison function (especially for DateTime)
	    $function = $attribute_name == "release_date" ? $other_comparison_function : $string_and_int_comparison_function;
	    
	    // Sort
	    usort($movies, $function);
		
	    // If a DESC sort, reverse the array
	    if ($order == "DESC")
		    rsort($movies);
		    
	}
}
