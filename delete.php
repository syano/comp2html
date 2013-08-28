<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<title>comp2html deleted</title>
		<script type="text/javascript" src="/comp2html/jquery-2.0.3.min.js"></script>
	</head>
	<body>
		<h1>comp2html</h1>
		<hr>
	    <h2>選択項目を削除</h2>
		<?php
			if($_POST['select']) {
				echo '<p>選択した下記項目を削除しました。</p>';
				echo '<ul>';
				foreach($_POST['select'] as $v){
					echo '<li>'.$v.'</li>';

					$deletedir = './'.$v;
					remove_directory($deletedir);
				}
				echo '</ul>';
			}

			function remove_directory($dir) {
			  if ($handle = opendir("$dir")) {
			   while (false !== ($item = readdir($handle))) {
			     if ($item != "." && $item != "..") {
			       if (is_dir("$dir/$item")) {
			         remove_directory("$dir/$item");
			       } else {
			         unlink("$dir/$item");
			         echo " removing $dir/$item<br>\n";
			       }
			     }
			   }
			   closedir($handle);
			   rmdir($dir);
			   echo "removing $dir<br>\n";
			  }
			}
		?>
		<br />
		<hr>
		<a href="./">back</a>    
	</body>
</html>