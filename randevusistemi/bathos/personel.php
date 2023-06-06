<?php

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

    $hekim_kntrl = $DB_connect->prepare('SELECT * FROM hekimbilgiler WHERE h_tc = :h_tc');
    $hekim_kntrl->execute(array(':h_tc' => $tckno));
    $hekimsonuc = $hekim_kntrl->rowCount();

    $eczacı_kntrl = $DB_connect->prepare('SELECT * FROM eczacıbilgiler WHERE e_tc = :e_tc');
    $eczacı_kntrl->execute(array(':e_tc' => $tckno));
    $eczacısonuc = $eczacı_kntrl->rowCount();

    $hbi_kntrl = $DB_connect->prepare('SELECT * FROM hbibilgiler WHERE hbi_tc = :hbi_tc');
    $hbi_kntrl->execute(array(':hbi_tc' => $tckno));
    $hbisonuc = $hbi_kntrl->rowCount();

    if (isset($_POST['cikis'])){ //ÇIKIŞ BUTONU
        ?>
        <div class="basari">
            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
            <strong>Başarılı!</strong> Başarıyla çıkış yapıldı.
        </div>
        <?php
        session_destroy();
        header("Refresh:1; url= ../", true, 303);
        die();
    }


    if (isset($_POST['bathos'])){
        if ($role == 1){
            if (!$hekimsonuc){
                ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Hata!</strong> Doğrulama için aşağıdaki alanda sicil numaranızı girmeniz gerekmektedir. Doğrulama sonucunda Hekim Bilgi Sistemine giriş sağlayabilirsiniz.
                </div>
                <?php
            }
            else{
                header("Refresh:1; url= HekimBilgiSistemi", true, 303);
                die();
            }
        }
        elseif ($role == 2){

            if (!$eczacısonuc){
                ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Hata!</strong> Doğrulama için aşağıdaki alanda sicil numaranızı, Eczane Şehir, Eczane isim ve vergi no girmeniz gerekmektedir. Doğrulama sonucunda Eczane Sistemine giriş sağlayabilirsiniz.
                </div>
                <?php
            }
            else{
                header("Refresh:1; url= EczaneBilgiSistemi", true, 303);
                die();
            }
        }
        elseif ($role == 3){
            if (!$hbisonuc){
                ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Hata!</strong> Doğrulama için aşağıdaki alanda sicil numaranızı, Hastahane Şehir, Hastahane isim ve Sigorta no girmeniz gerekmektedir. Doğrulama sonucunda Hastahane Bilgi İşlem sistemine giriş sağlayabilirsiniz.
                </div>
                <?php
            }
            else{
                header("Refresh:1; url= HastahaneBilgiIslem", true, 303);
                die();
            }
        }

    }

    if (isset($_POST['randevual'])){ //RANDEVUAL BUTONU
        header("Refresh:1; url= personelrandevu", true, 303);
        die();
    }

    if (isset($_POST['doğrulahekim'])){
        $dogrulahekim = $DB_connect->prepare("INSERT INTO hekimbilgiler (h_tc, h_il, h_ilce, h_hastahane, h_klinik, h_sicilno) VALUES (:h_tc, :h_il, :h_ilce, :h_hastahane, :h_klinik, :h_sicilno)");
        $dogrulahekim->bindParam( ':h_tc', $tckno);
        $dogrulahekim->bindParam( ':h_il', $_POST['il']);
        $dogrulahekim->bindParam( ':h_ilce', $_POST['ilce']);
        $dogrulahekim->bindParam( ':h_hastahane', $_POST['hastahane']);
        $dogrulahekim->bindParam( ':h_klinik', $_POST['klinik']);
        $dogrulahekim->bindParam( ':h_sicilno', $_POST['sicilnohekim']);
        if($dogrulahekim->execute()) {
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Bilgileriniz doğrulandı. Randevu ve Hekim Bilgi Sistemine ulaşabilirsiniz...
            </div>
            <?php
            header("Refresh:1; url=", true, 303);
        }
        else{
            ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Hata!</strong> Bir hata meydana geldi. Daha sonra tekrar deneyiniz veya iletişime geçiniz. (yardim@bathos.com)
            </div>
            <?php
        }
    }
    elseif (isset($_POST['doğrulaeczacı'])){
        $dogrulaeczacı = $DB_connect->prepare("INSERT INTO eczacıbilgiler (e_tc, e_sicilno, eczaneil, eczaneilce, eczaneisim, eczanevergino) VALUES (:e_tc, :e_sicilno, :eczaneil, :eczaneilce, :eczaneisim, :eczanevergino)");
        $dogrulaeczacı->bindParam( ':e_tc', $tckno);
        $dogrulaeczacı->bindParam( ':e_sicilno', $_POST['sicilnoeczacı']);
        $dogrulaeczacı->bindParam( ':eczaneil', $_POST['il']);
        $dogrulaeczacı->bindParam( ':eczaneilce', $_POST['ilce']);
        $dogrulaeczacı->bindParam( ':eczaneisim', $_POST['eisim']);
        $dogrulaeczacı->bindParam( ':eczanevergino', $_POST['evergino']);
        if($dogrulaeczacı->execute()) {
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Bilgileriniz doğrulandı. Randevu ve Eczane Bilgi Sistemine ulaşabilirsiniz...
            </div>
            <?php
            header("Refresh:1; url=", true, 303);
        }
        else{
            ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Hata!</strong> Bir hata meydana geldi. Daha sonra tekrar deneyiniz veya iletişime geçiniz. (yardim@bathos.com)
            </div>
            <?php
        }
    }
    elseif (isset($_POST['doğrulahbi'])){
        $dogrulahbi = $DB_connect->prepare("INSERT INTO hbibilgiler (hbi_tc, hastahaneil, hastahaneilce, hastahaneisim, hbi_sicilno, sigortano) VALUES (:hbi_tc, :hastahaneil, :hastahaneilce, :hastahaneisim, :hbi_sicilno, :sigortano)");
        $dogrulahbi->bindParam( ':hbi_tc', $tckno);
        $dogrulahbi->bindParam( ':hastahaneil', $_POST['il']);
        $dogrulahbi->bindParam( ':hastahaneilce', $_POST['ilce']);
        $dogrulahbi->bindParam( ':hastahaneisim', $_POST['hastahane']);
        $dogrulahbi->bindParam( ':hbi_sicilno', $_POST['sicilnohbi']);
        $dogrulahbi->bindParam( ':sigortano', $_POST['signohbi']);
        if($dogrulahbi->execute()) {
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Bilgileriniz doğrulandı. Randevu ve Hastahane Bilgi İşlem sistemine ulaşabilirsiniz...
            </div>
            <?php
            header("Refresh:1; url=", true, 303);
        }
        else{
            ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Hata!</strong> Bir hata meydana geldi. Daha sonra tekrar deneyiniz veya iletişime geçiniz. (yardim@bathos.com)
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
    <title>BATHOS | Türkiye'nin En Gelişmiş Sağlık Uygulaması | PERSONEL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script src="randevu.js"></script>
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
                            <input type="submit" name="anasayfa" class="nav-link" style=" border: none; background: url(images/randevubilgileri.png) no-repeat scroll 6px 6px; padding-top:2px; padding-left:30px; border-radius: 10px; margin-right: 600px; background-color: #ded7d7; height: 30px;" value="Randevu Al">
                        </form>
                    </li>

                    <?php
                    if ($role == 1){
                        ?>
                        <li class="nav-item">
                            <form method="post" action="">
                                <input type="submit" name="hbs" class="nav-link" style=" border: none; background: url(images/hesapbilgileri.png) no-repeat scroll 6px 6px; padding-top:2px; padding-left:30px; border-radius: 10px; margin-left: -570px; background-color: #ded7d7; height: 30px;" value="Hekim Bilgi Sistemi">
                            </form>
                        </li>
                        <?php
                    }
                    elseif ($role == 2){
                        ?>
                        <li class="nav-item">
                            <form method="post" action="">
                                <input type="submit" name="ebs" class="nav-link" style=" border: none; background: url(images/hesapbilgileri.png) no-repeat scroll 6px 6px; padding-top:2px; padding-left:30px; border-radius: 10px; margin-left: -570px; background-color: #ded7d7; height: 30px;" value="Eczane Bilgi Sistemi">
                            </form>
                        </li>
                        <?php
                    }
                    elseif ($role == 3){
                        ?>
                        <li class="nav-item">
                            <form method="post" action="">
                                <input type="submit" name="hbi" class="nav-link" style=" border: none; background: url(images/hesapbilgileri.png) no-repeat scroll 6px 6px; padding-top:2px; padding-left:30px; border-radius: 10px; margin-left: -570px; background-color: #ded7d7; height: 30px;" value="Hastahane Bilgi İşlem">
                            </form>
                        </li>
                        <?php
                    }
                    ?>


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
        <h1 class="font-weight-semibold">BATHOS | Türkiye'nin En Gelişmiş Sağlık Uygulaması | PERSONEL</h1>
        <h6 class="font-weight-normal text-muted pb-3">Türkiye'nin en gelişmiş sağlık sistemi.</h6>

            <center>
                <form action="" method="post">
                    <input type="submit" name="randevual" value="Randevu Al" style="background: url(images/personelrandevu.png) no-repeat scroll 15px 20px; width: 500px; height: 100px; font-size: 20px; font-weight: bold; color: white; background-color: #be191d; border: none; border-radius: 15px; margin-bottom: 30px;">
                    <input type="submit" name="bathos"
                    style="background: url(images/personelhekim.png) no-repeat scroll 15px 20px; width: 500px; height: 100px; font-size: 20px; font-weight: bold; color: white; background-color: #46b0ac; border: none; border-radius: 15px; margin-left: 30px; margin-bottom: 30px;" value="
                    <?php
                    if ($role == 1){
                        echo "Hekim Bilgi Sistemi";
                    }
                    elseif($role == 2){
                        echo "Eczane Bilgi Sistemi";
                    }
                    elseif($role == 3){
                        echo "Hastahane Bilgi İşlem";
                    }
                    ?>">
                </form>
        <div style="clear:both;"></div>

        <hr>

                <?php
                if ($role == 1){
                    if (!$hekimsonuc){
                        ?>
                        <h3 style="color: indianred; font-weight: bold">Doğrulama Yapın</h3>

                        Sayın <strong><?php echo mb_strtoupper($ad . " " . $soyad); ?>.</strong> Doğrulama için Hekim Sicil Numaranızı aşağıdaki alana girmeniz gerekmektedir.
                                                                                                 Bilgiyi girdiğiniz andan itibaren Hekim Bilgi Sistemini kullanabileceksiniz.
                        <br><br>
                        <form action="" method="post">
                            <div class="col-md-3">
                                <label for="il"></label>
                                <select name="il" id="il" class="form-control"required>
                                    <option value="" selected hidden>İl Seçiniz..</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="ilce"></label>
                                <select name="ilce" id="ilce" class="form-control" disabled="disabled" required>
                                    <option value="" selected hidden>İlçe Seçiniz..</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="hastahane"></label>
                                <select name="hastahane" id="hastahane" class="form-control" disabled="disabled" required>
                                    <option value="" selected hidden>Hastahane Seçiniz..</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="klinik"></label>
                                <select name="klinik" id="klinik" class="form-control" disabled="disabled" required>
                                    <option value="" selected hidden>Klinik Seçiniz..</option>
                                </select>
                            </div>
                            <input type="text" name="sicilnohekim" placeholder="Hekim Sicil Numarası" style="border-radius: 10px; color: rosybrown" required>
                            <input type="submit" name="doğrulahekim" value="Doğrula" style="border-radius: 10px; color: rosybrown">
                        </form>
                        <br><br>
                        <?php
                    }
                }
                elseif($role == 2){
                    if (!$eczacısonuc){
                        ?>
                        <h3 style="color: indianred; font-weight: bold">Doğrulama Yapın</h3>

                        Sayın <strong><?php echo mb_strtoupper($ad . " " . $soyad); ?>.</strong> Doğrulama için aşağıdaki bilgileri girmeniz gerekmektedir.
                                                                                                 Bilgiyi girdiğiniz andan itibaren Eczane Bilgi Sistemini kullanabileceksiniz.
                        <br><br>
                        <form action="" method="post">

                            <div class="col-md-3">
                                <label for="il"></label>
                                <select name="il" id="il" class="form-control"required>
                                    <option value="" selected hidden>İl Seçiniz..</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="ilce"></label>
                                <select name="ilce" id="ilce" class="form-control" disabled="disabled" required>
                                    <option value="" selected hidden>İlçe Seçiniz..</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="ilce"></label>
                                <input class="form-control" type="text" name="sicilnoeczacı" placeholder="Sicil Numarası" style="color: rosybrown" required>
                            </div>

                            <div class="col-md-3">
                                <label for="eisim"></label>
                                <input class="form-control" type="text" name="eisim" placeholder="Eczane İsim" style=" color: rosybrown" required>
                            </div>

                            <div class="col-md-3">
                                <label for="evergino"></label>
                                <input class="form-control" type="text" name="evergino" placeholder="Eczane Vergi Numarası" style=" color: rosybrown" required>
                            </div>

                            <div class="col-md-3">
                                <label for="dogrula"></label>
                                <input class="form-control" type="submit" name="doğrulaeczacı" value="Doğrula" style="border-radius: 10px; color: rosybrown">
                            </div>

                        </form>
                        <br><br>
                        <?php
                    }
                }
                elseif($role == 3){
                    if (!$hbisonuc){
                        ?>
                        <h3 style="color: indianred; font-weight: bold">Doğrulama Yapın</h3>

                        Sayın <strong><?php echo mb_strtoupper($ad . " " . $soyad); ?>.</strong> Doğrulama için aşağıdaki bilgileri girmeniz gerekmektedir.
                                                                                                 Bilgiyi girdiğiniz andan itibaren Hastahane Bilgi İşlem sistemini kullanabileceksiniz.
                        <br><br>
                        <form action="" method="post">
                            <div class="col-md-3">
                                <label for="il"></label>
                                <select name="il" id="il" class="form-control"required>
                                    <option value="" selected hidden>İl Seçiniz..</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="ilce"></label>
                                <select name="ilce" id="ilce" class="form-control" disabled="disabled" required>
                                    <option value="" selected hidden>İlçe Seçiniz..</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="hastahane"></label>
                                <select name="hastahane" id="hastahane" class="form-control" disabled="disabled" required>
                                    <option value="" selected hidden>Hastahane Seçiniz..</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="hbisicilno"></label>
                                <input class="form-control" type="text" name="sicilnohbi" placeholder="Sicil Numarası" style="color: rosybrown" required>
                            </div>

                            <div class="col-md-3">
                                <label for="signo"></label>
                                <input class="form-control" type="text" name="signohbi" placeholder="Sigorta Numarası" style="color: rosybrown" required>
                            </div>

                            <div class="col-md-3">
                                <label for="dogrula"></label>
                                <input class="form-control" type="submit" name="doğrulahbi" value="Doğrula" style="color: rosybrown">
                            </div>

                        </form>
                        <br><br>
                        <?php
                    }
                }
                ?>

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
        </body>
    </div>
</html>
