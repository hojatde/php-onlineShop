<?php
include '../models/product.php';
$stmt = product::fetchAll();
$stmt->bind_result($id,$title,$price,$imageurl,$description);
?>