<?php


require_once __DIR__."/../Controllers/DBconnector.php";
require_once __DIR__."/Customer.php";//starts session
require_once __DIR__."/Transaction.php";
require_once __DIR__."/Account.php";


class verification{
    private $db;

    public function __construct(){
        $this->db = new DBconnector();
    }   
    
    private function generateOTP() {
        $digits = 6;
        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    }

    public function CheckPIN(Customer $customer,$PIN){
        return ($customer->getPin()==$PIN);
    }

    public function CheckBalance(Account $account, Transaction $transaction){
        return ($transaction->getAmount() > $account->getBalance());
    }

    public function CheckBehavior(Account $account, Transaction $transaction, Customer $customer){
        if($this->CheckBalance($account, $transaction)){//Insufficient Account Balance
			$transaction->setState(false);
			return -1;//Save but denied
		}
        $result = $this->db->select("Account","*","ID = ?",array($account->getId()));

        $AvgAmount = null;
        if($transaction->getType() == "Withdraw"){
            if((int)$result[0]["numberOfWithdraws"] == 0){
                return true;//first time
            }
            $AvgAmount = (int)$result[0]["totalWithdraws"]/(int)$result[0]["numberOfWithdraws"];
        } 
        else{
            if((int)$result[0]["numberTransfer"] == 0){
                return true;//first time
            }
            $AvgAmount = (int)$result[0]["totalTransfer"]/(int)$result[0]["numberTransfer"];
        }

        $ValidAmount = $AvgAmount + $AvgAmount*(30/100);//30% above Average
        if($ValidAmount >= $transaction->getAmount())
            return true; //No fraud detected
        else{//Fraud detected
            if($transaction->getType() == "Withdraw"){//Withdraw
                if(!isset($_SESSION['CWOTP'])){//not verified yet
                    $atm = new ATM();
                    $atm->getAtmData();
                    $_SESSION['WOTP'] = $atm->sendOTP($customer, $this->generateOTP());
                    return false;
                }else{
                    unset($_SESSION['WOTP']);
                    return true;
                }
            }
            else{//Transfer
                if(!isset($_SESSION['CTOTP'])){//not verified yet
                    $atm = new ATM();
                    $atm->getAtmData();
                    $_SESSION['TOTP'] = $atm->sendOTP($customer, $this->generateOTP());
                    return false;
                }else{
                    unset($_SESSION['TOTP']);
                    return true;
                }
            }
        }
    }

    public function CheckExpDate(Card $card){//Login
        $date = new DateTime($card->getDate());
        $today = new DateTime();
        $result = $today->diff($date)->format('%R');//comparing

        if ($result === '+')//Early (running)
            return true;
        else
            return false;
    }

    public function CheckLocation(Customer $customer,ATM $ATM){//Login check 
        if(strtolower($customer->getCity()) == strtolower($ATM->getCity()))//IF the ATM city = Customer city
            return true;
            
        else{
            try{
                $SSN =  $customer->getSSN();
                $sql = "SELECT ATM.City FROM Transaction INNER JOIN ATM ON Transaction.AtmID = ATM.ID WHERE Transaction.SSN = '$SSN' ORDER BY Transaction.ID DESC LIMIT 1;";
                $result = $this->db->join($sql);
                if($result){
                    $lastLocation = $result['City'];
                    if(strtolower($lastLocation) == strtolower($ATM->getCity())){//Last transaction's location with ATM's location
                        return true;
                    }
                    else{
                        $OTP = $ATM->sendOTP($customer, $this->generateOTP());
                        return $OTP;
                    }
                }
                else{
                    if($result['City'] == '')
                        return true;//1st transaction

                    return false;//error in Database
                }
            }
            catch(Exception $e){
                return false;
            }
        }
    }
}


?>