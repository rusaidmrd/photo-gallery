<?php require_once("../inc/initialize.php"); ?>

<?php 

  // pagination
 
  // 1. the current page number ($current_page)
    $page=!empty($_GET['page']) ? (int)$_GET['page'] : 1;

  // 2. records per page ($per_page)
    $per_page=2;

  // 3. total record count ($total_count)
    $total_count=Photo::count_all();


    $pagination=new Pagination($page, $per_page, $total_count);

	   
  // instead of find all photos, just find the photos for this page
      $sql  ="SELECT * FROM photo ";
      $sql .="LIMIT {$per_page} ";
      $sql .="OFFSET {$pagination->offset()}";

      $photos=Photo::find_by_sql($sql);

  // Need to add ?page=$page to all links we want to maintain the current page (or store $page in $session)


 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Photo Gallary App - By Rusaid MRD</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- custome styles -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">


  </head>
  <body>

    <div class="main-wrapper">

      <div class="container-fluid">
         		<div class="row">
         			<h1>Simple Photo Gallery App</h1>

      				<div class="gallery cf">
      					<?php foreach($photos as $photo) : ?>
      					  <div class="box">
      					    <a href="large-photo.php?id=<?php echo $photo->id; ?>"><img src="<?php echo $photo->image_path(); ?>" /></a>
                    <a href="large-photo.php?id=<?php echo $photo->id; ?>">
                    <div class="box-content">
                        <h3 class="title"><?php echo $photo->filename; ?></h3>
                        <span class="post">Uploded By : Rusaid</span>
                    </div>
                    </a>
      					  </div>
      				 	<?php endforeach; ?>
      				</div><!-- end of gallery cf -->

         		</div><!-- end of row -->

          <?php if($pagination->total_pages() > 1) {?>
            <div class="row top center">
                <div class="pagination">
                    <!-- prev section of pagination -->
                    <?php if($pagination->has_prev_page()){ ?>
                      <a href="index.php?page=<?php echo $pagination->prev_page(); ?>" class="prev">&#60; Prev</a>
                    <?php } ?>
                    
                    <!-- list items of the pagination -->
                    <?php for($i=1; $i<=$pagination->total_pages(); $i++) { ?>
                      <a href="index.php?page=<?php echo $i;?>" <?php if($i == $page){ echo "class=selected"; } ?> > <?php echo $i; ?> </a>
                    <?php } ?>
                    
                    <!-- Next section of pagination -->
                    <?php if($pagination->has_next_page()){ ?>
                      <a href="index.php?page=<?php echo $pagination->next_page(); ?>" class="next">Next &#62;</a>
                    <?php } ?>
                </div><!-- end of pagination -->
            </div>
          <?php } ?>


      </div><!-- end of container -->

    </div><!-- end of main-wrapper -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootsnav.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
  </body>
</html>


