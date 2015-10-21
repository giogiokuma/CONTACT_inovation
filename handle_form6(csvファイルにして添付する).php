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



// タイトル
$mySbj = mb_encode_mimeheader("ザスパクサツ群馬 VS ジュビロ磐田チケットプレゼント申し込み");

$myName = mb_encode_mimeheader($name);

// 宛先メールアドレス
$toMail = "ohata@raijin.com";

// 宛先会社名 internal_encodingからmbstring.languageで設定した文字コードへ変換
$toName = mb_encode_mimeheader("上毛新聞社");

// 日時取得
ini_set("date.timezone", "Asia/Tokyo");
$datetime = date('Y-n-j H:i:s');


// 本文用　会社名
$myCompanyName = "上毛新聞社";

$message = "\n" . "\n" . PHP_EOL;
$message .= "添付ファイル送信のテストです。\n" . PHP_EOL;

// 添付ファイル

$cr = "\n";
$data = "項目" . ", " . "データ" . $cr;
$data .= "お名前" . ", " . $name . $cr;
$data .= "年 齢" . ", " . $age . $cr;
$data .= "郵便番号" . ", " . $postCode . $cr;
$data .= "住 所" . ", " . $address . $cr;
$data .= "電話番号" . ", " . $phone . $cr;
$data .= "メールアドレス" . ", " . $email . $cr;
$data .= "希望枚数" . ", " . $num_sheet . $cr;
$data .= "希望者名1" . ", " . $_REQUEST["希望者名1"] . $cr;
$data .= "希望者名1年齢" . ", " . $_REQUEST["希望者名1年齢"] . $cr;
$data .= "希望者名2" . ", " . $_REQUEST["希望者名1"] . $cr;
$data .= "希望者名1年齢" . ", " . $_REQUEST["希望者名1年齢"] . $cr;


$fp = @fopen('/thespa/form_sub.csv', 'a');
@fwrite($fp,$data);
@fclose($fp);

$attachments[] = Array(
  'data' => $data,
  'name' => 'form_sub',
  'type' => 'application/vnd.ms-excel'
  );

// 文字列
$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

// ヘッダーに添付ファイルを足す
$header = "MIME-Version: 1.0\n".
          "From: {$myName}<{$email}>\n" . 
          "Content-Type: multipart/mixed;\n" .
          " boundary=\"{$mime_boundary}\"";

// マルチパート　上の文字列の上部
 $message = "This is a multi-part message in MIME format.\n\n" .
                      "--{$mime_boundary}\n" .
                      "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
                      "Content-Transfer-Encoding: 7bit\n\n" .
                      $text . "\n\n";
// 変数
foreach($attachments as $attachment) {
  $data = chunk_split(base64_encode($attachment['data']));
  $name = $attachment['name'];
  $type = $attachment['type'];

  $message .= "--{$mime_boundary}\n" .
              "Content-Type: {$type};\n" .
              " name=\"{$name}\"\n" .
              "Content-Transfer-Encoding: base64\n\n" .
              $data . "\n\n" ;
}

$message .= "--{$mime_boundary}--\n";





if (mail($toMail, $mySbj, $message, $header)) {
  echo '';

} else {
  echo 'メール失敗しました';
}

} else {
  '<p class="error">必須項目に記入もれがあります。確認してもう一度送信してください。</p>';
}
 ?>

 <br />
<span class="back">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javaScript:history.back();">&raquo;１つ前へ戻る</a></span>
<br /><br /> 

</div><!--row-->
</div><!--container-->
  
</body>
</html>