<?php
include "../models/user.php";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $inputUsername=$_POST["username"];
    $inputPassword=$_POST["password"];
    $inputFirstName = $_POST["firstName"];
    $inputLastName=$_POST["lastName"];
    $inputPhoneNumber = $_POST["phoneNumber"];
    $newUser = new user($inputUsername,$inputPassword,$inputFirstName,$inputLastName,$inputPhoneNumber);
    $newUser->save();

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
    <form action="/signup" method="post">
        <div>
            <label for="username">نام کاربری</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">رمز عبور</label>
            <input type="text" name="password" id="password">
        </div>
        <div>
            <label for="firstName">نام</label>
            <input type="text" name="firstName" id="firstName">
        </div>
        <div>
            <label for="lastName">نام خانوادگی</label>
            <input type="text" name="lastName" id="lastName">
        </div>
        <div>
            <label for="phoneNumber">تلفن همراه </label>
            <input type="text" name="phoneNumber" id="phoneNumber">
        </div>
        <button type="submit">ثبت نام</button>
    </form>
</body>
</html>
