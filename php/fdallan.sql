-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Gen 13, 2021 alle 09:00
-- Versione del server: 10.1.47-MariaDB-0ubuntu0.18.04.1
-- Versione PHP: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fdallan`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Cavallo`
--

CREATE TABLE `Cavallo` (
  `idCavallo` int(11) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `immagine` varchar(100) DEFAULT NULL,
  `fiducia` int(11) NOT NULL,
  `stanchezza` int(11) NOT NULL,
  `velocita` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Gara`
--

CREATE TABLE `Gara` (
  `idGara` int(11) NOT NULL,
  `dataGara` datetime NOT NULL,
  `stato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Partecipante`
--

CREATE TABLE `Partecipante` (
  `idGara` int(11) NOT NULL,
  `idCavallo` int(11) NOT NULL,
  `posizione` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

CREATE TABLE `Utente` (
  `nomeUtente` varchar(40) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `dataNascita` date NOT NULL,
  `indirizzo` varchar(60) NOT NULL,
  `citta` varchar(30) NOT NULL,
  `credito` int(11) NOT NULL,
  `password` varchar(20) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Utente`
--

INSERT INTO `Utente` (`nomeUtente`, `nome`, `cognome`, `dataNascita`, `indirizzo`, `citta`, `credito`, `password`, `mail`, `admin`) VALUES
('admin', 'Gianluca', 'Innusa', '1999-12-25', 'Via degli Admin 33', 'Castelfranco Veneto', 9999, 'admin', 'matteo16.martini@outlook.it', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Cavallo`
--
ALTER TABLE `Cavallo`
  ADD PRIMARY KEY (`idCavallo`);

--
-- Indici per le tabelle `Gara`
--
ALTER TABLE `Gara`
  ADD PRIMARY KEY (`idGara`);

--
-- Indici per le tabelle `Partecipante`
--
ALTER TABLE `Partecipante`
  ADD PRIMARY KEY (`idGara`,`idCavallo`),
  ADD KEY `idCavallo` (`idCavallo`);

--
-- Indici per le tabelle `Utente`
--
ALTER TABLE `Utente`
  ADD PRIMARY KEY (`nomeUtente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Cavallo`
--
ALTER TABLE `Cavallo`
  MODIFY `idCavallo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `Gara`
--
ALTER TABLE `Gara`
  MODIFY `idGara` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Partecipante`
--
ALTER TABLE `Partecipante`
  ADD CONSTRAINT `Partecipante_ibfk_1` FOREIGN KEY (`idGara`) REFERENCES `Gara` (`idGara`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Partecipante_ibfk_2` FOREIGN KEY (`idCavallo`) REFERENCES `Cavallo` (`idCavallo`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
