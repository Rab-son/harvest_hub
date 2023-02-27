<?php 
// Imports
include_once '../util.php';
include_once 'user.php';
include_once 'sms.php';
include_once 'product.php';
include_once 'order.php';



class Menu{

    protected $text;
    protected $sessionId;
    
    function __construct(){

    }

    public function middleware($text){
        //remove entries for going back and going to the main menu
        return $this->goBack($this->goToMainMenu($text));
    }

    public function goBack($text){
        $explodedText = explode("*", $text);
        while(array_search(Util::$GO_BACK, $explodedText) != false){
            $firstIndex = array_search(Util::$GO_BACK, $explodedText);
            array_splice($explodedText, $firstIndex-1, 2);
        }
        return join("*", $explodedText);

    }

    public function goToMainMenu($text){
        $explodedText = explode("*", $text);
        while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) != false){
           $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
           $explodedText = array_slice($explodedText, $firstIndex + 1); 
        }

        return join("*", $explodedText);
    }



    public function mainMenuRegistered($name){
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
                $user->setCity($city);
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

    // buy products
    public function viewProductMenu($textArray, $name, $type ,$id, $pdo, $user){
        $level = count($textArray);
        if($level == 1){
            $numbering = 0;
            $response = "CON Market Place - Harvest Hub
                        Choose Product To Buy\n";
            foreach($name as $n){
                $numbering++;
                $n['id'];
                $a=array($numbering,$n['id']);
                $response .=($a[0]).". ".$a[1]." " .$n['name']." \n";
                
            }
            $response .=Util::$GO_TO_MAIN_MENU ." Main Menu\n";
            echo $response;
            return $a;

        }else if($level == 2){
            // choosing quantity type
            $numbering = 0;
            $response = "CON Quantity
                            Choose Amount\n";
            foreach($type as $t){
                $numbering++;
                $t['id'];
                $a=array($numbering,$t['id']);
                $response .=($a[0])." " .$t['name']." \n";
                
            }
            $response .=Util::$GO_TO_MAIN_MENU ." Main Menu\n";
            echo $response;

        }else if($level == 3){
            // enter amount of waste
            echo "CON Enter Drop Location (e.g Area 6)";
        }else if($level == 4){
            $response = "CON Request Details\n";

            $numbering = 0;
            foreach($name as $n){
                $numbering++;
                $a=array($numbering, $n['id']);
                if($textArray[1] == $a[0]){
                    $response .="Inst. : ".$n['name']." \n";
                }
            }

            $counting = 0;
            foreach($type as $t){
                $counting++;
                $a=array($counting, $t['id']);
                if($textArray[2] == $a[0]){
                    $response .="Waste Type : ".$t['name']." \n";
                }
            }

            $response .="Amount: $textArray[3] \n";
            $response .="Desc: $textArray[4] \n";
            $response .="Loc: $textArray[5] \n";
            $response .="1. Confirm\n";
            $response .="2. Cancel\n";
            $response .=Util::$GO_BACK ." Back\n";
            $response .=Util::$GO_TO_MAIN_MENU ." Main Menu\n";
            echo $response;
        }else if($level == 5 && $textArray[6] == 1){
            echo "CON Enter PIN";
        }else if($level == 5 && $textArray[6] == 2){
            echo "END Thank you for using our service";
        }else if($level == 6){
            $user->setPin($textArray[7]);
            if($user->correctPin($pdo) == true){
                //database serve
                $amount = $textArray[3];
                $description = $textArray[4];
                $location = $textArray[5];

                $numbering = 0;
                foreach($name as $n){
                    $numbering++;
                    $a=array($numbering, $n['id']);
                    if($textArray[1] == $a[0]){
                        $inst_id = $n['id'];
                        $inst_name = $n['name'];
                    }
                }

                $counting = 0;
                foreach($type as $t){
                    $counting++;
                    $a=array($counting, $t['id']);
                    if($textArray[2] == $a[0]){
                        $waste_type = $t['id'];
                        $waste_name = $t['name'];
                    }
                }

                $request = new Request();
                $request->setInstitutionId($inst_id);
                $request->setUserId($id);
                $request->setLocation($location);
                $request->setQuantity($quantity);
                $request->register($pdo);
                date_default_timezone_set('Africa/Blantyre');
                $msg = "Your request is sent to " .$inst_name. " with the following details:\n
                        Waste Type: $waste_name \n 
                        Amount: $amount\n
                        Location: $location\n
                        Description: $description\n 
                        Date: ". date("Y-m-d h:i:sa")." \n
                        Enjoy Our Services";
                $sms = new Sms($user->getPhone());
                $result = $sms->sendSMS($msg);
                if($result['status'] == "success"){
                    echo "END You will receive an SMS Shortly";
                }else{
                    echo "END Something went wrong. 
                        Please try again";
                }

            }else{
                $response = "CON Wrong PIN\n";
                $response .=Util::$GO_BACK ." Try Again\n";
                $response .=Util::$GO_TO_MAIN_MENU ." Main Menu\n";
                echo $response;
            }

        }else{
            $response = "CON Wrong Option\n";
            $response .=Util::$GO_BACK ." Bank\n";
            $response .=Util::$GO_TO_MAIN_MENU ." Main Menu\n";
            echo $response;
        }
    }



    public function submitProductMenu(){}

    public function viewOrdersMenu(){}

    public function viewAccount(){}

    public function viewHelp(){}



}


?>