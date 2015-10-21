<?php
/*----------------------------------------------------------
 添付ファイル付きメールをmb_send_mail()関数で送信する
----------------------------------------------------------*/
// 宛て先アドレス
$mailTo      = 'user@test.com';
 
// メールのタイトル
$mailSubject = 'メールタイトルです';
 
// メール本文
$mailMessage = 'メール本文です';
 
// 添付するファイル
$dir = './path/';
$file = 'sample.jpg';
$fileName    = $dir.$file;
 
// 差出人のメールアドレス
$mailFrom    = 'user@test.com';
 
// Return-Pathに指定するメールアドレス
$returnMail  = 'user@test.com';
 
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
 $result = mb_send_mail($mailTo, $mailSubject, $body, $header,'-f' . $returnMail);
}
 
if($result){
       echo '<p>送信成功</p>';
}else{
       echo '<p>送信失敗</p>';
}
 
?>