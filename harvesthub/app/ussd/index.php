<?php 

include_once "./components/menu.php";

//API Variables 
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];


$isRegistered = false;
$menu = new Menu($text, $sessionId);


if($text == "" && $isRegistered){
    // registered
    $menu->mainMenuRegistered();

}else if($text == "" && $isRegistered){
    // unregistered and empty string
    $menu->mainMenuUnRegistered();
    
}else if($isRegistered){
    // unregistered and non-empty string
}else{
    // registered and non-empty string
}


?>