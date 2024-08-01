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

    <title>LeavePro</title>
</head>

<body>
    <div class="wrapper">        
        <!-- Header -->
        <?php require_once 'include/header.php' ?>

        <!-- Sidebar -->
        <?php require_once 'include/sidebar.php' ?>

        <?php require_once "../connection.php"; ?>
        <div class="section">
            <div class="breadcrumb">
                <ol class="cd-breadcrumb-title">
                    <li class="title">Dashboard</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="#0">Dashboard</a></li>
                    <li class="current"><em>User Profiles</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <?php 
                        $query = "SELECT * FROM users WHERE role='admin' || role='employee'";
                        $run = mysqli_query($conn , $query);                        
                    ?>
                    <div class="card-container">
                        <?php 
                            if (mysqli_num_rows($run) > 0) {
                                while ($rows = mysqli_fetch_assoc($run)) { ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <img src="images/<?php echo $rows["image"]; ?>" width="100px" height="100px" style="border-radius: 50%;">
                                        </div>
                                        <div class="card-body">
                                            <p>Name : <?php echo $rows["name"]; ?> </p>
                                            <p>Email : <?php echo $rows["email"]; ?> </p>
                                            <p>Role : <?php echo $rows["role"]; ?> </p>
                                        </div>
                                    </div>
                                <?php }
                            }
                        ?>                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once 'include/footer.php' ?>
    </div>

    <?php require_once 'script.php' ?>

</body>

</html>