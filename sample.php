<head>
  <meta charset="utf-8">
  <title>グローバルナビの練習</title>
  <meta name="description" content="グローバルナビゲーション作成の演習です">
  <link rel="stylesheet" href="css/sample.css">
  <style>
  *{box-sizing: border-box;}

  ul.gnav-navi-1{
    background: #c71585;
    padding: 0;
    text-align: center;
  }
  ul.gnav-navi-1 li{
    display: inline-block;
  }


  ul.gnav-navi-1 li a{
    display: block;
    padding: 1em;
    color: #fff;
    text-decoration: none;
  }
  ul.gnav-navi-1 a::first-line{
    font-size: 16px;
    font-weight: bold;
  }
  </style>
</head>


<nav>
  <ul class="gnav-navi-1">
    <li><a href="#">TOP<br>トップ</a></li>
    <li><a href="#">SERVICE<br>サービスについて</a></li>
    <li><a href="#">INFORMATION<br>お知らせ</a></li>
    <li><a href="#">BLOG<br>ブログ</a></li>
    <li><a href="#">CONTACT<br>お問合せ</a></li>
  </ul>
</nav>
