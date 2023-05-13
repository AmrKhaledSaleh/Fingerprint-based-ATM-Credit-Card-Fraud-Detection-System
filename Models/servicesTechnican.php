<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// if(session_start()){

// }else {
//     session_start();
// }
require_once (__DIR__."/../Controllers/DBconnector.php");
class servicesTechinican{
private $firstName;
private $lastName;
private $userName;
private $password;
private $tqId;
private $role;
private $balance;
private $atmId;
private $accId;
private $trsType;
private $trsDate;
private $amount;
private $db;

private function pinVerification($pass){
        $password = hash("sha256", $pass);
        return $password;
    }

public function __construct($firstName=null,$lastName=null,$userName=null,$password=null,$tqId=null, $role = null){
        if($firstName && $lastName && $userName && $password && $tqId ){
            $this->firstName= $firstName;
            $this->lastName = $lastName;
            $this->tqId = $tqId;
            $this->userName = $userName;
            $this->password = $password;
            $this->role = $role;
        }
        $this->db = new DBConnector;
    }

public function getFirstName(){
    return $this->firstName;
}
public function getLastName(){
    return $this->lastName;
}
public function getPassword(){
    return $this->password ;
}
public function getUserName(){
    return $this->userName;
}
public function getTqId(){
    return $this->tqId ;
}
public function getAtmId(){
    return $this->atmId ;
}
public function getAtmBalance(){
    return $this->atmId ;
}
public function getAccId(){
    return $this->accId ;
}
public function getTrsType(){
    return $this->trsType ;
}
public function getTrsDate(){
    return $this->trsDate ;
}

public function login(){
    $userName = $_POST['teqUserName'];
    $password = $_POST['teqPassword'];
    $atmId = $_POST['atm_Id'];
    if(isset($userName) && isset($password) && isset($atmId) && !empty($userName) && !empty($password) && !empty($userName)){
            //$this->db = new DBconnector;
            $password = $this->pinVerification($password);
             $result = $this->db->select("Employee", "*" , "UserName=? AND Password=?", array($userName,$password));
            $result1 = $this->db->select("ATM", "*" , "ID=?", array($atmId));
            if(!$result){
                $_SESSION['errMsg'] = 'Wrong UserName or Password';
                return false;
            }else if(!$result1){
                $_SESSION['errMsg'] = "No Matchs For This Atm Id";
                return false;
            } else if($result[0]['Role'] == "Admin"){
                $_SESSION['errMsg'] = 'You Are Not A Services Technician';
            }else{
                    $_SESSION['empId'] = $result[0]['ID'];
                    $_SESSION['firstName'] = $result[0]['FirstName'];
                    $_SESSION['lastName'] = $result[0]['LastName'];
                    $_SESSION['userName'] = $result[0]['UserName'];
                    $_SESSION['atmId'] = $result1[0]['ID'];
                    $_SESSION['atmBalance'] = $result1[0]['Balance'];
                    $_SESSION['check'] = 0;
                    //header("location:../View/serviceMenu.php");
                    return true;
            }
    }else {
        return false;
    }
}//else echo "SETT";



public function logOut(){
        session_start();
        session_unset();
        session_destroy();
        header("location:../View/index.php");
    }




public function rechargeAtm (){
        $mAmount = $_POST['mAmount'];
        if(isset($mAmount) && !empty($mAmount) && !$_SESSION['check']){
            //$this->db = new DBconnector;
            $_SESSION['check'] = 1;
            $mAmount += $_SESSION['atmBalance'];
            $_SESSION['atmBalance'] = $mAmount;
            $table = 'ATM';
            $data = array('Balance' => $_SESSION['atmBalance']);
            $where = 'ID = ?';
            $params = array($_SESSION['atmId']);
            $affected_rows = $this->db->update($table, $data, $where, $params);
            return $affected_rows;
    }
}


public function checkLoggers(){
    //$this->db = new DBconnector;
    $result = $this->db->select("Transaction", "*" , "AtmID = ?", array($_SESSION['atmId']));
    return $result;
}

public function __destruct(){
        $this->db->close();
    }
}
?>