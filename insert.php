<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style_insert.css">
  <title>登録</title>
</head>
<body>
  <?php

  session_start();
  //register.phpのticket変数を取得
  $ticket = isset($_POST['ticket']) ? $_POST['ticket'] : '';

  //セッション変数に保存されたワンタイムチケットを取得
  $saveTicket = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';

  //セッション変数を解放
  unset($_SESSION['ticket']);

  //ワンタイムチケットの中身が空、ポストされなかった場合、強制終了
  if ( $ticket === "" ){
    die('<h1>不正な操作が行われました</h1><br>');
  }

  //ポストされたワンタイムチケットとセッション変数が一致したら、処理を行う
  if ( $ticket === $saveTicket ){
    //OK
  }
  else{
    echo '<h1>二重送信が行われました</h1><br>';
    echo '<div class="aTag"><a href="http://localhost/PBL_monday/register.php">画面を戻る</a></div>';
    die();
  }

  //database information
  $username = 'root';
  $password = '';
  $dsn = 'mysql:dbname=pbl_monday;host=127.0.0.1';

  $id = 1;  //仮に設定
  $eventname = $_POST['eventname'];

  //about files
  $tempfile = $_FILES['eventfile']['tmp_name'];
  $filename = $_FILES['eventfile']['name'];

  $eventdate = $_POST['eventdate'];
  $eventplace = $_POST['eventplace'];
  $eventcontent = $_POST['eventcontent'];

  /*echo $eventname.'<br>';
  echo $eventdate.'<br>';
  echo $eventplace.'<br>';
  echo $eventcontent.'<br>';*/

  if ( $eventname == "" || $eventdate == "" || $eventplace == "" || $filename == "" ){
    echo "<h1>全ての項目を入力してください</h1><br>";
    echo '<div class="aTag"><a href="http://localhost/PBL_monday/register.php">画面を戻る</a></div>';
    exit();
  }
  else{
    if ( is_uploaded_file($tempfile) ){
      if ( $_FILES['eventfile']['type'] === 'image/jpeg' || $_FILES['eventfile']['type'] === 'image/png' || $_FILES['eventfile']['type'] === 'image/jpg' ){
        //echo '画像がアップロードされました<br>';
        //echo "ファイルの種類は".$_FILES['eventfile']['type']."です。";
<<<<<<< HEAD
        $filepath = 'image/'.$filename;
=======
        $filepath = "image/".basename($_FILES['eventfile']['name']);  
>>>>>>> 6a6932220f349c8442ccf954d70ca00c570d6d16
        echo '<br>';
      }
      else{
        echo "<h1>画像ファイルをアップロードしてください</h1><br>";
        echo '<div class="aTag"><a href="http://localhost/PBL_monday/register.php">画面を戻る</a></div>';
        exit();
      }

    }

    try {
      $pdo = new PDO($dsn,$username,$password);
      echo 'データベースに接続しました<br>';
    }
    catch(PDOException $err){
      exit($err->getMessage());
    }

  }

  try {
    echo 'データベースに登録中...<br>';
    $sql = 'INSERT INTO eventhome (id,name,image,event_date,place,content) VALUES(:id,:name,:image,:event_date,:place,:content)';
    $stmt = $pdo->prepare($sql);  //PreparedStatement

    //型指定を行いバインドする
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':name', $eventname);
    $stmt->bindValue(':image', $filepath);
    $stmt->bindValue(':event_date', $eventdate);
    $stmt->bindValue(':place', $eventplace);
    $stmt->bindValue(':content', $eventcontent);
    /*$stmt->bindValue(2, $id, PDO::PARAM_INT);
    $stmt->bindValue(3, $eventname, PDO::PARAM_STR);
    $stmt->bindValue(4, $filename, PDO::PARAM_STR);
    $stmt->bindValue(5, $eventdate, PDO::PARAM_STR);
    $stmt->bindValue(6, $eventplace, PDO::PARAM_STR);
    $stmt->bindValue(7, $eventcontent, PDO::PARAM_STR);*/

    //PDOのエラー時に例外発生を指定
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stmt->execute();
  }
  catch(PDOException $err){
    echo '<h1>データ登録に失敗しました</h1>';
    exit($err->getMessage());
  }

  echo '<h1>登録が完了しました</h1>';
  ?>
  <div class="aTag"><a href="http://localhost/PBL_monday/register.php">画面を戻る</a></div>
</body>
</html>
