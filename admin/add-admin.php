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

    <title>Add Admin</title>
</head>

<body>
    <?php require_once "../connection.php"; ?>
    <?php        
        $nameErr = $emailErr = $passErr = $salaryErr = $dobErr = "";
        $name = $email = $dob = $gender = $passowrd = $salary = $marital_status = "";

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
            } elseif (strtotime($_REQUEST["dob"]) === false) {
                $dobErr = "Invalid date format.";
            } else {
                $dob = $_REQUEST["dob"];
            }

            if (empty($_REQUEST["name"])) {
                $nameErr = "<p style='color:red;'> * Name is required</p>";
            } elseif (!preg_match('/^[a-zA-Z\s]+$/', $_REQUEST["name"])) {
                $nameErr = "<p style='color:red'> * Please use only charcters.</p>";
            } else {
                $name = $_REQUEST["name"];
            }

            if (empty($_REQUEST["salary"])) {
                $salaryErr = "<p style='color:red'> * Salary is required</p>";                
            } elseif (!is_numeric($_REQUEST["salary"])) {
                $salaryErr = "<p style='color:red'> * Please enter only numbers.</p>";
            } else {
                $salary = $_REQUEST["salary"];
            }

            if (empty($_REQUEST["email"])) {
                $emailErr = "<p style='color:red'> * Email is required</p> ";
            } elseif (!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
                $emailErr = "<p style='color:red'> * Please enter valid email.</p>";
            } else {
                $email = $_REQUEST["email"];
            }

            if (empty($_REQUEST["password"])) {
                $passErr = "<p style='color:red'> * Password is required</p> ";
            } elseif (strlen($_REQUEST["password"]) < 8 || !preg_match('/[A-Z]/', $_REQUEST["password"]) || !preg_match('/[a-z]/', $_REQUEST["password"]) || !preg_match('/[0-9]/', $_REQUEST["password"]) || !preg_match('/[!@#$%^&*]/', $_REQUEST["password"])) {
                $passErr = "<p style='color:red'> * Password must be at least 8 characters long and contain uppercase, lowercase, number, and special characters.</p>";
            } else {
                $password = md5($_REQUEST["password"]);
            }

            if (!empty($name) && !empty($email) && !empty($password) && !empty($salary)) {

                $sql_select_query = "SELECT email FROM users WHERE email = '$email' ";
                $r = mysqli_query($conn, $sql_select_query);

                $image = "admin.jpg";

                if (mysqli_num_rows($r) > 0) {
                    $emailErr = "<br><p style='color:red'> * Email Already Register</p>";
                } else {

                    $sql = "INSERT INTO users( name , email , role , password , gender , dob , salary , leave_credit , image , marital_status) VALUES( '$name' , '$email' , 'admin' , '$password' , '$gender'  , '$dob' , '$salary' , '10' , '$image' , '$marital_status')  ";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        $name = $email = $dob = $gender = $password = $salary = $marital_status = "";
                    }
                }
            } else {
                echo "<p style='color:red;text-align:center;'> * All field are required</p>";
            }
        }
    ?>
    <div class="wrapper">
        <!-- Header -->
        <?php require_once 'include/header.php' ?>

        <!-- Sidebar -->
        <?php require_once 'include/sidebar.php' ?>


        <div class="section">
            <div class="breadcrumb">
                <ol class="cd-breadcrumb-title">
                    <li class="title">Admin</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="#0">Home</a></li>
                    <li class="current"><em>Add Admin</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <div class="form-group">
                            <h1>Add Admin</h1>
                            <p>Create a credentials for new admin.</p>

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

                            <div class="input-group">
                                <input type="password" class="form-control" name="password"
                                    value="<?php echo $passowrd; ?>" id="password" placeholder="Password">
                            </div>
                            <?php echo $passErr; ?>

                            <div class="rdb-group">
                                <div class="rdb-male">
                                    <input type="radio" class="form-control"
                                        <?php if ($gender == "Male") {echo "checked";}?> value="Male" name="gender"
                                        id="male" checked>
                                    <label for="male">Male</label>
                                </div>
                                <div class="rdb-female">
                                    <input type="radio" class="form-control"
                                        <?php if ($gender == "Female") {echo "checked";}?> value="Female" name="gender"
                                        id="female">
                                    <label for="female">Female</label>
                                </div>
                                <div class="rdb-other">
                                    <input type="radio" class="form-control"
                                        <?php if ($gender == "Other") {echo "checked";}?> value="Other" name="gender"
                                        id="other">
                                    <label for="other">Other</label>
                                </div>
                            </div>

                            <div class="input-group">
                                <input type="date" class="form-control" name="dob" id="dob">
                            </div>

                            <div class="input-group">
                                <input type="text" class="form-control" value="<?php echo $salary; ?>" name="salary"
                                    id="salary" placeholder="Salary">
                            </div>
                            <?php echo $salaryErr; ?>

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
                                <button type="submit" class="btn btn-outline-primary" id="login">Add</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan=7 style="text-align:center;font-size:25px;">All Admins</th>
                            </tr>
                            <tr>
                                <th>Sr. No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $sql = "SELECT * FROM users WHERE role = 'admin'";
                                $result = mysqli_query($conn, $sql);

                                $i = 1;
                                if (mysqli_num_rows($result) > 0) {
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        $name = $rows["name"];
                                        $email = $rows["email"];
                                        $dob = $rows["dob"];
                                        $gender = $rows["gender"];
                                        $id = $rows["id"];
                                        if ($gender == "") {
                                            $gender = "Not Defined";
                                        }

                                        if ($dob == "") {
                                            $dob = "Not Defined";
                                            $age = "Not Defined";
                                        } else {
                                            $dob = date('Y-m-d', strtotime($dob));
                                            $today = date('Y-m-d');

                                            $date1 = new DateTime($dob);
                                            $date2 = new DateTime($today);

                                            $diff = date_diff($date1, $date2);
                                            $age = $diff->format("%y Years");
                                        }

                                        ?>
                                <td><?php echo $i; ?></td>
                                <td> <?php echo $name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $gender; ?></td>
                                <td><?php echo $dob; ?></td>
                                <td><?php echo $age; ?></td>
                                <td> <?php if ($email == $_SESSION["email"]) {
                                            echo "<a href='profile.php' class='link-button'>Profile</a>";
                                        } else {
                                            $edit_icon = "<button type='button' class='btn btn-outline-primary' id='edit' name='edit'>&#x270E;</button>";
                                            $delete_icon = "<button type='button' class='btn btn-outline-danger' id='delete' name='delete'>&#10060;</button>";
                                            echo $edit_icon . $delete_icon;
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                            $i++;
                                        }
                                    } else {?>
                            <tr>
                                <th colspan=7 style="text-align:center;font-size:25px;">No Admin Found</th>
                            </tr>
                            <?php }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once 'include/footer.php' ?>
    </div>

    <?php require_once 'script.php' ?>

</body>

</html>