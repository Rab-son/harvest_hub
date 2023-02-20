<?php 

//API Variables 
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];


$isRegistered = false;


if($text == "" && $isRegistered){
    // registered


}else if($text == "" && $isRegistered){
    // unregistered and empty string

}else if($isRegistered){
    // unregistered and non-empty string
}else{
    // registered and non-empty string
}


?>