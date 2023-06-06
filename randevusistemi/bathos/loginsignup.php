<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;

if(!isset($_SESSION['logged'])){

    /////////////////////////////////////////////// GİRİŞ İŞLEMLERİ ///////////////////////////////////////////////
    if (isset($_POST['giris'])){ //Giriş butonuna tıklandığında ifin içine giriyor.

        //Kullanıcının forma girdiği bilgileri POST yöntemiyle değişkenlere atıyoruz.
	    $g_tckno = $_POST['g_tckno'];
        $g_parola = $_POST['g_parola'];
        //Kullanıcının forma girdiği bilgileri POST yöntemiyle değişkenlere atıyoruz.

        //MYSQL SELECT SQL sorgusunu kullanarak kayıtlı bilgilerle uyuşup uyuşmadığını kontrol ettiriyoruz.
        $g_kntrl = $DB_connect->prepare('SELECT * FROM vatandas WHERE tckno = :tckno and parola = :parola');
        $g_kntrl->execute(array(':tckno' => $g_tckno, ':parola' => $g_parola));
        $veri = $g_kntrl->fetch(PDO::FETCH_ASSOC);
        $sonuc = $g_kntrl->rowCount();
        if($sonuc){ //Eğer databasede bu bilgiler uyuşuyorsa giriş işlemlerini yaptırtıyoruz.
            $_SESSION['logged'] = $veri['v_id']; // Çerezleri kullanarak kullanıcının databasede birincil anahtar (autoincrement) değerini atıyoruz. (TC kimlik numarasıda atanabilir.)
            // Kullanıcıya başarıyla giriş yaptığına dair mesaj gönderip 5 saniye sonra randevu sayfasına yönlendiriyoruz.
            ?>
            <div class="basari">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Başarılı!</strong> Başarıyla giriş yapıldı. Randevu sayfasına yönlendiriliyorsunuz.
            </div>
            <?php
            header("Refresh:1; url= MerkeziHekimRandevuSistemi", true, 303);
        } else{ //Eğer databasede bu bilgiler uyuşmuyorsa hata mesajı gönderiyoruz.
            ?>
            <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Hatalı!</strong> T.C Kimlik numarası veya parola hatalı.
            </div>
            <?php
        }

    }
    /////////////////////////////////////////////// GİRİŞ İŞLEMLERİ ///////////////////////////////////////////////


    /////////////////////////////////////////////// KAYIT İŞLEMLERİ ///////////////////////////////////////////////
    if (isset($_POST['kayit'])){ //Üye ol butonuna tıklandığında ifin içine giriyor.
        // Kullanıcının forma girdiği değerleri POST yöntemiyle değişkenlere atıyoruz //
        $k_tckno = $_POST['k_tckno'];
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $cinsiyet = $_POST['cinsiyet'];
        $dogumtarihi = $_POST['dogumtarihi'];
        $meslek = $_POST['meslek'];
        $k_parola = $_POST['k_parola'];
        // Kullanıcının forma girdiği değerleri POST yöntemiyle değişkenlere atıyoruz //

        // Kullanıcının girdiği TC numarası databaseye kayıtlı mı diye kontrol ediyoruz //
        $tc_kntrl = $DB_connect->prepare('SELECT * FROM vatandas WHERE tckno = :tckno');
        $tc_kntrl->execute(array(':tckno' => $k_tckno));
        $tcsonuc = $tc_kntrl->rowCount(); //Dizi sayısını kontrol ederek tablomuzda var olup olmadığını anlayabiliriz.

        if($tcsonuc){ //Eğer kayıtlıysa hata verdirteceğiz.
            ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Hata!</strong> Bu Türkiye Cumhuriyeti Kimlik Numarası zaten kayıtlı. Şifreni unuttuysan şifremi unuttum kısmına tıklayınız.
            </div>
            <?php
        }
        else{ //Kayıtlı değilse işlemlere devam ediyoruz.
            //MYSQL INSERT INTO sorgusunu çağırıyoruz.
            $kayıt_Yap = $DB_connect->prepare("INSERT INTO vatandas (role, tckno, ad, soyad, cinsiyet, dogumtarihi, parola) VALUES (:role, :tckno, :ad, :soyad, :cinsiyet, :dogumtarihi, :parola)");
            //Execute öncesi kullanıcının girdiği bilgilerli öntanım yapıyoruz. (SQL Injection önüne geçiyoruz.)
            $kayıt_Yap->bindParam( ':role', $meslek);
            $kayıt_Yap->bindParam( ':tckno', $k_tckno);
            $kayıt_Yap->bindParam( ':ad', $ad);
            $kayıt_Yap->bindParam( ':soyad', $soyad);
            $kayıt_Yap->bindParam( ':cinsiyet', $cinsiyet);
            $kayıt_Yap->bindParam( ':dogumtarihi', $dogumtarihi);
            $kayıt_Yap->bindParam( ':parola', $k_parola);

            if($kayıt_Yap->execute()){ //Execute işlemini yaptırtıyoruz.
                //Kullanıcıya kayıt olduğuna dair bilgi metni gönderiyoruz. Ardından 5 saniye sonra sayfayı yenilettiriyoruz ve giriş yapacak duruma getirtiyoruz.
                ?>
                <div class="basari">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Başarılı!</strong> Kayıt işlemi tamamlandı. Kayıtlı bilgilerinizle giriş yapabilirsiniz. 5 saniye sonra otomatik kapanacak.
                </div>
                <?php
                header("Refresh:5; url=", true, 303);

            } else{ //Database bağlantı hataları ve benzeri engelleyici durumlar için kullanıcılara hata mesajı gönderiyoruz.
                ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Hata!</strong> Database hatası gerçekleşti. Lütfen daha sonra tekrar deneyiniz.
                </div>
                <?php
            }
        }

        // Kullanıcının girdiği TC numarası databaseye kayıtlı mı diye kontrol ediyoruz //
    }
    /////////////////////////////////////////////// KAYIT İŞLEMLERİ ///////////////////////////////////////////////
}
else{
    header("location: MerkeziHekimRandevuSistemi");
}


?>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../image/favicon.ico">
	<title>BATHOS | Giriş</title>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
	<link rel="stylesheet" href="assets2/style.css">

	<style>
		.alert {
		padding: 20px;
        border-radius: 30px;
		background-color: #f44336;
		color: white;
		}

		.basari {
			padding: 20px;
            border-radius: 30px;
			background-color: green;
			color: white;
		}
	 </style>

</head>

<body>
	<h2 style="color: #004a61">Türkiye'nin En Gelişmiş Sağlık Uygulaması</h2>
	<div class="container" id="container">

        <!--//////////////////////////////////////////////////      KAYIT FORMU      //////////////////////////////////////////////////-->
		<div class="form-container sign-up-container">
			<form action="#" method="post">
				<h1 style="color:#009197;">Üye Ol</h1>
				<span style="color:#009197;">Tüm alanların doldurulması zorunludur.</span>
				<input type="text" name="k_tckno" placeholder="T.C Kimlik No" minlength="11" maxlength="11" pattern="\d{11}" title="TC Kimlik Numarası 11 haneli sayıdan oluşmalıdır." style="border-radius: 15px;" required>
                <input type="text" name="ad" placeholder="Adı" style=" text-transform: capitalize; border-radius: 15px;"  required>
                <input type="text" name="soyad" placeholder="Soyad" style=" text-transform: capitalize; border-radius: 15px;" required>
                <select name="cinsiyet" id="cinsiyet" style="width: 284px; border: none; height: 39px; background-color: #eeeeee; color: #757588; border-radius: 15px;" required>
                    <option value="" selected disabled hidden>&nbsp;&nbsp;&nbsp;Cinsiyet</option>
                    <option value="Erkek">&nbsp;&nbsp;&nbsp;Erkek</option>
                    <option value="Kadın">&nbsp;&nbsp;&nbsp;Kadın</option>
                </select>
                <input type="date" name="dogumtarihi" placeholder="Doğum Tarihi" required style="color: #757588; border-radius: 15px;">
                <select name="meslek" id="meslek" style="width: 284px; border: none; height: 39px; background-color: #eeeeee; color: #757588; border-radius: 15px;" required>
                    <option value="0" selected>&nbsp;&nbsp;&nbsp;Vatandaş</option>
                    <option value="1">&nbsp;&nbsp;&nbsp;Doktor</option>
                    <option value="2">&nbsp;&nbsp;&nbsp;Eczacı</option>
                    <option value="3">&nbsp;&nbsp;&nbsp;Hastahane Bilgi İşlem</option>
                </select>
                <input type="password" name="k_parola" placeholder="Parola" style="border-radius: 15px;" required>
				<input type="submit" name="kayit" id="kayit" value="Üye Ol" style="border-radius: 20px;
                                                                                    border: 1px solid #009197;
                                                                                    background-color: #009197;
                                                                                    color: #FFFFFF;
                                                                                    font-size: 12px;
                                                                                    font-weight: bold;
                                                                                    padding: 12px 45px;
                                                                                    letter-spacing: 1px;
                                                                                    text-transform: uppercase;
                                                                                    transition: transform 80ms ease-in;">
			</form>
		</div>
        <!--//////////////////////////////////////////////////      KAYIT FORMU      //////////////////////////////////////////////////-->


        <!--//////////////////////////////////////////////////      GİRİŞ FORMU      //////////////////////////////////////////////////-->
		<div class="form-container sign-in-container">
			<form action="#" method="post">
				<h1 style="color: #009197">Giriş Yapınız</h1>
				<!--<div class="social-container">
                    <img src="../images/edevlet-logo-yeni.png" alt="E-devlet Giriş" height="50" width="170">
				</div>
				<span>veya kayıtlı kullanıcı bilgileriyle giriş yapınız.</span>-->
				<input type="text" name="g_tckno" placeholder="TC Kimlik Numarası" minlength="11" maxlength="11" pattern="\d{11}" title="TC Kimlik Numarası 11 haneli sayıdan oluşmalıdır." style="border-radius: 15px;" required>
				<input type="password" name="g_parola" placeholder="Şifre" style="border-radius: 15px;" required>
				<a href="#"></a>
				<input type="submit" name="giris" id="giris" value="Giriş" style="border-radius: 20px;
                                                                                    border: 1px solid #009197;
                                                                                    background-color: #009197;
                                                                                    color: #FFFFFF;
                                                                                    font-size: 12px;
                                                                                    font-weight: bold;
                                                                                    padding: 12px 45px;
                                                                                    letter-spacing: 1px;
                                                                                    text-transform: uppercase;
                                                                                    transition: transform 80ms ease-in;">
			</form>
		</div>
        <!--//////////////////////////////////////////////////      GİRİŞ FORMU      //////////////////////////////////////////////////-->


		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Giriş Yapın</h1>
					<p>Hesabınız var ise giriş yapınız.</p>
					<button class="ghost" id="signIn">GİRİŞ</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Üye Ol</h1>
					<p>Hesabın yok mu?</p>
					<button class="ghost" href="#" id="signUp">Üye Ol</button>
				</div>
			</div>
		</div>
	</div>

    <a type="button" href="../" style="margin-top: 50px; border-radius: 20px; border: 1px solid #009197;
                                                            background-color: #009197;
                                                            color: #FFFFFF;
                                                            font-size: 12px;
                                                            font-weight: bold;
                                                            padding: 12px 45px;
                                                            letter-spacing: 1px;
                                                            text-transform: uppercase;
                                                            transition: transform 80ms ease-in;"> Anasayfa </a>
	<!-- partial -->
	<script src="assets2/script.js"></script>
</body>

</html>
