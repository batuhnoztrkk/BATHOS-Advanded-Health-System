<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;
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

if (isset($_GET['randevuincele'])){
    $urlincele = $_GET['randevuincele'];
    $incele_check = $DB_connect->prepare('SELECT * FROM randevular WHERE r_id = :r_id');
    $incele_check->execute(array(':r_id' => $urlincele));
    $incelecheck = $incele_check->fetch(PDO::FETCH_ASSOC);

    $kullanıcı_check = $DB_connect->prepare('SELECT tckno FROM vatandas WHERE v_id = :v_id');
    $kullanıcı_check->execute(array(':v_id' => $_SESSION['logged']));
    $kullanıcıcheck = $kullanıcı_check->fetch(PDO::FETCH_ASSOC);

    if ($incelecheck['tckno'] != $kullanıcıcheck['tckno']){
        ?>
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
            <strong>Hata!</strong> Hatalı randevu inceleme işlemi. Size ait bir randevu için inceleme yapınız.
        </div>
        <?php
        header("Refresh:2; url=MerkeziHekimRandevuSistemi", true, 303);
        die();
    }

    $randevu_bilgileri = $DB_connect->prepare('SELECT * FROM randevusonuc WHERE r_id = :r_id');
    $randevu_bilgileri->execute(array(':r_id' => $urlincele));
    $randevubilgileri = $randevu_bilgileri->fetch(PDO::FETCH_ASSOC);

    $recete_bilgileri = $DB_connect->prepare('SELECT * FROM recete WHERE r_id = :r_id');
    $recete_bilgileri->execute(array(':r_id' => $urlincele));
    $recetebilgileri = $recete_bilgileri->fetch(PDO::FETCH_ASSOC);

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

            <br>

            <br><br>

            <hr size="10" color="9fdae7">

            <div id="pencerekodu">
                <label for="koddostu-ampshadow" class="dugmetani">Tanı</label>
                <input type="checkbox" class="Pencereac" id="koddostu-ampshadow" name="koddostu-ampshadow"></input>
                <label class="koddostu-ampshadow">
                    <div class="koddostu-ampwindow">
                        <div class="koddostu-p16"">
                        <center>
                            <table border="15" width="950px" bordercolor="#e8e8e8" style="overflow: hidden;">
                                <form method="post" action="">
                                    <tr>
                                        <td align="center" width="200px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Hasta Şikayeti</td>
                                        <td align="center"><input type="text" class="form-control" name="t_sikayet" id="sikayet" value="<?php echo $randevubilgileri['hasta_sikayeti'] ?>" style="max-width: 90%;" disabled></td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Yapılan Muayene</td>
                                        <td align="center"><input type="text" class="form-control" name="t_muayene" id="t_muayene" value="<?php echo $randevubilgileri['yapilan_muayene'] ?>" style="max-width: 90%;" disabled></td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Yapılan Tahliller</td>
                                        <td align="center"><input type="text" class="form-control" name="t_tahlil" id="t_tahlil" value="<?php echo $randevubilgileri['yapilan_tahliller'] ?>" style="max-width: 90%;" disabled></td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Röntgen/Tomografi</td>
                                        <td align="center"><input type="text" class="form-control" name="t_radyoloji" id="t_radyoloji" value="<?php echo $randevubilgileri['radyolojik_sonuclar'] ?>" style="max-width: 90%;" disabled></td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Tanı</td>
                                        <td align="center"><input type="text" class="form-control" name="t_tani" id="t_tani" value="<?php echo $randevubilgileri['tani'] ?>" style="max-width: 90%;" disabled></td>
                                    </tr>
                                </form>
                            </table>
                        </center>
                        <label for="koddostu-ampshadow" class="dugme">Kapat</label>
                    </div>
            </div>
            </label>
        </div>

        <div id="pencerekodu2">
            <label for="koddostu-ampshadow2" class="dugmetahlil">Tahlil Sonuçları</label>
            <input type="checkbox" class="Pencereac" id="koddostu-ampshadow2" name="koddostu-ampshadow2"></input>
            <label class="koddostu-ampshadow">
                <div class="koddostu-ampwindow">
                    <div class="koddostu-p16">

                        <label for="koddostu-ampshadow2" class="dugme">Kapat</label>
                    </div>
                </div>
            </label>
        </div>
        <br><br><br><br><br>
        <div id="pencerekodu3">
            <label for="koddostu-ampshadow3" class="dugmeradyo">Radyoloji Sonuçları</label>
            <input type="checkbox" class="Pencereac" id="koddostu-ampshadow3" name="koddostu-ampshadow3"></input>
            <label class="koddostu-ampshadow">
                <div class="koddostu-ampwindow">
                    <div class="koddostu-p16">

                        <label for="koddostu-ampshadow3" class="dugme">Kapat</label>
                    </div>
                </div>
            </label>
        </div>

        <div id="pencerekodu4">
            <label for="koddostu-ampshadow4" class="dugmerecete">Reçetem</label>
            <input type="checkbox" class="Pencereac" id="koddostu-ampshadow4" name="koddostu-ampshadow4"></input>
            <label class="koddostu-ampshadow">
                <div class="koddostu-ampwindow">
                    <div class="koddostu-p16">
                        <!--/////////////////////////////////////////////////////////////////////////////////////////////////////-->
                        <link rel="stylesheet" href="style.css"/>
                        <h4>Reçete</h4>
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
                                        <input type="text" name="ilacara" id="ilacara" class="input" value="<?php echo $recetebilgileri['ilac_adi'] ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="aciklama" id="aciklama" class="form-control" value="<?php echo $recetebilgileri['aciklama'] ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="doz" id="doz" class="form-control" value="<?php echo $recetebilgileri['doz'] ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="periyot" id="periyot" class="form-control" value="<?php echo $recetebilgileri['periyot'] ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="kullanimsekli" id="kullanimsekli" class="form-control" value="<?php echo $recetebilgileri['kullanim_sekli'] ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="kullanimsayisi" id="kullanimsayisi" class="form-control" value="<?php echo $recetebilgileri['kullanim_sayisi'] ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="kutuadedi" id="kutuadedi" class="form-control" value="<?php echo $recetebilgileri['kutu_adedi'] ?>" disabled>
                                    </td>
                                </tr>
                            </table>
                            <div id="sonuclar"><ul></ul></div>
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

    <?php
}







if (isset($_GET['randevuiptal'])){
    $urliptal = $_GET['randevuiptal'];
    $iptal_check = $DB_connect->prepare('SELECT * FROM randevular WHERE r_id = :r_id');
    $iptal_check->execute(array(':r_id' => $urliptal));
    $iptalcheck = $iptal_check->fetch(PDO::FETCH_ASSOC);

    $kullanıcı_check = $DB_connect->prepare('SELECT tckno FROM vatandas WHERE v_id = :v_id');
    $kullanıcı_check->execute(array(':v_id' => $_SESSION['logged']));
    $kullanıcıcheck = $kullanıcı_check->fetch(PDO::FETCH_ASSOC);
    if ($iptalcheck['tckno'] != $kullanıcıcheck['tckno']){
        ?>
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
            <strong>Hata!</strong> Hatalı randevu iptal işlemi. Size ait bir randevu için iptal işlemi başlatınız.
        </div>
        <?php
        header("Refresh:2; url=MerkeziHekimRandevuSistemi", true, 303);
        die();
    }
    if (isset($_POST["iptalet"])){
        $randevu_iptal = $DB_connect->prepare('UPDATE randevular SET durum = :durum WHERE r_id = :r_id');
        if ($randevu_iptal->execute(array(':r_id' => $urliptal, ":durum" => "3"))){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Randevu iptal edildi!</strong> Aşağıdaki bilgilere sahip randevunuz iptal edildi. Anasayfaya yönlendiriliyorsunuz.
            </div>
            <?php
            header("Refresh:2; url=MerkeziHekimRandevuSistemi", true, 303);
        }
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
            <h1 class="font-weight-semibold">BATHOS | Türkiye'nin En Gelişmiş Sağlık Uygulaması</h1>
            <h6 class="font-weight-normal text-muted pb-3">Türkiye'nin en gelişmiş sağlık sistemi.</h6>

            <br>
            <form method="post" action="">
                <div style="float: center;width: 100%">
                    <div class="container">
                        <div class="column">
                            <form method="post" action="">
                                <div class="koddostu-ampwindow">
                                    <div class="koddostu-p16">
                                        <h6 style="font-weight: bold">Randevuyu iptal etmek istediğine emin misin?</h6>
                                        <br>
                                        <center>
                                            <table border="1" width="315px" bordercolor="#e8e8e8" style="overflow: hidden; border-radius: 10px;" >
                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Randevu Zamanı</td>
                                                    <td align="center" style="font-weight: bold; font-size: 14px;"><?php echo $iptalcheck['tarih']." ".$iptalcheck['saat'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Randevu Türü</td>
                                                    <td align="center" style="color: #ff0000; ">Muayene</td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Hastahane</td>
                                                    <td align="center" style="color: #959595; font-size: 14px;"><?php echo $iptalcheck['hastahane'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Poliklinik Adı</td>
                                                    <td align="center" style="color: black; font-weight: bold; font-size: 14px;"><?php echo $iptalcheck['klinik'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Hekim Bilgileri</td>
                                                    <td align="center" style="color: #959595; font-size: 14px;"><?php echo $iptalcheck['hekim'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Randevu Sahibi</td>
                                                    <td align="center" style="color: #959595; font-size: 14px;"><?php echo $ad." ".$soyad ?></td>
                                                </tr>
                                            </table>
                                            <br>
                                            <input type="submit" name="iptalet" id="iptalet" class="form-control" value="İptal Et" style="background-color: rosybrown; color: white">
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>


    <script src="../vendors/jquery/jquery.min.js"></script>
    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="../vendors/aos/js/aos.js"></script>
    <script src="../js/landingpage.js"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){

            $("#tarih").on("change", function(){

                $("#saatsec").attr("disabled", false);
                ajaxFunc("tarih", $(this).val(), "#tarih");

            });

            function ajaxFunc(action, name, id ){
                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {action:action, name:name},
                    success: function(sonuc){
                        $.each($.parseJSON(sonuc), function(index, value){
                            var row="";
                            row +='<option value="'+value+'">'+value+'</option>';
                            $(id).append(row);
                        });
                    }});
            }
        });
    </script>

    <style>

        .dugme {
            cursor: pointer;
            display: inline-block;
            padding: 8px 12px;
            background: #F4511E;
            font-family:Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #fff;
            -webkit-border-radius: 3px;
            border-radius: 3px
        }
        [name="kapat"] {
            position: absolute;
            bottom: 20px;
            right: 20px
        }
        .koddostu-ampshadow {
            display:none;
            opacity:0
        }
        .Pencereac {
            width: 1px;
            height: 1px;
            visibility: hidden
        }
        .Pencereac:checked + .koddostu-ampshadow {
            display: block;
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.3);
            transition: opacity 0.6s ease;
            top: 0;
            left: 0;
            z-index: 9;
            opacity: 1
        }
        .koddostu-ampwindow{
            position:relative;
            background:#fff;
            width:350px;
            min-height:460px;
            max-width:86%;
            max-height:86%;
            margin:15px auto;
            box-shadow: 0 0 6px 2px rgba(0,0,0,.4);
            -webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,.4);
            -webkit-border-radius: 3px;
            border-radius: 3px
        }
        .koddostu-p16{padding:16px}

        .koddostu-ampwindow .dugme{
            position:absolute;
            bottom:16px;
            right:16px;
        }
    </style>
    </body>
    </div>
    </div>
    </html>
    <?php
}
?>
