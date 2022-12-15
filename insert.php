<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>登録</title>
</head>
<body>
  <?php
  //database information
  $username = 'root';
  $password = '';
  $dsn = 'mysql:dbname=pbl_monday;host=127.0.0.1';

  $id = 1;  //仮に設定
  $eventname = $_POST['eventname'];

  //about files
  //$tempfile = $_FILES['eventfile']['tmp_name'];
  //$filename = $_FILES['eventfile']['name'];

  $filename = 'file'; //仮に設定

  $eventdate = $_POST['eventdate'];
  $eventplace = $_POST['eventplace'];
  $eventcontent = $_POST['eventcontent'];

  echo $eventname.'<br>';
  echo $eventdate.'<br>';
  echo $eventplace.'<br>';
  echo $eventcontent.'<br>';

  if ( $eventname == "" || $eventdate == "" || $eventplace == "" || $eventcontent == "" || $filename == "" ){
    echo "全ての項目を入力してください";
    exit();
  }
  else{
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
    $stmt->bindValue(':image', $filename);
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
    exit($err->getMessage());
  }

  echo '<p>登録が完了しました</p>';
  ?>
  <a href="http://localhost/PBL_monday/register.php">画面を戻る</a>
</body>
</html>
