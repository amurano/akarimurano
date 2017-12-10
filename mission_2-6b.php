<?php
header('Content-Type: text/html; charset=UTF-8');
if(isset($_POST['edit'])){
$edit =$_POST['edit'];
}
?>
<?php
$filename = "out2-2.txt";
$file = file($filename);//「aファイルの配列読み込み」はこれでできている（？）
$fp = fopen($filename,"a+");//ファイルを追記モードで開く
while($line = fgets($fp)){
	$arrays = explode("<>",$line);
	if($edit == $arrays[0]){
		$number =$arrays[0];
		$name2 = $arrays[1];
		$comment2 = $arrays[2];
		$pass2 = $arrays[3];//編集用ﾊﾟｽﾜｰﾄﾞ
	}
}
fclose($fp);
echo $pass2;
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<title>プログラミングブログAM</title>
</head>
<body>
<h1>編集画面</h1>

<form action = "mission_2-6a.php" method = "post">
名前: <input type = "text" name ="name2" value = "<?php echo $name2; ?>"/>
コメント: <input type = "text" name ="comment2" value = "<?php echo $comment2; ?>"/><br>
パスワード: <input type = "password" name ="epass" />
パスワードが違うと変更されません。<br>
<input type = "hidden" name ="pass2" value="<?php echo $pass2; ?>"/>
<input type = "hidden" name ="number" value="<?php echo $number; ?>"/>
<input type = "submit" value ="編集完了"/>
</form>

</body>
</html>