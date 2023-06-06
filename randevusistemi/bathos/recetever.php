<?php
if (isset($_SESSION['logged'])) {
    include "query.php";
    if ($role == 2) {
        $recetebilgi = $recete_bilgi->fetch(PDO::FETCH_ASSOC);
        $ilac = $recetebilgi['ilac_adi'];
        $aciklama = $recetebilgi['aciklama'];
        $doz = $recetebilgi['doz'];
        $periyot = $recetebilgi['periyot'];
        $kullanımsekli = $recetebilgi['kullanim_sekli'];
        $kullanımsayisi = $recetebilgi['kullanim_sayisi'];
        $kutuadedi = $recetebilgi['kutu_adedi'];
        $hastatckno = $recetebilgi['hasta_tckno'];
        $hekimtckno = $recetebilgi['hekim_tckno'];

        //TANI BİLGİLERİ//
        $receteid = $recetebilgi['r_id'];
        $tani_bilgileri = $DB_connect->prepare('SELECT * FROM randevusonuc WHERE r_id = :r_id');
        $tani_bilgileri->execute(array(':r_id' => $receteid));
        $tanibilgileri = $tani_bilgileri->fetch(PDO::FETCH_ASSOC);
        $hasta_sikayeti = $tanibilgileri['hasta_sikayeti'];
        $yapilan_muayene = $tanibilgileri['yapilan_muayene'];
        $tani = $tanibilgileri['tani'];
        //TANI BİLGİLERİ//

        //HASTA BİLGİSİ//
        $hasta_bilgi = $DB_connect->prepare('SELECT * FROM vatandas WHERE tckno = :tckno');
        $hasta_bilgi->execute(array(':tckno' => $hastatckno));
        $hastabilgi = $hasta_bilgi->fetch(PDO::FETCH_ASSOC);
        $hastaad = $hastabilgi['ad'] . " " . $hastabilgi['soyad'];
        //HASTA BİLGİSİ//

        //HEKİM BİLGİSİ//
        $hekim_bilgi = $DB_connect->prepare('SELECT * FROM vatandas WHERE tckno = :tckno');
        $hekim_bilgi->execute(array(':tckno' => $hekimtckno));
        $hekimbilgi = $hekim_bilgi->fetch(PDO::FETCH_ASSOC);
        $hekimad = $hekimbilgi['ad'] . " " . $hekimbilgi['soyad'];
        //HEKİM BİLGİSİ//

        if (isset($_POST['onayla'])) {
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Reçete onaylandı.
            </div>
            <?php
            header("Refresh:1; url= ", true, 303);
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
                <div style="float: left;width: 50%">
                    <div class="container">
                        <div class="column">
                            <form method="post" action="">
                                <div class="koddostu-ampwindow">
                                    <div class="koddostu-p16">
                                        <h6 style="font-weight: bold">Hasta Tanı Bilgileri</h6>
                                        <br>
                                        <center>
                                            <table border="1" width="315px" bordercolor="#e8e8e8" style="overflow: hidden; border-radius: 10px;" >
                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Hekim İsim/Soyisim</td>
                                                    <td align="center" style="font-weight: bold; font-size: 14px;"><?php echo $hekimad ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Hasta İsim/Soyisim</td>
                                                    <td align="center" style="color: #ff0000; "><?php echo $hastaad ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Hasta Şikayeti</td>
                                                    <td align="center" style="color: #959595; font-size: 14px;"><?php echo $hasta_sikayeti?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Yapılan Muayene</td>
                                                    <td align="center" style="color: black; font-weight: bold; font-size: 14px;"><?php echo $yapilan_muayene ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Tanı Bilgisi</td>
                                                    <td align="center" style="color: #959595; font-size: 14px;"><?php echo $tani ?></td>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div style="float: right;width: 50%">
                    <div class="container">
                        <div class="column">
                            <form method="post" action="">
                                <div class="koddostu-ampwindow">
                                    <div class="koddostu-p16">
                                        <h6 style="font-weight: bold">Reçete Bilgileri</h6>
                                        <br>
                                        <center>
                                            <table border="1" width="315px" bordercolor="#e8e8e8" style="overflow: hidden; border-radius: 10px;" >
                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">İlaç</td>
                                                    <td align="center" style="font-weight: bold; font-size: 14px;"><?php echo $ilac ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Açıklama</td>
                                                    <td align="center" style="color: #ff0000; "><?php echo $aciklama ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Doz/Periyot</td>
                                                    <td align="center" style="color: #959595; font-size: 14px;"><?php echo $doz." / ".$periyot ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Kullanım Şekli</td>
                                                    <td align="center" style="color: black; font-weight: bold; font-size: 14px;"><?php echo $kullanımsekli ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="center" width="75px" style="background-color: #fafafa; margin-right: 10px;">Kullanım Sayısı/Kutu Adedi</td>
                                                    <td align="center" style="color: #959595; font-size: 14px;"><?php echo $kullanımsayisi." / ".$kutuadedi ?></td>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form method="post" action="">
                    <center><input type="submit" name="onayla" id="onayla" class="form-control" value="ONAYLA"></center>
                </form>
    </form>

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

