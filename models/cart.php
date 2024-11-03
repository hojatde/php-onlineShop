<?php
include_once "../public/database.php";
include "../models/product.php";
include "../models/order.php";

class cart{
    private $userId,$id;
    function __construct($inputuserid,$inputId)
    {
        $this->userId=$inputuserid;
        $this->id=$inputId;
    }
    public function getCartItems(){
        $dbConnect = connectDB();
        $stmt = $dbConnect->prepare("select productId,title,quantity,price from cart join cartItem on(cart.id=cartItem.cartId) join product on (product.id=cartItem.productId) where cartId=$this->id");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function increaseProduct($productId){
        $productFind = product::fetchOne($productId);
        if($productFind){
            if(($this->isProductExistInCart($productId))){
                $dbConnect = connectDB();
                $stmt = $dbConnect->prepare("select quantity from cartItem where cartId=$this->id and productId=$productId");
                $stmt->execute();
                $oldQuantity=$stmt->get_result()->fetch_assoc()['quantity'];
                $oldQuantity++;
                $stmt->close();
                $stmt=$dbConnect->prepare("update cartItem set quantity=$oldQuantity where cartId=$this->id and productId=$productId");
                $stmt->execute();$stmt->close();
                $dbConnect->close();
            }else{
                $dbConnect = connectDB();
                $stmt = $dbConnect->prepare("insert into cartItem (cartId,productId) values (?,?)");
                $cartId=(int)$this->id;
                $stmt->bind_param('is',$cartId,$productId);
                $stmt->execute();
                $stmt->close();$dbConnect->close();
            }
        }
    }
    public function decreaseProduct($productId){
        $productFind = product::fetchOne($productId);
        if($productFind){
            if(($this->isProductExistInCart($productId))){
                $dbConnect = connectDB();
                $stmt = $dbConnect->prepare("select quantity from cartItem where cartId=$this->id and productId=$productId");
                $stmt->execute();
                $oldQuantity=$stmt->get_result()->fetch_assoc()['quantity'];
                $oldQuantity--;
                if($oldQuantity===0){
                    $stmt->close();
                    $stmt=$dbConnect->prepare("delete from cartItem where cartId=$this->id and productId=$productId");
                    $stmt->execute();$stmt->close();
                    $dbConnect->close();
                }else{
                    $stmt->close();
                    $stmt=$dbConnect->prepare("update cartItem set quantity=$oldQuantity where cartId=$this->id and productId=$productId");
                    $stmt->execute();$stmt->close();
                    $dbConnect->close();
                }
            }
        }
    }
    public function deleteProduct($productId){
        $productFind = product::fetchOne($productId);
        if($productFind){
            if(($this->isProductExistInCart($productId))){
                $dbConnect = connectDB();
                $stmt = $dbConnect->prepare("delete from cartItem where cartId=$this->id and productId=$productId");
                $stmt->execute();
                $stmt->close();$dbConnect->close();
            }
        }
    }
    public function isProductExistInCart($productId){
        $dbConnect = connectDB();
        $stmt = $dbConnect->prepare('select cartId from cart join cartItem on(cart.id=cartItem.cartId) where cartItem.productId=?');
        $productId = (int)$productId;
        $stmt->bind_param('i',$productId);
        $stmt->execute();
        return ($stmt->get_result()->fetch_assoc());
    }
    public function createOrder(){
        $order = new order(null,$this->userId);
        $order->save();
        $order->createOrder($this->getCartItems());
    }

}

