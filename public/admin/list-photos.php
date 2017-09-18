<?php
  require_once("../../inc/initialize.php");

  if(!$session->is_logged_in()) { redirect_to("login.php"); }

  // find all photos
  $photos=Photo::find_by_sql("SELECT * FROM photo");

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
									<h3 class="panel-title">List of all photos</h3>
								</div>
								<div class="panel-body">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>#</th>
												<th>Filename</th>
												<th>Caption</th>
												<th>Image</th>
												<th>Size</th>
												<th>Type</th>
												<th>Comments</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($photos as $photo): ?>
											<tr>
												<td><?php echo $photo->id; ?></td>
												<td><?php echo $photo->filename; ?></td>
												<td><?php echo $photo->caption; ?></td>
												<td><img src="../<?php echo $photo->image_path(); ?>" alt="<?php echo $photo->caption; ?>"></td>
												<td><?php echo $photo->size_as_text(); ?></td>
												<td><?php echo $photo->type; ?></td>
												<td>
													<a href="all-comments.php?id=<?php echo $photo->id;?>"><?php echo count($photo->comment()); ?></a>
												</td>
												<td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a></td>
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