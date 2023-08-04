<?
$filename = $_GET["file"];
$target_Dir = $_GET["target_Dir"];
$file = $_SERVER['DOCUMENT_ROOT'] . "/" . $target_Dir . "/" . $filename;

$filesize = filesize($file);

if (is_file($file)) {

    header("Content-type: application/octet-stream");
    header("Content-Length: " . filesize("$file"));
    header("Content-Disposition: attachment; filename=$filename"); // 다운로드되는 파일명 (실제 파일명과 별개로 지정 가능)
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: public");
    header("Expires: 0");

    $fp = fopen($file, "rb");
    fpassthru($fp);
    fclose($fp);
} else {
    echo "해당 파일이 없습니다.";
}
?>