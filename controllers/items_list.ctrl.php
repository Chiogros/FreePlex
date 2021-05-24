<?php

require_once("../models/movieDAO.model.php");
require_once("../models/movieAPI.model.php");

$api = new MovieAPI("db4ee98f");
$dao = new MovieDAO();

// Displaying

$items = $dao->get_all_movies();
Movie::sort_by("release_date", "ASC", $items);

require("../views/items_list.view.html");
