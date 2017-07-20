<?php
use	Phalcon\Mvc\User\Plugin;
class Util extends Plugin{

    /**
	 *
	 * 生成logid
	 */
    public static function genLogId()
	{

		$code = microtime ( true ) . '#' . rand ( 0, 9999 );
		$ret = md5 ( $code );
		$high = hexdec ( substr ( $ret, 0, 16 ) );
		$low = hexdec ( substr ( $ret, 16 ) );
		$ret = (($high ^ $low) & 0xFFFFFF) * 100;
		$ret %= 10000000000;
		if ($ret < 10000000000)
		{
			$ret += 10000000000;
		}
		return $ret;
	}


	/**
	 * 获取请求的时间戳
	 * @return unknown
	 */
	public static function getTime(){
		return $_SERVER["REQUEST_TIME"];
	}

	public static function upload_file($file,$id){
	    //echo $_FILES[$file]["type"];
	    //echo $_FILES[$file]["size"];
		if ((($_FILES[$file]["type"] == "image/gif")
					|| ($_FILES[$file]["type"] == "image/jpeg")
		    || ($_FILES[$file]["type"] == "image/jpg")
		    || ($_FILES[$file]["type"] == "image/png")
					|| ($_FILES[$file]["type"] == "image/pjpeg"))
				&& ($_FILES[$file]["size"] < 200000))
		{
			if ($_FILES[$file]["error"] > 0)
			{
				echo "Return Code: " . $_FILES[$file]["error"] . "<br />";
				return false;
			}
			else
			{
				echo "Upload: " . $_FILES[$file]["name"] . "<br />";
				echo "Type: " . $_FILES[$file]["type"] . "<br />";
				echo "Size: " . ($_FILES[$file]["size"] / 1024) . " Kb<br />";
				echo "Temp file: " . $_FILES[$file]["tmp_name"] . "<br />";

				if (file_exists("upload/" . $id))
				{
					echo $_FILES[$file]["name"] . " already exists. ";
					return "upload/" . $id;
				}
				else
				{
					move_uploaded_file($_FILES[$file]["tmp_name"],
							"upload/" . $id);
					echo "Stored in: " . "upload/" . $_FILES[$file]["name"];
					return "upload/" . $id;
				}
			}
		}
		else
		{
		    //echo "no icon";
			return "NULL";
		}

	}

	public static function getHistoryCookieTime($cookBegin,$cookEnd,&$began,&$end){
		if(isset($_COOKIE[$cookBegin]))
		{
			$began = $_COOKIE[$cookBegin];
		}else{
			$began = date("Y-m-d",strtotime("-1 day"));
		}
		if(isset($_COOKIE[$cookEnd]))
		{
			$end = $_COOKIE[$cookEnd];
		}else{
			$end = date("Y-m-d",strtotime("-1 day"));
		}
		return true;
	}

	public static function getCookieTime($cookBegin,$cookEnd,&$began,&$end){
		if(isset($_COOKIE[$cookBegin]))
		{
			$began = $_COOKIE[$cookBegin];
		}else{
			$began = date("Y-m-d");
		}
		if(isset($_COOKIE[$cookEnd]))
		{
			$end = $_COOKIE[$cookEnd];
		}else{
			$end = date("Y-m-d");
		}
		return true;
	}

}
