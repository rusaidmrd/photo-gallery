<?php 
	
  // defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
  // defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'c'.DS.'wamp64'.DS.'www'.DS.'php'.DS.'practice'.DS.'photo-gallery');

  // defined('LIB_PATH') ? null : define('LIB_PATH',SITE_ROOT.DS.'inc');	



  // load config file first
  require_once("config.php");

  // load basic functions next so that everything after can use them
  require_once("functions.php");

  // load core objects
  require_once("session.php");
  require_once("database.php");
  require_once("database_object.php");

  // phpMailer classes
  require_once("phpMailer/class.phpmailer.php");
  require_once("phpMailer/class.smtp.php");
  require_once("phpMailer/class.pop3.php");

  // load database related classes
  require_once("user.php");
  require_once("photo.php");
  require_once("comments.php");
  require_once("pagination.php");

?>