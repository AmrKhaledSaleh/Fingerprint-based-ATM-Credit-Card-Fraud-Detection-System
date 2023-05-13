<?php

use PHPMailer\PHPMailer\PHPMailer;//like using namespace to make the code more readable.
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../Controllers/lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../Controllers/lib/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../Controllers/lib/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../Controllers/DBconnector.php';

class ATM{
    private $ID;
    private $city;
    private $street;
    private $area;
    private $balance;
    private $db;

    public function __construct($id = null, $city = null, $street = null, $area = null, $balance = null){
        if($city){
            $this->city = $city;
        }
        if($street){
            $this->street = $street;
        }
        if($area){
            $this->area = $area;
        }
        if($balance){
            $this->balance = $balance;
        }
        if($id){
            $this->ID = $id;
        }
        $this->db = new DBConnector();
        // $this->getAtmData(1268);
    }

    private function serverSettings(){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'amrkalledsaleh1@gmail.com';                //SMTP username
            $mail->Password   = 'zclvtztvnpaogweq';                     //SMTP password
            $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->isHTML(true);   

            //Recipients
            $mail->setFrom('amrkalledsaleh1@gmail.com', 'ATM');
            return $mail;
        }catch (Exception $e) {
            return null;
        }
    }

    public function getID(){
        return $this->ID;
    }
    public function setID($ID){
        $this->ID = $ID;
    }
    public function getCity(){
        return $this->city;
    }
    public function setCity($city){
        $this->city = $city;
    }
    public function getArea(){
        return $this->area;
        
    }
    public function setArea($area){
        $this->area = $area;
    }
    public function getStreet(){
        return $this->street;
    }
    public function setStreet($street) {
        $this->street = $street;
    }

    public function getBalance(){
		return $this->balance;
	}
	
	public function setBalance($balance) {
		$this->balance = $balance;
	}

    /**
     * @param Customer $customer The customer to send the OTP to
     * @return mixed OTP if the Email was sent successfully and null otherwise
     */
    public function sendOTP(Customer $customer, $OTP){//customer class
        $mail = $this->serverSettings();

        if($mail == null) 
            return null;


        $mail->addAddress($customer->getEmail(), 'Client');              //Add a recipient
        $mail->Subject = 'OTP Verification for ATM Access';
        $mail->Body = "<head> 
        <style>
        /* Email styling */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f7f7;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
        }
        h1 {
            margin-top: 0;
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            text-align: center;
        }
        p {
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #008CBA;
            color: #ffffff;
            text-align: center;
            padding: 12px 30px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .otp-code {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            padding: 20px 0;
            text-align: center;
            border: 1px solid #cccccc;
            border-radius: 4px;
            background-color: #f2f2f2;
        }
        .notice {
            font-size: 12px;
            margin-top: 40px;
            color: #999999;
        }
    </style>
    </head>
    <body>
        <div class=\"container\">
            <h1>OTP Verification</h1>
            <p>Dear ".$customer->getFirstName().",</p>
            <p>We have detected a suspicious transaction or login attempt on your account. To ensure your account security, we have sent you an OTP code. Please enter the code in the ATM or website to verify your identity.</p>
            <p>Your OTP code is:</p>
            <p class=\"otp-code\">$OTP</p>
            <p class=\"notice\">Note: This OTP code is valid for 15 minutes only. Please do not share this code with anyone.</p>
            <p>Thank you for banking with us.</p>
        </div>
    </body>";

        // Set up altbody for non-html mails
        $mail->AltBody = "Dear $".$customer->getFirstName().",

        Please enter the following OTP to verify your account:

        $OTP

        Thank you for using our service!";
        
        try{
            $mail->send();
        }catch(Exception $e){
            return null;
        }
        return $OTP;
    }
    
    /**
     * @param Customer $customer The customer to send the email to
     * @param Transaction $transaction The transaction details
     * @param Account $account The account of the customer with the new balance
     * @return bool True if the Email was sent successfully and false otherwise
     */
    public function notifyUser(Customer $customer, Transaction $transaction, Account $account, $insufficient = null){
        $mail = $this->serverSettings();
        $mail->addAddress($customer->getEmail(), 'Client');
        $mail->Subject = 'Transaction Notification';

        $current_date = date('Y-m-d');
        $current_time = date('h:i:s A');

        if($transaction->getState() == true)
            $HTMLstate = '<!-- Success message -->
            <div class="success">
                <p>The transaction was successful. Thank you for choosing our bank for your financial needs.</p>
            </div>';
        else
            $HTMLstate = '<!-- Error message -->
            <div class="error">
                <p>The transaction failed due to a fraudulent activity detected on your account OR an Insufficient Balance. Please contact our customer support for more information.</p>
            </div>';


        $emailBody = "
        <head>
            <style>
            /* Global Styles */
            body {
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            td {
                font-family: Arial, sans-serif;
                font-size: 14px;
                color: #555;
                padding: 10px;
            }

            th {
                font-family: Arial, sans-serif;
                font-size: 14px;
                color: #fff;
                background-color: #4CAF50;
                padding: 10px;
            }

            /* Header */
            .header {
                background-color: #333;
                color: #fff;
                text-align: center;
                padding: 10px;
            }

            /* Content */
            .content {
                padding: 10px;
            }

            /* Success message */
            .success {
                background-color: #DFF2BF;
                border: 1px solid #4F8A10;
                color: #4F8A10;
                padding: 10px;
            }

            /* Error message */
            .error {
                background-color: #FFBABA;
                border: 1px solid #D8000C;
                color: #D8000C;
                padding: 10px;
            }
                </style>
                <body>
            <table>
            <!-- Header -->
            <tr>
                <td colspan=\"2\" class=\"header\">
                    <h1>Transaction Notification</h1>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td colspan=\"2\" class=\"content\">
                    <p>Dear ".$customer->getFirstName() .",</p>
                    <p>A transaction of type ". $transaction->getType()." of <b>".$transaction->getAmount()."</b> LE on ".$current_date." $current_time occured at ATM with ID: ".$this->ID." on account with ID: ".$account->getId().".</p>
                    <p>Your current account balance is <b>".$account->getBalance()."</b> LE.</p>				
                    $HTMLstate
                    <p>Thank you for choosing our bank for your financial needs.</p>
                    <p>Sincerely,</p>
                    <p>The Bank Team</p>
                </td>
            </tr>
        </table>
        </body>";
        $mail->Body = $emailBody;
        try{
            $mail->send();
        }catch(Exception $e){
            return false;
        }
        return true;
    }

    public function getAtmData(){
        $result = $this->db->select("`ATM`", "*", "ID=?", array(1268));//**************************************** */
        if($result){
            $this->ID = $result[0]['ID'];
            $this->city = $result[0]['City'];
            $this->street = $result[0]['Street'];
            $this->area = $result[0]['Area'];
            $this->balance = $result[0]['Balance'];
        }else
        return false;//************** */
    }

    public function notifyNewUser(Card $card, Customer $customer){
        $mail = $this->serverSettings();
        $mail->addAddress($customer->getEmail(), 'Client');
        $mail->Subject = 'Transaction Notification';

        $emailBody = "<head>
        <meta charset=\"UTF-8\">
        <style>
          body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
          }
          h2 {
            color: #333;
          }
          ul {
            list-style-type: none;
            padding: 0;
          }
          li {
            margin-bottom: 10px;
          }
          strong {
            font-weight: bold;
          }
        </style>
      </head>
      <body>
        <div>
          <h2>New Credit Card Details</h2>
          <p>Dear ".$customer->getFirstName().",</p>
          <p>We are pleased to inform you that your new credit card details have been successfully created. Please find the details below:</p>
          <ul>
            <li><strong>Credit Card Number:</strong> ".$card->getId()."</li>
            <li><strong>Cardholder Name:</strong> ".$customer->getFirstName().' '.$customer->getLastName()."</li>
            <li><strong>Expiration Date:</strong> ".$card->getDate()."</li>
            <li><strong>CVV:</strong> ".$card->getCVV()."</li>
            <li><strong>CVV:</strong> ".$customer->getPin()."</li>
          </ul>
          <p>Please ensure to keep this information secure and do not share it with anyone. If you have any questions or concerns regarding your credit card, please feel free to contact our customer support team.</p>
          <p>Thank you for choosing our services!</p>
          <p>Sincerely,</p>
          <p>FCAIH Bank</p>
        </div>
      </body>";

      $mail->Body = $emailBody;
        try{
            $mail->send();
        }catch(Exception $e){
            return false;
        }
        return true;
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
?>