<?php 
/** 
 * UploadComponent.php
 * Component for uploading videos,files etc.
 */ 
class UploadComponent extends Component {

 	
/**
 * uploads files to the server
 * @params:
 *		$folder 	= the folder to upload the files e.g. 'img/files'
 *		$formdata 	= the array containing the form files
 * 		$permitted  = the array containig the accepted file formats
 * 		$maxSize    = maximum accepted size of a file in bytes	
 *		$itemId 	= id of the item (optional) will create a new sub folder
 * @return:
 *		will return an array with the success of each file upload
 */
function uploadFiles($folder_url, $formdata, $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png'), $maxSize=false, $itemId = null) {
	// setup dir names absolute and relative
	
	// create the folder if it does not exist
	if(!is_dir($folder_url)) {
		mkdir($folder_url);
	}
		
	// if itemId is set create an item folder
	if($itemId) {
		// set new absolute folder
		$folder_url = $folder_url.$itemId; 
		// create directory
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}
	}
	
	// loop through and deal with the files
	// replace spaces with underscores
	$filename = str_replace(' ', '_', $formdata['name']);
	// assume filetype is false
	$typeOK = false;
	// check filetype is ok
	
	//added by shivam on 27 nov 2013
	$filetypes = explode(".",$filename);
	if(strtolower($filetypes[count($filetypes)-1]) == 'pdf') {
		$typeOK = true;
	} else {
		foreach($permitted as $type) {
			if($type == $formdata['type']) {
				$typeOK = true;
				break;
			}
		}
	}
	if($maxSize && $formdata['size'] > $maxSize) {
		$formdata['error']=5;
		$maxSize = ($maxSize/1024)/1024;
	}
	// if file type ok upload the file
	if($typeOK) {
		// switch based on error code
		switch($formdata['error']) {
			case 0:
				// check filename already exists
				if(!file_exists($folder_url.$filename)) {
					// create full filename
					$full_url = $folder_url.$filename;
					$new_file_name=$filename;
					// upload the file
					$success = move_uploaded_file($formdata['tmp_name'], $full_url);
				} else {
					// create unique filename and upload file
					ini_set('date.timezone', 'Europe/London');
					$now = date('Y-m-d-His');
					$full_url = $folder_url.$now.$filename;
					$new_file_name=$now.$filename;
					$success = move_uploaded_file($formdata['tmp_name'], $full_url);
				}
				// if upload was successful
				if($success) {
					// save the url of the file
					$result['path'][] = $full_url;
					$result['new_filename'][] = $new_file_name;
				} else {
					$result['errors'][] = "Error uploaded $filename. Please try again.";
				}
				break;
			case 3:
				// an error occured
				$result['errors'][] = "Error uploading $filename. Please try again.";
				break;
			case 5:
				// an error occured
				$result['errors'][] = "File size should be less than {$maxSize} mb.";
				break;
			default:
				// an error occured
				$result['errors'][] = "System error uploading $filename.";
				break;
			}
		} elseif($formdata['error'] == 4) {
			// no file was selected for upload
			$result['errors'][] = "No file Selected";
		} else {
			// unacceptable file type
			$comma_separated = implode(",", $permitted);
			$result['errors'][] = "$filename cannot be uploaded. Acceptable file types: {$comma_separated}.";
		}
		return $result;
	}
/**
 * uploads video 
 * will return an array with the success of each video upload
 * In the first argument pass the folder name in which video is uploaded
 * And in second one the full info of video like tmp_name,name,type,etc.
 * And in third one the itemId, it is for if you want to create new folder basis on the newly inserted Id.
 */ 
	public function uploadVideos($folder_url, $formdata, $itemId = null) {
		// setup dir names absolute and relative
		if(empty($formdata['tmp_name'])) {
			// unacceptable file type
			$result['path']='error';
			$result['errors'] = "Form data is empty.";
			return $result;
		}
		
		// create the folder if it does not exist
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}
			
		$folder_url_tmp = ($itemId) ? $folder_url.$itemId.'/' : $folder_url.'tmp/'; 
		// set new relative folder
		// create directory
		if(!is_dir($folder_url_tmp)) {
			mkdir($folder_url_tmp);
		}
			
		// list of permitted video file types
		$permitted = array('video/x-flv','video/3gp','video/quicktime','video/mov','video/avi','video/mp4','video/swf','video/mpeg','video/mpeg','video/mp4','video/flv', 'video/x-ms-wmv', 'video/3gpp', 'video/x-flv', 'video/webm');
 	
		//$targetFileTypes = array('mp4', 'ogv', 'webm');
		$targetFileTypes = array('mp4',  'webm');
		
		// replace spaces with underscores
		$filename = rand(10,10000).str_replace(' ', '_', $formdata['name']);
		// assume filetype is false
		$typeOK = false;
		// check filetype is ok
		foreach($permitted as $type) {
			if ($type == $formdata['type']) {
				$typeOK = true;
				break;
			}
		}
		// if file type ok upload the file
		if ($typeOK) {
		 	if ($formdata['size'] <= MashupVideoMaxSize) {
				// switch based on error code
				switch ($formdata['error']) {
					case 0:
							// create unique filename and upload file
							$now = date('Y-m-d-His');
							ini_set('date.timezone', 'Europe/London');
							//$fileupload = $folder_url_tmp.$now.$filename;
							$fileupload = $folder_url_tmp.$filename;
							if (move_uploaded_file($formdata['tmp_name'], $fileupload)) {
								$path_parts = pathinfo($fileupload);  
								$source = $fileupload;
								foreach($targetFileTypes as $fileTypesVal) {
									$targetFilenameExt[$fileTypesVal] = $path_parts['filename'].".{$fileTypesVal}";
									$targetFilename[$fileTypesVal] = $path_parts['filename'];
									$targetFolder[$fileTypesVal] = $folder_url.$targetFilenameExt[$fileTypesVal];
								}
								$orgfile = explode(".",$filename);
								if(strtolower($orgfile[count($orgfile)-1]) != 'mp4') {
									exec(FFMPEG_PATH." -i ".escapeshellarg($source)." -b 500k -vcodec libx264 -g 30 ".escapeshellarg($targetFolder['mp4'])."");
								} else {
									if(copy($source,$targetFolder['mp4'])){
										
									} else {
										
									}
									exec(FFMPEG_PATH." -i ".escapeshellarg($source)." -c copy -copyts ".escapeshellarg($targetFolder['mp4']));
								}
								//exec(FFMPEG_PATH." -i ".escapeshellarg($source)." -c copy -copyts ".escapeshellarg($targetFolder['mp4'])); //encode video into mp4 format

								exec(FFMPEG_PATH." -i ".escapeshellarg($source)." -acodec libvorbis -b:a 64k -ac 2 -vcodec libvpx -b:v 200k -f webm -s 384x216 ".escapeshellarg($targetFolder['webm'])); //encode video into webm format

								//exec(FFMPEG_PATH." -i ".escapeshellarg($source)." -b 100k -vcodec libvpx -acodec libvorbis -ab 160000 -f webm -g 20 ".escapeshellarg($targetFolder['webm'])); //encode video into webm format
                                        
								//exec(FFMPEG_PATH." -i ".escapeshellarg($source)." -b 100k -vcodec libtheora -acodec libvorbis -ab 160000 -g 20 ".escapeshellarg($targetFolder['ogv'])); //encode video into ogv format

								/*$posterName = pathinfo($source);
								$posterName = $posterName['filename'].".jpg";
								exec(FFMPEG_PATH." -i ".escapeshellarg($source)." -deinterlace -an -ss ".VIDEO_POSTER_INTERVAL." -f mjpeg -t 1 -r 1 -y -s ".VIDEO_POSTER_SIZE." ".VIDEO_POSTER_UPLOADING_PATH."{$posterName} 2>&1");*/ //take video poster

								foreach($targetFileTypes as $key=>$fileTypesVal) {
									$result['path'][$key] = $targetFolder[$fileTypesVal];
									$result['filenameExt'][$key] = $targetFilenameExt[$fileTypesVal];
									$result['filename'][$key] = $targetFilename[$fileTypesVal];
								}
								//$result['poster'] = $posterName;
								if (file_exists($source)) {
									// to delete the original uploaded file
									unlink($source);
								}
							} else {
								$result['path']='error';
								$result['errors'] = "Error uploaded $filename. Please try again.";
							}
						break;
					case 3:
						// an error occured
						$result['path']='error';
						$result['errors'] = "Error uploading $filename. Please try again.";
						break;
					default:
						// an error occured
						$result['path']='error';
						$result['errors'] = "System error uploading $filename. Contact webmaster.";
						break;
				}
			} else {
				//if uploaded file size more then specified size. 
				$result['path']='error';
				$result['errors'] = "file size is too large, should be less than ".MashupVideoMaxSize." mb";
			}
		} else if($formdata['error'] == 4) {
			// no file was selected for upload
			$result['path']='error';
			$result['errors'] = "No file Selected";
			
		} else {
			// unacceptable file type
			$result['path']='error';
			$result['errors'] = "$filename cannot be uploaded. Acceptable file types: 3gp, flv, mpg, mp4, mov, avi.";
		}
    return $result;
  }  
 
	/*
		THIS METHOD RUN AFTER OR BEFORE UPLOADING A FULL SIZE IMAGE THEN PASS THE UPLOADED IMAGE INFO TO THE METHOD AND IT WILL Resize Or Crop THE IMAGE ACCORDING TO THE WIDTH HEIGHT AND COORDINATES PASSED.
		GET 11 ARGUMENTS 
		1) The source path of the image.
		2) The destination path of the image.
		3) Full info of the image like their type, siz etc.
		4) Image name.
		5) Required width of the image.
		6) Required height of the image. If null then it will adjust the height according to their aspect ratio.
		7) Prefix name that automatically added before the image name when saved.
		8) Quality of the image. But only works for the jpeg images.
		9) Image X coordinate incase if you want to crop the image.
		10) Image Y coordinate incase if you want to crop the image.
		11) Whether you want to crop the image or not. Default will be false.    

	*/
	function ImageCrop($tmpname, $destinationPath, $image, $name, $width, $argHeight=NULL, $thumb=NULL, $jpeg_quality = 90,$imageX=0,$imageY=0,$imageCrop=false) {
		$new_width = $width;
		$info = $image['type'];
		$fname = $name;
		$newImageInfo = array();
		/* Check the image type(extension)
		 * And according to their type create new image of same type*/
		if($info=="image/jpeg" || $info=="image/pjpeg" || $info=="image/jpg")	
		$img = imagecreatefromjpeg($tmpname);
		else if($info=="image/png")
		$img = imagecreatefrompng($tmpname);
		if($info=="image/gif")
		$img = imagecreatefromgif($tmpname);
		$width = imagesx( $img );
		$height = imagesy( $img );
		
		$new_height = (!$argHeight==NULL && !$argHeight=='')?$argHeight:floor( $height * ( $new_width / $width ) );
		
		$tmp_img = imagecreatetruecolor( $new_width, $new_height );
		if($imageCrop) {
			imagecopyresampled($tmp_img, $img, 0, 0, $imageX, $imageY, $new_width, $new_height, $new_width, $new_height);	//resize the image
		}
		else {
			imagecopyresampled($tmp_img, $img, 0, 0, $imageX, $imageY, $new_width, $new_height, $width, $height );	//resize the image
		}
		$newImageInfo['height'] = $new_height;
		$newImageInfo['width'] = $new_width;
		$newImageInfo['type'] = $info;
		
		/* Save image according to their type */
		if($info=="image/jpeg" || $info=="image/pjpeg" || $info=="image/jpg") {	
			imagejpeg($tmp_img,$destinationPath.$thumb.$fname,90);
		}	
		else if($info=="image/png") {
			imagepng($tmp_img,$destinationPath.$thumb.$fname);
		}
		else if($info=="image/gif") {
			imagegif($tmp_img,$destinationPath.$thumb.$fname);
		}
		return $newImageInfo;
	}	////Image Crope Method End ///

	
}?>
