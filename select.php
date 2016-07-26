<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>予定合わせて調っ</title>
    
</head>
<body>
<form method="post" action="" style="display: inline">
<?php
//ここからMySQLに接続
require_once 'common.php';
$dbh = new PDO($dsn, $username, $password); //MySQLに接続
$dbh->query('SET NAMES utf8');
$sql = 'SELECT * FROM list WHERE 1';
$stmt = $dbh->prepare($sql);
$stmt->execute();

echo '<br/>';
echo 'イベント名 <select name="eventName" style="width:200px">'; //selectで一覧表示させる
while(1){
    $rec = $stmt->fetch(PDO::FETCH_ASSOC); //一行ずつレコードを取り出す
    //レコードを最後まで取り出したら最後はfalseが入るため
    if($rec == false)
        break;

    $eventName = $rec['eventName']; //イベント名だけ取り出す
    echo '<option>' . $eventName; //取り出したイベント名を一覧に挿入
}
$dsh = null; //MySQLの接続を切る
echo '</select><br/><br/>';

echo 'パスワード <input type="password" name="password" style="width:200px"><br/><br/>';
$_POST['hoge'] = 5;

//なにも入力していなければはじく
if(!empty($_POST['password'])){
    $dbh->query('SET NAMES utf8');
    $sql = 'SELECT * FROM list WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while(1){
        $rec = $stmt->fetch(PDO::FETCH_ASSOC); //一行ずつレコードを取り出す
        //レコードを最後まで取り出したら最後はfalseが入るため
        if($rec == false) {
            $_POST['error'] = 'パスワードが違います';
            break;
        }
        else if($rec['eventName'] === $_POST['eventName']) {
            if ($rec['password'] === $_POST['password']) {
                header('location: add.php'); //予定表に飛ぶ
            }
        }
    }
}
?>



<br/><br/>

    <input type="submit" value="入る">
</form>



    <span>ㅤ</span> <!--空白文字を入れていい感じにボタンの間をあける-->
    <input type="submit" onclick="location.href='index.html'" value="戻る"><br/><br/> <!--1つ前のページ(index.php)に戻る-->

</body>
</html>
<script>
    try{
        var error = <?php echo json_encode($_POST['error'])?>;
        alert(error);
    }
    catch(e){

    }
</script>