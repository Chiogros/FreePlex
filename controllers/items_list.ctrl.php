<?php

require_once("../models/movieDAO.model.php");
require_once("../models/movieAPI.model.php");

$api = new MovieAPI("db4ee98f");
$dao = new MovieDAO();

// $dao->add_Movie($api->get_Movie("Transformers: Revenge of the Fallen"));
// $dao->add_Movie($api->get_Movie("Transformers"));
try {
	$api->get_Movie("rbvercse");
} catch (\Exception $e) {
	echo "Ce film n'existe pas";
}



// Displaying

$IDs = $dao->get_all_imdb_ids();
$items = array();
foreach($IDs as $ID) {
	array_push($items, $dao->get_Movie($ID));
}



require("../views/items_list.view.html");
