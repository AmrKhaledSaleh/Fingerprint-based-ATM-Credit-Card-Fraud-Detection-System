<?php
require_once(__DIR__ . "/Head.php");
require_once(__DIR__ . "/../../Models/Account.php");
$showAlert = 0;

if(!isset($_SESSION['firstname'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "../LoginAdmin.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}
if (isset($_POST["AccId"])) {
    $account = new Account();
    $account->setId($_POST["AccId"]);
    $admin = new admin();

    $result = $admin->deleteAccount($account);
    if ($result) {
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
        <!-- start deleteAccount -->

        <section class="deleteAccount screen" id="deleteAccount">
            <div class="container-fluid">
                <h2>Delete Account</h2>
                <form action="#" method="post">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="UserID" placeholder="name@example.com" name="AccId" required>
                        <label for="UserID">Account ID</label>
                    </div>
                    <input class="btn btn-danger rounded" value="Delete Account" type="submit">
                </form>
            </div>
        </section>

        <!-- end deleteAccount -->

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
            title: 'Account deleted successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
        Toast.fire({
            icon: 'warning',
            title: 'There is no account with this ID'
        })
    </script>
<?php
} ?>