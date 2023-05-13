<?php
require_once(__DIR__ . '/../Controllers/DBconnector.php');
require_once(__DIR__ . "/Account.php");
require_once(__DIR__ . "/customer.php");
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/Card.php");
require_once(__DIR__.'/ATM.php');

class admin extends User
{
    private  $userName;
    private  $passWord;
    private  $ID;

    public function __construct($user = null, $pass = null, $ID = null, $name = null)
    {
        $this->userName = $user;
        $this->passWord = $pass;
        $this->ID = $ID;
        $this->name = $name;
    }
    public function getID()
    {
        return $this->ID;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getUserName()
    {
        return $this->userName;
    }
    public function getPassword()
    {
        return $this->passWord;
    }
    public function login($user, $pass)
    {
        $db = new DBconnector();
        $hashedPassWord = hash("sha256", $this->passWord);
        return $db->select("`Employee`", "*", "UserName=? AND Password=?", array($this->userName, $hashedPassWord));
    }
    public function logout()
    {
        session_unset();
        session_destroy();
    }
    public function CreateCard()
    {
        $card = new Card();
        $card->generateCard();
        $data["ID"] = $card->getId();
        $data["ExpDate"] = $card->getDate();
        $data["CVV"] = $card->getCVV();
        $db = new DBConnector();
        $result = $db->insert("CreditCard", $data);
        while (!$result) {
            $this->CreateCard();
        }
        return $card;
    }

    public function addCustomer(customer $customer)
    {
        $card = $this->CreateCard();
        $hashedPIN = hash("sha256", $customer->getPin());

        $data["FirstName"] = $customer->getFirstName();
        $data["LastName"] = $customer->getLastName();
        $data["Email"] = $customer->getEmail();
        $data["Street"] = $customer->getStreet();
        $data["Area"] = $customer->getArea();
        $data["City"] = $customer->getCity();
        $data["SSN"] = $customer->getSSN();
        $data["PIN"] = $hashedPIN;
        $data["Fingerprint"] = $customer->getFingerprint();
        $data["PhoneNO"] = $customer->getPhoneNO();
        $data["CardID"] = $card->getId();

        try{
            $db = new DBConnector();
            if(!$result = $db->insert("User", $data)){
                throw new Exception();
            }
        }
        catch(Exception $e){
            return false;
        }

        $account = new Account();
        $account->setType("Current");

        $result = $this->createAccount($account, $customer);
        if (!$result)
            return false;
        $atm = new ATM();
        $atm->getAtmData();

        $atm->notifyNewUser($card, $customer);
        return true;
    }

    public function editCustomer(customer $customer , $hash)
    {
        if($hash){
            $hashedPIN = hash("sha256",$customer->getPin());
        }
        else{
            $hashedPIN = $customer->getPin();
        }
        
        $data["Email"] = $customer->getEmail();
        $data["Street"] = $customer->getStreet();
        $data["Area"] = $customer->getArea();
        $data["City"] = $customer->getCity();
        $data["PIN"] = $hashedPIN;
        $data["Fingerprint"] = $customer->getFingerprint();
        $data["PhoneNO"] = $customer->getPhoneNO();

        $db = new DBConnector();
        $result = $db->update("User", $data, "SSN=?", array($customer->getSSN()));
        return $result;
    }
    public function deleteCustomer($customerSNN)
    {
        $db = new DBconnector();
        $ok = $db->delete("User", "SSN=?", array($customerSNN));
        return $ok;
    }
    public function createAccount(Account $account, Customer $customer)
    {
        $db = new DBconnector();
        $data["SSN"] = $customer->getSSN();
        $data["Type"] = $account->getType();
        $result = $db->insert("Account", $data);
        return $result;
    }
    public function deleteAccount(Account $account)
    {
        $db = new DBconnector();
        $result = $db->delete("Account", "ID=?", array($account->getId()));
        return $result;
    }

    public function editAccount(Account $account)
    {
        $db = new DBconnector();
        if ($account->getBalance() >= 0) {
            $data["Balance"] = $account->getBalance();
        } else if ($account->getBalance() < -1) {
            return false;
        }

        if ($account->getType() != "Same") {
            $data["Type"] = $account->getType();
        }
        $ok = $db->update("Account", $data, "ID=?", array($account->getId()));
        return $ok;
    }

    public function CreditCardState(Card $cc)
    {
        $db = new DBconnector();
        $data["State"] = $cc->getState() ? "Running" : "Blocked";
        $result = $db->update("CreditCard", $data, "ID=?", array($cc->getId()));
        return $result;
    }
    public function viewAtmTransactions()
    {
    }
    public function addAtm(ATM $ATM)
    {
        $row = 0;
        $db = new DBconnector();
        $data["City"] = $ATM->getCity();
        $data["Area"] = $ATM->getArea();
        $data["Street"] = $ATM->getStreet();
        $data["Balance"] = 0;
        $row = $db->insert("ATM", $data);

        return $row > 0 ? true : false;
    }
    public function deleteAtm(ATM $ATM)
    {
        $db = new DBconnector();
        $ok = $db->delete("ATM", "ID = ?", array($ATM->getID()));
        return $ok;
    }
    public function viewAtm()
    {
    }
    public function createAdmin(Admin $admin)
    {
        $db = new DBconnector();
        $name = explode(",", $admin->getName());
        $data["FirstName"] = $name[0];
        $data["LastName"] = $name[1];
        $data["UserName"] = $admin->getUserName();
        $data["Password"] = hash("sha256", $admin->getPassword());
        $row = $db->insert("Employee", $data);

        return $row > 0 ? true : false;
    }
}
