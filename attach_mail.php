
<?php  

require "attach_mail.inc.php";

////////// 言語と文字コードの設定 //////////////////////////////
mb_language('ja');             // 必要に応じて使用言語を設定
mb_internal_encoding('SJIS');  // 必要に応じて内部コード系を設定
////////////////////////////////////////////////////////////////

$from_name = "送信元";
$from_addr = mb_encode_mimeheader($from_name);
$from_addr .= " <misa@ohatadesign.com>";

$to_name = "送信先";
$to_addr = mb_encode_mimeheader($to_name);
$to_addr .= " <misa@ohatadesign.com>";

$subject = "テスト";
$body = "こんにちは";

$filename = "img/test.jpg";
$mine = "image/jpeg";

($attach = file_get_contents($filename)) Or die("Open Error: $filename");

$filename = basename($filename);

$ret = Attach_Mail($from_addr, $to_addr, $subject, $body, $filename, $attach, $mine);

 ?>

 <html><body>Attach Mail</body></html>