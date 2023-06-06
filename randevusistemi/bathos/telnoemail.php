<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;
if(isset($_SESSION['logged'])){

    /////////////////////////////////////////////// GÜNCELLEME İŞLEMLERİ ///////////////////////////////////////////////
    if (isset($_POST['guncelle'])){ //Üye ol butonuna tıklandığında ifin içine giriyor.
        // Kullanıcının forma girdiği değerleri POST yöntemiyle değişkenlere atıyoruz //
        $email = $_POST['email'];
        $telno = $_POST['telno'];
        // Kullanıcının forma girdiği değerleri POST yöntemiyle değişkenlere atıyoruz //

        // Kullanıcının girdiği E-mail veya Telefon numarası databaseye kayıtlı mı diye kontrol ediyoruz //
        $kntrl = $DB_connect->prepare('SELECT email, telno FROM vatandas WHERE email = :email AND telno = :telno');
        $kntrl->execute(array(':email' => $email, ':telno' => $telno));
        $kntrlsonuc = $kntrl->rowCount(); //Dizi sayısını kontrol ederek tablomuzda var olup olmadığını anlayabiliriz.

        if($kntrlsonuc){ //Eğer kayıtlıysa hata verdirteceğiz.
            ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                <strong>Hata!</strong> Bu bilgiler farklı bir kişi tarafından kullanılmaktadır. Hata olduğunu düşünüyorsanız yardim@bathos.com adresine mail atınız.
            </div>
            <?php
        }
        else{ //Kayıtlı değilse işlemlere devam ediyoruz.
            //MYSQL UPDATE sorgusunu çağırıyoruz.
            $guncelle = $DB_connect->prepare("UPDATE vatandas SET email = :email, telno = :telno WHERE v_id = :v_id");
            //Execute öncesi kullanıcının girdiği bilgilerli öntanım yapıyoruz. (SQL Injection önüne geçiyoruz.)
            $guncelle->bindParam( ':email', $email);
            $guncelle->bindParam( ':telno', $telno);
            $guncelle->bindParam( ':v_id', $v_id);

            if($guncelle->execute()){ //Execute işlemini yaptırtıyoruz.
                //Kullanıcıya bilgilerinin güncellediğine dair bilgi gönderiyoruz.
                ?>
                <div class="basari">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';"><img src="../images/PngItem_5043128.png" width="20" height="20"></span>
                    <strong>Başarılı!</strong> Bilgileriniz başarıyla güncellendi. Randevu sayfasına yönlendiriliyorsunuz.
                </div>
                <?php
                header("Refresh:2; url=MerkeziHekimRandevuSistemi", true, 303);

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
    /////////////////////////////////////////////// GÜNCELLEME İŞLEMLERİ ///////////////////////////////////////////////
}
else{
    header("location: giriskayit");
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


        <!--//////////////////////////////////////////////////      GÜNCELLEME FORMU      //////////////////////////////////////////////////-->
		<div class="form-container sign-in-container">
			<form action="#" method="post">
				<!--<div class="social-container">
                    <img src="../images/edevlet-logo-yeni.png" alt="E-devlet Giriş" height="50" width="170">
				</div>
				<span>veya kayıtlı kullanıcı bilgileriyle giriş yapınız.</span>-->
				<input type="email" name="email" placeholder="E-mail" style="border-radius: 15px;" required>
				<input type="tel" name="telno" style="border-radius: 15px;" placeholder="Telefon Numarası" minlength="11" maxlength="11" pattern="\d{11}" title="Geçerli bir telefon numarası giriniz. (11 haneli, başında 0 kodlayarak giriniz.)" required>
				<a href="#"></a>
				<input type="submit" name="guncelle" id="guncelle" value="Güncelle" style="border-radius: 20px;
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
        <!--//////////////////////////////////////////////////      GÜNCELLEME FORMU      //////////////////////////////////////////////////-->


		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-right">
                    <h1>Bilgilerini Güncelle</h1>
					<p>Randevu bilgilendirmeleri için E-mail ve Telefon numaranı bize iletmen gerekli.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- partial -->
	<script src="assets2/script.js"></script>
</body>

</html>
