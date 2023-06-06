<?php
$array = array();
$_0900 = 0;
$_0915 = 0;
$_0930 = 0;
$_0945 = 0;
$_1000 = 0;
$_1015 = 0;
$_1030 = 0;
$_1045 = 0;
$_1100 = 0;
$_1115 = 0;
$_1130 = 0;
$_1145 = 0;
$_1300 = 0;
$_1315 = 0;
$_1330 = 0;
$_1345 = 0;
$_1400 = 0;
$_1415 = 0;
$_1430 = 0;
$_1445 = 0;
$_1500 = 0;
$_1515 = 0;
$_1530 = 0;
$r_bilgi = $DB_connect->prepare('SELECT tarih, saat, durum FROM randevular WHERE hastahane = :hastahane AND klinik = :klinik AND hekim = :hekim');
$r_bilgi->execute(array(':hastahane' => $hastahane, ':klinik' => $klinik, ':hekim' => $hekim));
if ($r_bilgi->rowCount()){
    while ($sonuc = $r_bilgi->fetch(PDO::FETCH_ASSOC)){
        if ($sonuc['tarih'] == $_SESSION['tarih']){
            $array[] = $sonuc['saat'];
        }
    }
    if (isset($array)){
        $count = count($array);
        for ($i = 0; $i<$count; $i++){
            if ($array[$i] == "09:00"){
                $_0900 = "1";
            }
            elseif ($array[$i] == "09:15"){
                $_0915 = "1";
            }
            elseif ($array[$i] == "09:30"){
                $_0930 = "1";
            }
            elseif ($array[$i] == "09:45"){
                $_0945 = "1";
            }
            elseif ($array[$i] == "10:00"){
                $_1000 = "1";
            }
            elseif ($array[$i] == "10:15"){
                $_1015 = "1";
            }
            elseif ($array[$i] == "10:30"){
                $_1030 = "1";
            }
            elseif ($array[$i] == "10:45"){
                $_1045 = "1";
            }
            elseif ($array[$i] == "11:00"){
                $_1100 = "1";
            }
            elseif ($array[$i] == "11:15"){
                $_1115 = "1";
            }
            elseif ($array[$i] == "11:30"){
                $_1130 = "1";
            }
            elseif ($array[$i] == "11:45"){
                $_1145 = "1";
            }
            elseif ($array[$i] == "13:00"){
                $_1300 = "1";
            }
            elseif ($array[$i] == "13:00"){
                $_1300 = "1";
            }
            elseif ($array[$i] == "13:15"){
                $_1315 = "1";
            }
            elseif ($array[$i] == "13:30"){
                $_1330 = "1";
            }
            elseif ($array[$i] == "13:45"){
                $_1345 = "1";
            }
            elseif ($array[$i] == "14:00"){
                $_1400 = "1";
            }
            elseif ($array[$i] == "14:15"){
                $_1415 = "1";
            }
            elseif ($array[$i] == "14:30"){
                $_1430 = "1";
            }
            elseif ($array[$i] == "14:45"){
                $_1445 = "1";
            }
            elseif ($array[$i] == "15:00"){
                $_1500 = "1";
            }
            elseif ($array[$i] == "15:15"){
                $_1515 = "1";
            }
            elseif ($array[$i] == "15:30"){
                $_1530 = "1";
            }
        }?><form method="post" action=""><?php
        if ($_0900){
            ?><input type="submit" name="09:00" value="09:00" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled ><?php
        }
        else{
            ?><input type="submit" name="09:00" value="09:00" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_0915){
            ?><input type="submit" name="09:15" value="09:15" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;cursor: no-drop" disabled ><?php
        }
        else{
            ?><input type="submit" name="09:15" value="09:15" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_0930){
            ?><input type="submit" name="09:30" value="09:30" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;cursor: no-drop" disabled ><?php
        }
        else{
            ?><input type="submit" name="09:30" value="09:30" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_0945){
            ?><input type="submit" name="09:45" value="09:45" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px; cursor: no-drop" disabled ><?php
        }
        else{
            ?><input type="submit" name="09:45" value="09:45" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;"><?php
        }

        if ($_1000){
            ?><input type="submit" name="10:00" value="10:00" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="10:00" value="10:00" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1015){
            ?><input type="submit" name="10:15" value="10:15" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="10:15" value="10:15" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1030){
            ?><input type="submit" name="10:30" value="10:30" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="10:30" value="10:30" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1045){
            ?><input type="submit" name="10:45" value="10:45" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="10:45" value="10:45" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;"><?php
        }

        if ($_1100){
            ?><input type="submit" name="11:00" value="11:00" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="11:00" value="11:00" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1115){
            ?> <input type="submit" name="11:15" value="11:15" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?> <input type="submit" name="11:15" value="11:15" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1130){
            ?><input type="submit" name="11:30" value="11:30" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="11:30" value="11:30" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1145){
            ?><input type="submit" name="11:45" value="11:45" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="11:45" value="11:45" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;"><?php
        }

        if ($_1300){
            ?><input type="submit" name="13:00" value="13:00" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="13:00" value="13:00" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1315){
            ?><input type="submit" name="13:15" value="13:15" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="13:15" value="13:15" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1330){
            ?><input type="submit" name="13:30" value="13:30" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="13:30" value="13:30" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1345){
            ?><input type="submit" name="13:45" value="13:45" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="13:45" value="13:45" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;"><?php
        }

        if ($_1400){
            ?><input type="submit" name="14:00" value="14:00" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="14:00" value="14:00" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1415){
            ?><input type="submit" name="14:15" value="14:15" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="14:15" value="14:15" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1430){
            ?><input type="submit" name="14:30" value="14:30" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="14:30" value="14:30" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1445){
            ?><input type="submit" name="14:45" value="14:45" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="14:45" value="14:45" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;"><?php
        }

        if ($_1500){
            ?><input type="submit" name="15:00" value="15:00" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="15:00" value="15:00" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1515){
            ?><input type="submit" name="15:15" value="15:15" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 10px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="15:15" value="15:15" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;"><?php
        }

        if ($_1530){
            ?><input type="submit" name="15:30" value="15:30" style="color: #d4d4d4; border-radius: 10px; background-color: #f5f5f5; border: none; float: left; height: 40px; width: 70px; margin-right: 70px; margin-bottom: 30px; cursor: no-drop" disabled><?php
        }
        else{
            ?><input type="submit" name="15:30" value="15:30" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 70px; margin-bottom: 30px;"><?php
        }
        ?></form>><?php
    }
    else{
        ?>
            <form method="post" action="">
                <input type="submit" name="09:00" value="09:00" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="09:15" value="09:15" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="09:30" value="09:30" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="09:45" value="09:45" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
                <input type="submit" name="10:00" value="10:00" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="10:15" value="10:15" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="10:30" value="10:30" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="10:45" value="10:45" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
                <input type="submit" name="11:00" value="11:00" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="11:15" value="11:15" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="11:30" value="11:30" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="11:45" value="11:45" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
                <input type="submit" name="13:00" value="13:00" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="13:15" value="13:15" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="13:30" value="13:30" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="13:45" value="13:45" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
                <input type="submit" name="14:00" value="14:00" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="14:15" value="14:15" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="14:30" value="14:30" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="14:45" value="14:45" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
                <input type="submit" name="15:00" value="15:00" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="15:15" value="15:15" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
                <input type="submit" name="15:30" value="15:30" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 70px; margin-bottom: 30px;">
            </form>
        <?php
    }
}
else{
    ?>
    <form method="post" action="">
        <input type="submit" name="09:00" value="09:00" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="09:15" value="09:15" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="09:30" value="09:30" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="09:45" value="09:45" style="color: white; border-radius: 10px; background-color: #1890ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
        <input type="submit" name="10:00" value="10:00" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="10:15" value="10:15" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="10:30" value="10:30" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="10:45" value="10:45" style="color: white; border-radius: 10px; background-color: #186aff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
        <input type="submit" name="11:00" value="11:00" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="11:15" value="11:15" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="11:30" value="11:30" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="11:45" value="11:45" style="color: white; border-radius: 10px; background-color: #1828ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
        <input type="submit" name="13:00" value="13:00" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="13:15" value="13:15" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="13:30" value="13:30" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="13:45" value="13:45" style="color: white; border-radius: 10px; background-color: #5418ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
        <input type="submit" name="14:00" value="14:00" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="14:15" value="14:15" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="14:30" value="14:30" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="14:45" value="14:45" style="color: white; border-radius: 10px; background-color: #a518ff; border: none; float: left; height: 40px; width: 70px; margin-bottom: 20px;">
        <input type="submit" name="15:00" value="15:00" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="15:15" value="15:15" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 10px;">
        <input type="submit" name="15:30" value="15:30" style="color: white; border-radius: 10px; background-color: #ff189a; border: none; float: left; height: 40px; width: 70px; margin-right: 70px; margin-bottom: 30px;">
    </form>
    <?php
}
?>