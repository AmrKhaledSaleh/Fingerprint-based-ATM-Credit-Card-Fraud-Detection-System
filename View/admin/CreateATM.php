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

if (isset($_POST['city']) && isset($_POST['area']) && isset($_POST['street'])) {
    $ATM = new ATM(0, $_POST['city'],$_POST['street'], $_POST['area'], 0);
    $ok = $admin->addAtm($ATM);
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
        <!-- start Create ATM  -->

        <section class="createATM screen " id="createATM">
            <div class="container-fluid">
                <h2>Add ATM</h2>
                <form method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="CityATM" placeholder="City" name="city" required>
                        <label for="CityATM">City</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="AreaATM" placeholder="Area" name="area" required>
                        <label for="AreaATM">Area</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="StreetATM" placeholder="StreetATM" name="street" required>
                        <label for="StreetATM">Street</label>
                    </div>
                    <button class="btn btn-success">
                        Add ATM
                    </button>
                </form>
            </div>
        </section>

        <!-- end Create ATM  -->
    </div>
</body>

<?php
if ($showAlert == 1) {

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
            icon: 'success',
            title: 'New ATM added successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
        const Tooast = Swal.mixin({
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

        Tooast.fire({
            icon: 'error',
            title: 'something went wrong with ATM adding'
        })
    </script>
<?php
} ?>