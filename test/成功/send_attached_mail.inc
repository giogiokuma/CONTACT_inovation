<?php

function SendAttachedMail( $from , $to , $subject , $body , $file ){

  mb_language( 'ja' );
  mb_internal_encoding( 'ISO-2022-JP' );

  $boundary = "__Boundary__" . uniqid( rand() , true ) . "__";
  $mime = "application/octet-stream";


  $header = "";
  $header .= "From: $from\n";
  $header .= "MIME-Version: 1.0\n";
  $header .= "Content-Type: Multipart/Mixed; boundary=\"$boundary\"\n";
  $header .= "Content-Transfer-Encoding: 7bit";


  $mbody = "--$boundary\n";
  $mbody .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
  $mbody .= "Content-Transfer-Encoding: 7bit\n";
  $mbody .= "\n";
  $mbody .= mb_convert_encoding( $body , 'ISO-2022-JP' , 'auto' );
  $mbody .= "\n";

  for( $i = 0 ; $i < count( $file ) ; $i++ ){

    $filename = mb_encode_mimeheader( mb_convert_encoding( basename( $file[ $i ] ) ,  "ISO-2022-JP" , 'auto' ) );


    $mbody .= "--$boundary\n";
    $mbody .= "Content-Type: $mime; name=\"$filename\"\n";
    $mbody .= "Content-Transfer-Encoding: base64\n";
    $mbody .= "Content-Disposition: attachment; filename=\"$filename\"\n";
    $mbody .= "\n";
    $mbody .= chunk_split( base64_encode(file_get_contents( $file[ $i ] ) ) , 76 ,"\n" );
    $mbody .= "\n";

  }


  $mbody .= "--$boundary--\n";

  return mail( $to , mb_encode_mimeheader( mb_convert_encoding( $subject , "ISO-2022-JP" , 'auto' )) , $mbody , $header );


}
?>