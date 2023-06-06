<?php
!defined('security') ? die('Aradığınız sayfaya ulaşılamıyor!') : null;

if(!isset($_SESSION['logged'])){
  ?>
    <script>
        window.location.href = 'loginsignup';
    </script>
  <?php
  die();
}
else{
  $id = $_SESSION['logged'];
  $kntrl = $DB_connect->prepare('SELECT * FROM users WHERE id = :id');
  $kntrl->execute(array(':id' => $id));
  $check = $kntrl->fetch(PDO::FETCH_ASSOC);
  $sonuc = $kntrl->rowCount();
  if(!$sonuc){
    session_destroy();
    ?>
      <script>
          window.location.href = 'loginsignup';
      </script>
    <?php
    die();
  }
  elseif ($check['role'] != 1) {
    ?>
      <script>
          window.location.href = 'loginsignup';
      </script>
    <?php
    die();
  }
  else{

  }
}




$islem = $_GET['action'];
if($islem == 'logout'){
  session_destroy();
  ?>
    <script>
        window.location.href = 'loginsignup';
    </script>
  <?php
  die();
}
?>
<!DOCTYPE html>
<html lang="tr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>FarmaLOG | Admin Panel</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>
    <div class="container">

      <nav class="navbar navbar-expand-md navbar-dark bg-dark card-header">
        <a class="navbar-brand" href="index.php"><i class="fas fa-home mr-2"></i>FarmaLOG Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav ml-auto">


              <li class="nav-item">

                  <a class="nav-link" href="userlist"><i class="fas fa-users mr-2"></i>Kullanıcı listesi</span></a>
              </li>
              <li class="nav-item


                          $path = $_SERVER['SCRIPT_FILENAME'];
                          $current = basename($path, '.php');
                          if ($current == 'addUser') {
                            echo " active ";
                          }

                         ?>"
              </li>
            </li>

            <li class="nav-item">
              <a onclick="return confirm('Çıkış yapmak istediğine emin misin?')" class="nav-link" href="?action=logout"><i class="fas fa-sign-out-alt mr-2"></i>Çıkış</a>
            </li>

          </ul>

        </div>
      </nav>
