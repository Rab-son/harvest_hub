<?php 

class Menu{

    protected $text;
    protected $sessionId;
    
    function __construct($text, $sessionId){
        $this->text = $text;
        $this->sessionId = $sessionId;
    }

    public function mainMenuRegistered(){}

    public function mainMenuUnRegistered(){}

    public function registerMenu(){}

    public function viewProductMenu(){}

    public function viewOrdersMenu(){}

    public function submitProductMenu(){}

}


?>