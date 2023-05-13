<?php
require_once (__DIR__."/Head.php");
require_once(__DIR__."/../../Models/customer.php");

$showAlert = 0;

$hashedFingerPrint = false;

if(!isset($_SESSION['firstname'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "../LoginAdmin.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}

if(isset($_POST["AddUser"])){
    if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["street"]) && isset($_POST["area"])
    && isset($_POST["city"]) && isset($_POST["SSN"]) &&  isset($_POST["PIN"]) && $_POST["PhoneNum"] && isset($_FILES['fprint'])){
        $target_file1 = $_FILES['fprint']["tmp_name"];
        $hashedFingerPrint = md5_file ($target_file1);

        $customer = new customer($_POST["SSN"],$_POST["fname"],$_POST["lname"],$_POST["PIN"],$hashedFingerPrint,
        $_POST["street"],$_POST["area"],$_POST["city"],$_POST["email"],"",$_POST["PhoneNum"]);
        $admin = new Admin();
        $result = $admin->addCustomer($customer);
        if ($result) 
            $showAlert = 1;
        else 
            $showAlert = 2;
    }
    else{
        $showAlert = 3;
    }
}
?>

<body>  
    <?php
        require_once (__DIR__. "/nav.php");
    ?>

    <div class="container">
       <!-- start createUser  -->

       <section class="createUser screen" id="createUser">
        <div class="container-fluid">
            <h2>Create User</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="name d-flex gap-4">

                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="firstName" placeholder="First Name" name="fname" required>
                        <label for="firstName">First Name</label>
                    </div>
                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lname" required>
                        <label for="lastName">Last Name</label>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="d-flex gap-4">
                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="street" placeholder="Street" name="street" required>
                        <label for="street">Street</label>
                    </div>
                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="area" placeholder="Area" name="area" required>
                        <label for="area">Area</label>
                    </div>
                </div>

                <div class="d-flex gap-4">

                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="city" placeholder="City" name="city" required>
                        <label for="city">City</label>
                    </div>
                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="country" placeholder="country" name="country" required>
                        <label for="country">Country</label>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingSSN" placeholder="SSN" name="SSN" required>
                    <label for="floatingSSN">SSN</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" id="fingerprint" placeholder="Fingerprint Image" name="fprint" required>
                    <label for="fingerprint">Upload Fingerprint Image</label>
                </div>
                <div class="d-flex gap-4">
                    <div class="form-floating w-50 mb-3">
                        <input type="number" class="form-control" id="PINcode" placeholder="PIN Code" name="PIN" required>
                        <label for="PINcode">PIN Code</label>
                    </div>
                    <div class="form-floating w-50 mb-3">
                        <input type="number" class="form-control" id="Phone No." placeholder="Phone No." name="PhoneNum" required>
                        <label for="Phone No.">Phone No.</label>
                    </div>
                </div>

                <input class="btn btn-success" type = "submit" value="Add User" name="AddUser" onclick="upload()">
                <script>
                    function upload(){
                        var x = document.getElementById("fingerprint").required = "true";
                        document.getElementById("fingerprint").innerHTML = x;                        
                    }
                </script>
            </form>
        </div>
    </section>
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
    <!-- end createUser  -->
    </div>

</body>

<?php
    if ($showAlert == 1) {

    ?>
        <script>
            Toast.fire({
                icon: 'success',
                title: 'New customer created successfully'
            })
        </script>
    <?php
    } else if ($showAlert == 2) {
    ?>
        <script>
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong with creating the customer'
            })
        </script>
    <?php
    } else if ($showAlert == 3) {
    ?>
        <script>
            Toast.fire({
                icon: 'warning',
                title: 'Please fill all the data'
            })
        </script>
    <?php
    } ?>