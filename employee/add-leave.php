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

    <title>Leave</title>
</head>

<body>
    <?php require_once "../connection.php";?>
    <?php
        $typeErr = $resoneErr = $fromDateErr = $toDateErr = "";
        $type = $reasone = $fromDate = $toDate = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_REQUEST["type"])) {
                $typeErr = "<p style='color:red;'> * Type is required</p>";
            } else {
                $type = $_REQUEST["type"];
            }

            if (empty($_REQUEST["reasone"])) {
                $resoneErr = "<p style='color:red'> * Reasone is required</p>";
            } else {
                $reasone = $_REQUEST["reasone"];
            }

            if (empty($_REQUEST["from-date"])) {
                $fromDateErr = "<p style='color:red'> * Please select date</p> ";
            } else {
                $fromDate = $_REQUEST["from-date"];
            }

            if (empty($_REQUEST["to-date"])) {
                $toDateErr = "<p style='color:red'> * Please select date</p>";
            } else {
                $toDate = $_REQUEST["to-date"];
            }

            if (!empty($type) && !empty($reasone) && !empty($fromDate) && !empty($toDate)) {
                $sql = "INSERT INTO leaves (emp_id , leave_type , reasone , from_date , to_date , status) VALUES('" . $_SESSION["id"] . "' , '$type' , '$reasone' , '$fromDate' , '$toDate' , 'pending')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $type = $reasone = $fromDate = $toDate = "";
                }
            } else {
                echo "<script>alert('All field are required');</script>";
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
                    <li class="sub"><a href="#0">Home</a></li>
                    <li class="current"><em>Apply For Leave</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <div class="form-group">
                            <h1>Apply For Leave</h1>
                            <p>Submit the application of you leave/absence.</p>

                            <div class="input-group">
                                <select class="form-control" name="type" id="type" title="Leave type">
                                    <option value="" selected disabled>Select leave type</option>
                                    <?php
                                        $sql = "SELECT * FROM leave_types";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($rows = mysqli_fetch_assoc($result)) {
                                                $id = $rows["id"];
                                                $name = $rows["name"];
                                                $desc = $rows["description"];
                                                echo "<option value='$id' title='$desc'>$name</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <?php echo $typeErr; ?>

                            <div class="input-group">
                                <textarea class="form-control" name="reasone" id="reasone" cols="10" rows="5"
                                    placeholder="Reasone" title="Reasone"><?php echo $reasone; ?></textarea>
                            </div>
                            <?php echo $resoneErr; ?>

                            <div class="input-group">
                                <input type="date" class="form-control" name="from-date" id="from-date"
                                    title="From date">
                            </div>
                            <?php echo $fromDateErr; ?>

                            <div class="input-group">
                                <input type="date" class="form-control" name="to-date" id="to-date" title="To date">
                            </div>
                            <?php echo $toDateErr; ?>

                            <div class="input-group">
                                <button type="submit" class="btn btn-outline-primary">Apply For Leave</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once 'include/footer.php'?>
    </div>

    <?php require_once 'script.php'?>

</body>

</html>