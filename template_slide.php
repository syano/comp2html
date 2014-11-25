<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<title><%PAGETITLE></title>
		<style type="text/css">
			html, body{	margin: 0; padding: 0; /*height: 100%;*/ }
			img{ display: block; margin: 0 auto; position: relative; z-index: 1; }
			a{ display: block; text-indent: -999em; overflow: hidden; background-repeat: no-repeat; text-align: left; direction: ltr; position: fixed; width: 40%; height: 100%; z-index: 2; }
			a.prev{ left: 0; }
			a.next{ right: 0; }
		</style>
		<script type="text/javascript" src="../../jquery-2.0.3.min.js"></script>
		<script type="text/javascript">
			document.onkeydown = pageMove;
			
			function pageMove(){
				switch(event.keyCode){
					case 37:
						location.href = "./<%PAGEPREV>.html";
						break;
						
					case 39:
						location.href = "./<%PAGENEXT>.html";
						break;
				}
			}
		</script>
	</head>
	<body>
		<div id="comp">
			<a class="prev" href="./<%PAGEPREV>.html"><</a>
			<a class="next" href="./<%PAGENEXT>.html">></a>
			<img src="<%PAGECONTENTS>" alt="画像" />
		</div>
	</body>
</html>