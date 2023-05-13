<?php
require_once(__DIR__ . "/../../Models/admin.php");
require_once(__DIR__ . "/../../Models/ATM.php");
require_once(__DIR__ . "/Head.php");

$showAlert = 0;
$admin = new admin();

if(!isset($_SESSION['firstname'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "../LoginAdmin.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}

if (isset($_POST['atmId'])) {
    $ATM = new ATM();
    $ATM->getAtmData();
    $ATM->setID($_POST['atmId']);
    $ok = $admin->deleteATM($ATM);
    if ($ok) {
        $showAlert = 1;
    } else {
        $showAlert = 2;
    }
}
?>


<body>
    <?php
    require_once(__DIR__ . "/nav.php");
    ?>
    <div class="container">
        <!-- start Delete ATM  -->

        <section class="deleteATM screen " id="deleteATM">
            <div class="container-fluid">
                <h2>Delete ATM</h2>
                <form method="POST" action="#">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="ATMid" placeholder="ATMid" name="atmId" required>
                        <label for="ATMid">ATM ID</label>
                    </div>
                    <button class="btn btn-danger">
                        Delete ATM
                    </button>
                </form>
            </div>
        </section>

        <!-- end Delete ATM  -->
    </div>

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
    </script>

</body>

<?php
if ($showAlert == 1) {
?>
    <script>
        Toast.fire({
            icon: 'success',
            title: 'ATM deleted successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
    Toast.fire({
    icon: 'error',
    title: 'something went wrong with the ATM deleting'
    })
    </script>
<?php
} ?>