<?php 

	require_once("database.php");

	class Comments extends DatabaseObjects {
		protected static $table_name="comments";
		protected static $db_fields= array('photo_id','created','author','body');

		public $id;
		public $photo_id;
		public $created;
		public $author;
		public $body;


		public static function make($photo_id, $author="Anonymous", $body="") {
			if(!empty($photo_id) && !empty($author) && !empty($body)) {
				$comment=new Comments();

				$comment->photo_id=(int)$photo_id;
				$comment->created=strftime("%Y-%m-%d %H:%M:%S", time());
				$comment->author=$author;
				$comment->body=$body;

				return $comment;
			} else {
				return false;
			}
		}

		public static function find_comments_on($photo_id=0) {
			global $database;
			$sql ="SELECT * FROM ". self::$table_name;
			$sql.=" WHERE photo_id=".$database->escape_value($photo_id);
			$sql.=" ORDER BY created ASC";

			return self::find_by_sql($sql);
		}

		public function sendNotification() {
			$mail = new PHPMailer();

			$mail->IsSMTP();
			$mail->Host = "mail.rusaidmrd.com";
			$mail->Port = 143;
			$mail->SMTPAuth = true;
			$mail->Username = "test@rusaidmrd.com";
			$mail->Password ="password";

			$mail->FromName ="Photo Gallery";
			$mail->From ="rusaidmrd@gmail.com";
			$mail->AddAddress("test@rusaidmrd.com","Photo Gallery Admin");
			$mail->Subject = "New Photo gallery Comment";
			$created=datetime_to_text($this->created);

			$mail->body =<<<EMAILBODY
			A new comment has been received in the Photo Gallery.
			At {$created}, {$this->author} wrote :
			{$this->author}

EMAILBODY;

			$result=$mail->send();
			return $result;

		}


	}



 ?>