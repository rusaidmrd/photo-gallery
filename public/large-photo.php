<?php require_once("../inc/initialize.php"); ?>

<?php 
	if(empty($_GET['id'])) {
		$session->message("No Photo ID was provided");
		redirect_to("index.php");
	}

	$photo=Photo::find_by_id($_GET['id']);
	if(!$photo) {
		$session->message("The photo could not be found");
		redirect_to("index.php");
	}

  if(isset($_POST['submit'])) {
      $author=trim($_POST['author']);
      $body=trim($_POST['body']);

      $new_comment=Comments::make($photo->id,$author,$body);

      if($new_comment && $new_comment->save()) {
        //comment saved
        //
        // send email
        $new_comment->sendNotification();

        redirect_to("large-photo.php?id={$photo->id}");
        
      }else {
        // failed
        $message="There was an error that prevented the comment from bieng saved.";
      }

  }else {
    $author = "";
    $body ="";
  }



  $comments=$photo->comment();

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

       <div class="container">
       		<div class="row single-img-container top">
       			<div class="col-lg-12 col-md-12">
       				<img src="<?php echo $photo->image_path(); ?>" alt="<?php echo $photo->caption; ?>">
       			</div>
       		</div><!-- end of row -->
       </div><!-- end of container -->

       <div class="container">
            <div class="row">
                 <?php foreach($comments as $comment): ?>
                    <div class="comments-container">
                        <ul id="comments-list" class="comments-list">
                          <li>
                            <div class="comment-main-level">
                              <!-- Avatar -->
                              <div class="comment-avatar"><img src="images/prof.png" alt=""></div>
                              <!-- Contenedor del Comentario -->
                              <div class="comment-box">
                                <div class="comment-head">
                                  <h6 class="comment-name by-author"><a href="http://creaticode.com/blog"><?php echo htmlentities($comment->author); ?></a></h6>
                                  <span><?php echo datetime_to_text($comment->created); ?></span>
                                  <i class="fa fa-reply"></i>
                                  <i class="fa fa-heart"></i>
                                </div>
                                <div class="comment-content">
                                  <?php echo strip_tags($comment->body,'<strong><em><p>') ?>
                                </div>
                              </div>
                            </div>


                            <!-- comments-list reply-list -->
                            <ul class="comments-list reply-list">
                              <li>
                                <!-- Avatar -->
                                <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                                <!-- Contenedor del Comentario -->
                                <div class="comment-box">
                                  <div class="comment-head">
                                    <h6 class="comment-name"><a href="http://creaticode.com/blog">Lorena Rojero</a></h6>
                                    <span>hace 10 minutos</span>
                                    <i class="fa fa-reply"></i>
                                    <i class="fa fa-heart"></i>
                                  </div>
                                  <div class="comment-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                                  </div>
                                </div>
                              </li>

                              <li>
                                <!-- Avatar -->
                                <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_1_zps8e1c80cd.jpg" alt=""></div>
                                <!-- Contenedor del Comentario -->
                                <div class="comment-box">
                                  <div class="comment-head">
                                    <h6 class="comment-name by-author"><a href="http://creaticode.com/blog">Agustin Ortiz</a></h6>
                                    <span>hace 10 minutos</span>
                                    <i class="fa fa-reply"></i>
                                    <i class="fa fa-heart"></i>
                                  </div>
                                  <div class="comment-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                                  </div>
                                </div>
                              </li>
                            </ul>


                          </li>

                        </ul><!-- end of ul comments-list -->
                    </div><!-- end of comments-container -->
                  <?php endforeach; ?>

                  <?php if(empty($comments)) { echo "empty comments"; } ?>

                    <div class="col-lg-12 col-md-12 top comment-form-container">
                        <div id="comment-form">
                            <div>
                              <input type="text" name="name" id="name" value="" placeholder="Name">
                            </div>
                            <div>
                              <input type="email" name="email" id="email" value="" placeholder="Email">
                            </div>
                            <div>
                              <input type="url" name="website" id="website" value="" placeholder="Website URL">
                            </div>
                            <div>
                              <textarea rows="10" name="comment" id="comment" placeholder="Comment"></textarea>
                            </div>
                            <div>
                              <input type="submit" name="submit" value="Add Comment">
                            </div>
                        </div><!-- end of comment-form -->
                    </div>
            </div><!-- end of row -->
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