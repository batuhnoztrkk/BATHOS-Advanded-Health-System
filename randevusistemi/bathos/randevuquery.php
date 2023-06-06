<?php
$saatler = array("09:00", "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45", "13:00", "13:15", "13:30", "13:45", "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30");
$simdiki_tarih = date("Y-m-d");
$randevu_Ekle = $DB_connect->prepare("INSERT INTO randevular (tckno, hastahane, klinik, hekim, tarih, saat, d_not, onaytarih) VALUES (:tckno, :hastahane, :klinik, :hekim, :tarih, :saat, :d_not, :onaytarih)");
$randevu_Ekle->bindParam( ':tckno', $tckno);
$randevu_Ekle->bindParam( ':hastahane', $_SESSION['hastahane']);
$randevu_Ekle->bindParam( ':klinik', $_SESSION['klinik']);
$randevu_Ekle->bindParam( ':hekim', $_SESSION['hekim']);
$randevu_Ekle->bindParam( ':tarih', $_SESSION['tarih']);
$randevu_Ekle->bindParam( ':onaytarih', $simdiki_tarih);
?>
