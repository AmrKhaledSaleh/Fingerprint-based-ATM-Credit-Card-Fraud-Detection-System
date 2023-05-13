<?php
require_once(__DIR__ . "/../../Models/admin.php");
require_once(__DIR__ . "/../../Models/Account.php");
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

if (isset($_POST['ID']) && isset($_POST['type'])) {
    $account = new Account();
    if ($_POST['Balance'] == -1 && $_POST['type'] == "Same") {
        $showAlert = 3;
    } else {        
        $account->setBalance($_POST['Balance']);
        $account->setType($_POST['type']);
        $account->setId($_POST['ID']);


        $ok = $admin->editAccount($account);
        if ($ok) {
            $showAlert = 1;
        } else {
            $showAlert = 2;
        }
    }
}
?>

<body>
    <?php
    require_once(__DIR__ . "/nav.php");
    ?>
    <!-- start editAccount -->
    <div class="container">
        <section class="editAccount screen" id="editAccount">
            <div class="container-fluid">
                <h2>Edit Account</h2>
                <form action="#" method="post">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="UserID" placeholder="name@example.com" name="ID" required>
                        <label for="UserID">Account ID</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingSSN" name="Balance" value="-1">
                        <label for="floatingSSN">New Balance</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="type">
                            <option value="Gold">Gold</option>
                            <option value="Saving">Saving</option>
                            <option value="Current">Current</option>
                            <option value="Same" selected>don't change</option>
                        </select>
                        <label for="floatingSelect">Change Account Type</label>
                    </div>
                    <button class="btn btn-success">Edit Account</button>
                </form>
            </div>
        </section>
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
            title: 'Account updated successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
        Toast.fire({
            icon: 'error',
            title: 'something went wrong with the account editing'
        })
    </script>
<?php
} else if ($showAlert == 3) { ?>

    <script>
        Toast.fire({
            icon: 'warning',
            title: 'Choose something to edit!'
        })
    </script>

<?php
}
?>