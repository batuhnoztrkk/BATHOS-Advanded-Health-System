<?php

if($_POST){
    /*
    *	Mysql Connect
    */

    include "db_connect.php";

    /* ---------------- **/

    /*
    *	Veriyi Alalım ve işlemleri yapalım
    */
    $value = strip_tags(rtrim($_POST['value']));
    if(!$value){
        echo 'bos';
    }else{

        $find = $DB_connect->prepare("SELECT * FROM ilac_liste WHERE i_ad like :value");
        $find->execute(array(':value' => $value."%"));
        if($find->rowCount()){

            while($row = $find->fetch(PDO::FETCH_ASSOC)){
                ?>
                <a><li onclick='fill("<?php echo $row['i_ad'];?>")'><?php echo $row['i_ad']; ?></li></a>
                <?php
            }

        }else{
            echo 'yok';
        }
    }
}else{
    header("Location: index.php");
}

?>