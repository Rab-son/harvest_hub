<?php 

class Menu{

    protected $text;
    protected $sessionId;
    
    function __construct($text, $sessionId){
        $this->text = $text;
        $this->sessionId = $sessionId;
    }

    public function mainMenuRegistered(){
        $response = "CON Welcome " .$name. " Reply with \n";
        $response .="1. Buy Products\n";
        $response .="2. View Orders\n";
        $response .="3. Sell Products\n";
        $response .="4. My Account\n";
        $response .="5. Help\n";
        echo $response;

    }

    public function mainMenuUnRegistered(){
        $response = "CON Welcome HarvestHub\n";
        $response .="1. Register\n";
        echo $response;
    }

    public function registerMenu(){}

    public function viewProductMenu(){}

    public function submitProductMenu(){}

    public function viewOrdersMenu(){}

    public function viewAccount(){}

    public function viewHelp(){}



}


?>