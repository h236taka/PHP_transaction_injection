<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style_insert.css" type="text/css" media="all">
  <title>登録</title>
</head>
<body>
  <p class="logo1">Evendertok</p>
  <nav>
    <ul class="gnav-navi-1">
      <li><a href="#">TOP</a></li>
      <li><a href="#">参加者一覧</a></li>
      <li><a href="#">ABOUT</a></li>
    </ul>
  </nav>
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
    echo '<h1>通信エラーが発生しました</h1><br>';
    echo '<footer><p>(c)copy right</p><footer>';
    exit();
  }

  //ポストされたワンタイムチケットとセッション変数が一致したら、処理を行う
  if ( $ticket === $saveTicket ){
    //OK
  }
  else{
    echo '<h1>二重送信が行われました</h1><br>';
    echo '<div class="aTag"><a href="http://localhost/PBL_monday/register.php">画面を戻る</a></div>';
    echo '<footer><p>(c)copy right</p><footer>';
    exit();
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
    echo '<footer><p>(c)copy right</p><footer>';
    exit();
  }
  else{
    if ( is_uploaded_file($tempfile) ){
      if ( $_FILES['eventfile']['type'] === 'image/jpeg' || $_FILES['eventfile']['type'] === 'image/png' || $_FILES['eventfile']['type'] === 'image/jpg' ){
        //echo '画像がアップロードされました<br>';
        //echo "ファイルの種類は".$_FILES['eventfile']['type']."です。";
        $filepath = "image/".basename($_FILES['eventfile']['name']);
        echo '<br>';
      }
      else{
        echo "<h1>画像ファイルをアップロードしてください</h1><br>";
        echo '<div class="aTag"><a href="http://localhost/PBL_monday/register.php">画面を戻る</a></div>';
        echo '<footer><p>(c)copy right</p><footer>';
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
  <footer>
    <p>(c)copy right</p>
  </footer>
</body>
</html>
