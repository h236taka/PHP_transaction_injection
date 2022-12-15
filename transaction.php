<?php
//$host = 'localhost';
$username = 'root';
$password = '';
$dsn = 'mysql:dbname=logindb;host=127.0.0.1';
//$dbname = 'logindb';

// データベース接続
try {
  $pdo = new PDO($dsn, $username, $password);
  echo 'データベースに接続しました。<br><br>';
}
catch (PDOException $err) {
  exit($err->getMessage());
}

try {
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo '---トランザクション開始---<br>';
  $pdo->beginTransaction();

  $pdo->exec('INSERT INTO transaction(name, age) VALUES("高井", 20)');
  $pdo->exec('INSERT INTO transaction(name, age) VALUES("鈴村", 23)');
  $pdo->exec('INSERT INTO transaction(name, age) VALUES("斎藤", 30)');
  $pdo->commit();

}
catch (Exception $err) {
  $pdo->rollBack();

  echo 'ロールバック処理実行<br>';
  echo '保存に失敗しました。<br>';
  echo 'エラー：'. $err->getMessage() . '<br>';

}
finally {
  echo '---トランザクション終了---';
}

?>
