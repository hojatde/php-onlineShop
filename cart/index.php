<?php
include "../models/user.php";

$user = user::findOne('hojat');
if($user){
    $cart=$user->getCart();
    $cartItems=[];
    if($cart) {
        $cartItems = $cart->getCartItems();
        if (isset($_GET['action']) and isset($_GET['productId'])) {
            if ($_GET['action'] === 'increaseProduct') $cart->increaseProduct($_GET['productId']);
            else if ($_GET['action'] === 'decreaseProduct') $cart->decreaseProduct($_GET['productId']);
            else if ($_GET['action'] === 'deleteProduct') $cart->deleteProduct($_GET['productId']);
            header("location:/cart");
        } else if (isset($_GET['action']) and $_GET['action'] === 'pay') $cart->createOrder();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<table id="customers">
    <tr>
        <th>ردیف</th><th>عنوان</th><th>تعداد</th><th>قیمت واحد</th><th>قیمت کل</th>
    </tr>

    <?php
    $c=1;
    $endSum=0;
    foreach($cartItems as $item){
        $sum = $item['quantity']*$item['price'];
        $endSum+=$sum;
        echo "<tr><td>$c</td><td>{$item['title']}</td><td>{$item['quantity']}</td><td>{$item['price']}</td><td>{$sum}</td>
<td><a href='/cart?action=increaseProduct&productId={$item["productId"]}'>+</a></td>
<td><a href='/cart?action=decreaseProduct&productId={$item["productId"]}'>-</a></td>
<td><a href='/cart?action=deleteProduct&productId={$item["productId"]}'>حذف</a></td>
</tr>";
        $c++;
    }
    ?>
    <tr><td colspan="5">مبلغ کل</td></tr>
    <tr><td colspan="5"><?php echo $endSum ?></td></tr>
    <tr><td colspan="5"></td></tr>
    <tr><td colspan="5"><a href="/cart?action=pay">پرداخت</a></td></tr>

</table>
</body>
</html>
