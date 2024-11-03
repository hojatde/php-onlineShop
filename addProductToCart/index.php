<?php
include "../models/user.php";

$user = user::findOne('hojat');
if($user){
     $user->addProductToCart($_GET['productId']);
     header('location:/products');
}
if($_GET['productId']){
}else{
    echo 'productId not set';
    exit();
}
