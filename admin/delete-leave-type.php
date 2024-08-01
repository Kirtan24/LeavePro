<?php
    require_once '../connection.php';
    
    if (isset($_GET['id'])) {
        $typeId = $_GET['id'];
        $sql = "DELETE FROM leave_types WHERE id = '".$typeId."'";
        $result = mysqli_query($conn, $sql);

        if($result){
            header('Location: add-leave-types.php?Leave-Type-Deleted');
        }
    } else {
        header('Location: add-leave-types.php?No-Id-Found');
    }
?>