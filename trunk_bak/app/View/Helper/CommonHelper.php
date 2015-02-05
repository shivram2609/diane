<?php
/*
 * @class name : CommonHelper
 * @model used : NA
 * @version	   : 1.0
 * @created by : shivam sharma
 * @created on : 31st oct 2012
*/
class CommonHelper extends Helper {
	var $helpers = array("Html");
	/*
	 * @function name	: capital
	 * @purpose			: create first letter capital of a string
	 * @arguments		: string
	 * @return			: string after making first letter capital
	 * @created by		: shivam sharma
	 * @created on		: 31st oct 2012
	 * @description		: NA
	*/
	function capital($str = null){
		if(!empty($str)){
			$strArr		= explode(" ",trim($str));
			$strArr[0]	= ucfirst($strArr[0]);
			return implode(" ",$strArr);
		}
	}
	/* end of function */
	
	
	/*
	 * @function name	: removehtml
	 * @purpose			: to remove html tags from string and trim upto given length
	 * @arguments		: string,length
	 * @return			: string after removing html tags and trimming to given length 
	 * @created by		: shivam sharma
	 * @created on		: 5th Jan 2013
	 * @description		: NA
	*/
	function removehtml($str = null,$length = 200){
		if(!empty($str)){
			$str = strip_tags($str);
			$str = rtrim(ltrim(substr($str,0,$length)));
			return $str;
		}
	}
	/* end of function */
	
	
	function dateformat($date) {
		if ( !empty($date)) {
			return (date('m/d/Y H:i:s',strtotime($date)));
		} else {
			return (date('m/d/Y H:i:s'));
		}
	}
	
	public function ago($dt) {
		$dt = date_parse($dt);
		$now = date_parse(date("Y-m-d H:i:s"));
		$suffix = " left";
		$nowdate = strtotime($dt['year'].'-'.$dt['month'].'-'.$dt['day']);
		$enddate = strtotime($now['year'].'-'.$now['month'].'-'.$now['day']);
		$days = (($nowdate-$enddate)/(24*60*60));
		if ($now['year'] != $dt['year']) return $this->pluralize($dt['year'] - $now['year'], "year") . $suffix;
		if ($now['month'] != $dt['month'] && $days > 28 ) { return $this->pluralize($dt['month'] - $now['month'], "month") . $suffix; } elseif($days > 0) { return $this->pluralize($days, "day") . $suffix;
		}
		if ($now['day'] != $dt['day'] ) { return $this->pluralize($dt['day'] - $now['day'], "day") . $suffix; }
		if ($now['hour'] != $dt['hour']) return $this->pluralize($dt['hour'] - $now['hour'], "hour") . $suffix;
		if ($now['minute'] != $dt['minute']) return $this->pluralize($dt['minute'] - $now['minute'], "minute") . $suffix;
		if ($now['second'] != $dt['second']) return $this->pluralize($dt['second'] - $now['second'], "second") . $suffix;
			return "just now";
	}

	private function pluralize($count, $text)
	{
		return $count . (($count == 1) ? (" $text") : (" ${text}s"));
	}
	
	function makeurl($str = NULL) {
		if(!empty($str)) {
			$str = strtolower((str_replace("/",'-',str_replace(' ','-',substr(strip_tags(rtrim(ltrim($str))),0,80)))));
		}
		return $str;
	}
	
	function display($str = NULL) {
		echo "<pre>"; print_r(h($str)); echo "</pre>";
	}
	
	function getImageName($profileImg, $prefix){
		$imgArr = (explode('/',$profileImg));
		$imgname = $prefix.$imgArr[count($imgArr)-1];
		unset($imgArr[count($imgArr)-1]);
		array_push($imgArr, $imgname);
		return implode($imgArr, '/');
	}
	
	function removetags($string = NULL, $allowedtags = array("<p>","<h>","<img>","<li>","<ul>","<em>","<strong>","<ol>","<a>","<br>","<br/>","<i>","<b>")) {
		$string = strip_tags($string,implode(",",$allowedtags));
		return $string;
	}
	
	function getquestion($string) {
		$str = explode("_",$string);
		$notallowed = array(",","&","and");
		$answer = array();
		$returnstring = array();
		foreach($str as $key =>$val) {
			if(!empty($val) && !in_array($val,$notallowed)) {
				$val1 = "_".$val."_";
				$val2 = "_".$val.".";
				if(strstr($string,$val1)) {
					$answer[] = $val;
					$string = str_replace($val1," __ ",$string);
				}
				if(strstr($string,$val2)) {
					$answer[] = $val;
					$string = str_replace($val2," __ ",$string);
				}
			}
		}
		$returnstring ['string'] = $string;
		$returnstring ['answer'] = $answer;
		return $returnstring;
	}
	
	function otherDiffDate($end=NULL, $out_in_array=false){
        $intervalo = date_diff(date_create(), date_create($end));
        $out = $intervalo->format("%Y,%M,%d,%H,%i,%s");
        $a_out = explode(",",$out);
        if($a_out[count($a_out)-6] != '00') {
			echo ($a_out[count($a_out)-6]*1).(($a_out[count($a_out)-6]*1) == 1?" year ago":" years ago");
		} elseif($a_out[count($a_out)-5] != '00') {
			echo ($a_out[count($a_out)-5]*1).(($a_out[count($a_out)-5]*1) == 1?" month ago":" months ago");
		} elseif($a_out[count($a_out)-4] != '00') {
			echo ($a_out[count($a_out)-4]*1).(($a_out[count($a_out)-4]*1) == 1?" day ago":" days ago");
		} elseif($a_out[count($a_out)-3] != '00') {
			echo ($a_out[count($a_out)-3]*1).(($a_out[count($a_out)-3]*1) == 1?" hour ago":" hours ago");
		} elseif($a_out[count($a_out)-2] != '00') {
			echo ($a_out[count($a_out)-2]*1).(($a_out[count($a_out)-2]*1) == 1?" minute ago":" minutes ago");
		} elseif($a_out[count($a_out)-1] != '00') {
			echo ($a_out[count($a_out)-1]*1).(($a_out[count($a_out)-1]*1) == 1?" second ago":" seconds ago");
		}
    }
    
    function formatbytes($file, $type) {
	   switch($type){
		  case "KB":
			 $filesize = filesize($file) * .0009765625; // bytes to KB
		  break;
		  case "MB":
			 $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
		  break;
		  case "GB":
			 $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
		  break;
	   }
	   if($filesize <= 0){
		  return $filesize = 'unknown file size';}
	   else{return round($filesize, 2).' '.$type;}
	}
	
	function download($fullPath = NULL) {
		Configure::write('debug',0);
			// Must be fresh start
			if( headers_sent() ) {
				die('Headers Sent');
			}
			// Required for some browsers
			if(ini_get('zlib.output_compression')) {
				ini_set('zlib.output_compression', 'Off');
			}
			$fullPath = WWW_ROOT."files/pdf/".$fullPath; 
			// File Exists?
			if( file_exists($fullPath) ){
				// Parse Info / Get Extension
				$fsize = filesize($fullPath);
				$path_parts = pathinfo($fullPath);
				$ext = strtolower($path_parts["extension"]);
				// Determine Content Type
				switch ($ext) {
					case "pdf": $ctype="application/pdf"; break;
					case "exe": $ctype="application/octet-stream"; break;
					case "zip": $ctype="application/zip"; break;
					case "doc": $ctype="application/msword"; break;
					case "xls": $ctype="application/vnd.ms-excel"; break;
					case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
					case "gif": $ctype="image/gif"; break;
					case "png": $ctype="image/png"; break;
					case "jpeg":
					case "jpg": $ctype="image/jpg"; break;
					default: $ctype="application/force-download";
				}
				header("Pragma: public"); // required
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false); // required for certain browsers
				header("Content-Type: $ctype");
				header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".$fsize);
				ob_clean();
				flush();
				readfile( $fullPath );
			}
	}
	
	function video_info($url = NULL) {
	 
		// Handle Youtube
		if (strpos(strtolower($url), "youtube.com")) {
			$url = parse_url($url);
			$vid = parse_str($url['query'], $output);
			$video_id = $output['v'];
			$data['video_type'] = 'youtube';
			$data['video_id'] = $video_id;
			//try {
				$xml = simplexml_load_file("http://gdata.youtube.com/feeds/api/videos?q=$video_id");
				 
				foreach ($xml->entry as $entry) {
					// get nodes in media: namespace
					$media = $entry->children('http://search.yahoo.com/mrss/');
					// get video player URL
					$attrs = $media->group->player->attributes();
					$watch = $attrs['url'];
					// get video thumbnail
					$data['thumb_1'] = $media->group->thumbnail[0]->attributes(); // Thumbnail 1
					$data['thumb_2'] = $media->group->thumbnail[1]->attributes(); // Thumbnail 2
					$data['thumb_3'] = $media->group->thumbnail[2]->attributes(); // Thumbnail 3
					$data['thumb_large'] = $media->group->thumbnail[3]->attributes(); // Large thumbnail
					$data['tags'] = $media->group->keywords; // Video Tags
					$data['cat'] = $media->group->category; // Video category
					$attrs = $media->group->thumbnail[0]->attributes();
					$thumbnail = $attrs['url'];
					// get <yt:duration> node for video length
					$yt = $media->children('http://gdata.youtube.com/schemas/2007');
					$attrs = $yt->duration->attributes();
					$data['duration'] = $attrs['seconds'];
					// get <yt:stats> node for viewer statistics
					$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
					$attrs = $yt->statistics->attributes();
					$data['views'] = $viewCount = $attrs['viewCount'];
					$data['title']=$entry->title;
					$data['info']=$entry->content;
					// get <gd:rating> node for video ratings
					$gd = $entry->children('http://schemas.google.com/g/2005');
					if ($gd->rating) {
						$attrs = $gd->rating->attributes();
						$data['rating'] = $attrs['average'];
					} else {
						$data['rating'] = 0;
					}
				} // End foreach
			} // End Youtube
			 
			// Handle Vimeo
			else if (strpos(strtolower($url), "vimeo.com")) {
				$video_id=explode('vimeo.com/', $url);
				$video_id=$video_id[1];
				$data['video_type'] = 'vimeo';
				$data['video_id'] = $video_id;
				$xml = simplexml_load_file("http://vimeo.com/api/v2/video/$video_id.xml");
				foreach ($xml->video as $video) {
					$data['id']=$video->id;
					$data['title']=$video->title;
					$data['info']=$video->description;
					$data['url']=$video->url;
					$data['upload_date']=$video->upload_date;
					$data['mobile_url']=$video->mobile_url;
					$data['thumb_small']=$video->thumbnail_small;
					$data['thumb_medium']=$video->thumbnail_medium;
					$data['thumb_large']=$video->thumbnail_large;
					$data['user_name']=$video->user_name;
					$data['urer_url']=$video->urer_url;
					$data['user_thumb_small']=$video->user_portrait_small;
					$data['user_thumb_medium']=$video->user_portrait_medium;
					$data['user_thumb_large']=$video->user_portrait_large;
					$data['user_thumb_huge']=$video->user_portrait_huge;
					$data['likes']=$video->stats_number_of_likes;
					$data['views']=$video->stats_number_of_plays;
					$data['comments']=$video->stats_number_of_comments;
					$data['duration']=$video->duration;
					$data['width']=$video->width;
					$data['height']=$video->height;
					$data['tags']=$video->tags;
				} // End foreach
			} // End Vimeo
			 
			// Set false if invalid URL
			else { $data = false; }
		//} catch(Exception $e) {
		//}
		 
		return $data;
	 
	}
	
}
?>
