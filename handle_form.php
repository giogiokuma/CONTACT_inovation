<?php header("Conatct-Type:text/html;charset=utf-8"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>群馬イノベーションアワード 2015</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800' rel='stylesheet' type='text/css'>
<style>
body {
  font-family: 'Open Sans', sans-serif;
  background-color:#f8f8f8;
  font-size:100%;
}
  .errorT1 {
    margin-left:100px;
    margin-top: 100px;
    margin-bottom: 20px;
    padding-top: 50px;
    padding-left: 50px;
    padding-right: 50px;
    padding-bottom: 60px;
    line-height: 150%;
    border:1px solid #999;
    text-align: left;
    width:70%;
    color:#ff0000;
    font-weight:bold;
    background-color:#fff;
  }

  .error {
    color:#ff0000;
  }

  .back {
    color:#333399;
    font-size:100%;
    text-align: right;
    padding-right:20px;
    padding-bottom: 30px;
    float:right;
  }

  .back a:link, a:visited {
    color:#333399;
    text-decoration: none;
    font-size:100%;
    text-align: right;
    padding-right: 20px;
    padding-bottom: 30px;
  }

  .back a:hover{
    text-decoration: underline;
    color:#70abf9;
  }
</style>
</head>
<body>
<main class="cd-container">

<?php // フォーム 
if (!empty($_REQUEST['氏名'])) {
    $name = $_REQUEST['氏名'];
} else {
    $name = NULL;
    echo '<p class="error">「お名前」必須項目を記入してください。</p>';
}

// Validate the 「メールアドレス」
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
     echo '<div class="back"><a href="javascript:history.back();" class="btn btn-primary" role="button">戻る</a> </div>';
}

if ($name && $email) {
    echo '<p class="T2"><strong>' . $name . '</strong>様、<br />
    お申込みを承りました。<br />
    入場券を' . $name . '様のメールアドレス《' . $email . '》に送らせていただきました。<br />
    当日入場口にて画面をご提示ください。<br /><br />

　  入場券はこちらからもダウンロード可能です。<br />
    <a href="img/finalStage.png" download="img/finalStage.png"><img src="img/finalStage.png"></a>
    弊社からメールが届かない場合は、お手数ですがお問い合わせください。<br /><br />
    群馬イノベーションアワード2015
    事務局　027-・・・-・・・・';

ini_set("mbstring.internal_encoding", "UTF-8");

// タイトル
$subject = "群馬イノベーションアワード2015";

// 差出人メールアドレス
$myMail = "ohata@raijin.com";

// 差出人名 internal_encodingからmbstring.languageで設定した文字コードへ変換
$myName = mb_encode_mimeheader("群馬イノベーションアワード事務局");

$body2 = "\n" . "\n" . PHP_EOL;
$body2 .= $name . "様" . "\n" . PHP_EOL;
$body2 .= "この度は申し込みをいただきまして, 誠にありがとうございます。" . "\n" . PHP_EOL;
$body2 .= $myCompanyName . "<" . $myMail . ">" . "\n" . PHP_EOL;


$head .="MIME-Version: 1.0" . "\n";
$head .="Content-Type: text/plain; charset=ISO-2022-JP" . "\n";
$head .= "Content-Transfer-Encoding: 7bit" . "\n";

$head = "From: " . $myName . "<" . $myMail . ">" . "\r\n";

if (mb_send_mail($email, $subject, $body2, $head)){
    echo "";
} else {
    echo "自動送信メール失敗しました";
}
} else {
    echo '<p class="error">必須項目に記入もれがあります。確認してもう一度送信してください。</p>';
  ;
}

 ?>

<br />
<span class="back">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javaScript:history.back();">&raquo;１つ前へ戻る</a></span>
<br /><br /> 

</main>


    
</body>
</html>