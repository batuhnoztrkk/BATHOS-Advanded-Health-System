<?php
session_start();
ob_start();
include ("dbConn.php");

$action=$_POST["action"];

switch ($action)
{
    case "il":
        $db=new dbConn();
        return $db->getIlList();
        break;

    case "ilce":
        $db=new dbConn();
        $il=$_POST["name"];
        return $db->getIlceList($il);
        break;

}