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
    if (isset($_POST['sorgula'])){//Sorgulama ekranına bilgileri yönlendirmek için çerezleri kullanacağız. Verilerl getter setter yöntemi ile de aktarılabilir...
        $_SESSION['il'] = $_POST['il'];
        $_SESSION['ilce'] = $_POST['ilce'];
        $_SESSION['hastahane'] = $_POST['hastahane'];
        $_SESSION['klinik'] = $_POST['klinik'];
        include "processrandevu.php";
        die();
    }


    //Randevu zamanı geçtiyse durumu güncelleyen kod (durumu 2 olarak atıyor. 2 gidilmedi karşılığına geliyor.)
    $simdikizaman = strtotime(date("Y-m-d"));
    $kntrl_randevu = $DB_connect->prepare('SELECT * FROM randevular WHERE tckno = :tckno');
    $kntrl_randevu->execute(array(':tckno' => $tckno));

    if ($kntrl_randevu->rowCount()){ //Listedeki satırları saydırıyoruz. Eğer randevu geçmişi varsa işlem yapıyoruz, yoksa boşuna sistemi kalabalıklaştırmamak adına hiçbir şey yapmıyoruz.
        while ($kntrlRandevu = $kntrl_randevu->fetch(PDO::FETCH_ASSOC)) { //While döngüsü ile tüm verileri birer birer çekiyoruz.
            if ($kntrlRandevu['durum'] == 0){ //Eğer randevu aktifse işlem yapıyoruz.
                $randevu_tarih = strtotime($kntrlRandevu['tarih']); //Randevu tarihini çekip milisaniye cinsine çeviriyoruz.
                if ($simdikizaman > $randevu_tarih){ //Eğer şuanki tarih randevu tarihinden büyükse tarih geçmiş kabul ediliyor. Randevunun durum değerini 2 olarak değiştirtiyoruz.
                    $duzelt_randevu = $DB_connect->prepare('UPDATE randevular SET durum = :durum WHERE r_id = :r_id');
                    if ($duzelt_randevu->execute(array(':r_id' => $kntrlRandevu['r_id'], ":durum" => "2"))){
                        ?>
                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                            <strong>Randevu Tarihi Geçti!</strong> <?php echo $kntrlRandevu['tarih']." ".$kntrlRandevu['saat']." Tarihli, ".$kntrlRandevu['hekim']."[".$kntrlRandevu['klinik']."]"." Randevunuzun tarihi geçti..."?>
                        </div>
                        <?php
                    }
                }
            }
        }
    }
    //Randevu zamanı geçtiyse durumu güncelleyen kod (durumu 2 olarak atıyor. 2 gidilmedi karşılığına geliyor.)


    if (isset($_POST['09:00'])){ //Saat seçim butonuna tıklandığında içine giriyor ve randevuyu kaydediyor. Ancak çok kod kalabalığı yapıyor bu halde.
                                 //For döngüsü içine almayı düşünüyorum. For döngüsüde sistemi yavaşlatabilir. Farklı alternatifler düşünülüp
                                 //Uygun hale getirilecek. Kod aralığı: [43-687]...
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[0]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['09:15'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[1]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['09:30'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[2]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['09:45'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[3]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['10:00'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[4]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['10:15'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[5]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['10:30'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[6]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['10:45'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[7]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['11:00'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[8]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['11:15'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[9]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['11:30'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[10]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['11:45'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[11]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['13:00'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[12]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['13:15'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[13]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['13:30'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[14]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['13:45'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[15]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['14:00'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[16]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['14:15'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[17]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['14:30'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[18]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['14:45'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[19]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['15:00'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[20]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['15:15'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[21]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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

    elseif (isset($_POST['15:30'])){
        include "randevuquery.php";
        if (!isset($_POST['not'])){
            $not = "Hasta notu bulunmuyor.";
        }
        else{
            $not = $_POST['not'];
        }
        $randevu_Ekle->bindParam( ':d_not', $not);
        $randevu_Ekle->bindParam( ':saat', $saatler[22]);
        if($randevu_Ekle->execute()){
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Randevunuz sisteme kayıt edildi. Randevularım sayfasından detaylarına ulaşıp, randevu üzerinden işlemler yapabilirsiniz.
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
  <div class="banner" >
    <div class="container">
      <h3 class="font-weight-semibold">BATHOS | Türkiye'nin En Gelişmiş Sağlık Uygulaması</h3>
      <h6 class="font-weight-normal text-muted pb-3">Türkiye'nin en gelişmiş sağlık sistemi.</h6>

        <center>
            <div class="container">
                <div class="column">
                    <form method="post" action="">

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

                        <div class="col-md-3">
                            <label for="hekim"></label>
                            <select name="hekim" id="hekim" class="form-control" disabled="disabled" required>
                                <option value="" selected hidden>Hekim Seçiniz..</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tarih"></label>
                            <?php
                            $mindate = date('Y-m-d', strtotime('+1 days')); //2017-06-01T08:30
                            $maxdate = date('Y-m-d', strtotime('+1 months') );
                            ?>
                            <input class="form-control" type="date" name="tarih" id="tarih" min="<?php echo $mindate?>" max="<?php echo $maxdate?>" disabled required>
                        </div>
                        <br>
                        <div class="col-md-3">
                            <?php
                            $limit = 0;
                            $simdikizaman = strtotime(date("Y-m-d"));
                            $randevu_limit = $DB_connect->prepare('SELECT onaytarih FROM randevular WHERE tckno = :tckno');
                            $randevu_limit->execute(array(':tckno' => $tckno));
                            while ($randevulimit = $randevu_limit->fetch(PDO::FETCH_ASSOC)){
                                if (strtotime($randevulimit['onaytarih']) == strtotime(date("Y-m-d"))){
                                    $limit = 1;
                                }
                            }
                            if ($limit == 1){
                                ?><input type="submit" name="limit" id="limit" class="form-control" style="border-radius: 10px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19)" value="RANDEVU LİMİTİ DOLDU [1]" disabled><?php
                            }
                            else{
                                ?><input type="submit" name="sorgula" id="sorgula" class="form-control" style="border-radius: 10px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19)" value="RANDEVU AL" disabled><?php
                            }
                            ?>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </center>
        <hr size="10" color="9fdae7">


        <div style="float:left;width:50%;">
            <p style="font-size: 18px; font-weight: bold; color: black">Aktif Randevular</p>
            <hr size="10" width="50" style="position: relative; right: 45px" color="black">
            <center>
                <?php
                $sayac = 0;
                $goster = 0;
                $aktif_durum = 1;
                $aktif_randevu = $DB_connect->prepare('SELECT * FROM randevular WHERE tckno = :tckno ORDER BY r_id DESC');
                $aktif_randevu->execute(array(':tckno' => $tckno));
                if ($aktif_randevu->rowCount()){
                    while ($aktifRandevu = $aktif_randevu->fetch(PDO::FETCH_ASSOC)){
                        if ($aktifRandevu['durum'] == "0"){
                            $sayac = $sayac + 1;
                            if ($sayac <= 4){
                                $aktif_durum = 0;
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
                                $goster = 1;
                            }
                        }
                    }
                    if ($aktif_durum){
                        ?>
                            <p style="color:gray;">Aktif Randevunuz Yok.</p>
                        <?php
                    }
                }
                else{
                    ?>
                        <p style="color:gray;">Aktif Randevunuz Yok.</p>
                    <?php
                }
                if($goster == 1){
                    ?> <input type="submit" value="Tümünü Göster" class="form-control"> <?php
                }
                else{
                    ?> <input type="submit" value="Tümünü Göster" class="form-control" style="cursor: no-drop" disabled> <?php
                }
                ?>
            </center>
        </div>
        <div style="float:right;width:50%;">
            <p style="font-size: 18px; font-weight: bold; color: darkgray">Geçmiş Randevular</p>
            <hr size="10" width="50" style="position: relative; right: 58px" color="darkgray">
            <center>
                <?php

                $goster_gecmis = 0;
                $sayac = 0;
                $gecmis_durum = 1;
                $gecmis_randevu = $DB_connect->prepare('SELECT tarih, saat, hastahane, klinik, hekim, durum, r_id FROM randevular WHERE tckno = :tckno ORDER BY r_id DESC');
                $gecmis_randevu->execute(array(':tckno' => $tckno));
                if ($gecmis_randevu->rowCount()){
                    while ($gecmisRandevu = $gecmis_randevu->fetch(PDO::FETCH_ASSOC)){
                        if ($gecmisRandevu['durum'] == "1" || $gecmisRandevu['durum'] == "2" || $gecmisRandevu['durum'] == "3" || $gecmisRandevu['durum'] == "4"){
                            $sayac = $sayac + 1;
                            if ($sayac <= 4){
                                $gecmis_durum = 0;
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
                                                <a type="button" style="margin-left:45px; margin-bottom: 12px; background-color: darkseagreen; color: white; width: 120px; font-weight: bold; border-radius: 5px; font-size: 12px; float: left border-radius: 5px" href="randevuislem?randevuincele=<?php echo  $gecmisRandevu['r_id']?>" >İncele</a>
                                            </li>
                                        </ul>
                                    </center>
                                </div>
                                <?php
                                $goster_gecmis = 1;
                            }
                        }
                    }
                    if ($gecmis_durum){
                        ?>
                            <p style="color:gray;">Geçmiş Randevunuz yok.</p>
                        <?php
                    }
                }
                else{
                    ?>
                        <p style="color:gray;">Geçmiş Randevunuz yok.</p>
                    <?php
                }
                if($goster_gecmis == 1){
                    ?> <input type="submit" name="gecmisrandevugoster" id="gecmisrandevugoster" value="Tümünü Göster" class="form-control"> <?php
                }
                else{
                    ?> <input type="submit" value="Tümünü Göster" class="form-control" style="cursor: no-drop" disabled> <?php
                }
                ?>
            </center>
        </div>
        <div style="clear:both;"></div>
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

