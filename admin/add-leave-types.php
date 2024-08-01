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

    <title>Add Leave Types</title>
</head>

<body>
    <?php require_once "../connection.php"; ?>
    <?php
    $nameErr = $desErr = "";
    $name = $description = $credits = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_REQUEST["name"])) {
            $nameErr = "<br><p style='color:red;'> * Name is required</p>";
        } else {
            $name = $_REQUEST["name"];
        }

        if (empty($_REQUEST["salary"])) {
            $salaryErr = "<br><p style='color:red'> * Salary is required</p>";
            $salary = "";
        } else {
            $salary = $_REQUEST["salary"];
        }

        if (empty($_REQUEST["description"])) {
            $desErr = "<br><p style='color:red'> * Description is required</p> ";
        } else {
            $description = $_REQUEST["description"];
        }

        if (empty($_REQUEST["credits"])) {
            $credits = NULL;
        } else {
            $credits = $_REQUEST["credits"];
        }

        if (!empty($name) && !empty($description)) {

            $sql_select_query = "SELECT * FROM leave_types WHERE name = '$name' ";
            $result = mysqli_query($conn, $sql_select_query);

            if (mysqli_num_rows($result) > 0) {
                $nameErr = "<p style='color:red'> * Leave Type Already Exist.</p>";
                $description = $credits = "";
            } else {
                $sql = "INSERT INTO leave_types (name , description , credits) VALUES('$name' , '$description' , '$credits')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $name = $description = $credits = "";
                } else {
                    echo "Error";
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
                    <li class="title">Leave Types</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="#0">Home</a></li>
                    <li class="current"><em>Add Leave Type</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                        <div class="form-group">
                            <h1>Add Leave Type</h1>
                            <p>Create a leave types.</p>

                            <div class="input-group">
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" placeholder="Name">
                            </div>
                            <?php echo $nameErr; ?>

                            <div class="input-group">
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Description"><?php echo $description; ?></textarea>
                            </div>
                            <?php echo $desErr; ?>

                            <div class="input-group">
                                <input type="text" class="form-control" name="credits" value="<?php echo $credits; ?>" id="credits" placeholder="Credits">
                            </div>

                            <div class="input-group">
                                <button type="submit" class="btn btn-outline-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan=5 style="text-align:center;font-size:25px;">All Leave Types</th>
                        </tr>
                        <tr>
                            <th>Sr. No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Credits</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $sql = "SELECT * FROM leave_types";
                            $result = mysqli_query($conn, $sql);

                            $i = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($rows = mysqli_fetch_assoc($result)) {
                                    $id = $rows["id"];
                                    $name = $rows["name"];
                                    $description = $rows["description"];
                                    $credits = $rows["credits"];
                            ?>
                                    <td><?php echo $i; ?></td>
                                    <td> <?php echo $name; ?></td>
                                    <td><?php echo $description; ?></td>
                                    <td><?php echo $credits; ?></td>
                                    <td>
                                        <div class="link-button-group">
                                            <?php
                                            $edit_icon = "<a href='edit-leave-type.php?id=$id' class='link-button' id='edit' name='edit'>&#x270E;</a>";
                                            $delete_icon = "<a href='delete-leave-type.php?id=$id' class='link-button-danger' id='delete' name='delete'>&#10060;</a>";
                                            echo $edit_icon . $delete_icon;
                                            ?>
                                        </div>
                                    </td>
                        <tr>
                        <?php
                                    $i++;
                                }
                            } else { ?>
                        <tr>
                            <th colspan=8 style="text-align:center;font-size:25px;">No Leave Type Found</th>
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