<?php
if (isset($_SESSION['logged'])){
$id = $_SESSION['logged']; //Kullanıcının idsini değişkene atıyoruz. (Birçok alanda kullanacağımız için)
$v_bilgi = $DB_connect->prepare('SELECT * FROM vatandas WHERE v_id = :v_id'); //İD üzerinden sorgularımızı yaparak kullanıcının tüm bilgilerini çekiyoruz.
$v_bilgi->execute(array(':v_id' => $id));
$vbilgi = $v_bilgi->fetch(PDO::FETCH_ASSOC);

$v_id = $vbilgi['v_id'];
$role = $vbilgi['role'];
$tckno = $vbilgi['tckno'];
$ad = $vbilgi['ad'];
$soyad = $vbilgi['soyad'];
$cinsiyet = $vbilgi['cinsiyet'];
$dogumtarih = $vbilgi['dogumtarihi'];
$email = $vbilgi['email'];
$telno = $vbilgi['telno'];
$parola = $vbilgi['parola'];
}
?>
