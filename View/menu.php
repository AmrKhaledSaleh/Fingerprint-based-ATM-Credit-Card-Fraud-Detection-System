<?php 
//functions of Customer start from here
require_once "../Models/customer.php";//Starts session
require_once "../Models/Account.php";

if(!isset($_SESSION['SSN'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "index.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}
$account = new Account($_SESSION['account_id'], $_SESSION['balance'], $_SESSION['type']);
$customer = new customer($_SESSION['SSN'],$_SESSION['fName'],$_SESSION['lName'],$_SESSION['upass'],$_SESSION['fingerpint'],
                            $_SESSION['Street'], $_SESSION['Area'], $_SESSION['City'],$_SESSION['Email'],$_SESSION['card_id']);

if(isset($_POST['lg_out'])){
    $customer->logOut();
    
}
if(isset($_POST['block'])){
    $customer->blockcard($_SESSION['card_id']);
    $customer->logOut();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/atm.png">
    <title>ATM APP</title>
</head>

<body>
    <div class="insert h-100 d-flex align-items-center justify-content-center">
        <div class="screens bg d-flex">
            <div class="screen info">
                <h2 class="text-white fw-bolder">ATM </h2>
                <div class="userInfo my-5">
                    <ul>
                        <li class="text-white d-flex flex-column text-start fs-5 mb-3"><span>welcome</span><?php echo $customer->getFirstName() , ' ' , $customer->getLastName() ?>
                        </li>

                        <li class="text-white d-flex flex-column text-start fs-5 mb-3"><span>Balance</span> <?php if($account->getBalance() == '') echo '0'; else echo $account->getBalance();?> LE
                        </li>

                        <li class="text-white d-flex flex-column text-start fs-5 mb-3"><span>Account id</span> <?php echo $account->getId() ?>
                        </li>
                        <?php
                        if(isset($_SESSION['fing']) && $_SESSION['fing'] == 1){//User blocks card if he is logged in by fingerprint
                        ?>
                            <li class="text-white d-flex flex-column text-start fs-5 mb-3">
                                <a href="Changepin.php">
                                    Change PIN
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="text-white d-flex flex-column text-start fs-5 mb-3">
                                <a href="Account.php">
                                    Change Account
                                </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="screen menu">
                <div class="buttons d-flex flex-wrap justify-content-between">
                    <a href="withdraw.php" class="btn btnMenu">
                        Withdraw
                    </a>
                    <a href="deposit.php" class="btn btnMenu">
                        Deposit
                    </a>
                    <a href="transfer.php" class="btn btnMenu">
                        Transfer
                    </a>
                    <a href="transaction.php" class="btn btnMenu">
                        Transaction History
                    </a>
                    <form action="" style="width: 100%;" method="post">
                    <?php
                        if(isset($_SESSION['fing']) && $_SESSION['fing'] == 1){//User blocks card if he is logged in by fingerprint
                        ?>
                            <button name="block" class="btn btnMenu btn-primary" id ="blockCard">
                                Block Card
                            </button>
                        <?php
                        }
                        ?>
                        <button name="lg_out" class="btn btnMenu btn-primary"style="font-weight: bold;">
                            logOut
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- <script src="assets/js/script.js"></script> -->
    <!-- <script src="assets/js/sessionTimout.js"></script> -->
</body>

</html>