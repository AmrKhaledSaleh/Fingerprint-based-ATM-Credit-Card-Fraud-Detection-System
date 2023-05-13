<?php
require_once (__DIR__."/Head.php");
require_once (__DIR__."/../../Controllers/DBconnector.php");
$customer = null;
$test = new customer();
$continue = true;
if(!isset($_SESSION['firstname'])){
    echo '<b>Redirecting you to login screen to login...</b>';
    $refresh_delay = 1; // 2 seconds delay
    $redirect_url = "../LoginAdmin.php";

    header("refresh:$refresh_delay;url=$redirect_url");
    exit();
}
?>

<body>  
    <?php
        require_once (__DIR__. "/nav.php");
    ?>

    <div class="container">
        <!-- start editUser  -->

    <section class="editUser screen screen" id="editUser">
        <div class="container-fluid">
            <h2>Edit User</h2>

            <form action="#" method="get">
                <input type="hidden" value="true" name="Search">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="SSN" placeholder="SSN" name="SSN">
                    <label for="SSN">SSN</label>
                </div>

                <input class="btn btn-success mb-3 " type = "submit" value="Search" >
            </form>
        </div>
        <?php
            $showAlert = 0;
            
            if(isset($_GET["Search"])){
                if(isset($_GET["SSN"])){
                    $db = new DBConnector();
                    $testCustomer = new Customer($_GET["SSN"]);
                    $result = $db->select('User',"*","SSN=?",array($testCustomer->getSSN()));

                    if(!$result){                   
                        $showAlert = 2;
                        $continue = false;
                    }
                    else{
                        $customer = new Customer($_GET["SSN"],$result[0]["FirstName"],$result[0]["LastName"],$result[0]["PIN"],$result[0]["Fingerprint"],$result[0]["Street"],
                        $result[0]["Area"],$result[0]["City"],$result[0]["Email"],"",$result[0]["PhoneNo"]);
                        $test = $customer;
                    }
                }
            }
        ?>

        <div class="Formpopup editForm " id = "Formpopup">
            <form action="#" method="post">
            <input type="hidden" value="true" name="EditUser">
                <div class="d-flex gap-4">
                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="street" placeholder="Street" name = "street" value='<?php echo($customer->getStreet())?>' required>
                        <label for="street">Edit Street</label>
                    </div>
                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="area" placeholder="Area" name = "area" value='<?php echo($customer->getArea())?>' required>
                        <label for="area">Edit Area</label>
                    </div>
                </div>
                <div class="d-flex gap-4">
                    <div class="form-floating w-50 mb-3">
                        <input type="text" class="form-control" id="city" placeholder="City" name = "city" value='<?php echo($customer->getCity())?>' required>
                        <label for="city">Edit City</label>
                    </div>
                    <div class="form-floating w-50 mb-3">
                    <input type="text" class="form-control" id="PINcode" placeholder="PIN Code" name = "PIN" value="Not set">
                    <label for="PINcode">Edit PIN Code</label>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="PINcode" name = "PhoneNo" placeholder="Phone No." value='<?php echo($customer->getPhoneNO())?>' required>
                    <label for="Phone No.">Edit Phone No.</label>
                </div>                
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" placeholder="Email" name = "email" value='<?php echo($customer->getEmail())?>' required
                    >
                    <label for="email">Edit Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" id="fingerprint" name = "fprint" placeholder="Fingerprint Image">
                    <label for="fingerprint">Edit Fingerprint Image</label>
                </div>

                <input class="btn btn-success" type= "submit" value="Edit User" >
                <button class="btn btn-success" onclick='document.getElementById("Formpopup").style.display = "none"'>Cancel</button>
            </form>
        </div>
        <?php
            if($continue && isset($_GET["SSN"])){
                    ?>
                    <script>
                        editUser = document.getElementById("Formpopup")
                        editUser.style.display = 'block'
                    </script>
                    <?php
            }
        ?>


    </section>

    <!-- end editUser  -->

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
echo $showAlert;
if($continue){
    $hashedFingerPrint = false;
    $hash = false;
    $newPIN = false;
    if(isset($_POST["EditUser"])){
        echo "wsap";
        if(isset($_FILES['fprint'])){
            $target_file1 = $_FILES['fprint']["tmp_name"];
            $hashedFingerPrint = md5_file ($target_file1);
        }
        else{
            $hashedFingerPrint = $customer->getFingerprint();
        }
        if(isset($_POST["PIN"]))
            $newPIN = $_POST["PIN"];
        if($newPIN=="Not set"){
            $newPIN = $test->getPin(); 
        }
        else{
            $hash = true;
        }
            
        if(isset($_POST["street"]) && isset($_POST["area"]) && isset($_POST["city"]) && isset($_POST["email"]) && isset($_POST["PhoneNo"]) && $newPIN && $hashedFingerPrint){

            echo $newPIN;
            $newCustomerData = new Customer($customer->getSSN(),"","",$newPIN,$hashedFingerPrint,$_POST["street"],$_POST["area"],
            $_POST["city"],$_POST["email"],"",$_POST["PhoneNo"]);
            
            $admin = new admin();
            $flag = $admin->editCustomer($newCustomerData,$hash);
            print_r($flag);
            if($flag){
            ?>
                <script>
                Toast.fire({
                    icon: 'success',
                    title: 'Customer edited successfully'
                })
                </script>
            <?php
            } else {
            ?>
                <script>
                Toast.fire({
                icon: 'error',
                title: 'Something went wrong , please try again'
                })
                </script>
            <?php
        }
    }
}
}
?>

<?php
if ($showAlert == 1) {
?>

    <script>
        Toast.fire({
            icon: 'success',
            title: 'Customer edited successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
    Toast.fire({
    icon: 'error',
    title: 'There is no customer with this SSN'
    })
    </script>
<?php
} else if ($showAlert == 3) {
    ?>
        <script>
        Toast.fire({
        icon: 'error',
        title: 'Something went wrong , please try again'
        })
        </script>
    <?php
} ?>