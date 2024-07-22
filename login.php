<!-- Proses Login -->
<?php
session_start();
require "config.php";

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $pass = md5($_POST["pass"]);

    $sql = "SELECT*FROM users WHERE username='$username' AND pass='$pass'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {

        $_SESSION['username'] = $row["username"];
        $_SESSION['level'] = $row["level"];
        $_SESSION['status'] = "y";

        header("Location:index.php");
    } else {
        header("Location:?msg=n");
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>

    <!-- Validasi Login Gagal -->
    <?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "n") {
    ?>
            <div class="alert alert-danger" align="center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Login Gagal</strong>
            </div>
    <?php
        }
    }
    ?>


    <div class="container-fluid" style="margin-top:150px">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <form method="POST">
                    <div class="card border-dark">
                        <div class="card-header bg-info text-light border-dark">
                            <strong>LOGIN</strong>
                        </div>
                        <div class="card-body border">
                            <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" class="form-control" name="username" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="pass" autocomplete="off" required>
                            </div>
                            <input type="submit" class="btn btn-primary" name="submit" value="Login">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>