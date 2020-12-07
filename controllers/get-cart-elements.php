<?php
require('./config.php');

if(isset($_SESSION['cart'])){
    $productIdArr = array_column($_SESSION['cart'],'product_id');
    $i = 0;
    foreach($productIdArr as $productHashedId){
        foreach($productsArray as $product){
            if(md5($product['id']) ==  $productHashedId){
                $_SESSION['cart'][$i]['product_name'] = $product['product_name'];
                $_SESSION['cart'][$i]['product_image'] = $product['product_image'];
                $_SESSION['cart'][$i]['product_price'] = $product['product_price'];
                $i++;
                break;
            }
        };
    }
    $response['data'] = $_SESSION['cart'];
    echo json_encode($response);
    return ;
}
else{
    $response['data'] = [];
    echo json_encode($response);
    return ;
}