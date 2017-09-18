<?php
	require_once("database.php");
	class Photo extends DatabaseObjects {

		protected static $table_name="photo";
		protected static $db_fields= array('filename','type','size','caption');
		
		public $id;
		public $filename;
		public $type;
		public $size;
		public $caption;

		private $temp_path;
		protected $upload_dir="images";
		public $errors=array();

		protected $uploaded_errors = array (
			// http://www.php.net/manual/en/features.file-upload.errors.php
			UPLOAD_ERR_OK			=>	"No errors.",
			UPLOAD_ERR_INI_SIZE		=>	"Larger than upload_max_filesize.",
			UPLOAD_ERR_FORM_SIZE	=>	"Larger than form MAX_FILE_SIZE.",
			UPLOAD_ERR_PARTIAL		=>	"Partial upload.",
			UPLOAD_ERR_NO_FILE		=>  "No file.",
			UPLOAD_ERR_NO_TMP_DIR	=>	"No temporary directory",
			UPLOAD_ERR_CANT_WRITE	=>	"Can't write to disk",
			UPLOAD_ERR_EXTENSION	=>	"File upload stopped by extension."
		);

		public function attach_file($file) {
			// perform error checking on the form parameters
			if(!$file || empty($file) || !is_array($file)) {
				$this->errors[]="No file was uploaded";
				return false;
			} else if ($file['error'] != 0) {
				$this->errors[]=$this->upload_errors[$file['error']];
				return false;
			} else {
				// Set object attributes to the form parameters
				$this->temp_path = $file['tmp_name'];
				$this->filename  = basename($file['name']);
				$this->type		 = $file['type'];
				$this->size 	 =$file['size'];
				return true;
			}
		}

		public function save () {
			// A new record won't have an id yet
			if(isset($this->id)) {
				$this->update();
			} else {
				// make sure there are no errors
				// 
				// cant save if there are pre-existing errors
				if(!empty($this->errors)) { return false; }
				// make sure the caption is not too long for the db
				if(strlen($this->caption) > 255) {
					$this->errors[] = "The caption can only be 255 characers long. ";
					return false;
				}
				// Determine the target path
				$target_path=SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;

				// Make sure a file doesn't already exist in the target location
				if(file_exists($target_path)) {
					$this->errors[] = "The file {$this->filename} already exists."; 
					return false;
				}

				// Attempt to move the file
				if(move_uploaded_file($this->temp_path, $target_path)) {
					// Success
					// save a corresponding entry to the database
					if($this->create()) {
						unset($this->temp_path);
						return true;
					}
				} else {
					$this->errors[] = "The file upload filed, possibly due to incorrect permissions on the upload folder";
					return false;
				}
				
			}
		}

		public function destroy() {
			// First remove the database entry
			if($this->delete()) {
				// remove the file
				$target_path=SITE_ROOT.DS. 'public'.DS.$this->image_path();
				return unlink($target_path) ? true : false;
			}else {
				// database deleted file
				return false;
			}
		}

		public function image_path() {
			return $this->upload_dir.DS.$this->filename;
		}


		public function size_as_text() {
			if($this->size < 1024) {
				return "{$this->size} bytes";
			} elseif($this->size < 1048576 ) {
				$size_kb=round($this->size/1024);
				return "{$size_kb} Kb";
			} else {
				$size_mb=round($this->size/1048576, 1);
				return "{$size_mb} MB";
			}
		}

		public function comment(){
			return Comments::find_comments_on($this->id);
		}

	}
?>