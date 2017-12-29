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


<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<title>プログラミングブログAM</title>
</head>
<body bgcolor="#ffffe0">
<h1>プログラミングブログAM</h1>

 <form action = "mission_2-15a.php" method = "post">
   名前: <input type = "text" name ="name"/>
   コメント: <input type = "text" name ="comment"/>
   パスワード: <input type = "password" name ="pass"/> <!--2-6aパスワード入力欄作成-->
   <input type = "submit" value ="送信"/><br/>
 </form>
 <form action = "mission_2-15a.php" method = "post">
   削除対象番号: <input type = "text" name ="delete"/>
   パスワード: <input type = "password" name="dpass"/><!--$passと$dpassが一緒だったら削除?-->
   <input type = "submit" value ="削除"/><br/> 
 </form>
 <form action = "mission_2-15b.php" method = "post">
   編集対象番号:<input type = "text" name ="edit"/>
   <input type = "submit" value ="編集"/><br/> 
 <p>&nbsp;</p>
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
$time = date("Y-m-d H:i:s");//日時の取得
}
?>

<?php
if("$comment" != ""&&"$name" != ""){
	$sql = $pdo -> prepare("INSERT INTO printemps(name,comment,password,time)VALUES(:name,:comment,:password,:time);");
	//idはinsert不要
	$sql -> bindparam(':name',$name, PDO::PARAM_STR);//(上で与えたﾊﾟﾗﾒｰﾀ,それに入れる変数,「文字列」指定)
	$sql -> bindparam(':comment',$comment, PDO::PARAM_STR);
	$sql -> bindparam(':password',$pass, PDO::PARAM_STR);
	$sql -> bindparam(':time',$time, PDO::PARAM_STR);
	$sql -> execute();//これを書かないと上記実行されない。もしくはquery使用。
}

if(isset($_POST['delete'])&&($_POST['delete'] != "")){
	$delete = $_POST['delete'];
	$dpass = $_POST['dpass'];
	$id = $delete;
//まずDBのデータ取得。一行だけSELECTしてidとpass照合。
	$sql = "SELECT * FROM printemps WHERE id='$id';";//「WHERE id='$id'」？
	$results = $pdo -> query($sql);//実行・結果取得
	foreach($results as $row){
		if($row['password'] == $dpass){//passwordだけではNG
			$sql = "delete from printemps where id = '$id';";
			$result = $pdo->query($sql);
			
		}elseif(password != $dpass){
			echo "パスワードが違います。<br>";
		}
	}
}
//編集用
if(isset($_POST['com2']) && isset($_POST['name2'])){
	$time = date("Y-m-d H:i:s");//日時の取得
	$epass = $_POST['epass'];//2-15bで入力されたﾊﾟｽﾜｰﾄﾞ
	$id = $_POST['number'];//行番号

	$sql = "SELECT * FROM printemps WHERE id='$id';";//「WHERE id='$id'」？
	$results = $pdo -> query($sql);//実行・結果取得
	foreach($results as $row){
		if($row['password'] == $epass){//passwordだけではNG
			$nm = $_POST['name2'];
			$kome = $_POST['com2'];
			$sql= "update printemps set name='$nm',comment='$kome' where id = '$id';";
			$result = $pdo -> query($sql);
		}elseif($row['password'] != $epass){
			echo "パスワードが違います。<br>";
		}
	}
}

$sql = 'SELECT * FROM printemps;';
$results = $pdo -> query($sql);
foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['time'].'<br>';
}
?>