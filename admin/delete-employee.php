<?php
    require_once '../connection.php';
    
    if (isset($_GET['id'])) {
        $empId = $_GET['id'];
        $sql = "DELETE FROM users WHERE id = '".$empId."'";
        $result = mysqli_query($conn, $sql);

        if($result){
            header('Location: add-employee.php?Employee-Deleted');
        }
    } else {
        header('Location: add-employee.php?No-Id');
    }
?>