<?php
include_once "../public/database.php";

class order{
    private $id,$userId;
    function __construct($inputId=null,$inputUserId)
    {
        if($inputId)$this->id=$inputId;
        $this->userId=$inputUserId;
    }
    public function save(){
        $dbConnect = connectDB();
        $stmt = $dbConnect->prepare("insert into `order` (userId) values (?)");
        $stmt->bind_param('s',$this->userId);
        $stmt->execute();
        $stmt->close();
        $stmt = $dbConnect->prepare("select id from `order` where userId= ? ");
        $stmt->bind_param('s',$this->userId);
        $stmt->execute();
        $this->id=$stmt->get_result()->fetch_assoc()['id'];
        $stmt->close();$dbConnect->close();

    }
    public function createOrder($array){
        $dbConnect = connectDB();
        $stmt = $dbConnect->prepare('insert into orderItem (orderId,productId,quantity,price) values (?,?,?,?)');
        $stmt->bind_param('iiii',$orderId,$productId,$quantity,$price);
        foreach ($array as $item){
            $orderId = $this->id;
            $productId=$item['productId'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $stmt->execute();
        }
        $stmt->close();
        $stmt = $dbConnect->prepare('insert into orderItem (orderId,productId,quantity,price) values (?,?,?,?)');
        $stmt->prepare("delete from cart where userId=?");
        $stmt->bind_param('s',$this->userId);
        $stmt->execute();
        $stmt->close();$dbConnect->close();
    }

}
