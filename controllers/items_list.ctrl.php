<?php

require_once("../models/movieDAO.model.php");
require_once("../models/movieAPI.model.php");
require_once("../models/movie.model.php");

$api = new MovieAPI("db4ee98f");
$dao = new MovieDAO();

$films = array(
	"Iron Man",
	"The Incredible Hulk",
	"Iron Man 2",
	"Thor",
	"Captain America: The First Avenger",
	"Marvel's The Avengers",
	"Iron Man 3",
	"Thor: The Dark World",
	"Captain America: The Winter Soldier",
	"Guardians of the Galaxy",
	"Avengers: Age of Ultron",
	"Ant-Man",
	"Captain America: Civil War",
	"Doctor Strange",
	"Guardians of the Galaxy Vol. 2",
	"Spider-Man: Homecoming",
	"Thor: Ragnarok",
	"Black Panther",
	"Avengers: Infinity War",
	"Ant-Man and the Wasp",
	"Captain Marvel",
	"Avengers: Endgame",
	"Spider-Man: Far From Home",
	"Oui-oui"
	); 


foreach ($films as $film) {
	$movie = null;
	try {
		$movie = $api->get($film);
	} catch (Exception $ex) {
		$movie = new Movie($film, null, null, null, 0, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
	} finally {
		$movie->path = "/home/alex/film/ok.mkv";
		$dao->add($movie);
	}
	
}

// Displaying

$items = $dao->get_all_movies();
Movie::sort_by("release_date", "ASC", $items);

require("../views/items_list.view.html");
