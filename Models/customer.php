<?php
require_once (__DIR__ . '/../Controllers/DBconnector.php');
require_once (__DIR__ ."/User.php");
require_once (__DIR__ ."/Card.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class Customer extends user
{
    private  $SSN;
    private  $FirstName;
    private  $LastName;
    private  $PIN;
    private  $Fingerprint;
    private  $Street;
    private  $Area;
    private  $City;
    private  $Email;
    private  $CardID;
    private  $phoneNO;
    private $db;
    public function setSSN($SSN)
    {
        $this->SSN = $SSN;
    }

    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
    }

    public function setLastName($LastName)
    {
        $this->LastName = $LastName;
    }

    public function setPIN($PIN)
    {
        $this->PIN = $PIN;
    }

    public function setFingerprint($Fingerprint)
    {
        $this->Fingerprint = $Fingerprint;
    }

    public function setStreet($Street)
    {
        $this->Street = $Street;
    }

    public function setArea($Area)
    {
        $this->Area = $Area;
    }

    public function setCity($City)
    {
        $this->City = $City;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    public function setCardID($CardID)
    {
        $this->CardID = $CardID;
    }

    public function setphoneNO($phoneNO)
    {
        $this->phoneNO = $phoneNO;
    }
    public function getId()
    {
        return $this->CardID;
    }
    public function getPin()
    {
        return $this->PIN;
    }
    public function getSSN()
    {
        return $this->SSN;
    }
    public function getFirstName()
    {
        return $this->FirstName;
    }
    public function getLastName()
    {
        return $this->LastName;
    }
    public function getFingerprint()
    {
        return $this->Fingerprint;
    }
    public function getArea()
    {
        return $this->Area;
    }
    public function getCity()
    {
        return $this->City;
    }
    public function getStreet()
    {
        return $this->Street;
    }
    public function getEmail()
    {
        return $this->Email;
    }
    public function getPhoneNO()
    {
        return $this->phoneNO;
    }
    public function __construct($SSN = null, $FirstName = null, $LastName = null, $PIN = null, $Fingerprint = null, $Street = null, $Area = null, $City = null, $Email = null, $CardID = null, $phoneNO = null)
    {
        if ($SSN)
            $this->SSN = $SSN;
        if ($FirstName)
            $this->FirstName = $FirstName;
        if ($LastName)
            $this->LastName = $LastName;
        if ($PIN)
            $this->PIN = $PIN;
        if ($Fingerprint)
            $this->Fingerprint = $Fingerprint;
        if ($Street)
            $this->Street = $Street;
        if ($Area)
            $this->Area = $Area;
        if ($City)
            $this->City = $City;
        if ($Email)
            $this->Email = $Email;
        if ($CardID)
            $this->CardID = $CardID;
        if ($phoneNO)
            $this->phoneNO = $phoneNO;

        $this->db = new DBConnector;
    }

    public function pinVerification($pass)
    {
        $password = hash("sha256", $pass);
        return $password;
    }
    private function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = str_replace(" ", "", $data);
        return $data;
    }
    public function login($id, $pass)
    {
        $id          = $this->validate($id);
        $hashed_pass = $this->pinVerification($pass);
        $result      = $this->db->select("User", "*", "CardID=? AND PIN=?", array($id, $hashed_pass));
        if ($result) {
            $block   = $this->db->select("CreditCard", "*", "ID=?", array($id));
            if ($block[0]['State'] == "Blocked") {
                return -1; //Blocked
            }
            //sessions
            $this->setSessions($result);
            $this->setCCSessions($block);
            return 1; //DONE
        } else {
            return 0; //Not in DB
        }
    }
    public function FingerprintValidation()
    {
        $target_file1 = $_FILES['image']["tmp_name"];
        $hash1        = md5_file($target_file1);
        $result       = $this->db->select("User", "*", "Fingerprint=?", array($hash1));
        if ($result) {
            // check if Card is blocked or not
            $cardid   = $result[0]['CardID'];
            $Block    = $this->db->select("CreditCard", "State", "ID=?", array($cardid));
            if ($Block[0]['State'] == "Blocked") {
                return -1; // card is blocled then not logged in 
            }
            //sessions
            $this->setSessions($result);
            $this->setCCSessions($Block);
            return 1; // Done
        } else {
            return 0; // not in DB
        }
    }
    public function logOut()
    {
        session_unset();
        session_destroy();
        header("location:index.php");
        exit();
    }
    public function resetPIN($pass1, $pass2, $CardID)
    {
        if (empty($pass1) or empty($pass2)) {
            return 1; // empty password field
        } else {
            if ($pass1 != $pass2) {
                return 2; // fields not matching
            } else {
                $hashed_password = $this->pinVerification($pass1);
                $table  = 'User';
                $data   = array('PIN' => $hashed_password);
                $where  = 'CardID =?';
                $params = array($CardID);
                $affected_rows = $this->db->update($table, $data, $where, $params);
                return 3; // pin changed succesfully
            }
        }
    }
    public function blockcard($CardID)
    {
        $table  = 'CreditCard';
        $data   = array('State' => 2);
        $where  = 'ID =?';
        $params = array($CardID);
        $affected_rows = $this->db->update($table, $data, $where, $params);
        return $affected_rows;
    }
    public function accounts($SSN)
    {
        $result = $this->db->select("Account", "ID , Type , Balance", "SSN=?", array($SSN));
        return $result;
    }
    // this function is called if user choose Account from his Accounts, it will take account_id
    public function chooseAccount($account_id)
    {
        $result                 = $this->db->select("Account", "ID,Balance,State,Type", "ID=?", array($account_id));
        $_SESSION['account_id'] = $result[0]['ID'];
        $_SESSION['balance']    = $result[0]['Balance'];
        $_SESSION['state']      = $result[0]['State'];
        $_SESSION['type']       = $result[0]['Type'];
    }
    public function __destruct()
    {
        $this->db->close();
    }
    /* this function called two times : if user logged by card or fingerprint
    and this sessions will be available for all pages not private but this method is the private one
    */
    private function setSessions($row)
    {
        $_SESSION['SSN']        = $row[0]['SSN'];
        $_SESSION['card_id']    = $row[0]['CardID'];
        $_SESSION['fingerpint'] = $row[0]['Fingerprint'];
        $_SESSION['upass']      = $row[0]['PIN'];
        $_SESSION['fName']      = $row[0]['FirstName'];
        $_SESSION['lName']      = $row[0]['LastName'];
        $_SESSION['Street']     = $row[0]['Street'];
        $_SESSION['Area']       = $row[0]['Area'];
        $_SESSION['City']       = $row[0]['City'];
        $_SESSION['Email']      = $row[0]['Email'];
    }
    private function setCCSessions($row)
    {
        $card = new Card($row[0]['ID'], $row[0]['CVV'], $row[0]['ExpDate'], $row[0]['State']);
        $_SESSION['card']    = serialize($card);
    }

   
}

?>