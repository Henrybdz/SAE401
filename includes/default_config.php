<?php

require "config/config.class.php";

$Conf = new stdClass();

$Conf->DBHOST = Config::$DBHOST ?? "localhost";
$Conf->DBUSER = Config::$DBUSER ?? "root";
$Conf->DBNAME = Config::$DBNAME ?? "magasin";
$Conf->DBPWD = Config::$DBPWD ?? "";

global $Conf;
