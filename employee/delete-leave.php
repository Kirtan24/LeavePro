<?php
    session_start();
    if (empty($_SESSION["email"])) {
        header("Location:../index.php");
    }

    require_once '../connection.php';
    
    if (isset($_GET['id'])) {
        $leaveId = $_GET['id'];
        $sql = "DELETE FROM leaves WHERE id = '".$leaveId."'";
        $result = mysqli_query($conn, $sql);

        if($result){
            header('Location: leave-status.php?Leave-Deleted');
        }
    } else {
        header('Location: add-employee.php?No-Id-Found');
    }
?>