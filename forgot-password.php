<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password</title>

    <style>
    body {
        background-image:url('office.jpg');
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
    <?php
        require_once "connection.php";
    ?>
    <?php
        $email_err = "";
        $email = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_REQUEST["email"])) {
                $email_err = " <p style='color:red'> * Email is required</p>";
            } else {
                $email = $_REQUEST["email"];
            }

            if (!empty($email)) {                

                $check = "SELECT * FROM users WHERE email='$email' ";
                $result = mysqli_query($conn, $check);                

                if (mysqli_num_rows($result) > 0) {
                    session_start();
                    session_unset();
                    $_SESSION["rEmail"] = $email;                    
                    header("location: recover-password.php");
                } else {
                    $email_err = "<p style='color:red'> * Incorrect email address enter.</p>";
                }
            }
        }
    ?>
    <!-- php script end -->
    <div class="card">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <div class="form-group">
                <h1>Forgot Password!</h1>
                <p class="text-medium-emphasis">Recover your password...</p>
                <div class="input-group">
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email your email...">
                </div>
                <?php echo $email_err; ?>

                <div class="input-group">
                    <button type="submit" class="btn btn-outline-primary" name="login" id="login">Conform!</button>
                    <a href="index.php" class="btn-link btn-link-primary">Go back...</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>