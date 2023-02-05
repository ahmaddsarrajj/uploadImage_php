<?php

// Include the database configuration file
include 'connection.php';


$statusMsg = '';

// File upload path
$image_process = 0;
$targetDir = "./images/";
$resizeFileName = time();

$fileName = basename($_FILES["file"]["name"]);
$sourceProperties = getimagesize($_FILES["file"]["tmp_name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
// Allow certain file formats
$allowTypes = array('jpg','png','jpeg','gif','pdf');

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){

    // Check if file already exists
    if (file_exists($targetFilePath)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    $file=$_FILES['file']['tmp_name'];
    list($width,$height)=getimagesize($file);
    $nwidth=200;
    $nheight=100;
    $newimage=imagecreatetruecolor($nwidth,$nheight);
    
    if($_FILES['file']['type']=='image/jpeg'){
        $source=imagecreatefromjpeg($file);
        imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
        imagejpeg($newimage,'images/'.$fileName);

        //insert to database
        $insert = $db->query("INSERT INTO `image`(`FILE_NAME`, `UPLOAD_ON`) VALUES ('$fileName',NOW())");
        if($insert){
            $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            echo $statusMsg;
            header("location: ./display.php");
        }else{
            $statusMsg = "File upload failed, please try again.";
            echo $statusMsg;
        } 
    }elseif($_FILES['file']['type']=='image/png'){
        $source=imagecreatefrompng($file);
        imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);    
        imagepng($newimage,'images/'.$fileName);

        //insert to database
        $insert = $db->query("INSERT INTO `image`(`FILE_NAME`, `UPLOAD_ON`) VALUES ('$fileName',NOW())");
        if($insert){
            $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            echo $statusMsg;
            header("location: ./display.php");
        }else{
            $statusMsg = "File upload failed, please try again.";
            echo $statusMsg;
        } 
    }elseif($_FILES['file']['type']=='image/gif'){
        $source=imagecreatefromgif($file);
        imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
        imagegif($newimage,'images/'.$fileName);
       
        //insert to database
        $insert = $db->query("INSERT INTO `image`(`FILE_NAME`, `UPLOAD_ON`) VALUES ('$fileName',NOW())");
        if($insert){
            $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            echo $statusMsg;
            header("location: ./display.php");
        }else{
            $statusMsg = "File upload failed, please try again.";
            echo $statusMsg;
        } 
    }else{
        echo "Please select only jpg, png and gif image";
    }

}else{
    $statusMsg = 'Please select a file to upload.';
}

?>
