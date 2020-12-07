<?php 

// start session
session_start();


// require db and model
require_once('./models/CreateDB.php');
$shopingDBModel = new CreateDb();
$Products = $shopingDBModel->getData();
$productsArray = $Products->fetch_all(MYSQLI_ASSOC);


// check for post request to this end point

// session_unset();

// if(isset($cartElements)){
//     print_r($cartElements);
// }
// if(isset($_SESSION['cart'])){
//     print_r($_SESSION['cart']);
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    
    <link rel="stylesheet" href="style.css">
    <title>Shopping Cart</title>
</head>
<body>
    <header>
        <h3 class="logo">
            Shopping Cart
        </h3>
        <div style="position: relative;">
            <button id="cart-button" type="button" class="btn btn-light" style="margin-left: auto;">
                <i class="fas fa-shopping-cart"></i>
            </button>
            <div id="cart-dropdown">
                <div class="cart-product">
                    <img class="cart-product-img" src="#" alt="Card image cap">
                    <div class="cart-product-info-wrapper">
                        <h5 class="cart-product-title"></h5>

                        <div class="product-count-wrapper">
                            <button type="button" class="btn btn-light increase-button" data-id="">
                                <i class="fas fa-plus"></i>
                            </button>
                            <input type="number" class="form-control count-input" disabled>
                            <button type="button" class="btn btn-light decrease-button" data-id="">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <h5 class="cart-product-price"></h5>
                </div>
            </div>
        </div>
    </header>

    <form class="cards-wrapper" action="">
        <?php 
            foreach($productsArray as $product):
        ?>
            <div class="card">
                <img class="card-img-top" src="<?php echo $product['product_image']; ?>" alt="Card image cap">
                <div class="card-body">
                    <div class="itemInfoWrapper">
                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text">Lorizzle ipsum dolizzle break yo neck, yall amizzle, hizzle adipiscing stuff. Nullizzle sapien velizzle, ma nizzle volutpizzle, hizzle things, daahng dawg vizzle,</p>
                    </div>
                    <div class="addButtonWrapper">
                        <h4 class="card-title"><?php echo $product['product_price']; ?>$</h4>
                        <button type="button" class="btn btn-primary submitButton"  data-id="<?php echo md5($product['id']); ?>">Add To Cart</button>    
                    </div>
                </div>
            </div>
        <?php 
            endforeach
        ?>

    </form>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>
</html>