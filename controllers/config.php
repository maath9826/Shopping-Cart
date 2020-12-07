<?php 

// start session
session_start();


// require db and model
require_once('../models/CreateDB.php');
$shopingDBModel = new CreateDb();
$Products = $shopingDBModel->getData();
$productsArray = $Products->fetch_all(MYSQLI_ASSOC);
$cartElements = [];
$response = array(
    'success'=> true,
    'data'=> '',
    'message' => '',
);