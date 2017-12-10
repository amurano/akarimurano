<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<title>プログラミングブログAM</title>
</head>
<body>
<h1>プログラミングブログAM</h1>

 <form action = "mission_2-6a.php" method = "post">
   名前: <input type = "text" name ="name"/>
   コメント: <input type = "text" name ="comment"/>
   パスワード: <input type = "password" name ="pass"/> <!--2-6aパスワード入力欄作成-->
   <input type = "submit" value ="送信"/><br/>
 </form>
 <form action = "mission_2-6a.php" method = "post">
   削除対象番号: <input type = "text" name ="delete"/>
   パスワード: <input type = "password" name="dpass"/><!--$passと$dpassが一緒だったら削除?-->
   <input type = "submit" value ="削除"/><br/> 
 </form>
 <form action = "mission_2-6b.php" method = "post">
   編集対象番号:<input type = "text" name ="edit"/>
   <input type = "submit" value ="編集"/><br/> 
 </form>
</body>
</html>

<?php
header('Content-Type: text/html; charset=UTF-8');
if(isset($_POST['name'])&&$_POST['name'] != ""){//空欄の場合は送信されないようにする
$name = $_POST['name'];
}
if(isset($_POST['comment'])&&$_POST['comment'] != ""){
$comment = $_POST['comment'];
}
if(isset($_POST['pass'])){//(2-6b)
$pass = $_POST['pass'];
}
if(isset($_POST['comment'])&&($_POST['name'])){
$time = date("Y/n/j G:i");//日時の取得
}
if(isset($_POST['edit'])){//(2-5b)
$edit = $_POST['edit'];
}
?>

<?php
 $filename = "out2-2.txt";
 $fp = fopen($filename,"a+");//ファイルを追記モードで開く
 $file = file($filename);//「aファイルの配列読み込み」はこれでできている（？）
 $count = count($file);//ファイルの行数をカウントし、$countに代入
 $newbango = explode("<>", $file[$count-1]);//$file[〇]と$countの数字ずれを直す
 $next = $newbango[0]+1;//このままだとゼロからスタートなので、1からスタートにする
 if("$comment" != ""&&"$name" != ""){
  $text = "{$next}<>{$name}<>{$comment}<>{$pass}<>{$time}";
  fwrite($fp,"$text"."\n");
 }

if(isset($_POST['delete'])){//削除送信→ループスタート
	$delete = $_POST['delete'];
	$dpass = $_POST['dpass'];
	for($k = 0; $k < count($file); ++$k){
		$deldata= explode("<>", $file[$k]);
		if($deldata[0] == $delete){//投稿番号一致
			if($deldata[3] == $dpass){//ﾊﾟｽﾜｰﾄﾞ一致したら、
				ftruncate($fp,0);
			}
		}
	}
	for($k = 0; $k < count($file); ++$k){//再度ループ
		$deldata= explode("<>", $file[$k]);
		if($deldata[0] != $delete){
			fwrite($fp, "$file[$k]");
		}
	}
}
fclose ($fp);//ファイルを閉じる

if(isset($_POST['comment2']) && isset($_POST['name2'])){
$time = date("Y/n/j G:i");//日時の取得
}
$epass = $_POST['epass'];
$pass2 = $_POST['pass2'];

$fp = fopen($filename,"a+");
if(isset($_POST['name2']) && isset($_POST['comment2'])){
	echo "ﾌｧｲﾙに表記されたﾊﾟｽは".$pass2."。新たに入力されたﾊﾟｽは".$epass."です。<br>";
	if($epass == $pass2){
		$name2 =$_POST['name2'];
		$comment2 =$_POST['comment2'];
		$number= $_POST['number'];
		ftruncate($fp,0);
		for($l = 0; $l < count($file); ++$l){
  		$editdata= explode("<>", $file[$l]);
  			if($editdata[0] != $number){
   			fwrite($fp, "$file[$l]");
			}elseif($editdata[0] == $number){
			fwrite($fp, "{$number}<>{$name2}<>{$comment2}<>{$pass2}<>{$time}"."\n");
  			}
		}
	} 
}
fclose ($fp);//ファイルを閉じる

$fp = fopen($filename,"a+");//ファイルを追記モードで開く
while($line = fgets($fp)){
	$arrays = explode("<>",$line);
	echo $arrays[0].$arrays[1].$arrays[2].$arrays[3].$arrays[4]."<br>";//ブラウザに表示
}
fclose($fp);
?>