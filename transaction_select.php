<?php
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

//$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//prepareメソッドでSQLをセット
$stmt = $pdo->query("select * from transaction");

//executeでクエリを実行

while ($row = $stmt->fetch()) {
  $id = htmlspecialchars($row['ID']);
  $name = htmlspecialchars($row['name']);
  $age = htmlspecialchars($row['age']);
  echo "<tr><td>$id</td>";
  echo "<td>$name さん</td>";
  echo "<td>$age 歳</td></tr>";
  echo "<br>";
}

?>
