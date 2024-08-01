<?php
session_start();
if (empty($_SESSION["email"])) {
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

    <title>Edit Employee</title>
</head>

<body>
    <?php require_once "../connection.php";?>
    <?php        
        $nameErr = $desErr = "";
        $id = $name = $description = $credits = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            if (empty($_REQUEST["name"])) {
                $nameErr = "<p style='color:red;'> * Name is required</p>";
            } else {
                $name = $_REQUEST["name"];
            }

            if (empty($_REQUEST["salary"])) {
                $salaryErr = "<p style='color:red'> * Salary is required</p>";
                $salary = "";
            } else {
                $salary = $_REQUEST["salary"];
            }

            if (empty($_REQUEST["description"])) {
                $desErr = "<p style='color:red'> * Description is required</p> ";
            } else {
                $description = $_REQUEST["description"];
            }

            if (empty($_REQUEST["credits"])) {
                $credits = NULL;
            } else {
                $credits = $_REQUEST["credits"];
            }            

            if (!empty($name) && !empty($description)) {
                $sql = "UPDATE leave_types SET name = '$name' , description = '$description' , credits = '$credits' WHERE id = '$id' ";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("location:add-leave-types.php?Updated-Successfully");
                    $name = $description = $credits = "";
                }
            } else {
                echo "<script>alert(' * All field are required');</script>";
            }
        }

        if(isset($_GET["id"]) && $i == 0){
            $typeId = $_GET["id"];
            $sql = "SELECT * FROM leave_types WHERE id = '".$typeId."'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    $id = $rows["id"];
                    $name = $rows["name"];
                    $description = $rows["description"];
                    $credits = $rows["credits"];
                }
                $i=1;
            }
            else{
                header("location:add-leave-types.php?Id-Not-Found");
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
                    <li class="title">Leave</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="/">Home</a></li>
                    <li class="sub"><a href="/add-leave-types.php">Leave Types</a></li>
                    <li class="current"><em>Edit Leave Type</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <div class="card">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                            <div class="form-group">
                                <h1>Edit Leave Type</h1>
                                <p>Edit leave type.</p>

                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="<?php echo $name; ?>" placeholder="Name">
                                </div>
                                <?php echo $nameErr; ?>

                                <div class="input-group">
                                    <textarea class="form-control" name="description" id="description" cols="30"
                                        rows="5" placeholder="Description"><?php echo $description; ?></textarea>
                                </div>
                                <?php echo $desErr; ?>

                                <div class="input-group">
                                    <input type="text" class="form-control" name="credits"
                                        value="<?php echo $credits; ?>" id="credits" placeholder="Credits">
                                </div>

                                <div class="input-group">
                                    <button type="submit" class="btn btn-outline-primary">Add</button>
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