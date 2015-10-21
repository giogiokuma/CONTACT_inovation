<?php header("Conatct-Type:text/html;charset=utf-8"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>群馬イノベーションアワード 2015</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800' rel='stylesheet' type='text/css'>
<style>
body {
    font-size:105%;
    font-family: 'Open Sans', sans-serif;
    color:#3d3536;
    background-color:#f9f9f9;
}

a {
    color: #99a478;
    text-decoration: none;
}

p {
    text-align:left;
    font-size:150%;
}
.error {
    color:red;
}
.back {
    float:right;
    font-size:150%;
}
.footer {
  font-size:120%;
  margin-top:10%;
  position: relative;
  bottom: 0;
  width: 100%;
  height: 30%;
  background: rgba(255, 255, 255, 0.95);
  z-index: 2;
}
.footer::after {
  clear: both;
  content: "";
  display: table;
}
li{
    list-style:none;
}

@media only screen and (min-width:320px) {
  .cd-container {
    padding-top: 20%;
  }
  .main-container {
    background: #f9f9f9;
    margin-bottom: 10px;
  }
  .main_A {
    width: 90%;
    margin: 0 5%;
    padding:5% 2%;
    border:1px solid #999;
    background:#fff;
  }
  .flexbox {
    width: 420px;
    display: -webkit-flex;
    display: flex;
    -webkit-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-justify-content: center;
    justify-content: center;
    margin-top: 5%;
  }
}
@media only screen and (min-width: 768px) {
  .cd-container {
    width: 800px;
    margin: 0 auto;
    padding-top: 10%;
  }
  .cd-container::after {
    content: '';
    display: table;
    clear: both;
  }
  .main_A {
    width: 90%;
    margin: 0 5%;
    padding:5% 2%;
    border:1px solid #999;
    background:#fff;
  }
  .main-container {
    margin: 0 10px 0 0;
    -webkit-flex: 2;
    flex: 2;
  }
}

</style>
</head>
<body>
<main class="cd-container">
<div class="main_A">
<?php

require "send_attached_mail.inc";

// Validate the "氏名"
if (!empty($_REQUEST['氏名'])) {
    $name = $_REQUEST['氏名'];
} else {
    $name = NULL;
    echo '<p class="error">「お名前」必須項目を記入してください。</p>';
}

//  Validate the "メールアドレス"
if (!empty($_REQUEST['メールアドレス'])) {
    $email = $_REQUEST['メールアドレス'];
    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
        echo '';
    } else {
        echo '<p class="error">正しいメールアドレスを記入してください。</p>';
        $email = NULL;
    }
} else {

    $email = NULL;
    echo '<p class="error">「E-mail」必須項目を記入してください。</p>';
    echo '';
}

if ( $name && $email ) {
    echo '<h2>' . $name . '様、</h2> 
    <p>お申込みを承りました。</p>
    <p>入場券を' . $name . '様のメールアドレス《' . $email . '》に送らせていただきました。</p>
    <p>当日入場口にて画面をご提示ください。<br /><br /></p>

　  <p>入場券はこちらからもダウンロード可能です。</p>
    <a href="img/ticket.gif" download="img/ticket.gif"><img src="img/ticket.gif"></a><br />
    <p>弊社からメールが届かない場合は、お手数ですがお問い合わせください。<br /><br />
    群馬イノベーションアワード2015<br />
    事務局　027-・・・-・・・・<br /><br /></p>';


$file[0] = "./img/ticket.gif";
// $file[1] = "/tmp/test.doc";
$body = $name . "様" . "\n" . PHP_EOL;
$body .= "この度は、群馬イノベーションアワード2015" . PHP_EOL;
$body .= "ファイナルステージ観覧お申込みを承りました。" . "\n" . PHP_EOL;
$body .= "\n" . PHP_EOL;
$body .= "入場券を" . $name . "様のメールアドレス《" . $email . "》に送らせていただきました。" . "\n" . PHP_EOL;
$body .= "当日入場口にて画面をご提示ください。" . "\n" . PHP_EOL;
$body .= "弊社からメールが届かない場合は、お手数ですがお問い合わせください。" . "\n" . PHP_EOL;
$body .= "【群馬イノベーションアワード2015】" . PHP_EOL;
$body .= "事務局　027-・・・-・・・・" . "\n" . PHP_EOL;
$body .= "Eメール：info@gi-award.com" . "\n" . PHP_EOL;

SendAttachedMail( $to , $email , "群馬イノベーションアワード2015" , $body , $file );

} else {
    echo '<p class="error">必須項目に記入もれがあります。確認してもう一度送信してください。</p>';
}

?>

 <br />
<span class="back">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javaScript:history.back();">&raquo;１つ前へ戻る</a></span>
<br /><br /> 
</div>
</main>
<!--footer section-->
<div class="footer">
<div class="container">
<div class="row">
<div class="col-xs-6 col-sm-3 sp">
  <h4>GIAとは</h4> 
  <div class="t1">「GunmaInnovationAward＝GIA」は、暮らしに変革をもたらすビジネスに挑戦する人材を発掘し、起業を支援したり、多くの人に知らせることで、家庭や学校や会社や地域にイノベーションの風を送り、新たな人材を輩出するプロジェクトです。3年目を迎え起業やイノベーションの大切さが認知され、具体的な動きが出ていることに手応えを感じています。幕末から昭和にかけ、資源のない日本を蚕糸絹業の技術革新によって近代国家に押し上げる原動力となった群馬。人口減少社会の日本の閉塞感を、再びここ群馬から打ち破るために、ここ群馬がイノベーターにとってチャンスにあふれた地であり続けるために、ことしも「ジャパニーズドリームを、群馬から」を合言葉に、このプロジェクトを推進します。
</div>
 
</div>
<div class="col-xs-6 col-sm-3 sp">
  <h4>リンク </h4> 
  <ul>
    <li><a href="http://www.gi-award.com/"><i class="fa fa-chain"></i>&nbsp;&nbsp;GIA ウェブサイト</a></li>
    <li><a href=""><i class="fa fa-chain"></i>&nbsp;&nbsp;ファイナルステージ観覧申し込みフォーム</a></li>
  </ul>
</div>
<div class="clearfix visible-xs"></div>
<div class="col-xs-6 col-sm-3 sp">
<h4>Other Info </h4>  
<ul>
<li><a href="https://www.facebook.com/GunmaInovationAward"><i class="fa fa-chain"></i>&nbsp;&nbsp;Facebook</a></li>
<li><a href="https://twitter.com/gunmainnovation"><i class="fa fa-chain"></i>&nbsp;&nbsp;Twitter</a></a></li>
</ul>
<br />
</div>
<div class="col-xs-6 col-sm-3 sp">
<h4>GIA お問い合わせは</h4>
<ul>
<li>Eメール：<a href="mailto:info@gi-award.com">info@gi-award.com</a></li>
</ul>
</div><!--row-->
<div class="row">   
<div class="col col-xs-12 col-sm-12 text-center">


<div class="copyright">
<br /><br /><br />
掲載の記事・写真などの無断転載を禁じます。<br>
Copyright &#169; <script type="text/javascript">var md=new Date(); var yr = md.getFullYear();document.write(yr);</script> Jomo Shimbun, Inc. All rights reserved.<br /><br /><br />
</div>
</div><!--col-sm-12-->
</div><!--row-->

</div><!--container-->
</div><!--footer-->