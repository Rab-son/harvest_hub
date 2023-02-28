<?php 
    class Order{

        protected $product_id;
        protected $user_id;
        protected $quantity;
        protected $location;

        //setters and getters
        public function setProduct($product_id){
            $this->product_id = $product_id;
        }

        public function getProduct(){
            return $this->product_id;
        }

        public function setQuantity($quantity){
            $this->quantity = $quantity;
        }

        public function getQuantity(){
            return $this->quantity;
        }

        public function setLocation($location){
            $this->location = $location;
        }

        public function getLocation(){
            return $this->location;
        }

        
        public function setUserId($id){
            $this->id = $id;
        }

        public function getUserId(){
            return $this->id;
        }


        public function register($pdo){
            try{
                //hash the pin
                $stmt = $pdo->prepare("INSERT INTO orders 
                (customer_id, product_id, location, quantity) 
                values(?,?,?,?)");
                $stmt->execute([$this->getUserId(),$this->getProduct(),
                                $this->getLocation(), $this->getQuantity() 
                              ]);
            
            }catch(PDOException $e){
                echo $e->getMessage();
            }            
        }

    }


?>