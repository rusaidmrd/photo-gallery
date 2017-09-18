<?php 
  require_once("../../inc/initialize.php");
  
  $message="";


  if($session->is_logged_in()) {
    redirect_to("index.php");
  } else {

  }

  if(isset($_POST['submit'])) {
      $email=trim($_POST['email']);
      $password=trim($_POST['password']);

      // check database to see if email/password exist
      $found_user=User::authenticate($email,$password);

      if($found_user) {
        $session->login($found_user);
        redirect_to("index.php");
        // $message=$found_user->id;
      } else {
        $message="Email/Password combimation incorrect";
      }
      
  } else {
    $email="";
    $password="";
  }


?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- title -->
    <title>Sign up form design by Rusaid MRD</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font-awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- custome styles -->
    <link rel="stylesheet" type="text/css" href="../css/styles.css">


  </head>
  <body>
    <div class="container">
      <div class="row">
            <div class="signin-form">
                <div class="logo-container">
                    <img src="../images/logo.png" alt="logo" class="img-responsive">
                   <?php echo output_message($message); ?> 
                </div><!-- end of logo-container -->
               <form action="login.php" method="post">
                 <div class="form-group ">
                   <input type="email" class="form-control" placeholder="Email " id="email" name="email">
                   <i class="fa fa-envelope"></i>
                 </div>
                 <div class="form-group">
                   <input type="password" class="form-control" placeholder="Password" id="Passwod" name="password">
                   <i class="fa fa-lock"></i>
                 </div>
                 <button type="submit" class="signup-btn" name="submit">Login</button>
               </form>
               <div class="btm-text">
                  <span>Create a new account</span><a href="">Sign up</a>
               </div><!-- end of btm-text -->
           </div><!-- end of signin-form -->
      </div><!-- end of row -->
    </div><!-- end of container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom script file -->
    <script type="text/javascript" src="../js/scripts.js"></script>
  </body>
</html>

<?php if(isset($database)) { $database->close_connection(); } ?>