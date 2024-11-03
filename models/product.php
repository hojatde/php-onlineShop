<?php
include_once "../public/database.php";

class product{
    private $id,$title,$price,$imageUrl=null,$description=null;
    // private $error = new error();
    function __construct($inputId=null,$inputTitle,$inputPrice,$inputImageUrl,$inputDescription){
        if(isset($inputId))$this->id=$inputId;
        $this->title=$this->validateInput($inputTitle);
        $this->price=$this->validateInput($inputPrice);
        if($inputImageUrl){
            $this->imageUrl=$this->validateInput($inputImageUrl);
        }
        if($inputDescription){
            $this->description=$this->validateInput($inputDescription);
        }
    }
    private function validateInput($input){
        // $input=trim($input);
        // $input=stripslashes($input);
        // $input=htmlspecialchars($input);
        return $input;
    }

    public function getId(){return $this->id;}
    public function getTitle(){return $this->title;}
    public function getPrice(){return $this->price;}
    public function getImageUrl(){return $this->imageUrl;}
    public function getDescription(){return $this->description;}



    public function save(){
        $dbConnect=self::connectDB();
        if($dbConnect){
            $stmt = $dbConnect->prepare("insert into product (title,price,imageUrl,description) values (?,?,?,?)");
            $stmt->bind_param("siss",$passTitle,$passPrice,$passImage,$passDec);
            $passTitle = $this->title;
            $passImage = $this->imageUrl;
            $passPrice = $this->price;
            $passDec = $this->description;
            $stmt->execute();
            if($stmt->errno){
                echo 'save product error';
                exit();
            }$stmt->close();

        }else{
            echo "<br>connect failed!!!<br>";
        }
        $dbConnect->close();
    }
    public function deleteProduct(){
        $dbConnect=self::connectDB();
        $id=(int)$this->id;
        $stmt = $dbConnect->prepare("delete from product where id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result=$stmt->errno;
        $stmt->close();
        $dbConnect->close();
        return $result;

    }
    public function updateOne($id,$title,$price,$imageUrl,$description){
        $dbConnect=self::connectDB();
        if($dbConnect->errno){
            exit();
        }
        $stmt = $dbConnect->prepare("update product set title=?,price=?,imageUrl=?,description=? where id=?");
        $stmt->bind_param('sissi',$title,$price,$imageUrl,$description,$id);
        $stmt->execute();
        $stmt->close();
        $dbConnect->close();
    }
    static function connectDB(){
        $dbConnect = mysqli_connect('localhost:3306','root','691377','phptest');
        if($dbConnect){
            return $dbConnect;
        }else{
            echo 'connect to database failed';
            exit();
        }
    }
    static function fetchAll(){
        $dbConnect = $dbConnect=self::connectDB();
        if($dbConnect){
            $stmt = $dbConnect->prepare('select * from product');
            $stmt->execute();
            $stmt->store_result();
            return $stmt;
        }else{
            echo "<br>connect failed!!!<br>";
        }
        $dbConnect->close();
    }

    static function fetchOne($id){
        $dbConnect = $dbConnect=self::connectDB();
        if($dbConnect->errno){
            exit();
        }
        $stmt = $dbConnect->prepare('select * from product where id=? limit 1');
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if(isset($result)){
            return new product($result['id'],$result['title'],$result['price'],$result['imageurl'],$result['description']);
        }
        $dbConnect->close();

    }

}
?>