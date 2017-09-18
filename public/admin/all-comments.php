<?php
 	require_once("../../inc/initialize.php");

  	if(!$session->is_logged_in()) { redirect_to("login.php"); }

 	if(empty($_GET['id'])) {
		$session->message("No Photo ID was provided");
		redirect_to("index.php");
	}

	$photo=Photo::find_by_id($_GET['id']);
	if(!$photo) {
		$session->message("The photo could not be found");
		redirect_to("index.php");
	}

	// find all comments
	$comments=$photo->comment();

?>

<?php include_layout_template("admin_header.php"); ?>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<?php include_layout_template("admin_top_nav.php"); ?>
		<!-- END NAVBAR -->


		<!-- LEFT SIDEBAR -->
		<?php include_layout_template("admin_sidebar.php"); ?>
		<!-- END LEFT SIDEBAR -->


		<div class="main">
			<div class="main-content">
				<div class="container">
					<div class="row list-all-img">
						<h2><?php echo output_message($message); ?></h2>

						<div class="col-md-12">
							<!-- TABLE HOVER -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">List of all Commnets for <?php echo $photo->filename; ?> &nbsp;<span><?php echo count($photo->comment()); ?></span> </h3>
								</div>
								<div class="panel-body">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>#</th>
												<th>Author name</th>
												<th>Comment</th>
												<th>Created</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($comments as $comment): ?>
											<tr>
												<td><?php echo $comment->id; ?></td>
												<td><?php echo htmlentities($comment->author); ?></td>
												<td><?php echo strip_tags($comment->body, "<strong><em><p>"); ?></td>
												<td><?php echo datetime_to_text($comment->created); ?></td>
												<td><a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a></td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>

							</div>
							<!-- END TABLE HOVER -->
						</div>


						<a href="photo_upload.php">Upload a new photo</a>


					</div><!-- end of row with list-all-img -->

				</div><!-- end of container -->
			</div><!-- end of main-content -->
		</div><!-- end of main -->
		
<?php include_layout_template("admin_footer.php"); ?>