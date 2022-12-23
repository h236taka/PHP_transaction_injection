<!DOCTYPE html>
<?php
session_start();
//ワンタイムチケット(uniqid:一意なIDを生成, md5:文字列のmd5ハッシュ値を計算する)
$ticket = md5(uniqid(rand(), true));

$_SESSION['ticket'] = $ticket;
 ?>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link href="style_register.css" rel="stylesheet" type="text/css" media="all">
    <title>イベント登録</title>
    <script src="register.js" charset="utf-8"></script>
  </head>
  <body>
    <p class="logo">Evendertok</p>
    <div class="divBox">
      <form action="http://localhost/PBL_monday/insert.php" enctype="multipart/form-data" method="post">
        <p><input type="text" class="inputText" placeholder="イベント名" onfocus="clickBox(this)" onblur="notClick(this)" name="eventname" required></p>
        <p><input type="text" class="inputText" placeholder="開催日" onfocus="clickBox(this)" onblur="notClick(this)" name="eventdate" required></p>
        <p><input type="text" class="inputText" placeholder="開催場所" onfocus="clickBox(this)" onblur="notClick(this)" name="eventplace" required></p>
        <p><textarea class="inputText" placeholder="内容" onfocus="clickBox(this)" onblur="notClick(this)" name="eventcontent"></textarea></p>
        <div id="input-group">
          <input type="file" name="eventfile" id="01" name="01"><label for="01" id="input-label">ファイルを選択してください</label>
        </div>
        <p></p>
        <p><input type="submit" class="register" value="開催を予約する"></p>
        <input type="hidden" name="ticket" value="<?=$ticket?>">
      </form>
    </div>
    <!--jqueryを使用-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.8.0.min.js"></script>
    <script type="text/javascript">
    $(function(){
      $("input[type='file']").on('change',function(){
        var file = $(this).prop('files')[0];
        if(!($(".filename").length)){
          $("#input-group").append('<span class="filename"></span>');
        }
        $("#input-label").addClass('changed');
        $(".filename").html(file.name);
      });
    });
    </script>

  </body>
</html>
