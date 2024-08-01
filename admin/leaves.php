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

    <title>Leave</title>
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
                    <li class="title">Leaves</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="#0">Home</a></li>
                    <li class="current"><em>Leaves</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan=10 style="text-align:center;font-size:25px;">All Leaves</th>
                            </tr>
                            <tr>
                                <th>Sr. no</th>
                                <th>Name</th>
                                <th>Leave Type</th>
                                <th>Starting Date</th>
                                <th>Ending Date</th>
                                <th>Total Days</th>
                                <th>Reasone</th>
                                <th>Status</th>
                                <th>By Whome</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                                require_once '../connection.php';
                                $sql = "SELECT * from leaves";
                                $result = mysqli_query($conn, $sql);
                                // echo $result;
                                
                                if (mysqli_num_rows($result) > 0) {
                                    $i = 1;
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        $leave_id = $rows["id"];
                                        $emp_id = $rows["emp_id"];
                                        $query = "SELECT name FROM users WHERE id = '$emp_id'";
                                        $run = mysqli_query($conn , $query);
                                        if ($run) {                                            
                                            $row = mysqli_fetch_assoc($run);
                                            $emp_id = $row['name'];
                                        }

                                        $type_id = $rows["leave_type"];
                                        $query = "SELECT name FROM leave_types WHERE id = '$type_id'";
                                        $run = mysqli_query($conn , $query);
                                        if ($run) {                                            
                                            $row = mysqli_fetch_assoc($run);
                                            $type_id = $row['name'];
                                        }

                                        $sDate = date('Y-m-d', strtotime($rows["from_date"]));
                                        $eDate = date('Y-m-d', strtotime($rows["to_date"]));

                                        $date1 = new DateTime($sDate);
                                        $date2 = new DateTime($eDate);

                                        $diff = date_diff($date1, $date2);
                                        $days = $diff->format("%d Days");

                                        $reasone = $rows["reasone"];
                                        $status = $rows["status"];                                        
                                        if($rows["by_whome"] == NULL){
                                            $byWhome = "---";
                                        }
                                        else{
                                            $byWhome = $rows["by_whome"];
                                            $query = "SELECT name FROM users WHERE id = '$byWhome'";
                                            $run = mysqli_query($conn , $query);
                                            if ($run) {
                                                $row = mysqli_fetch_assoc($run);
                                                $byWhome = $row['name'];
                                            }
                                        }
                                    ?>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $emp_id; ?></td>
                                <td><?php echo $type_id; ?></td>
                                <td><?php echo $sDate; ?></td>
                                <td><?php echo $eDate; ?></td>
                                <td><?php echo $days; ?></td>                                
                                <td><?php echo $reasone; ?></td>
                                <td align="center">
                                    <?php if($status == "pending"){?>
                                    <div class="status-pending" title="Pending">                                        
                                    </div>
                                    <?php }elseif($status == "accepted"){?>
                                    <div class="status-accepted" title="Accepeted">
                                    </div>
                                    <?php }elseif($status == "canceled"){?>
                                    <div class="status-canceled" title="Canceled">
                                    </div>
                                    <?php }?>
                                </td>
                                <td align="center"><?php echo $byWhome; ?></td>
                                <td align="center">
                                <div class="link-button-group">
                                        <?php
                                            $accept_icon = "<a href='accept-leave.php?id=$leave_id' class='link-button-success' id='edit' name='edit' title='Accept'>&#10004;</a>";
                                            $cancel_icon = "<a href='cancel-leave.php?id=$leave_id' class='link-button-danger confirm' id='delete' name='delete' title='Cancel'>&#10060;</a>";
                                            echo $accept_icon . $cancel_icon;
                                        ?>
                                    </div>
                                </td>
                            <tr>
                                <?php
                                            $i++;
                                        }
                                    } else {?>
                            <tr>
                                <th colspan=8 style="text-align:center;font-size:25px;">No Leave(s) Found</th>
                            </tr>
                            <?php } ?>
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