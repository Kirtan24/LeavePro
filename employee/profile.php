<?php 
    require_once "../connection.php";
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

    <title>Profile</title>
</head>

<body>
    <div class="wrapper">
        <!-- Header -->
        <?php require_once 'include/header.php' ?>

        <!-- Sidebar -->
        <?php require_once 'include/sidebar.php' ?>


        <div class="section">
            <div class="breadcrumb">
                <ol class="cd-breadcrumb-title">
                    <li class="title">Profile</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="index.php">Home</a></li>
                    <li class="current"><em>Profile</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <form action="#" method="post">
                        <div class="form-group">
                            <?php
                                  $sql = "SELECT * FROM users WHERE id = '".$_SESSION["id"]."'";
                                  $result = mysqli_query($conn, $sql);
                                  if(mysqli_num_rows($result) > 0){
                                    while($rows = mysqli_fetch_assoc($result)){
                                        $image = $rows["image"];
                                        $name = $rows["name"];
                                        $dob = date('d M Y', strtotime($rows["dob"]));
                                        $today = date('Y-m-d');

                                        $date1 = new DateTime($dob);
                                        $date2 = new DateTime($today);

                                        $diff = date_diff($date1, $date2);
                                        $age = $diff->format("%y Years");

                                        $role = $rows["role"];
                                        $gender = $rows["gender"];
                                        $salary = $rows["salary"];
                                        $credits = $rows["leave_credit"];
                                        $marital_status = $rows["marital_status"];
                                    }   
                                }
                            ?>
                            <div style="text-align:center;">
                                <img src="images/<?php echo $image?>" alt="Admin" class="profile-img">
                                <a href="change-image.php" style="font-size:30px;">&#128228;</a>
                            </div>
                            <h1 style="text-align:center;"><?php echo $name; ?></h1>
                            <p class="details"><span class="tag">Role : </span><?php echo ucfirst($role); ?></p>
                            <p class="details"><span class="tag">Email ID : </span><?php echo $_SESSION["email"]; ?></p>
                            <p class="details"><span class="tag">Date Of Birth : </span><?php echo $dob; ?></p>
                            <p class="details"><span class="tag">Age : </span><?php echo $age; ?></p>
                            <p class="details"><span class="tag">Salary : </span><?php echo $salary; ?> Rs.</p>
                            <!-- <p class="details"><span class="tag">Availabel Leave Credits : </span><?php echo $credits; ?></p> -->
                            <p class="details"><span class="tag">Marital Status : </span><?php echo $marital_status; ?></p>
                            <div class="link-button-group">
                                <a href="edit-profile.php" class="link-button" id="edit">Edit Profile</a>
                                <a href="change-password.php" class="link-button" id="change-pass">Change Password</a>                            
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