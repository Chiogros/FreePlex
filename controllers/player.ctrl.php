<?php

require_once("../models/movieDAO.model.php");

$dao = new MovieDAO();

try {

	$item = $dao->get($_GET['imdb_id']);
	require("../views/player.view.html");
	
} catch (Exception $e) {
	
	// $message = $e->getMessage();
	// Redirect to 404
	header("Location: ../views/404.view.html", true, 404);
	exit;
}


