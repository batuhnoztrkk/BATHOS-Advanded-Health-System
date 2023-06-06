<?php
define('security', true);
include 'db_connect.php';
date_default_timezone_set('Europe/Istanbul');
ob_start();
session_start();

if(isset($_SESSION['logged'])){
    include "query.php";
    if (isset($_GET['sayfa'])) {
        $sayfa = $_GET['sayfa'];
        switch ($sayfa) {
            case 'giriskayit';
                include 'loginsignup.php';
                break;
            case 'MerkeziHekimRandevuSistemi';
                include "query.php"; //Bilglerimizi çekiyoruz.
                if (!$telno || !$email){
                    include "telnoemail.php";
                }
                else{
                    if ($role == 0){ //Eğer giriş yapan kişi vatandaş ise direkt randevu sayfasına yönlendiriyoruz.
                        include 'randevual.php';
                    }
                    elseif ($role == 1 || $role == 2 || $role == 3){ //Giriş yapan kişi personel ise personel.php ye yönlendiriyoruz.
                        include "personel.php";
                    }
                    else{ //Kişi çerez ekleyerek buraya geldiyse ve databasede kayıtlı değilse çerezlerini temizleyip girş sayfasına yönlendiriyoruz. (Çerez çakışması, Cookie inject vb.)
                        session_destroy();
                        ob_clean();
                        include "loginsignup.php";
                    }
                }
                break;
            case 'personelrandevu';
                if ($role == 1 || $role == 2 || $role == 3){
                    include 'randevual.php';
                }
                else{
                    header("Refresh:0; url= MerkeziHekimRandevuSistemi", true, 303);
                }

                break;
            case 'randevuislem';
                include 'randevuislem.php';
                break;
            case 'HekimBilgiSistemi';
                include 'p_hbs.php';
                break;
            case 'hekimislem';
                include 'hekimislem.php';
                break;
            case 'EczaneBilgiSistemi';
                include 'ebs.php';
                break;
            case 'HastahaneBilgiIslem';
                include 'hbi.php';
                break;
            case 'hesabim';
                include 'hesap.php';
                break;
            case 'randevubilgileri';
                include 'randevubilgileri.php';
                break;
            default;
                include 'loginsignup.php';
                break;
        }
    }
    else{
        include 'loginsignup.php';
    }
}
else{
    include 'loginsignup.php';
}

?>
<head>
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
