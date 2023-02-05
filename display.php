
<?php
// Include the database configuration file
include 'connection.php';
// Get images from the database
$query = $db->query("SELECT * FROM image ORDER BY UPLOAD_ON DESC");

?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select Image File to Upload:
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
</form>

<?php
if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL = 'images/'.$row["FILE_NAME"];
?>
<img src="<?php echo $imageURL; ?>" alt="" />

<?php }
}else{ ?>
    <p>No image(s) found...</p>

<?php } ?>