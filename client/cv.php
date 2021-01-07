<?php
session_start();
$cv = $_SESSION['cv'];

$file = $cv;
$name = $cv;
header('Content-type: application/docx');
header('Content-Disposition: inline; filename="'.$name.'"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
@readfile ($file);
?>
