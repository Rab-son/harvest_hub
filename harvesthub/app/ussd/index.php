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
    $textArray = explode("*", $text);

    switch($textArray[0]){
        case 1: $menu->registerMenu($textArray);
        break;
        default: echo "END Invalide Choice. Please
        Try Again";
    }


}else{
    // registered and non-empty string
    $textArray = explode("*", $text);
    switch($textArray[0]){
        case 1: $menu->viewProductMenu($textArray);
        break;
        case 2: $menu->viewOrdersMenu($textArray);
        break;
        case 3: $menu->submitProductMenu($textArray);
        break;
        case 4: $menu->viewAccount($textArray);
        break;
        case 5: $menu->viewHelp($textArray);
        break;
        default: echo "END Invalide Choice. Please
        Try Again";
    }
}


?>