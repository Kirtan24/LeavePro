<?php 
    session_start();    
    if( empty($_SESSION["rEmail"]) ){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>New Password</title>

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
        $pass_err = $conpass_err = $err = "";
        $pass = $conpass = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_REQUEST["password"])) {
                $pass_err = " <p style='color:red'> * Password is Required</p> ";
            } else {
                $pass = md5($_REQUEST["password"]);
            }

            if (empty($_REQUEST["con-password"])) {
                $conpass_err = " <p style='color:red'> * Conform Password is Required</p> ";
            } else {
                $conpass = md5($_REQUEST["con-password"]);
            }

            $email = $_REQUEST["email"];

            if (!empty($pass) && !empty($conpass)) {
                
                $update = "UPDATE users SET password = '$pass' WHERE email = '$email'";
                $result = mysqli_query($conn, $update);
                echo $result;

                if ($result) {
                    unset($_SESSION["rEmail"]);
                    header("location: index.php");
                }
            }
            elseif($pass !== $conpass) {
                $err =  " <p style='color:red'> * Both password must be same.</p> ";
            }
        }
    ?>
    <!-- php script end -->
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <div class="form-group">
            <h1>New Password</h1>
            <p>Create new password...</p>
            <input type="hidden" name="email" value='<?php echo $_SESSION['rEmail']; ?>'>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <?php echo $pass_err; ?>

            <div class="input-group">
                <input type="password" class="form-control" name="con-password" id="con-password" placeholder="Conform Password">
            </div>
            <?php echo $conpass_err; ?>

            <div class="input-group">
                <button type="submit" class="btn btn-outline-primary" id="login">Submit</button>
                <a href="index.php" class="btn-link btn-link-primary">Go back...</a>
            </div>
        </div>
    </form>
</body>
</html>