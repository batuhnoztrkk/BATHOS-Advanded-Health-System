<?php

class dbConn
{
    protected static $db;

    //turkticaret
    /*public function __construct()
    {
        try{
            self::$db = new PDO("mysql:host=localhost;dbname=boy22elimcom_bathos;charset=utf8", "boy22elimcom_bosoft", "a;e@cy&{4,_@");
        }
        catch (PDOException $exception)
        {
            print $exception->getMessage();
        }
    }*/

    //veritabanına bağlanan fonksiyon
    public function __construct()
    {
        try{
            self::$db = new PDO("mysql:host=localhost;dbname=bathos;charset=utf8", "root", "");
        }
        catch (PDOException $exception)
        {
            print $exception->getMessage();
        }
    }

    //Bölgeleri getiren fonksiyon
    public function getBolgeList()
    {
        $data=array();
        $query = self::$db->query("SELECT DISTINCT bolge from ilveilceler", PDO::FETCH_ASSOC);
        if($query->rowCount())
        {
            foreach ($query as $row)
            {
                $data[]=$row["bolge"];
            }
        }
        echo json_encode($data);
    }


    //İlleri getiren fonksiyon
    public function getIlList(){
        $data=array();
        $query = self::$db->query("SELECT DISTINCT il FROM ilveilceler");
        if($query->rowCount())
        {
            foreach ($query as $row)
            {
                $data[]=$row["il"];
            }
        }
        echo json_encode($data);
    }


    //İlçeleri getiren fonksiyon
    public function getIlceList($il){
        $_SESSION['il'] = $il;
        $data=array();
        $query = self::$db->prepare("SELECT DISTINCT ilce FROM ilveilceler WHERE il=:il");
        $query->execute(array(":il"=>$il));
        if($query->rowCount())
        {
            foreach ($query as $row)
            {
                $data[]=$row["ilce"];
            }
        }
        echo json_encode($data);
    }

    //Hastahaneleri getiren fonksiyon
    public function getHastahaneList($ilce){
        $_SESSION['ilce'] = $ilce;
        $data=array();
        $query = self::$db->prepare("SELECT DISTINCT hastahane FROM ilveilceler WHERE ilce=:ilce");
        $query->execute(array(":ilce"=>$ilce));
        if($query->rowCount())
        {
            foreach ($query as $row)
            {
                $data[]=$row["hastahane"];
            }
        }
        echo json_encode($data);
    }

    //Klinikleri getiren fonksiyon
    public function getKlinikList($hastahane){
        $_SESSION['hastahane'] = $hastahane;
        $data=array();
        $query = self::$db->prepare("SELECT DISTINCT klinik FROM hastahaneklinikler WHERE hastahane=:hastahane");
        $query->execute(array(":hastahane"=>$hastahane));
        if($query->rowCount())
        {
            foreach ($query as $row)
            {
                $data[]=$row["klinik"];
            }
        }
        echo json_encode($data);
    }

    //Hekimleri getiren fonksiyon
    public function getHekimList($klinik){
        $_SESSION['klinik'] = $klinik;
        $data=array();
        $query = self::$db->prepare("SELECT DISTINCT hekim FROM hastahaneklinikler WHERE hastahane = :hastahane AND klinik = :klinik");
        $query->execute(array(":hastahane" => $_SESSION['hastahane'], ":klinik" => $klinik));
        if($query->rowCount())
        {
            foreach ($query as $row)
            {
                $data[]=$row["hekim"];
            }
        }
        echo json_encode($data);
    }
}
?>