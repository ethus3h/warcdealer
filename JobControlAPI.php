<?php 

#from http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

$filename = "pending/" . gen_uuid();
if ($_REQUEST[actionType] === "i") {
    $filename = "pending/multiseed" . gen_uuid();
}
$url = $_REQUEST[actionUrl];
if (is_writable($filename)) {
    if (!$handle = fopen($filename, 'w')) {
         header("HTTP/1.0 503 Service Unavailable");
         exit;
    }
    if (fwrite($handle, $somecontent) === FALSE) {
        header("HTTP/1.0 503 Service Unavailable");
        exit;
    }
    header("HTTP/1.0 200 OK");
    echo $filename;
    fclose($handle);
    exit
} else {
    header("HTTP/1.0 503 Service Unavailable");
    exit
}

 ?>
