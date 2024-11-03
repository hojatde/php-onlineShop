<?php
    include '../models/product.php';
    $stmt = product::fetchAll();
    $stmt->bind_result($id,$title,$price,$imageurl,$description);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css" >
</head>
<body>
    <h1>Products</h1>
    <table id="customers">
        <tr>
            <th>ردیف</th>
            <th>عنوان</th>
            <th>قیمت</th>
            <th>ادرس عکس</th>
            <th>توضیحات</th>
        </tr>
        <?php

            while ($stmt->fetch()) {
                echo "<tr><td>{$id}</td><td>{$title}</td><td>{$price}</td><td><img src=./images/{$imageurl}></td><td>{$description}</td>
<td><a href='/addProductToCart?productId={$id}'>add to cart</a></td>
<td><a href='productEdit?id={$id}'>edit</a></td>
<td>
<form action='/productDelete' method='post'>
<input type='hidden' name='productId' value={$id}>
<button type='submit'>حذف</button>
</form>
</td>
</tr>";
            }

        ?>
    </table>
</body>
</html>