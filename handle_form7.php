<?php header("Conatct-Type:text/html;charset=utf-8"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>群馬イノベーションアワード 2015</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800' rel='stylesheet' type='text/css'>

<?php

// Validate the "氏名"
if (!empty($_REQUEST['氏名'])) {
    $name = $_REQUEST['氏名'];
} else {
    $name = NULL;
    echo '<p class="error">「お名前」必須項目を記入してください。</p>';
}

// Validate the "メールアドレス"
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
if ( $name && $email) {
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

// 添付メール設定
// メール本文
$mailTo      = 'user@test.com';
 
// メールのタイトル
$mailSubject = 'メールタイトルです';
 
// メール本文
$mailMessage = 'メール本文です';
 
// 添付するファイル
$dir = './img/';
$file = 'ticket.gif';
$fileName    = $dir.$file;
 
// 差出人のメールアドレス
$mailFrom    = 'ohata@raijin.com';
 
// Return-Pathに指定するメールアドレス
$returnMail  = 'ohata@raijin.com';
 
// メールで日本語使用するための設定をします。
mb_language("Ja") ;
mb_internal_encoding("UTF-8");
 
$header  = "From: $mailFrom\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"__PHPRECIPE__\"\r\n";
$header .= "\r\n";
 
$body  = "--__PHPRECIPE__\r\n";
$body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\r\n";
$body .= "\r\n";
$body .= $mailMessage . "\r\n";
$body .= "--__PHPRECIPE__\r\n";
 
// 添付ファイルへの処理をします。
$handle = fopen($fileName, 'r');
$attachFile = fread($handle, filesize($fileName));
fclose($handle);
$attachEncode = base64_encode($attachFile);
 
$body .= "Content-Type: image/jpeg; name=\"$file\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"$file\"\r\n";
$body .= "\r\n";
$body .= chunk_split($attachEncode) . "\r\n";
$body .= "--__PHPRECIPE__--\r\n";
 
// メールの送信と結果の判定をします。セーフモードがOnの場合は第5引数が使えません。
if (ini_get('safe_mode')) {
 $result = mb_send_mail($mailTo, $mailSubject, $body, $header);
} else {
 echo "";
}
// 添付メール終了


} else {
    echo '<p class="error">必須項目に記入もれがあります。確認してもう一度送信してください。</p>';
}

?>

 <br />
<span class="back">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javaScript:history.back();">&raquo;１つ前へ戻る</a></span>
<br /><br /> 

</main>


    
</body>
</html>