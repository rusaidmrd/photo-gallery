<?php
	require_once("../../inc/initialize.php");
	if(!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php 

	if(empty($_GET['id'])) {
		$session->message("No comment ID was provided");
		redirect_to("index.php");
	}


	$comment=Comments::find_by_id($_GET['id']);

	if($comment && $comment->delete()) {
		$session->message("The comment was deleted");
		redirect_to("all-comments.php?id={$comment->photo_id}");
	} else {
		$session->message("The comment could not be deleted");
		redirect_to("list-photos.php");
	}

 ?>

 <?php if(isset($database)) { $database->close_connection(); } ?>