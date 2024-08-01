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

    <title>Edit Profile</title>
</head>

<body>    
    <?php
        require_once "../connection.php";
        $nameErr = $emailErr = "";
        $name = $email = $dob = $gender = $marital_status = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_REQUEST["gender"])) {
                $gender = "";
            } else {
                $gender = $_REQUEST["gender"];
            }

            if (empty($_REQUEST["marital_status"])) {
                $marital_status = "";
            } else {
                $marital_status = $_REQUEST["marital_status"];
            }

            if (empty($_REQUEST["dob"])) {
                $dob = "";
            } else {
                $dob = $_REQUEST["dob"];
            }

            if (empty($_REQUEST["name"])) {
                $nameErr = "<br><p style='color:red;'> * Name is required</p>";
            } else {
                $name = $_REQUEST["name"];
            }            

            if (empty($_REQUEST["email"])) {
                $emailErr = "<br><p style='color:red'> * Email is required</p> ";
            } else {
                $email = $_REQUEST["email"];
            }

            if (!empty($name) && !empty($email)) {
                $sql = "UPDATE users SET name = '$name' , email = '$email' , gender = '$gender' , dob = '$dob' , marital_status = '$marital_status' WHERE id = '".$_SESSION["id"]."'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $name = $email = $dob = $gender = $marital_status = "";
                }
            } else {
                echo "<p style='color:red;text-align:center;'> * All field are required</p>";
            }
        }
    ?>
    <div class="wrapper">
        <!-- Header -->
        <?php require_once 'include/header.php'?>

        <!-- Sidebar -->
        <?php require_once 'include/sidebar.php'?>


        <div class="section">
            <div class="breadcrumb">
                <ol class="cd-breadcrumb-title">
                    <li class="title">Edit Profile</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="/">Home</a></li>
                    <li class="sub"><a href="profile.php">Profile</a></li>
                    <li class="current"><em>Edit Profile</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <div class="card">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                            <div class="form-group">
                                <h1>Edit Profile</h1>
                                <p>Update you personal profile.</p>

                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="<?php echo $name; ?>" placeholder="Name">
                                </div>
                                <?php echo $nameErr; ?>

                                <div class="input-group">
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="<?php echo $email; ?>" placeholder="Email">
                                </div>
                                <?php echo $emailErr; ?>

                                <div class="rdb-group">
                                    <div class="rdb-male">
                                        <input type="radio" class="form-control"
                                            <?php if ($gender == "Male") {echo "checked";}?> value="Male" name="gender"
                                            id="male" checked>
                                        <label for="male">Male</label>
                                    </div>
                                    <div class="rdb-female">
                                        <input type="radio" class="form-control"
                                            <?php if ($gender == "Female") {echo "checked";}?> value="Female"
                                            name="gender" id="female">
                                        <label for="female">Female</label>
                                    </div>
                                    <div class="rdb-other">
                                        <input type="radio" class="form-control"
                                            <?php if ($gender == "Other") {echo "checked";}?> value="Other"
                                            name="gender" id="other">
                                        <label for="other">Other</label>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <input type="date" class="form-control" name="dob" id="dob">
                                </div>

                                <div class="rdb-group">
                                    <div class="rdb-married">
                                        <input type="radio" class="form-control"
                                            <?php if ($marital_status == "Married") {echo "checked";}?> value="Married"
                                            name="marital_status" id="married" checked>
                                        <label for="married">Married</label>
                                    </div>
                                    <div class="rdb-unmarried">
                                        <input type="radio" class="form-control"
                                            <?php if ($marital_status == "Female") {echo "checked";}?> value="Unmarried"
                                            name="marital_status" id="unmarried">
                                        <label for="unmarried">Unmarried</label>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary" id="update">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once 'include/footer.php'?>
    </div>

    <?php require_once 'script.php'?>

</body>

</html>