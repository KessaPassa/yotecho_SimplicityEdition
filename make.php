<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>予定合わせて調っ</title>
   <form method="post" action="" style="display: inline">
   <br/>
   イベント名  <input name="eventName" type="text" style="width:200px"><br/><br/>
   パスワード <input name="password" type="text" style="width:200px"><br/><br/>

   <input type="submit" value="確定">
   </form>

    <span>ㅤ</span> <!--空白文字を入れていい感じにボタンの間をあける-->
    <input type="submit" onclick="location.href='index.html'" value="戻る"><br/><br/> <!--1つ前のページ(index.php)に戻る-->

</head>
</html>

<?php
//なにも入力していなければはじく
if(!empty($_POST['eventName']) && !empty($_POST['password'])){
    //パスワードに全角が紛れていないかチェック
    if(preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])){
        $_POST['isJudge'] = 1; //半角英数字のみなのでOK

        //ここからMySQLに接続
        require_once 'common.php';
        $dbh = new PDO($dsn, $username, $password); //MySQLに接続
        $dbh->query('SET NAMES utf8');

        $event = $_POST['eventName']; //クォーテーションがややこしいので格納
        $pass = $_POST['password']; //クォーテーションがややこしいので格納
        $sql = "INSERT INTO `list`(`eventName`, `password`) VALUES ('$event', '$pass')"; //イベント名とパスワードを登録する
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $dsh = null; //MySQLの接続を切る
    }
    else {
        $_POST['isJudge'] = -1; //全角が紛れているのでダメ
    }
}
else{
    $_POST['isJudge'] = 0; //入力されていないまたはその他のエラー
}

/*function disp(){
    $_SESSION[$_POST['title']] = $_POST['password'];
    error_log('だめだめ');
}*/
?>

<!--PHPからJavaScriptに変数を渡すため、jeson_encode()でjsonに変換して値渡しをしている-->
<script>
    var isJudge = <?php echo json_encode($_POST['isJudge'])?>; //フラグを取得

    //フラグがtrueならhtmlのinputで入力した情報を取得
    if (isJudge == 1) {
        var title = <?php echo json_encode($_POST['eventName'])?>;
        var password = <?php echo json_encode($_POST['password'])?>;
        alert('イベント名: ' + title + '\nパスワード: ' + password + '\nこの内容で予定表を作りました'); //alert表示

        //あきらめ
        /*if(confirm('イベント名: ' + title + '\nパスワード: ' + password + '\n\nこの内容で予定表を作りますか？') == true){
            alert('予定表をつくりました<?php //disp(); ?>');
            console.log('hogehoge');
        }
        else{
            alert('キャンセルしました');
        }*/
    }
    else if(isJudge == -1){
        alert('パスワードは半角英数字のみ使用可能です');
    }
    else{
        alert('イベント名またはパスワードを入力してください');
    }
</script>
