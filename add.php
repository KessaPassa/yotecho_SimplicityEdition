<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>予定合わせて調っ</title>

</head>
<body>
<form method="post" action="" style="display: inline">

<?php
echo '名前  <input name="name" type="text" style="width:100px"><br/><br/>';

echo "<select name='year'>";
    for ($i = 2016; $i <= 2020; $i++) {
    echo "<option>".$i;
        }
        echo "</select> 年　";

echo "<select name='month'>";
    for ($i = 1; $i <= 12; $i++) {
    echo "<option>".$i;
        }
        echo "</select> 月　";

echo "<select name='day'>";
    for ($i = 1; $i <= 31; $i++) {
    echo "<option>".$i;
        }
        echo "</select> 日　";


echo '<br/><br/>';

echo '参加・不参加<select name="judge">';
    echo '<option>○</option>';
    echo '<option>△</option>';
    echo '<option>×</option>';
echo '</select>';

echo '<br/><br/>';
echo '<input type="submit" value="送信"><br/>';

echo '<span>ㅤ</span>'; //空白文字を入れていい感じにボタンの間をあける
//echo '<input type="submit" onclick="location.href=\'select.php\'" value="戻る"><br/><br/>'; //1つ前のページ(index.php)に戻る


require_once 'common.php';
$dbh = new PDO($dsn, $username, $password); //MySQLに接続
$dbh->query('SET NAMES utf8');

$sql = 'SELECT * FROM `table` WHERE 1';
$stmt = $dbh->prepare($sql);
$stmt->execute();

//テーブル表記で一覧を表示する
print '<table border="1">';
while(1)
{
    $rec = $stmt->fetch(PDO::FETCH_ASSOC); //一行ずつレコードを取り出す
    if($rec == false) {
        break;
    }
    //予定一覧を表示
    echo '<tr><th>' . $rec['name'] .'</th>';
    echo '<th>' . $rec['year'].'年'. $rec['month'].'月'. $rec['day'].'日'. '</th>';
    echo '<th>' . $rec['judge'] . '</th></tr>';
}
print '</table>';

//MySQLにデータを挿入する
if(!empty($_POST['name'])){
    $name = $_POST['name'];
    $year= $_POST['year'];
    $month= $_POST['month'];
    $day= $_POST['day'];
    $judge= $_POST['judge'];

    $sql = "INSERT INTO `table`(`name`, `year`, `month`, `day`, `judge`) VALUES ('$name', '$year', '$month', '$day', '$judge')"; //名前と日にちと参加情報を登録する
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $_POST['name'] = null;
}

$dsh = null; //MySQLの接続を切る
?>
</form>
    <br/><br/>
    <input type="submit" onclick="location.href='index.html'" value="戻る"> <!--1つ前のページ(index.php)に戻る-->
</body>
</html>