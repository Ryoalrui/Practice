<?PHP
function trans_bytes(string $filesize){
$level=['B','KB','MB','GB','TB'];
$key=floor(log($filesize,1024));
$res=round($filesize/pow(1024,$key),2);
}
