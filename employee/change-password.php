<?php 
    session_start();    
    if( empty($_SESSION["email"]) ){
        header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Leave</title>
</head>

<body>
    <!-- php script start -->
    <?php
        require_once "../connection.php";
    ?>
    <?php
        $old_pass_err = $new_pass_err = $conpass_err = "";
        $oldpass = $pass = $conpass = $userpass = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_REQUEST["new-password"])) {
                $new_pass_err = " <p style='color:red'> * New Password is Required</p> ";
            } else {
                $pass = md5($_REQUEST["new-password"]);
            }

            if (empty($_REQUEST["old-password"])) {
                $old_pass_err = " <p style='color:red'> * Old Password is Required</p> ";
            } else {
                $sql = "SELECT password FROM users WHERE id = '".$_SESSION["id"]."'";
                $result = mysqli_query($conn , $sql);                
                if(mysqli_num_rows($result) == 1){
                    while($rows = mysqli_fetch_assoc($result)){
                        $userpass = $rows["password"];
                    }   
                }
                $oldpass = md5($_REQUEST["old-password"]);
            }

            if (empty($_REQUEST["con-password"])) {
                $conpass_err = " <p style='color:red'> * Conform Password is Required</p> ";
            } else {
                $conpass = md5($_REQUEST["con-password"]);
            }

            $email = $_REQUEST["email"];

            if($pass !== $conpass) {
                $err =  " <p style='color:red'> * Both password must be same.</p> ";
            }
            if($userpass !== $pass) {
                $old_pass_err =  " <p style='color:red'> * Enter Corret Old Password.</p> ";
            }
            if (!empty($pass) && !empty($conpass)) {
                
                $update = "UPDATE users SET password = '$pass' WHERE id = '".$_SESSION["id"]."'";
                $result = mysqli_query($conn, $update);

                if ($result) {
                    header("location: profile.php?password-updated");
                }
            }                        
        }
    ?>
    <!-- php script end -->
    <div class="wrapper">
        <!-- Header -->
        <?php require_once 'include/header.php' ?>

        <!-- Sidebar -->
        <?php require_once 'include/sidebar.php' ?>


        <div class="section">
            <div class="breadcrumb">
                <ol class="cd-breadcrumb-title">
                    <li class="title">Leave</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="index.php">Home</a></li>
                    <li class="sub"><a href="profile.php">Profile</a></li>
                    <li class="current"><em>Change Password</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <div class="form-group">
                            <h1>Change Password</h1>
                            <p>Change the password for security...</p>
                            <div class="input-group">
                                <input type="password" class="form-control" name="old-password" id="old-password"
                                    placeholder="Old Password">
                            </div>
                            <?php echo $old_pass_err; ?>

                            <div class="input-group">
                                <input type="password" class="form-control" name="new-password" id="new-password"
                                    placeholder="New Password">
                            </div>
                            <?php echo $new_pass_err; ?>

                            <div class="input-group">
                                <input type="password" class="form-control" name="con-password" id="con-password"
                                    placeholder="Conform Password">
                            </div>
                            <?php echo $conpass_err; ?>

                            <div class="input-group">
                                <button type="submit" class="btn btn-outline-primary" id="change">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php require_once 'include/footer.php' ?>
    </div>

    <?php require_once 'script.php' ?>
</body>
</html>