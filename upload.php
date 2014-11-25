<?php
	if(isset($_POST)){
		//ディレクトリ作成
		//$date = date("YmdHi");
		$date = htmlspecialchars($_POST['folder_name']);
		if(!is_dir("./".$date)){
			mkdir("./".$date);
			chmod("./".$date, 0777);
			mkdir("./".$date."/html");
			chmod("./".$date."/html", 0777);
			mkdir("./".$date."/images");
			chmod("./".$date."/images", 0777);
		}

		$pageVal = 0;
		$extension = 0;

		//アップが確認されたらスライド生成
		if(isset($_FILES["image_file"])){
			$data = getReformFilesData();

			$i=0;
			foreach ($data as $v) {
				$i++;
				$ext = end(explode('.', $v["name"]));
				$filename = num2str($i).".".$ext;
				$filepath = './'.$date.'/images/'.$filename;
		
				$result = @move_uploaded_file( $v["tmp_name"], $filepath);
			}
			
			$pageVal = count($data);
			$extension = $ext;
		}
		
		//ポータルを作成
		generatePortal($date, $pageVal);
		
		//スライドを生成
		generateSlide($date, $pageVal, $extension);

		//スライド一式をzip圧縮
		$zipfile =  "./".$date."/".$date.".zip";
		zipComp("./".$date."/", $zipfile);

		//生成したポータルへリダイレクト
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ./".$date."/index.html");
	}

	//ポータル生成用関数
	function generatePortal($date, $slidetotal){
		$portal = file_get_contents("./template_portal.php");
		$portal = str_replace("<%PORTALTITLE>", $date, $portal);

		$linkArray = array();
		for($i=1;$i<=$slidetotal;$i++){
			array_push($linkArray, '<a href="./html/'.num2str($i).'.html" target="_blank">0'.$i.'</a>');
		}

		$portal = str_replace("<%SLIDELINK>", join(" ", $linkArray), $portal);
		$handle2 = fopen('./'.$date.'/index.html', "w");

		fwrite($handle2, $portal);
		fclose($handle2);
	}

	//スライド生成用関数
	function generateSlide($date, $pagemax, $ext){
		for($i=1;$i<=$pagemax;$i++){
			$contents = file_get_contents("./template_slide.php");
			$filepath = './'.$date.'/images/'.$filename;
			$htmlpath = './'.$date.'/html/';

			$contents = str_replace("<%PAGETITLE>", num2str($i), $contents);
			//$contents = str_replace("<%PAGECURRENT>", $page, $contents);
			$contents = str_replace("<%PAGECONTENTS>", '../images/'.num2str($i).".".$ext, $contents);
			$contents = str_replace("<%PAGEMAX>", num2str($pagemax), $contents);
			if(($i-1) == 0){
				$contents = str_replace("<%PAGEPREV>", num2str($pagemax), $contents);
			}else{
				$contents = str_replace("<%PAGEPREV>", num2str($i-1), $contents);
			}
			if(($i+1) > $pagemax){
				$contents = str_replace("<%PAGENEXT>", "01", $contents);
			}else{
				$contents = str_replace("<%PAGENEXT>", num2str($i+1), $contents);
			}
			$handle = fopen($htmlpath.num2str($i).".html", "w");
			fwrite($handle, $contents);
			fclose($handle);
		}
	}

	//情報整理用関数
	function getReformFilesData(){
		if(isset($_FILES["image_file"])){
			$t=array();
			$i=0;
			foreach ($_FILES["image_file"] as $key=>$list) {
				foreach ($list as $no => $v) {
					$t[$no][$key]=$v;
				}
			}
			return $t;
		}else{
			return array();
		}
	}

	//zip圧縮関数
	function zipComp($source, $destination){
		if (extension_loaded('zip') === true){
			if (file_exists($source) === true){
				$zip = new ZipArchive();
				if ($zip->open($destination, ZIPARCHIVE::CREATE) === true){
					$source = realpath($source);
					if (is_dir($source) === true){
						$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
	
						foreach ($files as $file){
							$file = realpath($file);
							if (is_dir($file) === true)
								$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
							else if (is_file($file) === true)
								$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
						}
					}
					else if (is_file($source) === true){
							$zip->addFromString(basename($source), file_get_contents($source));
					}
				}
				return $zip->close();
			}
		}
		return false;
	}

	function num2str($number){
		$str = "";
		if($number < 10){
			$str = "0".$number;
		}else{
			$str = (string)$number;
		}

		return $str;
	}
?>