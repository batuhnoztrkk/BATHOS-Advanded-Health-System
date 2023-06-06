<?php
if (isset($_POST['randevual'])){
    header("location: bathos/");
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <title>BATHOS | Gelişmiş Sağlık Sistemi</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="vendors/owl-carousel/css/owl.carousel.min.css">
  <link rel="stylesheet" href="vendors/owl-carousel/css/owl.theme.default.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/aos/css/aos.css">
  <link rel="stylesheet" href="css/style.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //sayfa açıldığında otomatik açılması için
            $("#modalNesne").modal('show');
        });
    </script>
  <!-- Chatra
<script>
    (function(d, w, c) {
        w.ChatraID = 'xJAwxPkY9rBojkdZD';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = 'https://call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
 /Chatra -->
</head>
<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">
<!-- modal nesnesi başlangıç -->
<div id="modalNesne" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <center><h2 style="color: red">ÖNEMLİ!</h2></center>
                <p>- Proje tamamlanmamıştır. Demo sürümü olarak teste açık yerleştirilmiştir.</p>
                <p>- Randevu al kısmından yeni hesap oluşturarak sistem test edilebilir. (Vatandaş-Hekim gibi seçimlerle kontrol işlemleri yapılabilir)</p>
                <p>- Kullanıcı kayıt işlemleri, loglar, randevular, reçeteler vb. database verileri gün sonu sıfırlanmaktadır.</p>
                <p>- Sistemde istenmeyen hatalar veya açıklarla karşılaşılabilir.</p>
                <p style="color: red">- Sistem içinde yapılacak her hareketten kullanıcı sorumludur.</p>
            </div>
        </div>
    </div>
</div>
<!-- // modal nesnesi bitiş -->

  <header id="header-section">
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
    <div class="container">
        <img src="images/logo2.png" alt="" width="60" height="75" >
      <div class="navbar-brand-wrapper d-flex w-100">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="mdi mdi-menu navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
          <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
            <div class="navbar-collapse-logo">
              <img src="images/logo2.png" alt="">
            </div>
            <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
            </button>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#header-section">Anasayfa <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#features-section">Hakkımızda</a>
          </li>
          <li class="nav-item">
              <form method="post" action="">
                <input type="submit" name="randevual" class="nav-link" style="border: none; height: 30px; border-radius: 15px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19)" value="Randevu Al">
              </form>
          </li>
        </ul>
      </div>
    </div>
    </nav>
  </header>
  <div class="banner" >
    <div class="container">
      <h1 class="font-weight-semibold" style="color:#004a61;">BATHOS | Türkiye'nin En Gelişmiş Sağlık Uygulaması</h1>
      <h6 class="font-weight-normal text-muted pb-3">Türkiye'nin en gelişmiş sağlık uygulamaları için doğru yerdesiniz. </h6>
      <img src="images/03.png" alt="" class="img-fluid">
    </div>
  </div>
  <!--//HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA -->
  <div class="content-wrapper">
    <div class="container">
      <section class="features-overview" id="features-section" >
        <div class="content-header">
          <h2>HAKKIMIZDA</h2>
          <h6 class="section-subtitle text-muted">BATHOS olarak bir çok farklı platform üzerinde çalışan sistemleri tek bir platforma birleştirerek <br> sağlık sisteminde kolaylık sağlıyoruz. ARTIK SAĞLIKLI OLMAK DAHA KOLAY..</h6>
        </div>
        <!-- //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA //HAKKIMIZDA -->
           </section>
           <section class="digital-marketing-service" id="digital-marketing-section">
             <div class="row align-items-center">
               <div class="col-12 col-lg-7 grid-margin grid-margin-lg-0" data-aos="fade-right">
                 <h3 class="m-0">Hangi hizmetleri sunuyoruz?</h3>
                 <div class="col-lg-7 col-xl-6 p-0">
                   <p class="py-4 m-0 text-muted">Vatandaş için; randevu alabileceği ve randevularını kontrol edebileceği kullanılışlı arayüz hizmetini sunuyoruz.
                                                <br> <br> Hekim için; aynı sistem üzerinde günlük randevu alan hastaların listesini, hastalarına koyulan önceki tahlil, teşhis ve tanıları görebileceği ekran, muayene sonrası yeni bilgiler girebileceği alanlarda hizmet sunuyoruz.
                                                <br> <br> Eczane için; T.C. kimlik numarası üzerinden sorgu yaparak hastalara yazılan ilaçları görebileceği ekrana ek olarak ilaç stoklarını yönetebileceği alanda hizmet sunuyoruz. </p>

                     <p class="font-weight-medium text-muted">Yukarıdaki hizmetlere ek olarak hizmetlerde sunulmaktadır. Hizmetlerimizin hepsi www.bathos.com üzerinden yapılmaktadır.</p>
                 </div>
               </div>
               <div class="col-12 col-lg-5 p-0 img-digital grid-margin grid-margin-lg-0" data-aos="fade-left">
                 <img src="images/02.png" alt="" class="img-fluid">
               </div>
             </div>
             <div class="row align-items-center">
               <div class="col-12 col-lg-7 text-center flex-item grid-margin" data-aos="fade-right">
                 <img src="images/01.png" alt="" class="img-fluid">
               </div>
               <div class="col-12 col-lg-5 flex-item grid-margin" data-aos="fade-left">
                 <h3 class="m-0">Neler Yapıyoruz?</h3>
                 <div class="col-lg-9 col-xl-8 p-0">
                   <p class="py-4 m-0 text-muted">Sistemi her gün geliştirerek; e-nabız, mhrs sistemini birleştiriyoruz. Buna ek olarak e-devlet içinde sağlık kısmını ilgilendiren kısımlar içinde çalışmalarımız sürmektedir.</p>
                   <p class="pb-2 font-weight-medium text-muted">Hasta muayenesi sonucunda yapılan ankette hekim hakkında bilgi vererek sadece geliştirmeler sistem üzerinde değil hekimlerimiz içinde gerçekleşmektedir. Hekimler için bu anketler sonucu HERP puanı belirlenmektedir. BAGNO puanı belirli amaçlarda devreye girerek kullanılmaktadır. <br> <br> Eczane içinde anket sonucunda alınan bilgiler dahilinde ECRP puanı belirlenmektedir.</p>
                 </div>

               </div>
             </div>
           </section>



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
                   <p class="text-muted">Dumlupınar Üniversitesi Bilgisayar Mühendisliği Bölümü <p>Merkez | Kütahya</p>

               </div>
             </div>
           </section>
           <footer class="border-top">
             <p class="text-center text-muted pt-4">Copyright © 2021<a href="https://www.google.com/" class="px-1">Bathos | Gelişmiş Sağlık Sistemi</p>
           </footer>
           <!-- Modal for Contact - us Button -->
      
  <script src="vendors/jquery/jquery.min.js"></script>
  <script src="vendors/bootstrap/bootstrap.min.js"></script>
  <script src="vendors/owl-carousel/js/owl.carousel.min.js"></script>
  <script src="vendors/aos/js/aos.js"></script>
  <script src="js/landingpage.js"></script>
</body>
</html>
