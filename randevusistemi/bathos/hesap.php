<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;

if(isset($_SESSION['logged'])){ //Kullanıcının çerezlerine bakıyoruz. Girişliyse işlem yaptırtıyoruz.
    include "query.php"; //Bilgileri çekiyoruz.

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
    if (isset($_POST['guncelleparola'])){
        if ($_POST['yeniparola'] != ""){
            $eskiparola = $_POST['eskiparola'];
            $yeniparola = $_POST['yeniparola'];
            $yeniparolacheck = $_POST['yeniparolacheck'];
            if ($eskiparola != $parola){
                ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Hata!</strong> Eski parolanız eşleşmedi.
                </div>
                <?php
            }
            else{
                if ($yeniparola != $yeniparolacheck){
                    ?>
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                        <strong>Hata!</strong> Yeni parolalarınız eşleşmedi.
                    </div>
                    <?php
                }
                else{
                    $update = $DB_connect->prepare("UPDATE `vatandas` SET parola = :yeniparola WHERE v_id = :v_id");
                    if ($update->execute(array(':v_id' => $v_id, ':yeniparola' => $yeniparola))){
                        ?>
                        <div class="basari">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                            <strong>Başarılı!</strong> Parolanız güncellendi.
                        </div>
                        <?php
                    }
                    else{
                        ?>
                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                            <strong>Hata!</strong> Beklenmeyen bir hata meydana geldi. Hata Kodu: BHS02.
                        </div>
                        <?php
                    }
                }
            }
        }
        else{
            ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Hata!</strong> Boş alanları kontrol ediniz..
            </div>
            <?php
        }
    }

}
else{
    header("location: giriskayit"); //Kullanıcı giriş yapmadan bir şekilde buraya geldi. Ona menüyü göstermeden giriş sayfasına yönlendiriyoruz.
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

  <link rel="stylesheet" href="style.css"/>



  <div id="pencerekodu">
      <label for="koddostu-ampshadow" class="dugmetani" style="background: url(images/id-card.png) no-repeat scroll 15px 20px; width: 500px; height: 100px; font-size: 20px; font-weight: bold; color: white; background-color: #46b5af; border: none; border-radius: 15px; margin-top: 30px; margin-left: 200px;" >Kimlik Bilgileri</label>
      <input type="checkbox" class="Pencereac" id="koddostu-ampshadow" name="koddostu-ampshadow"></input>
      <label class="koddostu-ampshadow">
          <div class="koddostu-ampwindow">
              <div class="koddostu-p16"">
              T.C Kimlik No:
              <input class="form-control" value="<?php echo $tckno?>" disabled>
              <br>
              Adı:
              <input class="form-control" value="<?php echo $ad?>" disabled>
              <br>
              Soyad:
              <input class="form-control" value="<?php echo $soyad?>" disabled>
              <br>
              Cinsiyet:
              <input class="form-control" value="<?php echo $cinsiyet?>" disabled>
              <br>
              Doğum Tarihi:
              <input class="form-control" value="<?php echo $dogumtarih?>" disabled>
              <label for="koddostu-ampshadow" class="dugme">Kapat</label>
              </div>
          </div>
      </label>
  </div>

  <div id="pencerekodu2">
      <label for="koddostu-ampshadow2" class="dugmetani" style="background: url(images/phone-contact.png) no-repeat scroll 15px 20px; width: 500px; height: 100px; font-size: 20px; font-weight: bold; color: white; background-color: #46b5af; border: none; border-radius: 15px;  margin-left: 90px;">İletişim Bilgileri</label>
      <input type="checkbox" class="Pencereac" id="koddostu-ampshadow2" name="koddostu-ampshadow2"></input>
      <label class="koddostu-ampshadow">
          <div class="koddostu-ampwindow">
              <div class="koddostu-p16"">
              Telefon Numarası:
              <input class="form-control" value="<?php echo $telno?>" disabled>
              <br>
              E-Posta Bilgileri:
              <input class="form-control" value="<?php echo $email?>" disabled>
              <label for="koddostu-ampshadow2" class="dugme">Kapat</label>
              </div>
          </div>
      </label>
  </div>

  <div id="pencerekodu3">
      <label for="koddostu-ampshadow3" class="dugmetani" style="background: url(images/padlock.png) no-repeat scroll 15px 20px; width: 500px; height: 100px; font-size: 20px; font-weight: bold; color: white; background-color: #46b5af; border: none; border-radius: 15px; margin-top: 70px; margin-left: 200px;">Parola İşlemleri</label>
      <input type="checkbox" class="Pencereac" id="koddostu-ampshadow3" name="koddostu-ampshadow3"></input>
      <label class="koddostu-ampshadow">
          <div class="koddostu-ampwindow">
              <div class="koddostu-p16"">
              <form method="post" action="">
                  Eski Parolanız:
                  <input class="form-control" name="eskiparola" placeholder="Eski Parolanız">
                  <br>
                  Yeni Parola:
                  <input class="form-control" name="yeniparola" placeholder="Yeni Parolanız">
                  <br>
                  Tekrar Yeni Parola:
                  <input class="form-control" name="yeniparolacheck" placeholder="Tekrar Yeni Parolanız">
                  <br>
                  <input type="submit" name="guncelleparola" id="guncelleparola" class="form-control" value="Güncelle">
              </form>
                <label for="koddostu-ampshadow3" class="dugme">Kapat</label>
              </div>
          </div>
      </label>
  </div>

  <div id="pencerekodu4">
      <label for="koddostu-ampshadow4" class="dugmetani" style="background: url(images/secure.png) no-repeat scroll 15px 20px; width: 500px; height: 100px; font-size: 20px; font-weight: bold; color: white; background-color: #46b5af; border: none; border-radius: 15px; margin-top: 70px; margin-left: 90px;" >İleri Seviye Güvenlik</label>
      <input type="checkbox" class="Pencereac" id="koddostu-ampshadow4" name="koddostu-ampshadow4"></input>
      <label class="koddostu-ampshadow">
          <div class="koddostu-ampwindow">
              <div class="koddostu-p16"">
              <label class="form-control">ÇOK YAKINDA...</label>
              <label for="koddostu-ampshadow4" class="dugme">Kapat</label>
              </div>
          </div>
      </label>
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

