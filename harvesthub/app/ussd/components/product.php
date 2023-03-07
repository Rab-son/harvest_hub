<?php 
    class Product{

        //
        protected $id;
        protected $name;

        protected $unit;
        protected $price;
        protected $quantity;

        //setters and getters
        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }

        public function setUnit($unit){
            $this->unit = $unit;
        }

        public function getUnit(){
            return $this->unit;
        }

        public function setPrice($price){
            $this->price = $price;
        }

        public function getPrice(){
            return $this->price;
        }

        public function setQuantity($quantity){
            $this->quantity = $quantity;
        }

        public function getQuantity(){
            return $this->quantity;
        }



        public function setID($id){
            $this->id = $id;
        }
    
        public function getID(){
            return $this->id;
        }

        public function productNames($pdo){

            $stmt = $pdo->prepare("SELECT * FROM products WHERE status = 'Approved' LIMIT 6");
            $stmt->execute();  
            $rows = $stmt->fetchAll();
    
            return $rows;
          
        }

        public function submittedProduct($pdo){

            $stmt = $pdo->prepare("SELECT * FROM products WHERE status = 'Pending' LIMIT 8");
            $stmt->execute();  
            $rows = $stmt->fetchAll();
    
            return $rows;
          
        }



        public function register($pdo){
            try{
                //hash the pin
                $stmt = $pdo->prepare("INSERT INTO products 
                (name, unit, price, quantity) 
                values(?,?,?,?)");
                $stmt->execute([$this->getName(),$this->getUnit(),
                                $this->getPrice(), $this->getQuantity() 
                              ]);
            
            }catch(PDOException $e){
                echo $e->getMessage();
            }            
        }

               
    }