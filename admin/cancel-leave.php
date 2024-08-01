<?php    
    session_start();
    if( empty($_SESSION["email"]) ){
        header("Location: ../index.php");
    }

    $empId = $_GET["id"];

    require_once "../connection.php";

    $sql = "UPDATE leaves SET status = 'canceled' , by_whome = '".$_SESSION["id"]."' WHERE id = '$empId' ";
    $result = mysqli_query($conn , $sql);
    if($result){
        header("Location: leaves.php?Leave-Canceled");        
    }

?>