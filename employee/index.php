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
    <link rel="icon" href="icon.png" type="image/png">
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

        <?php
        $leave_status_sql = "SELECT * FROM leaves WHERE emp_id = " . $_SESSION["id"] . " ORDER BY from_date DESC LIMIT 1";
        $leave_status_result = mysqli_query($conn, $leave_status_sql);
        $leave_status_row = mysqli_fetch_assoc($leave_status_result);

        $applied_leaves_sql = "
            SELECT 
                SUM(status = 'accepted') as accepted,
                SUM(status = 'canceled') as canceled,
                SUM(status = 'pending') as pending,
                COUNT(*) as total
            FROM leaves WHERE emp_id = " . $_SESSION["id"] . "
        ";
        $applied_leaves_result = mysqli_query($conn, $applied_leaves_sql);
        $applied_leaves_row = mysqli_fetch_assoc($applied_leaves_result);
        ?>


        <div class="section">
            <div class="breadcrumb">
                <ol class="cd-breadcrumb-title">
                    <li class="title">Dashboard</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="#0">Dashboard</a></li>
                    <li class="current"><em>Home</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <div class="card-container">
                        <?php
                        if ($_SESSION["role"] == 'superadmin') { ?>
                            <div class="card">
                                <div class="card-header">
                                    <h2>Admins</h2>
                                </div>
                                <div class="card-body">
                                    <p>Total Admins : <?php echo mysqli_num_rows($total_admins); ?></p>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="card-button">View All Admins</a>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h2>Leave Status</h2>
                            </div>
                            <div class="card-body">
                                <p>Upcoming Leave : <?php echo $leave_status_row ? date('jS M', strtotime($leave_status_row['from_date'])) : 'N/A'; ?></p>
                                <p>Last Leave Status : <?php echo $leave_status_row ? $leave_status_row['status'] : 'N/A'; ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="card-button">View Leave Status</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h2>Applied Leaves</h2>
                            </div>
                            <div class="card-body">
                                <p>Total Accepted : <?php echo $applied_leaves_row['accepted']; ?></p>
                                <p>Total Rejected : <?php echo $applied_leaves_row['canceled']; ?></p>
                                <p>Total Pending : <?php echo $applied_leaves_row['pending']; ?></p>
                                <p>Total Applied : <?php echo $applied_leaves_row['total']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan=7 style="text-align:center;font-size:25px;">Employee Leadership Board
                                    </th>
                                </tr>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Age</th>
                                    <th>Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php require_once "../connection.php"; ?>
                                    <?php
                                    $sql = "SELECT * FROM users  WHERE role = 'employee' ORDER BY salary DESC";
                                    $result = mysqli_query($conn, $sql);

                                    $i = 1;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($rows = mysqli_fetch_assoc($result)) {
                                            $name = $rows["name"];
                                            $email = $rows["email"];
                                            $dob = $rows["dob"];
                                            $gender = $rows["gender"];
                                            $id = $rows["id"];
                                            $salary = $rows["salary"];
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
                                            <td><?php echo $salary; ?></td>
                                </tr>
                                <tr>
                                <?php
                                            $i++;
                                        }
                                    } else { ?>
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
        </div>

        <!-- Footer -->
        <?php require_once 'include/footer.php' ?>
    </div>

    <?php require_once 'script.php' ?>

</body>

</html>