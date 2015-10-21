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
$from .= " <ohata@raijin.com>";

$to   .= " <ohata@raijin.com>";

$subject    = "添付ファイルテスト";
$body       = "添付ファイルテスト正文";

$filename   = "./img/ticket.gif";
$att_files   = ".img/ticket.gif";
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
} // function


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