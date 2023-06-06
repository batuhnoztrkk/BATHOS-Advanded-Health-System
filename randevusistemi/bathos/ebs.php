<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;

if(isset($_SESSION['logged'])){ //Kullanıcının çerezlerine bakıyoruz. Girişliyse işlem yaptırtıyoruz.
    include "query.php"; //Bilgileri çekiyoruz.
    if ($role == 2){
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
        if (isset($_POST['sorgula'])){
            $hastatckno = $_POST['hastatckimlik'];
            $recete_bilgi = $DB_connect->prepare('SELECT * FROM recete WHERE hasta_tckno = :hasta_tckno ORDER BY recete_id ASC');
            $recete_bilgi->execute(array(':hasta_tckno' => $hastatckno));
            if ($recete_bilgi->rowCount()){

                include "recetever.php";
                die();
            }
            else{
                ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Reçete Bulunamadı!</strong> Bu hastaya ait reçete bilgisi bulunmamaktadır.
                </div>
                <?php
            }
        }
    }
    else{
        header("Refresh:1; url= ../", true, 303);
        die();
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
    </div>
    <br><br>


    <div class="container">
        <form method="post" action="">
            <h4 class="font-weight-normal text-muted pb-3">Reçete Sorgulama</h4>
            <input type="text" name="hastatckimlik" class="form-control" placeholder="Hasta T.C Kimlik Numarası">
            <input type="submit" name="sorgula" class="form-control" value="SORGULA">
        </form>
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


