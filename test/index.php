<?php
include '../models/product.php';

$dbConnect = mysqli_connect('localhost:3306','root','691377','phptest');
if($dbConnect->errno){
    exit();
}
$stmt = $dbConnect->prepare('create table users (id smallint primary key unsigned not null auto_increment,
username char(50) not null ,
password char 50 not null ,
firstName char(50),
lastName char(50),
createTime timestamp default (current_timestamp)
)');

//$stmt->bind_param('i',$id);
$stmt->execute();
//$stmt->bind_result($id,$title,$price,$imageurl,$description);
var_dump($stmt->errno);



?>