<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;
include "query.php";
include "hekimquery.php";
$hekim_kntrl = $DB_connect->prepare('SELECT * FROM hekimbilgiler WHERE h_tc = :h_tc');
$hekim_kntrl->execute(array(':h_tc' => $tckno));
$hekimsonuc = $hekim_kntrl->rowCount();

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

    if (!$hekimsonuc){
        ?>
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
            <strong>Hata!</strong> Doğrulama için aşağıdaki alanda sicil numaranızı girmeniz gerekmektedir. Doğrulama sonucunda Hekim Bilgi Sistemine giriş sağlayabilirsiniz.
        </div>
        <?php
        header("Refresh:3; url= MerkeziHekimRandevuSistemi", true, 303);
        die();
    }
    else{
        $hekim = mb_strtoupper($ad." ".$soyad);
        $kntrl_randevu = $DB_connect->prepare('SELECT * FROM randevular WHERE hastahane = :hastahane AND klinik = :klinik AND hekim = :hekim ORDER BY saat ASC');
        $kntrl_randevu->execute(array(':hastahane' => $h_hastahane, ":klinik" => $h_klinik, ":hekim" => $hekim));

        if (isset($_POST['hastacagir'])){//Hastaya SMS gidebilir...
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Hasta Çağırıldı</strong> Hasta takip ekranında hasta çağırıldı...
            </div>
            <?php
        }
        if (isset($_POST['p_giris'])){
            $hastatckno = $_POST['p_tckno'];
            $v_bilgi = $DB_connect->prepare('SELECT * FROM vatandas WHERE tckno = :tckno');
            $v_bilgi->execute(array(':tckno' => $hastatckno));
            if ($v_bilgi->rowCount()){
                $hekim = mb_strtoupper($ad." ".$soyad);
                $tarih = date("Y-m-d");
                $saat = date("H:i");
                $durum = "4";
                $d_not = "Randevu hekim tarafından oluşturuldu.";
                $randevu_Ekle = $DB_connect->prepare("INSERT INTO randevular (tckno, hastahane, klinik, hekim, tarih, saat, onaytarih, d_not, durum) VALUES (:tckno, :hastahane, :klinik, :hekim, :tarih, :saat, :onaytarih, :d_not, :durum)");
                $randevu_Ekle->bindParam( ':tckno', $hastatckno);
                $randevu_Ekle->bindParam( ':hastahane', $h_hastahane);
                $randevu_Ekle->bindParam( ':klinik', $h_klinik);
                $randevu_Ekle->bindParam( ':hekim', $hekim);
                $randevu_Ekle->bindParam( ':tarih', $tarih);
                $randevu_Ekle->bindParam( ':onaytarih', $tarih);
                $randevu_Ekle->bindParam( ':saat', $saat);
                $randevu_Ekle->bindParam( ':durum', $durum);
                $randevu_Ekle->bindParam( ':d_not', $d_not);
                if($randevu_Ekle->execute()){
                    ?>
                    <div class="basari">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                        <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Günlük Randevu listesinden işlem yapabilirsiniz.
                    </div>
                    <?php
                    header("Refresh:2; url=", true, 303);
                } else{
                    ?>
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                        <strong>Hata!</strong> Database hatası gerçekleşti. Lütfen daha sonra tekrar deneyiniz.
                    </div>
                    <?php
                }
            }
            else{
                ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Hata!</strong> Hatalı T.C. kimlik numarası. Lütfen kontrol ediniz.
                </div>
                <?php
            }
        }
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

        <h4 style="color: grey;">Günlük Randevulu Hasta Listesi <strong><?php echo date("d/m/Y")?></strong></h4>
        <table border="25" width="1100px" bordercolor="#e8e8e8" style="overflow: hidden;">
            <tr>
                <td align="center" width="10px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Sıra No</td>
                <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Randevu Zamanı</td>
                <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Hasta İsim/Soyisim</td>
                <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">Hastanın Notu</td>
                <td align="center" width="150px" height="60px" style="background-color: #fafafa; margin-right: 10px; font-weight: bold;">İşlem</td>
            </tr>

            <?php
            $sirano = 1;
            while ($gunlukliste = $kntrl_randevu->fetch(PDO::FETCH_ASSOC)) {
                if ($gunlukliste['durum'] == 0 || $gunlukliste['durum'] == 4){
                    if (strtotime($gunlukliste['tarih']) == strtotime(date("Y-m-d"))){
                        $v_bilgi_check = $DB_connect->prepare('SELECT v_id, ad, soyad FROM vatandas WHERE tckno = :tckno');
                        $v_bilgi_check->execute(array(":tckno" => $gunlukliste['tckno']));
                        $vbilgicheck = $v_bilgi_check->fetch(PDO::FETCH_ASSOC);

                        $adsoyad = $vbilgicheck['ad']." ".$vbilgicheck['soyad']." [".$gunlukliste['tckno']."]";
                        $randevuzamani = $gunlukliste['tarih']." ".$gunlukliste['saat'];
                        $hastanotu = $gunlukliste['d_not'];
                        $v_id = $vbilgicheck['v_id'];
                        ?>
                        <tr>
                            <td align="center" width="75px" height="50px" style="margin-right: 10px;"><?php echo $sirano ?></td>
                            <td align="center" width="75px" height="50px" style=""><?php echo $randevuzamani ?></td>
                            <td align="center" style=""><?php echo $adsoyad ?></td>
                            <td align="center" width="75px" style="margin-right: 10px;"><?php echo $hastanotu ?></td>
                            <td align="center" width="75px" style="margin-right: 10px;">
                                <form method="post">
                                    <?php
                                        if ($gunlukliste['durum'] != 4){
                                            ?><input type="submit" value="Çağır" name="hastacagir" class="form-control" style="width: 60px; float: left; margin-left: 20px; margin-top: 8px; margin-bottom: 8px; background-color: darkgreen; color:white;"><?php
                                        }
                                    ?>
                                </form>
                                <a type="submit" href="hekimislem?muayene=<?php echo $v_id ?>" class="form-control" style="width: 90px; float: right; margin-right: 20px; margin-top: 8px; margin-bottom: 8px; background-color: orangered; color: white;">Muayene</a>
                            </td>
                        </tr>
                        <?php
                        $sirano = $sirano+1;
                    }
                }
            }
            ?>
        </table>

        <br><br>

        <hr size="10" color="9fdae7">

        <h4 style="color: grey;">Plansız Muayeneye Gelen Hastalar</h4>
        <center>
            <form action="" method="post">
                <div class="col-md-3">
                    <label for="tckno"></label>
                    <input type="text" name="p_tckno" class="form-control" placeholder="Hasta T.C. Kimlik Numarası" minlength="11" maxlength="11" pattern="\d{11}" title="TC Kimlik Numarası 11 haneli sayıdan oluşmalıdır." required>
                </div>
                <div class="col-md-3">
                    <label for="tckno"></label>
                    <input type="submit" name="p_giris" class="form-control" value="Giriş">
                </div>
            </form>
            <br>
        </center>
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
        <script>
            $(document).ready(function(){
                ajaxFunc("il", "", "#il");



                $("#il").on("change", function(){

                    $("#ilce").attr("disabled", false).html("<option value='' selected hidden>İlçe Seçiniz..</option>");
                    console.log($(this).val());
                    ajaxFunc("ilce", $(this).val(), "#ilce");

                });

                $("#ilce").on("change", function(){

                    $("#hastahane").attr("disabled", false).html("<option value='' selected hidden>Hastahane Seçiniz..</option>");
                    console.log($(this).val());
                    ajaxFunc("hastahane", $(this).val(), "#hastahane");

                });

                $("#hastahane").on("change", function(){

                    $("#klinik").attr("disabled", false).html("<option value='' selected hidden>Klinik Seçiniz..</option>");
                    console.log($(this).val());
                    ajaxFunc("klinik", $(this).val(), "#klinik");

                });

                $("#klinik").on("change", function(){

                    $("#hekim").attr("disabled", false).html("<option value='' selected hidden>Hekim Seçiniz..</option>");
                    console.log($(this).val());
                    ajaxFunc("hekim", $(this).val(), "#hekim");

                });

                $("#hekim").on("change", function(){

                    $("#tarih").attr("disabled", false);
                    console.log($(this).val());
                    ajaxFunc("hekimsession", $(this).val(), "#hekimsession");

                });

                $("#tarih").on("change", function(){
                    console.log($(this).val());
                    ajaxFunc("tarih", $(this).val(), "#tarih");
                    $("#sorgula").attr("disabled", false);

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
        </body>
</html>
