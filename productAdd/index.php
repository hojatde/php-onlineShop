<?php

    include '../models/product.php';

    $hasError=false;
if($_SERVER["REQUEST_METHOD"]==="POST"){
    if($_POST["title"] and $_POST["price"]){
        if($_FILES['imageUrl']){
            $fileName =str_replace(' ','',$_FILES['imageUrl']['name']);
            $isUpload = move_uploaded_file($_FILES['imageUrl']['tmp_name'],"./images/{$fileName}");
        }
        $newProduct=new product(null,$_POST["title"],$_POST["price"],$isUpload ? $fileName : null,($_POST["description"]) ? $_POST["description"] : null);
        $newProduct->save();
        }else{
            $GLOBALS["hasError"]="title and price is required.";
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <form action="/productAdd" method="post" enctype="multipart/form-data">
        <div class="error" style="display: <?php echo($GLOBALS["hasError"]) ? 'block' : 'none'; ?>;">
            <p><?php echo($GLOBALS["hasError"]) ?></p>
        </div>
        <div>
            <label for="title">title</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="price">price</label>
            <input type="text" name="price" id="price">
        </div>
        <div>
            <label for="imageUrl">imageUrl</label>
            <input type="file" name="imageUrl" id="imageUrl">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
        </div>
        <button type="submit">send</button>
    </form>
</body>
</html>

<!-- 

    ----------------------------
    create new Table
     $myQuery = "create table product(id smallint primary key not null auto_increment,
                    title char(50) not null,
                    price mediumint unsigned not null,
                    imageurl char(255),
                    description text
                )";


    
    $dbConnect = mysqli_connect('localhost:3306','root','691377','phpTest');
           if($dbConnect){
                echo('succses-');
                $myQuery = "create table product(id smallint primary key not null auto_increment,
                     title char(50) not null,
                     price mediumint unsigned not null,
                     imageurl char(255),
                 description text
             )";
          
             if(mysqli_query($dbConnect,$myQuery)){
                 echo 'created';
             }else{
                 echo '!!!' . mysqli_error($dbConnect);
             }
         }else{
             echo("dismiss");
         }
    mysqli_close($dbConnect);
 -->
 