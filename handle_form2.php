<?php

$from .= " <ohata@raijin.com>";

$to   .= " <ohata@raijin.com>";

$subject    = "添付ファイルテスト";
$body       = "添付ファイルテスト正文";

$filename   = "./img/test.txt";
$att_files   = ".img/test.txt";
//$mine       = "js";

//send_mail2($to, $subject, $text_body, $headers, $html_body="", $att_names="", $att_files="", $file_types="");
/*
if ($filename){
($attach = file_get_contents($filename)) Or die("Open Error: $filename");
$filename = basename($filename);
$ret = Attach_Mail($from, $to, $subject, $body, $filename, $attach, $mine);
}else{

}
*/
$ret = send_mail($to, $from, $subject, $body, $cc = null, $bcc = null, $filename);
//echo $ret;

function send_mail($to, $from, $subject, $body, $cc = null, $bcc = null, $attachment = null)
{
if ($to  != ""  &&  isset( $to  )  ) {
$to =str_replace( " " , "" , $to  ) ;
$to =str_replace( "\t" , ","  , $to  ) ; 
}
if ($cc  != ""  &&  isset( $cc  )  ) {
$cc =str_replace( " " , "" , $cc  ) ;
$cc =str_replace( "\t" , ","  , $cc  ) ; 
}
if ($bcc  != ""  &&  isset( $bcc  )  ) {
$bcc =str_replace( " " , "" , $bcc  ) ;
$bcc =str_replace( "\t" , ","  , $bcc  ) ; 
}

// 念の為、言語と文字コードの設定
$body = "BCC:$bcc\r\n$body\r\n";
$body = "CC:$cc\r\n$body\r\n";
$to_tmp = join("\r\n   ",explode(",",$to));
$body = "TO:$to_tmp\r\n$body\r\n";

mb_language("Japanese");
mb_internal_encoding("EUC-JP");
mb_detect_order("ASCII, JIS, UTF-8, EUC-JP, SJIS");

// From を変換
//$FromName = mb_encode_mimeheader(mb_convert_encoding($FromName,'JIS','auto'));
//$header .= 'From:'.$FromName.' <'.$FromMail.'>'."\r\n";
$to = "ohata@raijin.com";
$cc = "ohata@raijin.com";
$header .= 'From:'.$from."\r\n";
//$ToName = mb_encode_mimeheader(mb_convert_encoding($ToName,'JIS','auto'));
//$header .= 'To:"'.$ToName.'"<'.$to.'>'."\r\n";
//$header .= 'To:'.$to."\r\n";
$header .= "Cc:".$cc."\r\n";
$header .= "Bcc:".$bcc."\r\n";


if ($attachment){

//  ($attach = file_get_contents($attachment)) Or die("Open Error: $attachment");
$fh = fopen($attachment,rb);
$attach = fread ($fh, filesize ($attachment));
fclose ($fh);

$filename = basename($attachment);
$boundary = "_Boundary_" . uniqid(rand(1000,9999) . '_') . "_";

// 件名と本文のエンコード
$subject = mb_encode_mimeheader( $subject );                  // ISO-2022-JP/Base64に変換

// 添付データのエンコード
// 日本語のファイル名はRFC違反ですが、多くのメーラは理解します
$filename = mb_encode_mimeheader( $filename );           // ISO-2022-JP/Base64に変換
$attach   = chunk_split(base64_encode($attach),76,"\n"); // Base64に変換し76Byte分割

// メディアタイプ未指定の場合は汎用のタイプを指定
if (!$mime) $mime = "application/octet-stream";

// ヘッダー
$header  = "To: ".$to."\n" .
"From: ".$from."\n" .
"X-Mailer: PHP/" . phpversion() . "\n".
"MIME-Version: 1.0\n" .
"Content-Type: Multipart/Mixed; boundary=\"".$boundary."\"\n" ;
//"Content-Transfer-Encoding: 7bit";

// マルチパート:本文
$mbody .= "--$boundary\n";
$mbody .= "Content-Type: text/plain; charset=ISO-2022-JP\n" .
"Content-Transfer-Encoding: 7bit\n";
$mbody .= "\n";        // 空行
$mbody .= "$body\n";   // 本文

// マルチパート:添付ファイル
$mbody .= "--".$boundary."\n";
$mbody .= "Content-Type: ".$mime."; name=\"".$filename."\"\n" .
"Content-Transfer-Encoding: base64\n" .
"Content-Disposition: attachment; filename=\"".$filename."\"\n";
$mbody .= "\n";        // 空行
$mbody .= "$attach\n"; // 添付

// マルチパート:終わり
$mbody .= "--$boundary--\n";

return mail(NULL, $subject, $mbody, $header);
}else{
return  mb_send_mail($to, $subject, $body, $header);
}
}

?>