<?php
	require_once("../../inc/initialize.php");
	if(!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php 

	if(empty($_GET['id'])) {
		$session->message("No Photo ID was provided");
		redirect_to("index.php");
	}


	$photo=Photo::find_by_id($_GET['id']);

	if($photo && $photo->destroy()) {
		$session->message("The photo was deleted");
		redirect_to("list-photos.php");
	} else {
		$session->message("The photo could not be deleted");
		redirect_to("list-photos.php");
	}

 ?>

 <?php if(isset($database)) { $database->close_connection(); } ?>