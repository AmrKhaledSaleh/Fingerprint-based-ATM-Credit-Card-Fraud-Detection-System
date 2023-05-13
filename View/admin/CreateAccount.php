    <!-- start createAccount  -->
    <?php
    require_once(__DIR__ . "/Head.php");
    require_once(__DIR__ . "/../../Models/Account.php");
    require_once(__DIR__ . "/../../Models/Card.php");
    require_once(__DIR__ . "/../../Models/customer.php");

    $showAlert = 0;
    if(!isset($_SESSION['firstname'])){
        echo '<b>Redirecting you to login screen to login...</b>';
        $refresh_delay = 1; // 2 seconds delay
        $redirect_url = "../LoginAdmin.php";
    
        header("refresh:$refresh_delay;url=$redirect_url");
        exit();
    }
$account = new Account();
if(isset($_POST["SSN"]) && isset($_POST["Type"])){
    $account->setType($_POST["Type"]);
    $customer = new customer($_POST["SSN"]);
    $db = new DBConnector();
    $result = $db->select('`Account`',"Type","SSN = ?",array($customer->getSSN()));
    $flag = true;
    for($i=0;$i<count($result);$i++){
        if($result[$i]["Type"]==$account->getType()){
            $flag = false;
        }
    }
    if($flag && $result){
        $admin = new admin();
        $yes = $admin->createAccount($account,$customer);  
        if ($yes) 
            $showAlert = 1;
        else 
            $showAlert = 2;
    }
    else{
        if($result)
            $showAlert = 3;
        else
            $showAlert = 4;
    }  


}
?>
<body>
    <?php
        require_once (__DIR__. "/nav.php");
    ?>    
    <div class="container">
        <div class="createAccount screen" id="createAccount">
            <div class="container-fluid">
                <h2>Create Account</h2>
                <form method="post" action="#">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingSSN" placeholder="Password" name="SSN" required>
                        <label for="floatingSSN">SSN</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="Type">
                            <option value="Gold">Gold</option>
                            <option value="Saving">Saving</option>
                            <option value="Current">Current</option>
                        </select>
                        <label for="floatingSelect">Select Account Type</label>
                    </div>
                    <input type = "submit" class="btn btn-success" value="Add Account">
                </form>
            </div>
        </div>
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
            title: 'Account created successfully'
        })
    </script>
<?php
} else if ($showAlert == 2) {
?>
    <script>
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong with creating the account'
        })
    </script>
<?php
} else if ($showAlert == 3) {
?>
    <script>
        Toast.fire({
            icon: 'warning',
            title: 'This User has <?php echo "(".$account->gettype().")"; ?> account already'
        })
    </script>
<?php
} else if ($showAlert == 4) {
?>
    <script>
        Toast.fire({
            icon: 'warning',
            title: 'There is no user with this SSN'
        })
    </script>
<?php
} ?>
    <!-- end createAccount  -->