<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;
include "db_connect.php";
include "query.php";
include "hekimquery.php";
if ($role == 1){
    if (isset($_POST['cikis'])){
        session_destroy();
        ob_clean();
        ?>
        <div class="basari">
            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
            <strong>Başarılı!</strong> Başarıyla çıkış yapıldı.
        </div>
        <?php
        header("Refresh:1; url= ../", true, 303);
        die();
    }
    if(isset($_POST['randevubilgileri'])){
        header("Refresh:1; url= randevubilgileri", true, 303);
    }
    if(isset($_POST['hesapbilgileri'])){
        header("Refresh:1; url= hesabim", true, 303);
    }

    $vatandasid = $_GET['muayene'];

    //Hasta Bilgileri
    $v_bilgi = $DB_connect->prepare('SELECT * FROM vatandas WHERE v_id = :vatandasid');
    $v_bilgi->execute(array(':vatandasid' => $vatandasid));
    $vbilgi = $v_bilgi->fetch(PDO::FETCH_ASSOC);
    $adsoyad = mb_strtoupper($vbilgi['ad']." ".$vbilgi['soyad']);
    $h_tckno = $vbilgi['tckno'];
    $cinsiyet = $vbilgi['cinsiyet'];
    $dogumtarihi = $vbilgi['dogumtarihi'];
    $email = $vbilgi['email'];
    $telno = $vbilgi['telno'];
    //Hasta Bilgileri

    $tarih = date("Y-m-d");
    $hekim = mb_strtoupper($ad." ".$soyad);
    $r_bilgi = $DB_connect->prepare('SELECT * FROM randevular WHERE tckno = :tckno AND hekim = :hekim AND tarih = :tarih AND hastahane = :hastahane AND klinik = :klinik');
    $r_bilgi->execute(array(':tckno' => $h_tckno, ":hekim" => $hekim, ":tarih" => $tarih, ":hastahane" => $h_hastahane, ":klinik" => $h_klinik));
    if ($r_bilgi->rowCount()){
        $rkntrl = $r_bilgi->fetch(PDO::FETCH_ASSOC);
        if ($rkntrl['durum'] == 0 || $rkntrl['durum'] == 4){

            //E-nabiz
            $k_bilgi = $DB_connect->prepare('SELECT * FROM k_veri WHERE k_tckno = :k_tckno');
            $k_bilgi->execute(array(':k_tckno' => $h_tckno));
            if ($k_bilgi->rowCount()){
                $kbilgi = $k_bilgi->fetch(PDO::FETCH_ASSOC);
                $boykilo = $kbilgi['k_boy']."cm / ".$kbilgi['k_kilo']."kg";
            }
            else{
                $boykilo = "Veri bulunamadı.";
            }



            if (isset($_POST['tani_Kaydet'])){
                // NOT: Tanı bilglierini databaseye kaydet... Tanıyı kaydedince randevu durumunuda değiştir.
                $randevu_id = $rkntrl['r_id'];
                $t_hasta_tckno = $h_tckno;
                $t_hekim_tckno = $tckno;
                $t_sikayet = $_POST['t_sikayet'];
                $t_muayene = $_POST['t_muayene'];
                $t_tahlil = $_POST['t_tahlil'];
                $t_radyoloji = $_POST['t_radyoloji'];
                $t_tani = $_POST['t_tani'];

                $tani_Kaydet = $DB_connect->prepare("INSERT INTO randevusonuc (r_id, hekim_tckno, hasta_tckno, hasta_sikayeti, yapilan_muayene, yapilan_tahliller, radyolojik_sonuclar, tani) VALUES (:r_id, :hekim_tckno, :hasta_tckno, :hasta_sikayeti, :yapilan_muayene, :yapilan_tahliller, :radyolojik_sonuclar, :tani)");
                $tani_Kaydet->bindParam( ':r_id', $randevu_id);
                $tani_Kaydet->bindParam( ':hekim_tckno', $t_hekim_tckno);
                $tani_Kaydet->bindParam( ':hasta_tckno', $t_hasta_tckno);
                $tani_Kaydet->bindParam( ':hasta_sikayeti', $t_sikayet);
                $tani_Kaydet->bindParam( ':yapilan_muayene', $t_muayene);
                $tani_Kaydet->bindParam( ':yapilan_tahliller', $t_tahlil);
                $tani_Kaydet->bindParam( ':radyolojik_sonuclar', $t_radyoloji);
                $tani_Kaydet->bindParam( ':tani', $t_tani);
                if($tani_Kaydet->execute()){
                    $duzelt_randevu = $DB_connect->prepare('UPDATE randevular SET durum = :durum WHERE r_id = :r_id');
                    if ($duzelt_randevu->execute(array(':r_id' => $randevu_id, ":durum" => "1"))){
                        ?>
                        <div class="basari">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                            <strong>Başarılı!</strong> Tanı ve teşhisler kaydedildi.
                        </div>
                        <?php
                        header("Refresh:1; url=", true, 303);
                    }
                    else{
                        ?>
                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                            <strong>Hata!</strong> Bir hata meydana geldi. Tanı kaydedilmedi (BAT05).
                        </div>
                        <?php
                    }
                }
                else{
                    ?>
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                        <strong>Hata!</strong> Bir hata meydana geldi. Tanı kaydedilmedi (BAT06).
                    </div>
                    <?php
                }
            }

            if (isset($_POST['kantahlil'])){ //SONUÇLARI GİRECEK KİŞİ LABARATUVAR OLMADIĞINDAN VARMIŞ GİBİ VARSAYIYORUZ...
                $kantahlilarray = array();
                if (isset($_POST['biyokimya'])){
                    $kantahlilarray[] = "Biyokimya Tahlili";
                }
                if (isset($_POST['hormon'])){
                    $kantahlilarray[] = "Hormon Tahlili";
                }
                if (isset($_POST['tumor'])){
                    $kantahlilarray[] = "Tümor Belirteçleri";
                }
                if (isset($_POST['pihtilasma'])){
                    $kantahlilarray[] = "Pıhtılaşma Tahlili";
                }
                if (isset($_POST['hematoloji'])){
                    $kantahlilarray[] = "Hematoloji Tahlili";
                }
                if (isset($_POST['hepatit'])){
                    $kantahlilarray[] = "Hepatit Tahlili";
                }
                if (isset($_POST['immunoloji'])){
                    $kantahlilarray[] = "İmmunoloji Tahlili";
                }
                if (isset($_POST['kankultur'])){
                    $kantahlilarray[] = "Kan Kültür Tahlili";
                }
                if (isset($_POST['genetik'])){
                    $kantahlilarray[] = "Genetik Tahlili";
                }
                
            }

            if (isset($_POST['idrartahlil'])){ //SONUÇLARI GİRECEK KİŞİ LABARATUVAR OLMADIĞINDAN VARMIŞ GİBİ VARSAYIYORUZ...
            }

            if (isset($_POST['spermiogramtahlil'])){ //SONUÇLARI GİRECEK KİŞİ LABARATUVAR OLMADIĞINDAN VARMIŞ GİBİ VARSAYIYORUZ...
            }

            if (isset($_POST['radyolojikayit'])){ //SONUÇLARI GİRECEK KİŞİ LABARATUVAR OLMADIĞINDAN VARMIŞ GİBİ VARSAYIYORUZ...
                $rontgen = $_POST['rontgen'];
                $ultrason = $_POST['ultrason'];
                $mr = $_POST['mr'];
                $istemrontgen = $_POST['istemrontgen'];
                $istemultrason = $_POST['istemultrason'];
                $istemmr = $_POST['istemmr'];
            }

            if (isset($_POST['receteyaz'])){ //Şuanda sadece 1 ilaç yazılabiliyor ileride arttırılabilir.
                $randevu_id = $rkntrl['r_id'];
                $t_hasta_tckno = $h_tckno;
                $t_hekim_tckno = $tckno;
                $ilacara = $_POST['ilacara'];
                $aciklama = $_POST['aciklama'];
                $doz = $_POST['doz'];
                $periyot = $_POST['periyot'];
                $kullanimsekli = $_POST['kullanimsekli'];
                $kullanimsayisi = $_POST['kullanimsayisi'];
                $kutuadedi = $_POST['kutuadedi'];

                $recete_Kaydet = $DB_connect->prepare("INSERT INTO recete (r_id, hekim_tckno, hasta_tckno, ilac_adi, aciklama, doz, periyot, kullanim_sekli, kullanim_sayisi, kutu_adedi) VALUES (:r_id, :hekim_tckno, :hasta_tckno, :ilac_adi, :aciklama, :doz, :periyot, :kullanim_sekli, :kullanim_sayisi, :kutu_adedi)");
                $recete_Kaydet->bindParam( ':r_id', $randevu_id);
                $recete_Kaydet->bindParam( ':hekim_tckno', $t_hekim_tckno);
                $recete_Kaydet->bindParam( ':hasta_tckno', $t_hasta_tckno);
                $recete_Kaydet->bindParam( ':ilac_adi', $ilacara);
                $recete_Kaydet->bindParam( ':aciklama', $aciklama);
                $recete_Kaydet->bindParam( ':doz', $doz);
                $recete_Kaydet->bindParam( ':periyot', $periyot);
                $recete_Kaydet->bindParam( ':kullanim_sekli', $kullanimsekli);
                $recete_Kaydet->bindParam( ':kullanim_sayisi', $kullanimsayisi);
                $recete_Kaydet->bindParam( ':kutu_adedi', $kutuadedi);
                if($recete_Kaydet->execute()){
                    ?>
                    <div class="basari">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                        <strong>Başarılı!</strong> Reçete kaydedildi.
                    </div>
                    <?php
                }
                else{
                    ?>
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                        <strong>Hata!</strong> Bir hata meydana geldi. Reçete kaydedilmedi (BAT06).
                    </div>
                    <?php
                }
            }//Kayıt sonrası hastanın eski tahlil ve tanılarını görebileceği alan yaratılabilir...
        }
        else{
            header("Refresh:1; url= ../", true, 303);
            die();
        }
    }
    else{
        header("Refresh:1; url= ../", true, 303);
        die();
    }
}
else{
    header("Refresh:1; url= ../", true, 303);
    die();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title>BATHOS | Türkiye'nin En Gelişmiş Sağlık Uygulaması</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../vendors/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../vendors/owl-carousel/css/owl.theme.default.css">
    <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendors/aos/css/aos.css">
    <link rel="stylesheet" href="../css/style.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">

<header id="header-section">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
        <div class="container">
            <img src="../images/logo2.png" alt="" width="60" height="75" >
            <div class="navbar-brand-wrapper d-flex w-100">
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="mdi mdi-menu navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
                <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
                    <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
                        <div class="navbar-collapse-logo">
                            <img src="../images/logo2.png" alt="">
                        </div>
                        <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <form method="post" action="">
                            <input type="submit" name="anasayfa" class="nav-link" style=" border: none; background: url(images/anasayfa.png) no-repeat scroll 6px 6px; padding-top:2px; padding-left:30px; border-radius: 10px; margin-right: 600px; background-color: #ded7d7; height: 30px;" value="Anasayfa">
                        </form>
                    </li>

                    <li class="nav-item">
                        <form method="post" action="">
                            <input type="submit" name="adsoyad" class="nav-link" style=" border: none; background: url(images/user.png) no-repeat scroll 6px 5px; padding-top:2px; padding-left:30px; background-color: #46b5af; border-radius: 10px; color: white; font-weight: normal; height: 30px;" value="<?php echo mb_strtoupper($ad." ".$soyad) ?>" disabled>
                        </form>
                    </li>

                    <li class="nav-item">
                        <form method="post" action="">
                            <input type="submit" name="cikis" class="nav-link" style=" border: none; background: url(images/cikis.png) no-repeat scroll 8px 8px; padding-top:2px; padding-left:30px; background-color: #efefef; border-radius: 10px; color: red; font-weight: normal; margin-left: 20px; height: 30px;" value="Çıkış">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="banner" >
    <div class="container">
        <h3 class="font-weight-semibold">BATHOS | Türkiye'nin En Gelişmiş Sağlık Uygulaması</h3>
        <h6 class="font-weight-normal text-muted pb-3">Türkiye'nin en gelişmiş sağlık sistemi.</h6>

        <br>

        <h4 style="color: grey;"><strong>Hasta Bilgileri</strong></h4>
        <table border="25" width="1100px" bordercolor="#e8e8e8" style="overflow: hidden;">
            <tr>
                <td align="center" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">İsim/Soyisim</td>
                <td align="center" style="background-color: #fafafa; margin-right: 10px;"><?php echo $adsoyad ?></td>
            </tr>
            <tr>
                <td align="center" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Cinsiyet</td>
                <td align="center" style="background-color: #fafafa; margin-right: 10px;"><?php echo $cinsiyet ?></td>
            </tr>
            <tr>
                <td align="center" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Doğum Tarihi</td>
                <td align="center" style="background-color: #fafafa; margin-right: 10px;"><?php echo $dogumtarihi ?></td>
            </tr>
            <tr>
                <td align="center" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Sisteme Kayıtlı Boy/Kilo</td>
                <td align="center" style="background-color: #fafafa; margin-right: 10px;"><?php echo $boykilo ?></td>
            </tr>
        </table>

        <br><br>

        <hr size="10" color="9fdae7">

        <div id="pencerekodu">
            <label for="koddostu-ampshadow" class="dugmetani">Tanı Ekle</label>
            <input type="checkbox" class="Pencereac" id="koddostu-ampshadow" name="koddostu-ampshadow"></input>
            <label class="koddostu-ampshadow">
                <div class="koddostu-ampwindow">
                    <div class="koddostu-p16"">
                    <center>
                        <table border="15" width="950px" bordercolor="#e8e8e8" style="overflow: hidden;">
                            <form method="post" action="">
                                <tr>
                                    <td align="center" width="200px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Hasta Şikayeti*</td>
                                    <td align="center"><input type="text" class="form-control" name="t_sikayet" id="sikayet" placeholder="Hasta Şikayeti*" style="max-width: 90%;" required></td>
                                </tr>
                                <tr>
                                    <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Yapılan Muayene*</td>
                                    <td align="center"><input type="text" class="form-control" name="t_muayene" id="t_muayene" placeholder="Yapılan Muayene/İşlemler*" style="max-width: 90%;" required></td>
                                </tr>
                                <tr>
                                    <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Yapılan Tahliller</td>
                                    <td align="center"><input type="text" class="form-control" name="t_tahlil" id="t_tahlil" placeholder="Yapılan Tahliller" style="max-width: 90%;"></td>
                                </tr>
                                <tr>
                                    <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Röntgen/Tomografi</td>
                                    <td align="center"><input type="text" class="form-control" name="t_radyoloji" id="t_radyoloji" placeholder="Radyolojik sonuçları hakkında bilgilendirme" style="max-width: 90%;"></td>
                                </tr>
                                <tr>
                                    <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Tanı*</td>
                                    <td align="center"><input type="text" class="form-control" name="t_tani" id="t_tani" placeholder="Muayene sonucu tanı*" style="max-width: 90%;" required></td>
                                </tr>
                                <tr>
                                    <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">İşlem</td>
                                    <td><center><input type="submit" name="tani_Kaydet" id="tani_Kaydet" class="form-control" value="Kaydet" style="max-width: 90%;"></center></td>
                                </tr>
                            </form>
                        </table>
                    </center>
                        <p style="color:#c1bfbf; float: left; margin-left: 15px; margin-top: 15px;">
                            Yıldız (*) ile işaretlenen kısımların doldurulması zorunludur.
                        </p>
                        <p style="color:#c1bfbf; float: left; margin-left: 15px; margin-top: 15px;">
                            Hasta Şikayeti ve yapılan muayene/işlemler kısmı tam doldurulmalıdır. Eksik veya yanlış bilgi tespiti halinde HERP puanına
                            etkide bulunacaktır.
                        </p>
                        <label for="koddostu-ampshadow" class="dugme">İptal</label>
                    </div>
                </div>
            </label>
        </div>

        <div id="pencerekodu2">
            <label for="koddostu-ampshadow2" class="dugmetahlil">Tahlil Yönlendir</label>
            <input type="checkbox" class="Pencereac" id="koddostu-ampshadow2" name="koddostu-ampshadow2"></input>
            <label class="koddostu-ampshadow">
                <div class="koddostu-ampwindow">
                    <div class="koddostu-p16">

                        <div style="background: #e8e8e8; width: 970px; height: 680px; border-radius: 10px;">
                            <div id="pencerekodu5">
                                <label for="koddostu-ampshadow5" class="dugmetani" style="background-color: #d095db">Kan Tahlili</label>
                                <input type="checkbox" class="Pencereac" id="koddostu-ampshadow5" name="koddostu-ampshadow5"></input>
                                <label class="koddostu-ampshadow">
                                    <div class="koddostu-ampwindow">
                                        <div class="koddostu-p16">
                                            <form action="" method="post">
                                                <div align="left">
                                                <input type="checkbox" name="biyokimya" value="1" id="biyokimya" style="width: 40px; height: 40px; margin-left: 250px;">
                                                <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Biyokimya Tahlilleri</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="hormon" value="1" id="hormon" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Hormon Tahlilleri</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="tumor" value="1" id="tumor" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Tümör Belirteçleri</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="pihtilasma" value="1" id="pihtilasma" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Pıhtılaşma Tahlilleri</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="hematoloji" value="1" id="hematoloji" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Hematoloji Tahlilleri</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="hepatit" value="1" id="hepatit" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Hepatit Tahlilleri</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="immunoloji" value="1" id="immunoloji" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">İmmünoloji Tahlilleri</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="kankultur" value="1" id="kankultur" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Kan kültür Tahlili</label>
                                                </div>

                                                <div align="left">
                                                    <input type="checkbox" name="genetik" value="1" id="genetik" style="width: 40px; height: 40px;margin-left: 250px;">
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Genetik Tahliller</label>
                                                </div>

                                                <div align="left">
                                                    <input type="submit" value="Gönder" name="kantahlil" class="form-control" style="">
                                                </div>

                                                <label for="koddostu-ampshadow5" class="dugme">Kapat</label>
                                            </form>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div id="pencerekodu6">
                                <label for="koddostu-ampshadow6" class="dugmetahlil" style="background-color: #9f95db">İdrar Tahlili</label>
                                <input type="checkbox" class="Pencereac" id="koddostu-ampshadow6" name="koddostu-ampshadow6"></input>
                                <label class="koddostu-ampshadow">
                                    <div class="koddostu-ampwindow">
                                        <div class="koddostu-p16">
                                            <form method="post">
                                                <div align="left">
                                                    <input type="checkbox" name="idrar" style="width: 40px; height: 40px;margin-left: 250px;" checked required>
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Tam İdrar Tahlili</label>
                                                </div>
                                                <div align="left">
                                                    <input type="submit" value="Gönder" name="idrartahlil" class="form-control" style="">
                                                </div>
                                            </form>
                                            <label for="koddostu-ampshadow6" class="dugme">Kapat</label>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div id="pencerekodu6">
                                <label for="koddostu-ampshadow7" class="dugmetani" style="background-color: #95dba1">Spermiogram</label>
                                <input type="checkbox" class="Pencereac" id="koddostu-ampshadow7" name="koddostu-ampshadow7"></input>
                                <label class="koddostu-ampshadow">
                                    <div class="koddostu-ampwindow">
                                        <div class="koddostu-p16">
                                            <form method="post">
                                                <div align="left">
                                                    <input type="checkbox" name="spermiogram" style="width: 40px; height: 40px;margin-left: 250px;" checked required>
                                                    <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Spermiogram (Meni) Tahlili</label>
                                                </div>
                                                <div align="left">
                                                    <input type="submit" value="Gönder" name="spermiogramtahlil" class="form-control" style="">
                                                </div>
                                            </form>
                                            <label for="koddostu-ampshadow7" class="dugme">Kapat</label>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <label for="koddostu-ampshadow2" class="dugme">Kapat</label>
                    </div>
                </div>
            </label>
        </div>
        <br><br><br><br><br>
        <div id="pencerekodu3">
            <label for="koddostu-ampshadow3" class="dugmeradyo">Radyoloji Yönlendir</label>
            <input type="checkbox" class="Pencereac" id="koddostu-ampshadow3" name="koddostu-ampshadow3"></input>
            <label class="koddostu-ampshadow">
                <div class="koddostu-ampwindow">
                    <div class="koddostu-p16">
                        <form method="post">
                            <div align="left">
                                <input type="checkbox" name="rontgen" style="width: 40px; height: 40px;margin-left: 250px;">
                                <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Röntgen</label>
                            </div>
                            <div align="left">
                                <input type="checkbox" name="ultrason" style="width: 40px; height: 40px;margin-left: 250px;">
                                <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">Ultrason</label>
                            </div>
                            <div align="left">
                                <input type="checkbox" name="mr" style="width: 40px; height: 40px;margin-left: 250px;">
                                <label for="test" style="font-size: 45px; font-weight: bold; color: #0075ff">MR</label>
                            </div>
                            <div align="left">
                                <input type="text" name="istemrontgen" class="form-control" placeholder="RÖNTGEN İstem Sebebi / Bölge*">
                            </div>
                            <div align="left">
                                <input type="text" name="istemultrason" class="form-control" placeholder="ULTRASON İstem Sebebi / Bölge*">
                            </div>
                            <div align="left">
                                <input type="text" name="istemmr" class="form-control" placeholder="MR İstem Sebebi / Bölge*">
                            </div>
                            <div align="left">
                                <input type="submit" value="Gönder" name="radyolojikayit" class="form-control">
                            </div>
                            <p style="color:#c1bfbf; float: left; margin-left: 15px; margin-top: 15px;">
                                Radyolojik sonuçların kesin ve net olması açısından seçilenlerin istem sebebi ve açıklaması yapılması zorunludur.
                            </p>
                        </form>
                        <label for="koddostu-ampshadow3" class="dugme">Kapat</label>
                    </div>
                </div>
            </label>
        </div>

        <div id="pencerekodu4">
            <label for="koddostu-ampshadow4" class="dugmerecete">Reçete Yaz</label>
            <input type="checkbox" class="Pencereac" id="koddostu-ampshadow4" name="koddostu-ampshadow4"></input>
            <label class="koddostu-ampshadow">
                <div class="koddostu-ampwindow">
                    <div class="koddostu-p16">
                        <!--/////////////////////////////////////////////////////////////////////////////////////////////////////-->
                            <link rel="stylesheet" href="style.css"/>
                        <h4>Reçete Yaz</h4>
                        <!-- Ortala -->
                            <form method="post">
                                <table border="5" width="970px" bordercolor="#e8e8e8" style="overflow: hidden;">
                                    <tr>
                                        <td>
                                            <p>Sayı</p>
                                        </td>
                                        <td>
                                            <p>İlaç Adı</p>
                                        </td>
                                        <td>
                                            <p>Açıklama</p>
                                        </td>
                                        <td>
                                            <p>Doz</p>
                                        </td>
                                        <td>
                                            <p>Periyot</p>
                                        </td>
                                        <td>
                                            <p>Kullanım Şekli</p>
                                        </td>
                                        <td>
                                            <p>Kullanım Sayısı</p>
                                        </td>
                                        <td>
                                            <p>Kutu Adedi</p>
                                        </td>
                                    <tr>
                                        <td>
                                        1
                                        </td>
                                        <td>
                                            <input type="text" name="ilacara" id="ilacara" class="input" placeholder="İlaç Adı" required>
                                        </td>
                                        <td>
                                        <input type="text" name="aciklama" id="aciklama" class="form-control" placeholder="Açıklama" required>
                                        </td>
                                        <td>
                                        <input type="text" name="doz" id="doz" class="form-control" placeholder="Doz" required>
                                        </td>
                                        <td>
                                        <input type="text" name="periyot" id="periyot" class="form-control" placeholder="Periyot" required>
                                        </td>
                                        <td>
                                        <input type="text" name="kullanimsekli" id="kullanimsekli" class="form-control" placeholder="Kullanım Şekli" required>
                                        </td>
                                        <td>
                                        <input type="text" name="kullanimsayisi" id="kullanimsayisi" class="form-control" placeholder="Kullanım Sayısı" required>
                                        </td>
                                        <td>
                                        <input type="text" name="kutuadedi" id="kutuadedi" class="form-control" placeholder="Kutu Adedi" required>
                                        </td>
                                    </tr>
                                </table>
                                <div id="sonuclar"><ul></ul></div>
                                <input type="submit" name="receteyaz" id="receteyaz" class="form-control" value="Reçete Yaz">
                            </form>
                        <label for="koddostu-ampshadow4" class="dugme">Kapat</label>
                    </div>
                </div>
            </label>
        </div>
        <br><br><br><br><br><br><br><br><br><br>

    <script>
        function fill(Value) {
            $('#ilacara').val(Value);
            $('#sonuclar').hide();
        }
    </script>
</body>
</div>
</div>
<div class="content-wrapper">
    <div class="container">
        <section class="contact-details" id="contact-details-section">
            <div class="row text-center text-md-left">
                <div class="col-12 col-md-6 col-lg-3 grid-margin">
                    <img src="images/logonotext.png" alt="" class="pb-2" width="50" height="55">
                    <div class="pt-2">
                        <p class="text-muted m-0">Bathos@info.com</p>

                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 grid-margin">
                    <h5 class="pb-2">Politikalarımız</h5>
                    <a href="/hakkimizda/sozlesme/kullanici.html"><p class="m-0 pb-2">Kullanıcı Sözleşmesi</p></a>
                    <a href="/hakkimizda/sozlesme/gizlilik.html" ><p class="m-0 pt-1 pb-2">Gizlilik Politikası</p></a>
                    <a href="/hakkimizda/sozlesme/cerez.html"><p class="m-0 pt-1 pb-2">Çerez Politikası</p></a>

                </div>
                <div class="col-12 col-md-6 col-lg-3 grid-margin">
                    <h5 class="pb-2">Adres</h5>
                    <p class="text-muted">Dumlupınar Üniversitesi Bilgisayar Mühendisliği Bölümü <p>Tavşanlı yolu 10. km | Kütahya</p>

                </div>
            </div>
        </section>
        <footer class="border-top">
            <p class="text-center text-muted pt-4">Copyright © 2021<a href="https://www.google.com/" class="px-1">Bathos | Gelişmiş Sağlık Sistemi</p>
        </footer>
        <!-- Modal for Contact - us Button -->

        <script src="../vendors/jquery/jquery.min.js"></script>
        <script src="../vendors/bootstrap/bootstrap.min.js"></script>
        <script src="../vendors/owl-carousel/js/owl.carousel.min.js"></script>
        <script src="../vendors/aos/js/aos.js"></script>
        <script src="../js/landingpage.js"></script>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


        <script type="text/javascript">
            $(function(){
                $("#sonuclar").hide();
                // Tıklandığında işlem  yap
                $(".input").keyup(function(){
                    // Veriyi alalım
                    var value = $(this).val();
                    var deger = "value="+value;
                    $.ajax({
                        type: "POST",
                        url: "post.php",
                        data: deger,
                        success: function(cevap){
                            if(cevap == "yok"){
                                $("#sonuclar").show().html("");
                                $("#sonuclar").html("İlaç Bulunamadı");
                            }else if(cevap == "bos"){
                                $("#sonuclar").hide();
                            }else {

                                $("#sonuclar").show();
                                $("#sonuclar").html(cevap);
                            }
                        }
                    })
                });
            });
        </script>
        </body>
</html>
