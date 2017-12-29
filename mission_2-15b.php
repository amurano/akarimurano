<?php
//データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//SQLｺﾏﾝﾄﾞ「create table」で新規テーブルを作成する
$sql="CREATE TABLE printemps"
."("
."id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
."name char(32) NOT NULL,"
."comment TEXT NOT NULL,"
."password char(32) NOT NULL,"
."time TEXT NOT NULL"
.");";//式の中でｺﾒﾝﾄｱｳﾄは入れられない。
$stmt = $pdo->query($sql);
$stmt = $pdo->query('SET NAMES utf8');//文字化け対策用
?>

<?php
header('Content-Type: text/html; charset=UTF-8');
if(isset($_POST['edit'])){
	$edit =$_POST['edit'];
	$id = $edit;
	$sql = "SELECT * FROM printemps WHERE id='$id';";//「WHERE id='$id'」？
	$results = $pdo->query($sql);//実行・結果取得
	foreach($results as $row){
		$number = $row['id'];
		$name2 = $row['name'];
		$com2 = $row['comment'];
	}
}
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<title>プログラミングブログAM</title>
</head>
<body bgcolor="#faebd7">
<h1>編集画面</h1>

<form action = "mission_2-15a.php" method = "post">
名前: <input type = "text" name ="name2" value = "<?php echo $name2; ?>"/>
コメント: <input type = "text" name ="com2" value = "<?php echo $com2; ?>"/><br>
パスワード: <input type = "password" name ="epass" />
パスワードが違うと変更されません。<br>
<input type = "hidden" name ="number" value="<?php echo $number; ?>"/>
<input type = "submit" value ="編集完了"/>
</form>

</body>
</html>