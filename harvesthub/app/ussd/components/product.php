<?php 
    class Product{

        //
        protected $id;
        protected $name;

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

               
    }