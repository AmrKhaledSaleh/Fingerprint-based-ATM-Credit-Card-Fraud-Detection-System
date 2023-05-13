<?php
require_once(__DIR__ . "/../../Models/admin.php");
require_once(__DIR__ . "/Head.php");

$showAlert = 0;
$admin = new admin("", "");

if(!isset($_SESSION['firstname'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "../LoginAdmin.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}

if (isset($_POST['customerSSN'])) {
    $ok = $admin->deleteCustomer($_POST['customerSSN']);
    if ($ok) {
        $showAlert = 1;
    } else {
        $showAlert = 2;
    }
}
?>

<body>  
    <?php
        require_once (__DIR__. "/nav.php");
    ?>

    <div class="container">
        <!-- start deleteUser  -->

    <section class="deleteUser screen" id="deleteUser">
        <div class="container-fluid">
            <h2>Delete User</h2>

            <form method="POST" action="#">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="SSN" placeholder="SSN" name="customerSSN" required>
                    <label for="SSN">SSN</label>
                </div>

                <button class="btn btn-danger mb-3 ">Delete User</button>
            </form>
        </div>
        <div class="OTPpopup">
            <div class="alert alert-info" role="alert">
                OTP Send to Your Email
            </div>
            <form action="#">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="OTP" placeholder="OTP">
                    <label for="OTP">OTP</label>
                </div>
                <button class="btn btn-danger">
                    Delete User
                </button>
            </form>
            <a href="#" class="forget">
                Forget Email
            </a>
        </div>
        <div class="fingerPopup">
            <form action="#">
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" id="fingerprint" placeholder="Fingerprint Image">
                    <label for="fingerprint">Edit Fingerprint Image</label>
                </div>
                <button class="btn btn-danger">
                    Delete User
                </button>
            </form>
        </div>
    </section>

    <!-- end deleteUser  -->
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
            title: 'user deleted successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
        Toast.fire({
            icon: 'error',
            title: 'something went wrong with the user deleting'
        })
    </script>
<?php
} ?>