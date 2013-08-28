<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<title>comp2html</title>
		<style type="text/css">
			#inputBtn{ border: gray solid 0.5em; padding: 10em; }
		</style>
	</head>
	<body>
		<h1>comp2html</h1>
		<hr>
	    <h2>画像選択：ダイアログ / ドラッグ&ドロップ</h2>
		<form id="uploadForm" name="form1" method="post" action="upload.php" enctype="multipart/form-data">
		    <input id="inputBtn" type="file" name="image_file[]" multiple="multiple" accept="image/*"/>
		    <p>　　　↓</p>　
		    <input class="submitBtn" type="submit" value="htmlへ変換" />
		</form>
		<br />
		<br />
		<hr>
	    <h2>画像管理</h2>
		<form type="checkbox" name="form2" action="delete.php" method="post">
			<?php
				$dir = './';
				$filelist = scandir($dir);
				foreach($filelist as $file){
					if( is_dir($file) && $file !== '.' && $file !== '..'){
						echo '<input type="checkbox" name="select[]" value='.$file.'>'.$file.' <a href="./'.$file.'/index.html" target="_blank">link</a><br />';
					}
				}
			?>
			<br />
			<input type="submit" value="選択項目を削除" />
		</form>
	</body>
</html>