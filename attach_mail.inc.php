

<?php 
  function Attach_Mail( $from, $to, $subject, $body, $filename, $attach, $mime="" ){

    $boundary = "_Boundary_" . uniqid(rand(1000, 9999) . '_') . "_";

    // 件名と本文のエンコード
    $subject = mb_encode_mimeheader( $subject );                  // ISO-2022-JP/Base64に変換
    $body    = mb_convert_encoding($body, 'ISO-2022-JP', 'auto'); // ISO-2022-JPに変換

    // 添付データのエンコード
    // 日本語のファイル名はRFC違反ですが、多くのメーラは理解します
    $filename = mb_encode_mimeheader( $filename );           // ISO-2022-JP/Base64に変換
    $attach   = chunk_split(base64_encode($attach),76,"\n"); // Base64に変換し76Byte分割
    
    // メディアタイプ未指定の場合は汎用のタイプを指定
    if (!$mime) $mime = "application/octet-stream";

    // ヘッダー
 $header  = "To: $to\n" .
             "From: $from\n" .
             "X-Mailer: PHP/" . phpversion() . "\n" .
             "MIME-Version: 1.0\n" .
             "Content-Type: Multipart/Mixed; boundary=\"$boundary\"\n" .
             "Content-Transfer-Encoding: 7bit";
// マルチパート:本文
  $mbody .= "--$boundary\n";
  $mbody .= "Content-Type: text/plain; charset=ISO-2022-JP\n" .
            "Content-Transfer-Encoding: 7bit\n";
  $mbody .= "\n";        // 空行
  $mbody .= "$body\n";   // 本文

  // マルチパート:添付ファイル
  $mbody .= "--$boundary\n";
  $mbody .= "Content-Type: $mime; name=\"$filename\"\n" .
            "Content-Transfer-Encoding: base64\n" .
            "Content-Disposition: attachment; filename=\"$filename\"\n";
  $mbody .= "\n";        // 空行
  $mbody .= "$attach\n"; // 添付

  // マルチパート:終わり
  $mbody .= "--$boundary--\n";

  return mail(NULL, $subject, $mbody, $header);
}
?>