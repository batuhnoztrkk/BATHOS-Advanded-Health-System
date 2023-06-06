<?php
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
                            <input type="submit" name="hesapbilgileri" class="nav-link" style=" border: none; background: url(images/hesapbilgileri.png) no-repeat scroll 6px 6px; padding-top:2px; padding-left:30px; border-radius: 10px; margin-left: -570px; background-color: #ded7d7; height: 30px;" value="Hesap Bilgileri">
                        </form>
                    </li>

                    <li class="nav-item">
                        <form method="post" action="">
                            <input type="submit" name="randevubilgileri" class="nav-link" style=" border: none; background: url(images/randevubilgileri.png) no-repeat scroll 6px 6px; padding-top:2px; padding-left:30px; border-radius: 10px; margin-left: -400px; background-color: #ded7d7; height: 30px;" value="Randevu Bilgileri">
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

<div style="float:left;width:50%;">
    <p style="font-size: 18px; font-weight: bold; color: black">Aktif Randevular</p>
    <hr size="10" width="50" style="position: relative; right: 45px" color="black">
    <center>
        <?php
        $goster = 0;
        $aktif_durum = 1;
        $aktif_randevu = $DB_connect->prepare('SELECT * FROM randevular WHERE tckno = :tckno ORDER BY r_id DESC');
        $aktif_randevu->execute(array(':tckno' => $tckno));
        if ($aktif_randevu->rowCount()){
            while ($aktifRandevu = $aktif_randevu->fetch(PDO::FETCH_ASSOC)){
                if ($aktifRandevu['durum'] == "0"){
                        ?>
                        <div class="card" style="width: 15rem; padding-left: 10px; padding-top: 10px; float: left; margin-left: 20px; margin-bottom: 18px">
                            <center>
                                <ul class="navbar-nav align-items-start ml-auto">
                                    <li>
                                        <p style="margin-left: 0px; background-color: cornflowerblue; border-radius: 10px; width: 105px; color: white; font-weight: bold; font-size: 12px; float: left"><?php echo $aktifRandevu['tarih']." ".$aktifRandevu['saat']?></p>
                                        <p style="margin-left: 10px; background-color: forestgreen; width: 100px; border-radius: 10px; color: white; font-weight: bold; font-size: 12px; float: left">Aktif Randevu</p>
                                    </li>
                                    <li>
                                        <img src="images/hastahane.ico" alt="" style="width: 23px; float:left; left: 25px">
                                        <p style="padding-left:15px; color: gray; font-weight: bold; font-size: 12px; float: left"><?php echo $aktifRandevu['hastahane']?></p>
                                    </li>
                                    <li>
                                        <img src="images/klinik.ico" alt="" style="width: 23px; float:left;">
                                        <p style="padding-left:15px;color: gray; font-weight: bold; font-size: 12px; float: left"><?php echo $aktifRandevu['klinik']?></p>
                                    </li>
                                    <li>
                                        <img src="images/doktor.ico" alt="" style="width: 23px; float:left;">
                                        <p style="padding-left:15px;color: gray; font-weight: bold; font-size: 12px; float: left"><?php echo $aktifRandevu['hekim']?></p>
                                    </li>
                                    <li>
                                        <a type="button" style="margin-left:45px; margin-bottom: 12px; background-color: orangered; color: white; width: 130px; font-weight: bold; border-radius: 5px; font-size: 12px; float: left border-radius: 5px" href="randevuislem?randevuiptal=<?php echo  $aktifRandevu['r_id']?>" >Randevuyu İptal Et</a>
                                    </li>
                                </ul>
                            </center>
                        </div>
                        <?php
                    }
                }
            }

        else{
            ?>
            <p style="color:gray;">Aktif Randevunuz Yok.</p>
            <?php
        }
        ?>
    </center>
</div>
<div style="float:right;width:50%;">
    <p style="font-size: 18px; font-weight: bold; color: darkgray">Geçmiş Randevular</p>
    <hr size="10" width="50" style="position: relative; right: 58px" color="darkgray">
    <center>
        <?php
        $gecmis_randevu = $DB_connect->prepare('SELECT tarih, saat, hastahane, klinik, hekim, durum, r_id FROM randevular WHERE tckno = :tckno ORDER BY r_id DESC');
        $gecmis_randevu->execute(array(':tckno' => $tckno));
        if ($gecmis_randevu->rowCount()){
            while ($gecmisRandevu = $gecmis_randevu->fetch(PDO::FETCH_ASSOC)){
                if ($gecmisRandevu['durum'] == "1" || $gecmisRandevu['durum'] == "2" || $gecmisRandevu['durum'] == "3" || $gecmisRandevu['durum'] == "4"){
                        ?>
                        <div class="card" style="width: 15rem; padding-left: 10px; padding-top: 10px; float: left; margin-left: 20px; margin-bottom: 18px">
                            <center>
                                <ul class="navbar-nav align-items-start ml-auto">
                                    <li>
                                        <p style="margin-left: 0px; background-color: gray; border-radius: 10px; width: 105px; color: white; font-weight: bold; font-size: 12px; float: left"><?php echo $gecmisRandevu['tarih']." ".$gecmisRandevu['saat']?></p>
                                        <?php
                                        if ($gecmisRandevu['durum'] == "2"){
                                            ?><p style="margin-left: 10px; background-color: indianred; width: 105px; border-radius: 10px; color: white; font-weight: bold; font-size: 10px; float: left"><?php
                                            echo "Randevuya Gidilmedi";
                                        }
                                        elseif ($gecmisRandevu['durum'] == "1"){
                                            ?><p style="margin-left: 10px; background-color: indianred; width: 105px; border-radius: 10px; color: white; font-weight: bold; font-size: 12px; float: left"><?php
                                            echo "Geçmiş Randevu";
                                        }
                                        elseif ($gecmisRandevu['durum'] == "3"){
                                            ?><p style="margin-left: 10px; background-color: indianred; width: 105px; border-radius: 10px; color: white; font-weight: bold; font-size: 12px; float: left"><?php
                                            echo "Randevu İptal";
                                        }
                                        elseif ($gecmisRandevu['durum'] == "4"){
                                        ?><p style="margin-left: 10px; background-color: indianred; width: 105px; border-radius: 10px; color: white; font-weight: bold; font-size: 12px; float: left"><?php
                                            echo "Hekim Randevusu";
                                            }
                                            ?>
                                        </p>
                                    </li>
                                    <li>
                                        <img src="images/g_hastahane.ico" alt="" style="width: 23px; float:left; left: 25px">
                                        <p style="padding-left:15px; color: gray; font-weight: bold; font-size: 12px; float: left"><?php echo $gecmisRandevu['hastahane']?></p>
                                    </li>
                                    <li>
                                        <img src="images/g_klinik.ico" alt="" style="width: 23px; float:left;">
                                        <p style="padding-left:15px;color: gray; font-weight: bold; font-size: 12px; float: left"><?php echo $gecmisRandevu['klinik']?></p>
                                    </li>
                                    <li>
                                        <img src="images/g_doktor.ico" alt="" style="width: 23px; float:left;">
                                        <p style="padding-left:15px;color: gray; font-weight: bold; font-size: 12px; float: left"><?php echo $gecmisRandevu['hekim']?></p>
                                    </li>
                                    <li>
                                        <a type="button" style="margin-left:45px; margin-bottom: 12px; background-color: darkseagreen; color: white; width: 120px; font-weight: bold; border-radius: 5px; font-size: 12px; float: left border-radius: 5px" href="randevuislem?randevuincele=<?php echo  $gecmisRandevu['r_id']?>">İncele</a>
                                    </li>
                                </ul>
                            </center>
                        </div>
                        <?php
                    }
                }
            }

        else{
            ?>
            <p style="color:gray;">Geçmiş Randevunuz yok.</p>
            <?php
        }
        ?>
    </center>
</div>
<div style="clear:both;"></div>
</body>
</div>
</div>
