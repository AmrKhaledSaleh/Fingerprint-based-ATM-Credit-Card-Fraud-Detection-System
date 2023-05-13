<?php

session_start();
require_once '../Models/admin.php';
$showAlert = 0;

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $admin = new admin($_POST['user'], $_POST['pass']);
    $result = $admin->login("", "");

    if ($result) {
        $_SESSION['userID'] = $result[0]['ID'];
        $_SESSION['firstname'] = $result[0]['FirstName'];
        $_SESSION['lastname'] = $result[0]['LastName'];

        header("Location: admin/home.php");
        exit();
    } else {
        $showAlert = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="admin/adminAssets/css/style.css">
    <link rel="icon" href="admin/adminAssets/img/atm.png">
    <title>Admin Login</title>
</head>

<body>

    <!-- start nav  -->

    <nav class="navbar">
        <div class="container-fluid">
            <h1>Login</h1>
            <span class="mb-0 fs-1">ADMIN Login</span>
        </div>
    </nav>

    <!-- end nav  -->

    <section class="login">
        <div class="container">
            <form method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingSSN" placeholder="Username" name="user" maxlength="20" required>
                    <label for="floatingSSN">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="Password" class="form-control" id="floatingPassword" placeholder="Password" name="pass" required>
                    <label for="floatingCard">Password</label>
                </div>
                <button class="btn btn-success" type="submit">Login</button>
            </form>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            icon: 'error',
            title: 'Wrong username or password, Try again'
        })
    </script>
<?php
}
?>

</html>