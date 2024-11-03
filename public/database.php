<?php
function connectDB(){
    $dbConnect = mysqli_connect('localhost:3306','root','*******','phptest');
    if($dbConnect){
        return $dbConnect;
    }else{
        echo 'connect to database failed';
        exit();
    }
}

?>
