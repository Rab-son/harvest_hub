<?php

include_once 'db.php';
include_once 'util.php';
include_once 'sms.php';
include_once 'components/user.php';

$phoneNumber = $_POST["from"];
$text = $_POST["text"];

$user = new User($phoneNumber);
$db = new DBConnector();
$pdo = $db->connectToDB();

$text = explode(",", $text);
$user->setFirstName($text[0]);
$user->setLastName($text[1]);
$user->setLocation($text[2]);
$user->setNationalID($text[3]);
$user->setPin($text[4]);
$language = strtolower($text[5]);
$user->setLanguage($language);

if (!$user->isUserRegistered($pdo)) {
    $user->register($pdo);
    $msg = "" . $first_name . " " . $last_name . ",
                You Are Now Registered.
                Enjoy Our Services ";
    $sms = new Sms($user->getPhone());
    $result = $sms->sendSMS($msg);
} else {
    $msg = " " . $text[0] . " " . $text[1] . ",
        Is Already Registered.";
    $sms = new Sms($user->getPhone());
    $result = $sms->sendText($msg);
}
