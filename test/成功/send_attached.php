<?php

require "send_attached_mail.inc";


$file[0] = "./img/ticket.gif";
// $file[1] = "/tmp/test.doc";

SendAttachedMail( "ohata@raijin.com" , "ohata@raijin.com" , "題名はテスト" , "本文1行目\n本文2行目" , $file );

?>