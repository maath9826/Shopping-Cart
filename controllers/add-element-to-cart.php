<?php
require('./config.php');



if(isset($_POST['hashed_id'])){
    if(isset($_SESSION['cart'])){ // check if session variable already exist
        $productIdArr = array_column($_SESSION['cart'],'product_id');
        if(in_array($_POST['hashed_id'],$productIdArr)){ // check if product already added 
            $response['success'] = false;
            $response['message'] = 'this product is already added';
            echo json_encode($response);
            return ;
        }
        else{
            $productArray = array(
                'product_id' => $_POST['hashed_id'],
                'count' => 1,
                'product_name'=>'',
                'product_image'=>'',
                'product_price'=>'',
            );
            $count = count( $_SESSION['cart']);
            $productId = $productArray['product_id'];
            foreach($productsArray as $product){
                if(md5($product['id']) ==  $productId){
                    $productArray['product_name'] = $product['product_name'];
                    $productArray['product_image'] = $product['product_image'];
                    $productArray['product_price'] = $product['product_price'];
                    break;
                }
            };
            $_SESSION['cart'][$count] = $productArray;
            $response['data'] = $productArray;
            echo json_encode( $response);
            return ;
        }
    }
    else{
        $productArray = array(
            'product_id' => $_POST['hashed_id'],
            'count' => 1,
            'product_name'=>'',
            'product_image'=>'',
            'product_price'=>'',
        );
        $productId =  $productArray['product_id'];
        foreach($productsArray as $product){
            if(md5($product['id']) ==  $productId){
                $productArray['product_name'] = $product['product_name'];
                $productArray['product_image'] = $product['product_image'];
                $productArray['product_price'] = $product['product_price'];
                break;
            }
        };
        $_SESSION['cart'][0] = $productArray;
        $response['data'] =  $productArray;
        echo json_encode($response);
        return ;
    }
}
else if(isset($_POST['productToChangeCount'])){

    $productId = $_POST['productToChangeCount'];
    $count = $_POST['count'];
    for($x = 0; $x < count($_SESSION['cart']); $x++){
        if($_SESSION['cart'][$x]['product_id'] == $productId){
            if($count == 0){
                array_splice($_SESSION['cart'],$x,1);
                $response['data'] =  $_SESSION['cart'];
                echo json_encode($response);
                return ;
            }
            else{
                $_SESSION['cart'][$x]['count'] = $count;
            }
        }
    }

}