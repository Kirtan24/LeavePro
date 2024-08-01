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

        <?php
            $currentDay = date( 'Y-m-d', strtotime("today") );
            $tomarrow = date( 'Y-m-d', strtotime("+1 day") );

            $today_leave = 0;
            $tomarrow_leave = 0;
            $this_week = 0;
            $next_week = 0;
            $i = 1;
            // total admin
            $select_admins = "SELECT * FROM users WHERE role='admin'";
            $total_admins = mysqli_query($conn , $select_admins);

            // total employee
            $select_emp = "SELECT * FROM users WHERE role='employee'";
            $total_emp = mysqli_query($conn , $select_emp);

            // employee on leave
            $emp_leave  ="SELECT * FROM leaves";
            $total_leaves = mysqli_query($conn , $emp_leave);

            if( mysqli_num_rows($total_leaves) > 0 ){
                while( $leave = mysqli_fetch_assoc($total_leaves) ){
                    $leave = $leave["from_date"];

                    //daywise
                    if($currentDay == $leave){
                        $today_leave += 1;
                    }elseif($tomarrow == $leave){
                       $tomarrow_leave += 1;
                    }
                }
            }else {
                echo "no leave found";
            }
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
                            if($_SESSION["role"] == 'superadmin'){ ?>
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
                                <h2>Employees</h2>
                            </div>
                            <div class="card-body">
                                <p>Total Employees : <?php echo mysqli_num_rows($total_emp); ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="card-button">View All Employees</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h2>Employee On Leave (Day Wise)</h2>
                            </div>
                            <div class="card-body">
                                <p>Today : <?php echo $today_leave; ?> </p>
                                <hr>
                                <p>Tomarrow : <?php echo $tomarrow_leave; ?> </p>
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
        </div>

        <!-- Footer -->
        <?php require_once 'include/footer.php' ?>
    </div>

    <?php require_once 'script.php' ?>

</body>

</html>