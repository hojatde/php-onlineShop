<?php
include "../models/product.php";
if($_SERVER["REQUEST_METHOD"]==="GET" || empty($_POST['productId'])){
    header("location:/");
}

$productId =$_POST["productId"];
$product=product::fetchOne($productId);
if($product){
    if($product->deleteProduct()){
        echo 'delete product error ';
        exit();
    }
}
header("location:/products");
