<?php
session_start();
require_once __DIR__.'/../Models/Account.php';
require_once __DIR__.'/../Models/Transaction.php';

if(!isset($_SESSION['SSN'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 3 seconds delay
    $redirect_url = "index.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}
$tr = new Transaction();
$account = new Account($_SESSION['account_id'], $_SESSION['balance'], $_SESSION['type']);

$transactions = $tr->viewTransactionHistory($account);
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/atm.png">
    <title>ATM APP</title>
</head>

<body>

    <div class="insert h-100 d-flex align-items-center justify-content-center">
        <div class="screens d-flex">
            <div class="screen history">
                <h2 class="text-white fw-bolder">transaction History</h2>
                <div class="transactions">
                    <?php  for($i=0; $i<sizeof($transactions); $i++){
                                if($transactions[$i]['Type'] == "Withdraw" || $transactions[$i]['Type'] == "Transfer")
                                    $arrow = "fa-arrow-up";
                                else
                                    $arrow = "fa-arrow-down";
                    ?>
                            <div class="transaction d-flex mt-4 justify-content-between" id="<?php echo $i+1;?>">
                                <div class="accountInfo">
                                    <ul>
                                        <li>
                                            <p>Account ID : <span><?php echo $transactions[$i]['AccountID']; ?></span></p>
                                        </li>
                                        <li>
                                            <p>transaction Type : <span><?php echo $transactions[$i]['Date']; ?></span></p>
                                        </li>
                                        <li>
                                            <p>Date : <span><?php echo $transactions[$i]['Type']; ?></span></p>
                                        </li>
                                    </ul>
                                </div>
                                <i class="fa-solid <?php echo $arrow?>"></i>
                            </div>
                    <?php
                            } 
                    ?>
                </div>
            </div>
        </div>
        <div class="backk">
            <a href="menu.php" style="margin-left: 50px;">
                <img src="assets/img/icons8-back-64.png" alt="Back button">
                <br>
                <b style="color:azure">Back</b>
            </a>
        </div>
    </div>

    <div class="popup-cards">
        <?php  for($i=0; $i<sizeof($transactions); $i++){
                        if($transactions[$i]['Type'] == "Transfer")
                            $recAccID = $transactions[$i]['receiverId'];
        ?>
        <div class="popup details flex-column" pop="true" id="<?php echo $i+1;?>-popup">
            <i id="close" class="fa-solid fa-xmark"></i>
            <h2 class="text-white fs-1 mb-5">Transaction Details</h2>
            <ul class="text-start text-white">
                <li>
                    <p>Account ID : <span><?php echo $transactions[$i]['AccountID']; ?></span></p>
                </li>
                <li>
                    <p>transaction Type : <span><?php echo $transactions[$i]['Type']; ?></span></p>
                </li>
                <li>
                    <p>transaction id : <span><?php echo $transactions[$i]['ID']; ?></span></p>
                </li>
                <?php
                if($transactions[$i]['Type'] == "Transfer"){
                    ?>
                    <li>
                        <p>Recipient Account ID : <span><?php echo $recAccID ?></span></p>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <p>ATM ID : <span><?php echo $transactions[$i]['AtmID']; ?></span></p>
                </li>
                <li>
                    <p>State : <span value="<?php echo $transactions[$i]['State']; ?>"><?php echo $transactions[$i]['State']; ?></span></p>
                </li>
                <li>
                    <p>Amount : <span><?php echo $transactions[$i]['Amount']; ?> LE</span></p>
                </li>
                <li>
                    <p>Date : <span><?php echo $transactions[$i]['Date']; ?></span></p>
                </li>
            </ul>
        </div>
        <?php            
            } 
        ?>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="assets/js/logger.js"></script>
    <script src="assets/js/sessionTimout.js"></script>
</body>

</html>