<?php 
    //Log Out
    if(isset($_POST['ptnLogOut'])){
        $admin = new admin();
        $admin->logout();
        header("Location: ../loginAdmin.php");
        exit;
    }
?>


    <!-- start nav  -->

    <nav class="navbar">
        <div class="container-fluid">
            <i id="menuBTN" class="fa-solid fa-bars"></i>
            <span class="mb-0 fs-1">ATM ADMIN</span>
        </div>
    </nav>

    <!-- end nav  -->

    <!-- start leftSide -->

    <div class="leftSide" id="leftSide">
        <ul class="d-flex flex-column ">
            <li>
                <a href="home.php"><button class="btn-primary d-flex" id="DashBoardBTN">DashBoard</button></a>
            </li>
            <li>
                <button class="btn-primary d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1">
                    Manage Accounts <i class="fa-solid fa-chevron-down"></i>
                </button>
            </li>
            <div class="collapse" id="collapseExample1">
                <ul>
                    <a href="CreateAccount.php"><li class="ps-3 " id="createAccountBTN">Create Account</li></a>
                    <a href="DeleteAccount.php"><li class="ps-3 " id="deleteAccountBTN">Delete Account</li></a>
                    <a href="EditAccount.php"><li class="ps-3 " id="editAccountBTN">Edit Account</li></a>
                    <a href="ManageCreditCards.php"><li class="ps-3 " id="creditCardBTN">Manage Credit Cards</li></a>
                </ul>
            </div>
            <li>
                <button class="btn-primary d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                    Manage users <i class="fa-solid fa-chevron-down"></i>
                </button>
            </li>
            <div class="collapse" id="collapseExample2">
                <ul>
                    <a href="CreateUser.php"><li class="ps-3" id="createUserBTN">Create user</li></a>
                    <a href="DeleteUser.php"><li class="ps-3" id="deleteUserBTN">Delete user</li></a>
                    <a href="EditUser.php"><li class="ps-3" id="editUserBTN">Edit user</li></a>
                </ul>
            </div>
            <li>
                <button class="btn-primary d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                    Manage ATMs <i class="fa-solid fa-chevron-down"></i>
                </button>
            </li>
            <div class="collapse" id="collapseExample3">
                <ul>
                    <a href="CreateATM.php"><li class="ps-3" id="createATMBTN">Create ATM</li></a>
                    <a href="DeleteATM.php"><li class="ps-3" id="deleteATMBTN">Delete ATM</li></a>
                </ul>
            </div>
            <li>
                <a href="CreateAdmin.php"><button class="btn-primary d-flex" id="CreateAdminBTN">Create Admin</button></a>
            </li>
        </ul>
        
        <form method="POST" action="home.php">
            <button class="btn btn-danger" name="ptnLogOut" style="width: 100%">Log out</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="adminAssets/js/script.js"></script>



    <!-- end leftSide -->