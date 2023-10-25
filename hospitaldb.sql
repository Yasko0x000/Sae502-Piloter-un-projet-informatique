-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ott 25, 2023 alle 20:57
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospitaldb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `badgesrfid`
--

CREATE TABLE `badgesrfid` (
  `ID` int(11) NOT NULL,
  `IDBadgeRFID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `badgesrfid`
--

INSERT INTO `badgesrfid` (`ID`, `IDBadgeRFID`) VALUES
(1, 12345),
(2, 67890),
(3, 54321),
(4, 98765),
(5, 11111),
(6, 22222),
(7, 33333),
(8, 44444),
(9, 55555),
(10, 66666);

-- --------------------------------------------------------

--
-- Struttura della tabella `docteurs`
--

CREATE TABLE `docteurs` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `IDBadgeRFID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `docteurs`
--

INSERT INTO `docteurs` (`ID`, `Nom`, `Prenom`, `IDBadgeRFID`) VALUES
(1, 'Anderson', 'Emily', 11111),
(2, 'Miller', 'Oliver', 22222),
(3, 'Clark', 'Sarah', 33333),
(4, 'White', 'Robert', 12345),
(5, 'Harris', 'Susan', 54321),
(6, 'Lee', 'Richard', 98765),
(7, 'Hall', 'Megan', 44444),
(8, 'Walker', 'Samuel', 66666);

-- --------------------------------------------------------

--
-- Struttura della tabella `operations`
--

CREATE TABLE `operations` (
  `ID` int(11) NOT NULL,
  `NomOperation` varchar(255) NOT NULL,
  `DateOperation` date NOT NULL,
  `Etat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `operations`
--

INSERT INTO `operations` (`ID`, `NomOperation`, `DateOperation`, `Etat`) VALUES
(1, 'Opération du cœur', '2023-10-01', 'En cours'),
(2, 'Chirurgie orthopédique', '2023-09-05', 'Terminée'),
(3, 'Gastroscopie', '2023-08-15', 'En cours'),
(4, 'Chirurgie plastique', '2023-07-20', 'Terminée'),
(5, 'Appendicectomie', '2023-06-05', 'En cours'),
(6, 'Césarienne', '2023-05-10', 'Terminée'),
(7, 'Opération de la rétine', '2023-04-15', 'En cours'),
(8, 'Transplantation rénale', '2023-03-20', 'Terminée'),
(9, 'Chirurgie dentaire', '2023-02-25', 'En cours'),
(10, 'Chirurgie bariatrique', '2023-01-30', 'Terminée');

-- --------------------------------------------------------

--
-- Struttura della tabella `patients`
--

CREATE TABLE `patients` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `DateNaissance` date NOT NULL,
  `OperationID` int(11) DEFAULT NULL,
  `DocteurID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `patients`
--

INSERT INTO `patients` (`ID`, `Nom`, `Prenom`, `DateNaissance`, `OperationID`, `DocteurID`) VALUES
(1, 'Smith', 'John', '1990-01-01', 1, 8),
(2, 'Johnson', 'Mary', '1985-02-02', 2, 3),
(3, 'Williams', 'David', '1982-03-15', 3, 1),
(4, 'Davis', 'Linda', '1987-04-20', 4, 8),
(5, 'Brown', 'Michael', '1980-05-05', 5, 2),
(6, 'Wilson', 'Anna', '1975-06-10', 6, 5),
(7, 'Jones', 'James', '1995-07-15', 7, 6),
(8, 'Grinta', 'Emily', '1989-08-20', 8, 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `salledesoperations`
--

CREATE TABLE `salledesoperations` (
  `ID` int(11) NOT NULL,
  `NomSalle` varchar(255) NOT NULL,
  `IDBadgeRFID` int(11) NOT NULL,
  `DateAcces` datetime NOT NULL,
  `OperationEnCoursID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `salledesoperations`
--

INSERT INTO `salledesoperations` (`ID`, `NomSalle`, `IDBadgeRFID`, `DateAcces`, `OperationEnCoursID`) VALUES
(6, 'Salle 1', 1, '2023-10-25 17:39:25', 1),
(7, 'Salle 2', 2, '2023-10-25 17:39:25', 3),
(8, 'Salle 3', 3, '2023-10-25 17:39:25', 5),
(9, 'Salle Urgence', 1, '2023-10-25 17:39:25', 7),
(10, 'Salle Urgence ++', 4, '2023-10-25 17:39:25', 9);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `badgesrfid`
--
ALTER TABLE `badgesrfid`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `docteurs`
--
ALTER TABLE `docteurs`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `salledesoperations`
--
ALTER TABLE `salledesoperations`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDBadgeRFID` (`IDBadgeRFID`),
  ADD KEY `FK_OperationEnCours` (`OperationEnCoursID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `badgesrfid`
--
ALTER TABLE `badgesrfid`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `docteurs`
--
ALTER TABLE `docteurs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `operations`
--
ALTER TABLE `operations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `patients`
--
ALTER TABLE `patients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `salledesoperations`
--
ALTER TABLE `salledesoperations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `salledesoperations`
--
ALTER TABLE `salledesoperations`
  ADD CONSTRAINT `FK_OperationEnCours` FOREIGN KEY (`OperationEnCoursID`) REFERENCES `operations` (`ID`),
  ADD CONSTRAINT `salledesoperations_ibfk_1` FOREIGN KEY (`IDBadgeRFID`) REFERENCES `badgesrfid` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
