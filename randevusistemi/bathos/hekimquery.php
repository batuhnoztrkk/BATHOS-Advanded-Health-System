<?php
if (isset($_SESSION['logged'])){
    $id = $_SESSION['logged']; //Kullanıcının idsini değişkene atıyoruz. (Birçok alanda kullanacağımız için)
    $h_bilgi = $DB_connect->prepare('SELECT * FROM hekimbilgiler WHERE h_tc = :h_tc'); //İD üzerinden sorgularımızı yaparak kullanıcının tüm bilgilerini çekiyoruz.
    $h_bilgi->execute(array(':h_tc' => $tckno));
    $hbilgi = $h_bilgi->fetch(PDO::FETCH_ASSOC);

    $h_id = $hbilgi['h_id'];
    $h_tc = $hbilgi['h_tc'];
    $h_il = $hbilgi['h_il'];
    $h_ilce = $hbilgi['h_ilce'];
    $h_hastahane = $hbilgi['h_hastahane'];
    $h_klinik = $hbilgi['h_klinik'];
    $h_sicilno = $hbilgi['h_sicilno'];
}
?>
