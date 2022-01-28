<?php
session_start();

if(!file_exists(__DIR__.'/db') && !is_dir(__DIR__.'/db')) mkdir(__DIR__.'/db');
if(!defined('db_file')) define('db_file',__DIR__.'/db/inquiry_mail_db.db');
if(!defined('tZone')) define('tZone',"Europe/Berlin");
if(!defined('dZone')) define('dZone',ini_get('date.timezone'));
function my_udf_md5($string) {
    return md5($string);
}

Class DBConnection extends SQLite3{
    protected $db;
    function __construct(){
        $this->open(db_file);
        $this->createFunction('md5', 'my_udf_md5');
        $this->exec("PRAGMA foreign_keys = ON;");

        $this->exec("CREATE TABLE IF NOT EXISTS `message_list` (
            `message_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `firstname` TEXT NOT NULL,
            `lastname` text NOT NULL,
            `status` INTEGER NOT NULL Default 0,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `date_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"); 

    }
    function __destruct(){
         $this->close();
    }
}

$conn = new DBConnection();