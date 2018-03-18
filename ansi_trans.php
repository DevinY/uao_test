<?php
error_reporting(E_ALL);
ini_set( 'display_errors','1');

	$filename = "ansi_0312.txt";
	$fp = fopen($filename, "r");
	$str = fread($fp, filesize($filename));

//uao的array	
$china_sea_charset = require ("china-sea.php");
//讀取的文字檔換成16進制
$hex=bin2hex($str);
//每4個英文切成一個字
$chars = explode(",",chunk_split($hex,4,","));
foreach($chars as $char){
    $w = hex2bin($char);
    //嘗試換為UTF-8
    $word=@iconv("big5", "utf-8//IGNORE",$w);
    //無法轉換的，視為中國海字集編碼
    if($word==""){
	//輸出utf-8字型
	if(array_key_exists($char,$china_sea_charset)){
	$text = $china_sea_charset[$char];
	echo html_entity_decode(sprintf("&#x%s;",$text),ENT_NOQUOTES,"UTF-8");
	}
    }else{
        echo sprintf("%s",$word);
}
}
?>
