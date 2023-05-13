<?php
require_once(__DIR__ . "/../../Models/admin.php");
require_once(__DIR__ . "/../../Models/Card.php");
require_once(__DIR__ . "/Head.php");

$showAlert = 0;
$admin = new admin();
$cc = new Card;

if(!isset($_SESSION['firstname'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "../LoginAdmin.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}

if (isset($_POST['ccId']) && isset($_POST['ccState'])) {
    $cc->setId($_POST['ccId']);
    $cc->setState($_POST['ccState'] == "Blocked"? false: true);
    $ok = $admin->CreditCardState($cc);
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
        <!-- start creditCard -->

        <section class="creditCard screen" id="creditCard">
            <div class="container-fluid">
                <h2>Manage Credit Cards</h2>
                <form method="POST" action="#">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="UserID" placeholder="name@example.com" name="ccId" required>
                        <label for="UserID">Credit Card ID</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name=ccState>
                            <option value="Blocked">Blocked</option>
                            <option value="Running" selected>Running</option>
                        </select>
                        <label for="floatingSelect">Change State</label>
                    </div>
                    <button class="btn btn-success rounded">Edit Credit Card</button>
                </form>
            </div>
        </section>

        <!-- end creditCard -->
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
            title: 'CreditCard state changed successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
    Toast.fire({
    icon: 'error',
    title: 'something went wrong with the state changing'
    })
    </script>
<?php
} ?>