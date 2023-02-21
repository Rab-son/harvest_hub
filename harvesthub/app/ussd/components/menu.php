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

    //registration Menu
    public function registerMenu($textArray, $phoneNumber, $pdo){
        $level = count($textArray);
        if($level == 1){
            echo "CON Enter First Name";
        }else if($level == 2){
            echo "CON Enter Last Name";
        }else if ($level == 3){
            echo "CON Enter Your City";
        }else if ($level == 4){
            echo "CON Enter Your National ID Number";
        }else if ($level == 5){
            echo "CON Set Your PIN (Maximum of 4 Characters)";
        }else if ($level == 6){
            echo "CON Please Re-Enter Your PIN";
        }else if ($level == 7){
            $first_name = $textArray[1];
            $last_name = $textArray[2];
            $city = $textArray[3];
            $national_id = $textArray[4];
            $pin = $textArray[5];
            $confirmPin = $textArray[6];

            if($pin != $confirmPin){
                echo "END Your PIN Do Not Match. Please Try Again";
            }else{
                // register the user 
                $user = new User($phoneNumber);
                $user->setFirstName($first_name);
                $user->setLastName($last_name);
                $user->setLocation($city);
                $user->setNationalID($national_id);
                $user->setPin($pin);
                $user->register($pdo);
                // send sms
                $msg = "" .$first_name. " " .$last_name. ", 
                        You Are Now Registered. 
                        Enjoy Our Services ";
                $sms = new Sms($user->getPhone());
                $result = $sms->sendSMS($msg);
                if($result['status'] == "success"){
                    echo "END You will receive an SMS Shortly";
                }else{
                    echo "END Something went wrong. 
                        Please try again";
                }

            } 
            
        }

    }

    public function viewProductMenu(){}

    public function submitProductMenu(){}

    public function viewOrdersMenu(){}

    public function viewAccount(){}

    public function viewHelp(){}



}


?>