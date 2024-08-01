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

    <title>Leave Status</title>
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
                    <li class="title">Leave Status</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="#0">Home</a></li>
                    <li class="current"><em>Leave Status</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan=7 style="text-align:center;font-size:25px;">Leave Status</th>
                            </tr>
                            <tr>
                                <th>Sr. no</th>
                                <th>Starting Date</th>
                                <th>Ending Date</th>
                                <th>Total Days</th>
                                <th>Reasone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                require_once '../connection.php';
                                $sql = "SELECT * FROM leaves WHERE emp_id = '".$_SESSION["id"]."'";
                                $result = mysqli_query($conn, $sql);
                                
                                if (mysqli_num_rows($result) > 0) {
                                    $i = 1;
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        $leave_id = $rows["id"];
                                        $sDate = date('Y-m-d', strtotime($rows["from_date"]));
                                        $eDate = date('Y-m-d', strtotime($rows["to_date"]));

                                        $date1 = new DateTime($sDate);
                                        $date2 = new DateTime($eDate);

                                        $diff = date_diff($date1, $date2);
                                        $days = $diff->format("%d Days");

                                        $reasone = $rows["reasone"];
                                        $status = $rows["status"];
                                    ?>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $sDate; ?></td>
                                <td><?php echo $eDate; ?></td>
                                <td><?php echo $days; ?></td>
                                <td><?php echo $reasone; ?></td>
                                <td align="center">
                                    <?php if($status == "pending"){?>
                                    <div class="status-pending">
                                        Pending
                                    </div>
                                    <?php }elseif($status == "accepted"){?>
                                    <div class="status-accepted">
                                        Accepted
                                    </div>
                                    <?php }elseif($status == "canceled"){?>
                                    <div class="status-canceled">
                                        Canceled
                                    </div>
                                    <?php }?>
                                </td>
                                <td align="center">
                                    <?php
                                        $delete_icon = "<a href='delete-leave.php?id=$leave_id' class='link-button-danger' id='delete' name='delete'>&#10060;</a>";
                                        echo $delete_icon;
                                    ?>
                                </td>
                            <tr>
                                <?php
                                            $i++;
                                        }
                                    } else {?>
                            <tr>
                                <th colspan=8 style="text-align:center;font-size:25px;">No Leave(s) Found</th>
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