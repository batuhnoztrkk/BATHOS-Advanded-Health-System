<?php
//turkticaret
/*$DB_host = "localhost";
$DB_name = "boy22elimcom_bathos";
$DB_username = "boy22elimcom_bosoft";
$DB_password = "a;e@cy&{4,_@";*/

//localhost
$DB_host = "localhost";
$DB_name = "bathos";
$DB_username = "root";
$DB_password = "";


try {
    $DB_connect = new PDO("mysql:host={$DB_host};dbname={$DB_name};charset=utf8", $DB_username, $DB_password);
    $DB_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
