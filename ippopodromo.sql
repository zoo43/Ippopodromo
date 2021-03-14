-- --------------------------------------------------------
-- Host:                         localhost
-- Versione server:              10.4.17-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database ippopodromo
CREATE DATABASE IF NOT EXISTS `ippopodromo` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `ippopodromo`;

-- Dump della struttura di tabella ippopodromo.cavallo
CREATE TABLE IF NOT EXISTS `cavallo` (
  `idCavallo` int(11) NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(255) DEFAULT NULL,
  `immagine` varchar(100) DEFAULT NULL,
  `fiducia` int(11) NOT NULL,
  `stanchezza` int(11) NOT NULL,
  `velocita` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `ritiro` tinyint(1) NOT NULL,
  PRIMARY KEY (`idCavallo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ippopodromo.cavallo: ~3 rows (circa)
/*!40000 ALTER TABLE `cavallo` DISABLE KEYS */;
INSERT INTO `cavallo` (`idCavallo`, `descrizione`, `immagine`, `fiducia`, `stanchezza`, `velocita`, `nome`, `ritiro`) VALUES
	(1, 'Il cavallo più veloce del west', 'cavallo1.jpg', 15, 5, 10, 'Samu Merda',0),
	(2, 'Cavallo celebroleso', 'cavallo2.png', 20, 0, 1, 'Aperino',0),
	(3, 'Il cavallo più lento del West', 'cavallo3.png', 15, 5, 2, 'Lucatoni',0);
/*!40000 ALTER TABLE `cavallo` ENABLE KEYS */;

-- Dump della struttura di tabella ippopodromo.gara
CREATE TABLE IF NOT EXISTS `gara` (
  `idGara` int(11) NOT NULL AUTO_INCREMENT,
  `dataGara` datetime NOT NULL,
  `stato` int(11) NOT NULL,
  PRIMARY KEY (`idGara`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ippopodromo.gara: ~2 rows (circa)
/*!40000 ALTER TABLE `gara` DISABLE KEYS */;
INSERT INTO `gara` (`idGara`, `dataGara`, `stato`) VALUES
	(1, '2005-01-13 09:59:39', 2),
	(2, '2013-01-13 09:59:57', 0),
	(3, '2021-01-19 16:51:56', 0);
/*!40000 ALTER TABLE `gara` ENABLE KEYS */;

-- Dump della struttura di tabella ippopodromo.partecipante
CREATE TABLE IF NOT EXISTS `partecipante` (
  `idGara` int(11) NOT NULL,
  `idCavallo` int(11) NOT NULL,
  `posizione` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGara`,`idCavallo`),
  KEY `idCavallo` (`idCavallo`),
  CONSTRAINT `Partecipante_ibfk_1` FOREIGN KEY (`idGara`) REFERENCES `gara` (`idGara`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Partecipante_ibfk_2` FOREIGN KEY (`idCavallo`) REFERENCES `cavallo` (`idCavallo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ippopodromo.partecipante: ~6 rows (circa)
/*!40000 ALTER TABLE `partecipante` DISABLE KEYS */;
INSERT INTO `partecipante` (`idGara`, `idCavallo`, `posizione`) VALUES
	(1, 1, 1),
	(1, 2, 3),
	(1, 3, 2),
	(2, 1, 2),
	(2, 2, 1),
	(2, 3, 3),
	(3, 3, NULL);
/*!40000 ALTER TABLE `partecipante` ENABLE KEYS */;

-- Dump della struttura di tabella ippopodromo.scommessa
CREATE TABLE IF NOT EXISTS `scommessa` (
  `idGara` int(11) NOT NULL,
  `idCavallo` int(11) NOT NULL,
  `nomeUtente` varchar(40) NOT NULL,
  `puntata` int(11) NOT NULL,
  `stato` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idGara`,`idCavallo`,`nomeUtente`),
  UNIQUE KEY `UN_Scommessa` (`idGara`,`nomeUtente`),
  KEY `idCavallo` (`idCavallo`),
  KEY `nomeUtente` (`nomeUtente`),
  CONSTRAINT `scommessa_ibfk_1` FOREIGN KEY (`idGara`) REFERENCES `gara` (`idGara`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `scommessa_ibfk_2` FOREIGN KEY (`idCavallo`) REFERENCES `cavallo` (`idCavallo`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `scommessa_ibfk_3` FOREIGN KEY (`nomeUtente`) REFERENCES `utente` (`nomeUtente`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ippopodromo.scommessa: ~2 rows (circa)
/*!40000 ALTER TABLE `scommessa` DISABLE KEYS */;
INSERT INTO `scommessa` (`idGara`, `idCavallo`, `nomeUtente`, `puntata`, `stato`) VALUES
	(1, 1, 'utente', 30, 1),
	(1, 1, 'utente2', 13, 1);
/*!40000 ALTER TABLE `scommessa` ENABLE KEYS */;

-- Dump della struttura di tabella ippopodromo.utente
CREATE TABLE IF NOT EXISTS `utente` (
  `nomeUtente` varchar(40) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `dataNascita` date NOT NULL,
  `indirizzo` varchar(60) NOT NULL,
  `citta` varchar(30) NOT NULL,
  `credito` int(11) NOT NULL,
  `password` varchar(20) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`nomeUtente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ippopodromo.utente: ~3 rows (circa)
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` (`nomeUtente`, `nome`, `cognome`, `dataNascita`, `indirizzo`, `citta`, `credito`, `password`, `mail`, `admin`) VALUES
	('admin', 'Gianluca', 'Innusa', '1999-12-25', 'Via degli Admin 33', 'Castelfranco Veneto', 9999, 'admin', 'matteo16.martini@outlook.it', 1),
	('utente', 'utente', 'utente', '2000-03-03', 'Via degli utenti 69', 'quella bella', 400, 'utente', 'random@random.com', 0),
	('utente2', 'rewqrewq', 'rewqrewq', '0004-04-04', 'rewqrewq', 'fewqfewq', 75, 'utente2', 'fdasfdsa@fdsafd.it', 0);
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;