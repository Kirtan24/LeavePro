<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    

    <title>Login</title>

    <style>
    body {
        background-image: url('office.jpg');
        display: flex;
        min-height: 100vh;
        flex-direction: row;
        align-items: center;
        box-sizing: border-box;
        justify-content: center;
    }
    </style>
</head>

<body>
    <!-- php script start -->
    <?php
        require_once "connection.php";
    ?>
    <?php
        $email_err = $pass_err = $login_Err = "";
        $email = $pass = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_REQUEST["email"])) {
                $email_err = " <p style='color:red'> * Email is Required</p> ";
                $email = "";
            } else {
                $email = $_REQUEST["email"];
            }

            if (empty($_REQUEST["password"])) {
                $pass_err = " <p style='color:red'> * Password is Required</p> ";
                $pass = "";
            } else {
                $pass = md5($_REQUEST["password"]);
            }

            if (!empty($email) && !empty($pass)) {
                $sql_query = "SELECT * FROM users WHERE email='$email' && password = '$pass'  ";
                $result = mysqli_query($conn, $sql_query);

                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        session_start();
                        session_unset();
                        $_SESSION["id"] = $rows["id"];
                        $_SESSION["email"] = $rows["email"];
                        $_SESSION["role"] = $rows["role"];
                        $_SESSION["image"] = $rows["image"];

                        if($rows["role"] == "admin" || $rows["role"] == "superadmin"){
                            header("location: admin/index.php?login-sucess");
                        }
                        elseif($rows["role"] == "employee"){                            
                            header("location: employee/index.php?login-sucess");
                        }
                    }
                } else {
                    echo "<script>alert('Invalid Email or Password.');</script>";
                    $email = "";
                    $pass = "";
                }
            }
        }
    ?>
    <!-- php script end -->
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <div class="form-group">
            <h1>Login</h1>
            <p>Sign In to your account</p>
            <div class="input-group">
                <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" id="email" placeholder="Email">
            </div>
            <?php echo $email_err; ?>

            <div class="input-group">
                <input type="password" class="form-control" name="password" value="<?php echo $pass; ?>" id="password" placeholder="Password">
            </div>
            <?php echo $pass_err; ?>

            <div class="input-group">
                <button type="submit" class="btn btn-outline-primary" id="login">Login</button>
                <a href="forgot-password.php" class="btn-link btn-link-primary">Forgot password?</a>
            </div>
        </div>
    </form>
</body>
</html>