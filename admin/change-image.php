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

    <title>Change Profile Image</title>
</head>

<body>
    <?php
        require_once "../connection.php";
        $imageErr = "";
        $image = $name = "";        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_FILES["profileImage"])){
                $sql = "SELECT name FROM users WHERE id = '".$_SESSION["id"]."'";
                $result = mysqli_query($conn , $sql);                
                if(mysqli_num_rows($result) > 0){
                    while($rows = mysqli_fetch_assoc($result)){
                        $name = $rows["name"];                        
                    }   
                }
    
                $targetDir = "images/";
                $fileName = basename($_FILES["profileImage"]["name"]);
                $fileName = $name . '_' . time() . '_' . $fileName;
    
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFilePath)) {                    
                                
                        $update = "UPDATE users SET image = '$fileName' WHERE id = '".$_SESSION["id"]."'";
                        $result = mysqli_query($conn , $update);
                        if ($result) {
                            echo "<script> alert('Image uploaded successfully!'); </script>";
                            header("location:profile.php");
                        }                    
                    } else {
                        echo "<script> alert('Sorry, there was an error uploading your file.'); </script>";
                    }
                }
                else{
                    $imageErr =  "<p style='color:red;'> * Please enter only  jpg , jpeg , png and gif files<br>You entered : $fileType file.</p>";    
                }
            }
            else{
                $imageErr =  "<p style='color:red;'> * Please select image</p>";
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
                    <li class="title">Change Image</li>
                </ol>
                <ol class="cd-breadcrumb">
                    <li class="sub"><a href="#0">Home</a></li>
                    <li class="sub"><a href="#0">Profile</a></li>
                    <li class="current"><em>Change Profile</em></li>
                </ol>
            </div>
            <div class="content">
                <div class="main">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <h1>Change Profile Image</h1>
                            <p>Change profile image to your choice.</p>

                            <div class="input-group">
                                <input type="file" class="form-control" id="imageInput" name="profileImage" accept="image/*">
                            </div>
                            <?php echo $imageErr; ?>
                            
                            <div id="previewContainer">
                                <?php
                                    if($_SESSION["image"] != NULL){ ?>
                                        <img id="previewImage" src="images/<?php echo $_SESSION["image"]; ?>" alt="Preview">
                                    <?php }
                                    else{ ?>
                                        <img id="previewImage" src="images/admin.jpg" alt="Preview">
                                <?php } ?>
                            </div>
                            <div class="input-group">
                                <button type="submit" class="btn btn-outline-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require_once 'include/footer.php' ?>
    </div>

    <?php require_once 'script.php' ?>

</body>

</html>