# MySQL dump of database 'knomos_db' on host 'localhost'
# backup date and time: 10/13/10 09:51:17
# built by phpMyBackupPro v.2.1
# http://www.phpMyBackupPro.net

CREATE DATABASE IF NOT EXISTS `knomos_db`;

USE `knomos_db`;




### structure of table `calendar` ###

ALTER TABLE calendar ADD COLUMN provenienza date NOT NULL '0000-00-00';
ALTER TABLE calendar ADD COLUMN id_provenienza int(10) NOT NULL default '0';
ALTER TABLE calendar ADD COLUMN notulato int(5) NOT NULL default '0';
ALTER TABLE calendar ADD COLUMN servizio1 varchar(30) NOT NULL default '';
ALTER TABLE calendar ADD COLUMN servizio2 varchar(30) NOT NULL default '';
ALTER TABLE calendar ADD COLUMN servizio3 varchar(30) NOT NULL default '';




