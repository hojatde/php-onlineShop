<?php
include "../public/database.php";
include "../models/cart.php";
//include "../models/user.php";

class user{
    private $username,$password,$firstName,$lastName,$phoneNumber,$dataCreated;
    function __construct($inputUsername,$inputPassword,$inputFirstName=null,$inputLastName=null,$inputPhoneNumber=null)
    {
        $this->username=$inputUsername;
        $this->password=$inputPassword;
        if($inputFirstName){$this->firstName=$inputFirstName;}
        if($inputLastName){$this->lastName=$inputLastName;}
        if($inputPhoneNumber){$this->phoneNumber=$inputPhoneNumber;}
    }

    public function save(){
        $dbConnect = connectDB();
        $user=self::findOne($this->username);
        if($user){
            echo 'already exist';
            exit();
        }
        $stmt=$dbConnect->prepare("insert into users (username,password,firstname,lastName,phoneNumber) values (?,?,?,?,?)");
        $stmt->bind_param('sssss',$this->username,$this->password,$this->firstName,$this->lastName,$this->phoneNumber);
        $stmt->execute();
        $stmt->close();
        $dbConnect->close();
    }
    public function createCart(){
        $existCart=$this->getCart();
        if($existCart) {return $existCart['id'];}
        $dbConnect = connectDB();
        $stmt = $dbConnect->prepare('insert into cart (userId) values (?)');
        $stmt->bind_param('s',$this->username);
        $stmt->execute();
        $stmt->close();$dbConnect->close();return 0;
    }
    public function getCart(){
        $dbConnect = connectDB();
        $stmt = $dbConnect->prepare('select * from cart where userId=?');
        $stmt->bind_param('s',$this->username);
        $stmt->execute();
        $existCart=$stmt->get_result()->fetch_assoc();
        $stmt->close();$dbConnect->close();
        if(!isset($existCart)){
            return null;
        }
        return new cart($this->username,$existCart['id']);
    }

    public function addProductToCart($productId){
        $cart = $this->getCart();
        if(!$cart) {
            $this->createCart();
            $cart = $this->getCart();
        }
        $cart->increaseProduct($productId);
    }


    static function findOne($username){
        $dbConnect = connectDB();
        $stmt=$dbConnect->prepare("select * from users where username=?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if($user){return new user($user['username'],$user['password'],$user['firstName'],$user['password'],$user['phoneNumber']);}
        return null;
    }

}
