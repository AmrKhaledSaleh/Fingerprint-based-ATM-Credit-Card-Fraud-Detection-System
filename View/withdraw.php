<?php
ob_start();//Capture the HTML in output buffer instead of being sending to the browser immediately
require_once __DIR__.'/../Models/Account.php';
require_once __DIR__.'/../Models/customer.php';//Starts the sessions
require_once __DIR__.'/../Models/Transaction.php';

if(!isset($_SESSION['SSN'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "index.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}

if($_SESSION['fing'] == '1' and $_SESSION['correctPIN'] != '1'){
    $_SESSION['transType'] = 'withdraw';
    header("Location: pin.php");
    exit();
}

//Defining Objects
$account = new Account($_SESSION['account_id'], $_SESSION['balance'], $_SESSION['type']);
$atm = new ATM();//HARD CODED ATM ID: 1264
$atm->getAtmData();
$transaction = new Transaction();
$customer = new Customer($_SESSION['SSN'], $_SESSION['fName'], $_SESSION['lName'], $_SESSION['upass'],
                        $_SESSION['fingerpint'], $_SESSION['Street'], $_SESSION['Area'], $_SESSION['City'],
                        $_SESSION['Email'], $_SESSION['card_id']);

$sweetAlert = null;
if(isset($_POST['amount']) and $_POST['amount'] != ''){
    $transaction->setType("Withdraw");
    $transaction->setAmount($_POST['amount']);
    $sweetAlert = $transaction->withdraw($account, $atm, $customer);

    $sweetAlert === 2 ? $_SESSION['balance'] = $account->getBalance() : null;
}else if(isset($_POST['sbmtbtn']))
    $sweetAlert = 4;
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
                <h2 class="text-white fw-bolder">Withdraw</h2>
                <div class="userInfo my-5">
                    <ul class="">
                        <li class="text-white d-flex flex-column text-start fs-5 mb-3">
                            <span>Balance</span> <?php if($account->getBalance() == '') echo '0'; else echo $account->getBalance();  ?> LE
                        </li>
                        <li class="text-white d-flex flex-column text-start fs-5 mb-3">
                            <span>Account id</span> <?php echo $account->getID();?>
                        </li>
                        <li class="text-white d-flex flex-column text-start fs-5 mb-3">
                            <a href="menu.php">
                                    <img src="assets/img/icons8-back-64.png" alt="Back button">
                                    <br>
                                    <b>Back</b>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="screen menu">
                <div class="buttons d-flex flex-wrap justify-content-between">
                    <form action="#" class="w-100" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="Amount" minlength="2" maxlength="5"
                                placeholder="01234 5648 6542 3156" name="amount">
                            <label for="Amount">Enter Amount</label>
                        </div>
                        <div class="btn btnMenu withdrawBTN" value="50">
                            50 LE
                        </div>
                        <div class="btn btnMenu withdrawBTN" value="100">
                            100 LE
                        </div>
                        <div class="btn btnMenu withdrawBTN" value="200">
                            200 LE
                        </div>
                        <div class="btn btnMenu withdrawBTN" value="500">
                            500 LE
                        </div>
                        <div class="btn btnMenu withdrawBTN" value="1000">
                            1000 LE
                        </div>
                        <div class="btn btnMenu withdrawBTN" value="2000">
                            2000 LE
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 mt-4" name="sbmtbtn">
                            Withdraw
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
    <script src="assets/js/withdraw.js"></script>
    <!-- <script src="assets/js/sessionTimout.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
<?php
    if($sweetAlert === 0 or $sweetAlert === 1 or $sweetAlert === 2 or $sweetAlert === 3 or $sweetAlert === 4 or $sweetAlert === 5){
        $icon = '';
        $message = '';
        switch($sweetAlert){
            case 0:
                $icon = 'error';
                $message = 'Balance Insufficient';
                break;
            case 1:
                $icon = 'error';
                $message = 'Withdrawal Failed, Try again later';
                break;
            case 2:
                $icon = 'success';
                $message = 'Withdrawal completed Successfully';
                break;
            case 3:
                $icon = 'error';
                $message = 'Insufficient ATM balance, please Try another ATM';
                break;
            case 4:
                $icon = 'warning';
                $message = 'Please enter amount before submitting';
                break;
            case 5:
                $icon = 'warning';
                $message = 'withdrawal amount is more than 30% above average, sending OTP to verify';
                break;
            default:
                $icon = 'error';
                $message = 'Something went wrong...';
                break;
        }
?>
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })

        Toast.fire({
        icon: '<?php echo $icon; ?>',
        title: '<?php echo $message; ?>'
        })
    </script>
<?php
    if($sweetAlert === 2){

        $refresh_delay = 3; // 3 seconds delay
        $redirect_url = "menu.php";
        
        header("refresh:$refresh_delay;url=$redirect_url");
        ob_end_flush();//Sends the HTML to the browser
    }

    if($sweetAlert === 5){
        $refresh_delay = 3; // 3 seconds delay
        $redirect_url = "OTP.php";

        header("refresh:$refresh_delay;url=$redirect_url");
        ob_end_flush();//Sends the HTML to the browser
    }
}
?>
</html>