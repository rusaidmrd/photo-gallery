<?php
require_once("../../inc/initialize.php");
if(!$session->is_logged_in()) { redirect_to("login.php"); }
	
?>

<?php 
	$max_file_size=1048576;


	if(isset($_POST['submit'])) {
		$photo=new Photo();

		$photo->caption=$_POST['caption'];
		$photo->attach_file($_FILES['file_upload']);

		if($photo->save()) {
			// success
			$session->message("Photograph uploaded successfully");
			redirect_to("list-photos.php");
		} else {
			// failure
			$message = join ("</br>", $photo->errors);
		}
	}

?>

<h2>Photo upload</h2>

<h3><?php  echo output_message($message); ?></h3>

<form action="photo_upload.php" method="post" enctype="multipart/form-data">
	<div>
		<input type="hidden" name="MAX_FILE_SIZE"  value="<?php echo $max_file_size; ?>" tabindex="1" />
	</div>

	<div>
		<!-- <label for="file_upload">Photo:</label> -->
		<input type="file" name="file_upload" id="file_upload" tabindex="1" />
	</div>

	<div>
		<label for="caption">Caption:</label>
		<input type="text" name="caption" id="caption" tabindex="1" />
	</div>
	
	<div>
		<input type="submit" name="submit" value="Upload" />
	</div>
</form>