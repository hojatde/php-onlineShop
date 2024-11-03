<?php
    include "../models/product.php";

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $productId=$_POST["productId"];
        $product=product::fetchOne($productId);
        if($_POST["title"] and $_POST["price"]){
        if($_FILES['imageUrl']){
            $fileName =str_replace(' ','',$_FILES['imageUrl']['name']);
            $isUpload = move_uploaded_file($_FILES['imageUrl']['tmp_name'],"./images/{$fileName}");
        }
        $product->updateOne($_POST["productId"],$_POST["title"],$_POST["price"],($fileName?$fileName:null),$_POST["description"]?$_POST["description"]:null);
        }
        header("location:/products");
    }
    $id=$_GET['id'];
    $id=(int)$id;
    $product=product::fetchOne($id);
    if(!isset($product)){
        echo 'محصولی با ای دی وارد شده ثبت نشده است';
        exit();
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="/productEdit" method="post" enctype="multipart/form-data">
    <input type="hidden" name="productId" value=<?php echo $product->getId() ?>>
<div>
    <label for="title">title</label>
    <input type="text" value="<?php echo $product->getTitle() ?>" name="title" id="title">
</div>
<div>
    <label for="price">price</label>
    <input type="text" value="<?php echo $product->getPrice() ?>" name="price" id="price">
</div>
<div>
    <label for="imageUrl">imageUrl</label>
    <?php
        if($product->getImageUrl()){
            echo "<img src='../../images/{$product->getImageUrl()}'>";
        }
    ?>
    <input type="file" name="imageUrl" id="imageUrl">
</div>
<div>
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10"><?php echo $product->getDescription()?$product->getDescription():'' ?></textarea>
</div>
<button type="submit">ویرایش</button>
</form>
</body>
</html>

