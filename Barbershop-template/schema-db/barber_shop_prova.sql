-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Lug 04, 2022 alle 16:04
-- Versione del server: 5.7.34
-- Versione PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barber_shop_prova`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appuntamento`
--

CREATE TABLE `appuntamento` (
  `idAppuntamento` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `inizioDataAppuntamento` date NOT NULL,
  `inizioTempoAppuntamento` time NOT NULL,
  `fineAppuntamentoPrevisto` timestamp NULL DEFAULT NULL,
  `cancellazione` tinyint(1) NOT NULL,
  `ragioneCancellazione` text,
  `createdAt` datetime NOT NULL,
  `updateAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `appuntamento`
--

INSERT INTO `appuntamento` (`idAppuntamento`, `idUtente`, `inizioDataAppuntamento`, `inizioTempoAppuntamento`, `fineAppuntamentoPrevisto`, `cancellazione`, `ragioneCancellazione`, `createdAt`, `updateAt`) VALUES
(21, 3, '2022-07-08', '16:00:00', NULL, 0, NULL, '2022-07-02 14:31:27', NULL),
(22, 3, '2022-07-08', '17:00:00', NULL, 0, NULL, '2022-07-04 14:58:37', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `attivita`
--

CREATE TABLE `attivita` (
  `idAttivita` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `nomeAttivita` varchar(50) NOT NULL,
  `descrizioneAttivita` varchar(200) NOT NULL,
  `prezzoAttivita` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `attivita`
--

INSERT INTO `attivita` (`idAttivita`, `idCategoria`, `nomeAttivita`, `descrizioneAttivita`, `prezzoAttivita`) VALUES
(1, 10, 'Taglio Capelli', 'Servizio di taglio dei capelli.', '12.00'),
(2, 10, 'Piega Capelli', 'Servizio di piega per capelli', '10.00'),
(3, 10, 'Colore Capelli', 'Servizio colore (ricrescita) capelli', '10.00'),
(5, 8, 'American Shave', 'Servizio di rasatura barba relax in tre passaggi con tutti i comfort.', '25.00'),
(6, 9, 'Face Cleaning', 'Trattamento di pulizia della pelle del viso', '10.00'),
(7, 9, 'Maschera viso', 'Trattamento di pulizia pelle viso ed applicazione maschera', '20.00'),
(9, 8, 'Traditional Shave', 'Servizio di rasatura tradizionale', '20.00');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoriaAttivita`
--

CREATE TABLE `categoriaAttivita` (
  `idCategoria` int(11) NOT NULL,
  `nomeCategoria` varchar(50) NOT NULL,
  `descrizioneCategoria` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `categoriaAttivita`
--

INSERT INTO `categoriaAttivita` (`idCategoria`, `nomeCategoria`, `descrizioneCategoria`) VALUES
(8, 'Rasatura', 'Descrizione per servizio rasatura'),
(9, 'Trattamento Pelle', 'Descrizione trattamento della pelle'),
(10, 'Trattamento Capelli', 'Descrizione trattamento dei capelli');

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendenti`
--

CREATE TABLE `dipendenti` (
  `idDipendente` int(11) NOT NULL,
  `idImmagine` int(11) NOT NULL,
  `nomeDipendente` varchar(50) NOT NULL,
  `cognomeDipendente` varchar(50) NOT NULL,
  `cellulareDipendente` varchar(50) NOT NULL,
  `emailDipendente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `dipendenti`
--

INSERT INTO `dipendenti` (`idDipendente`, `idImmagine`, `nomeDipendente`, `cognomeDipendente`, `cellulareDipendente`, `emailDipendente`) VALUES
(3, 14, 'Francesco', 'Totti', '4444444444', 'francesco.totti@roma.com'),
(4, 15, 'Daniele ', 'De Rossi', '1234567892', 'ddr.16@roma.com'),
(5, 16, 'Lorenzo', 'Pellegrini', '2222222222', 'lorenzo.pellegrini@roma.com'),
(6, 17, 'Jose ', 'Mourinho', '3333333333', 'jose.mou@roma.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `galleria`
--

CREATE TABLE `galleria` (
  `idImmagine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `galleria`
--

INSERT INTO `galleria` (`idImmagine`) VALUES
(5),
(6),
(7),
(9),
(10),
(11),
(12),
(13);

-- --------------------------------------------------------

--
-- Struttura della tabella `gruppi`
--

CREATE TABLE `gruppi` (
  `idGruppo` int(11) NOT NULL,
  `nomeGruppo` varchar(30) NOT NULL,
  `descrizioneGruppo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `gruppi`
--

INSERT INTO `gruppi` (`idGruppo`, `nomeGruppo`, `descrizioneGruppo`) VALUES
(1, 'admin', 'administrator'),
(2, 'user', 'normaluser');

-- --------------------------------------------------------

--
-- Struttura della tabella `gruppiServizi`
--

CREATE TABLE `gruppiServizi` (
  `idGruppo` int(11) NOT NULL,
  `idServizio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `gruppiServizi`
--

INSERT INTO `gruppiServizi` (`idGruppo`, `idServizio`) VALUES
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 15),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62);

-- --------------------------------------------------------

--
-- Struttura della tabella `immagini`
--

CREATE TABLE `immagini` (
  `idImmagine` int(11) NOT NULL,
  `path` varchar(50) NOT NULL,
  `alt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `immagini`
--

INSERT INTO `immagini` (`idImmagine`, `path`, `alt`) VALUES
(2, 'design/images/barbershop_image_1.jpg', 'Prima slide carosello'),
(3, 'design/images/barbershop_image_2.jpg', 'Seconda slide carosello'),
(4, 'design/images/barbershop_image_3.jpg', 'Terza slide carosello'),
(5, 'design/images/portfolio-4.jpg', 'Immagine galleria 1'),
(6, 'design/images/portfolio-5.jpg', 'Immagine galleria 2'),
(7, 'design/images/portfolio-6.jpg', 'Immagine galleria 3'),
(9, 'design/images/portfolio-7.jpg', 'Immagine galleria 4'),
(10, 'design/images/portfolio-8.jpg', 'Immagine galleria 5'),
(11, 'design/images/portfolio-1.jpg', 'Immagine galleria 6'),
(12, 'design/images/portfolio-2.jpg', 'Immagine galleria 7'),
(13, 'design/images/portfolio-3.jpg', 'Immagine galleria 8'),
(14, 'design/images/team-1.jpg', 'Immagine dipendente 1'),
(15, 'design/images/team-2.jpg', 'Immagine dipendente 2'),
(16, 'design/images/team-3.jpg', 'Immagine dipendente 3'),
(17, 'design/images/team-4.jpg', 'Immagine dipendente 4'),
(18, 'design/images/barbershop_image_1.jpg', 'Quarta slide carosello'),
(19, 'design/images/barbershop_logo.png', 'Immagine logo sito web');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `idAppuntamento` int(11) NOT NULL,
  `idAttivita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO `prenotazione` (`idAppuntamento`, `idAttivita`) VALUES
(21, 1),
(21, 1),
(22, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `servizi`
--

CREATE TABLE `servizi` (
  `idServizio` int(11) NOT NULL,
  `script` varchar(100) NOT NULL,
  `descrizioneServizio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `servizi`
--

INSERT INTO `servizi` (`idServizio`, `script`, `descrizioneServizio`) VALUES
(4, '/TecWeb/Barbershop-template/login.php', 'script per procedura di login '),
(5, '/TecWeb/Barbershop-template/appointment.php', 'Script per prenotare un appuntamento'),
(6, '/TecWeb/Barbershop-template/authorization-page.php', 'Script per controllare che utente è dentro il sito'),
(7, '/TecWeb/Barbershop-template/error_page.php', 'Script per pagina di errore'),
(8, '/TecWeb/Barbershop-template/signup.php', 'Script per effettuare registrazione al sito'),
(9, '/TecWeb/Barbershop-template/success_page.php', 'Script per pagina di corretta prenotazione appuntamento'),
(15, '/TecWeb/Barbershop-template/index.php', 'Script home iniziale'),
(17, '/TecWeb/Barbershop-template/index.php', 'Script home iniziale (admin)'),
(18, '/TecWeb/Barbershop-template/login.php', 'script per procedura di login (admin)'),
(19, '/TecWeb/Barbershop-template/appointment.php', 'Script per prenotare un appuntamento (admin)'),
(20, '/TecWeb/Barbershop-template/authorization-page.php', 'Script per controllare che utente è dentro il sito (admin)'),
(21, '/TecWeb/Barbershop-template/error_page.php', 'Script per pagina di errore (admin)'),
(22, '/TecWeb/Barbershop-template/success_page.php', 'Script per pagina di corretta prenotazione appuntamento (admin)'),
(23, '/TecWeb/Barbershop-template/admin/index.php', 'Script home dashboard '),
(24, '/TecWeb/Barbershop-template/admin/clients.php', 'Script per pagina clienti'),
(25, '/TecWeb/Barbershop-template/admin/appointment.php', 'Script pagina lista appuntamenti'),
(26, '/TecWeb/Barbershop-template/admin/appointment_delete.php', 'Script per cancellare appuntamento'),
(27, '/TecWeb/Barbershop-template/admin/appointment_edit.php', 'Script per modificare appuntamento'),
(28, '/TecWeb/Barbershop-template/admin/employees.php', 'Script lista staff'),
(29, '/TecWeb/Barbershop-template/admin/employees_add.php', 'Script per aggiungere membro staff'),
(30, '/TecWeb/Barbershop-template/admin/employees_edit.php', 'Script per modificare membro staff'),
(31, '/TecWeb/Barbershop-template/admin/employees_delete.php', 'Script per cancellare membro staff'),
(32, '/TecWeb/Barbershop-template/admin/images.php', 'Script per visualizzare lista immagini'),
(33, '/TecWeb/Barbershop-template/admin/images_add.php', 'Script per aggiungere immagine '),
(34, '/TecWeb/Barbershop-template/admin/images_edit.php', 'Script per modificare immagine'),
(35, '/TecWeb/Barbershop-template/admin/images_delete.php', 'Script per cancellare immagine'),
(36, '/TecWeb/Barbershop-template/admin/images_gallery_add.php', 'Script per aggiungere immagine in galleria'),
(37, '/TecWeb/Barbershop-template/admin/images_gallery_delete.php', 'Script per cancellare immagine galleria'),
(38, '/TecWeb/Barbershop-template/admin/images_gallery_edit.php', 'Script per modificare immagine in galleria'),
(39, '/TecWeb/Barbershop-template/admin/images_slider_add.php', 'Script per aggiungere immagine in slider'),
(40, '/TecWeb/Barbershop-template/admin/images_slider_delete.php', 'Script per cancellare immagine slider'),
(41, '/TecWeb/Barbershop-template/admin/images_slider_edit.php', 'Script per modificare immagine slider'),
(42, '/TecWeb/Barbershop-template/admin/privileges.php', 'Script per visualizzare lista privilegi'),
(43, '/TecWeb/Barbershop-template/admin/privileges_add.php', 'Script per aggiungere privilegio'),
(44, '/TecWeb/Barbershop-template/admin/privileges_delete.php', 'Script per cancellare privilegio'),
(45, '/TecWeb/Barbershop-template/admin/privileges_edit.php', 'Script per modificare privilegio'),
(46, '/TecWeb/Barbershop-template/admin/profile.php', 'Script per visualizzare profilo'),
(47, '/TecWeb/Barbershop-template/admin/profile_edit.php', 'Script per modificare profilo'),
(48, '/TecWeb/Barbershop-template/admin/service_category.php', 'Script per visualizzare lista categoria servizi'),
(49, '/TecWeb/Barbershop-template/admin/service_category_add.php', 'Script per aggiungere categoria servizio'),
(50, '/TecWeb/Barbershop-template/admin/service_category_delete.php', 'Script per cancellare categoria servizio'),
(51, '/TecWeb/Barbershop-template/admin/service_category_edit.php', 'Script per modificare categoria servizio'),
(52, '/TecWeb/Barbershop-template/admin/services.php', 'Script per vedere lista servizi offerti'),
(53, '/TecWeb/Barbershop-template/admin/services_add.php', 'Script per aggiungere servizio'),
(54, '/TecWeb/Barbershop-template/admin/services_edit.php', 'Script per modificare servizio'),
(55, '/TecWeb/Barbershop-template/admin/services_delete.php', 'Script per cancellare servizio'),
(56, '/TecWeb/Barbershop-template/admin/setting.php', 'Script per impostazioni '),
(57, '/TecWeb/Barbershop-template/admin/settings_user.php', 'Script per impostazioni utente'),
(58, '/TecWeb/Barbershop-template/admin/settings_user_add.php', 'Script per aggiungere amministratore'),
(59, '/TecWeb/Barbershop-template/admin/settings_user_delete.php', 'Script per cancellare amministratore'),
(60, '/TecWeb/Barbershop-template/admin/privileges_admin_add.php', 'Script per aggiungere privilegio (admin)'),
(61, '/TecWeb/Barbershop-template/admin/privileges_admin_delete.php', 'Script per cancellare privilegio (admin)'),
(62, '/TecWeb/Barbershop-template/admin/privileges_admin_edit.php', 'Script per modificare privilegio (admin)');

-- --------------------------------------------------------

--
-- Struttura della tabella `slider`
--

CREATE TABLE `slider` (
  `idImmagine` int(11) NOT NULL,
  `idPosition` int(11) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `testo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `slider`
--

INSERT INTO `slider` (`idImmagine`, `idPosition`, `titolo`, `testo`) VALUES
(2, 0, 'Titolo Slider 1', 'Testo di esempio per Slider 1'),
(3, 1, 'Titolo Slider 2', 'Testo di esempio per Slider 2'),
(4, 2, 'Titolo Slider 3', 'Testo di esempio per Slider 3'),
(18, 4, 'Titolo slider 4', 'Testo di esempio per Slider 4');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `idUtente` int(11) NOT NULL,
  `nomeUtente` varchar(50) NOT NULL,
  `cognomeUtente` varchar(50) NOT NULL,
  `cellulareUtente` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `emailUtente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`idUtente`, `nomeUtente`, `cognomeUtente`, `cellulareUtente`, `username`, `password`, `emailUtente`) VALUES
(1, 'Lorenzo', 'Salvi', '3468192605', 'lors10', 'prova1', 'lors.93.10@gmail.com'),
(3, 'utente', 'prova', '1111111111', 'user1', 'user', NULL),
(53, 'Cesare', 'Salvi', '3468754321', 'cesar', 'password1', 'cesar@gmail.com'),
(54, 'Ida', 'Frezza', '3452187650', 'freida', 'idas', 'frezza@gmail.com'),
(56, 'Mario', 'Rossi', '3458769843', 'marios', 'prova2', 'mario@rossi.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `utentiGruppi`
--

CREATE TABLE `utentiGruppi` (
  `idUtente` int(11) NOT NULL,
  `idGruppo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utentiGruppi`
--

INSERT INTO `utentiGruppi` (`idUtente`, `idGruppo`) VALUES
(1, 1),
(3, 2),
(53, 2),
(54, 2),
(56, 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD PRIMARY KEY (`idAppuntamento`),
  ADD KEY `appuntamento_utenti` (`idUtente`);

--
-- Indici per le tabelle `attivita`
--
ALTER TABLE `attivita`
  ADD PRIMARY KEY (`idAttivita`),
  ADD KEY `servizi_categoriaServizi` (`idCategoria`);

--
-- Indici per le tabelle `categoriaAttivita`
--
ALTER TABLE `categoriaAttivita`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indici per le tabelle `dipendenti`
--
ALTER TABLE `dipendenti`
  ADD PRIMARY KEY (`idDipendente`),
  ADD KEY `barbieri_immagini` (`idImmagine`);

--
-- Indici per le tabelle `galleria`
--
ALTER TABLE `galleria`
  ADD KEY `galleria_immagine` (`idImmagine`);

--
-- Indici per le tabelle `gruppi`
--
ALTER TABLE `gruppi`
  ADD PRIMARY KEY (`idGruppo`);

--
-- Indici per le tabelle `gruppiServizi`
--
ALTER TABLE `gruppiServizi`
  ADD KEY `gruppiServices_gruppi` (`idGruppo`),
  ADD KEY `gruppiServices_services` (`idServizio`);

--
-- Indici per le tabelle `immagini`
--
ALTER TABLE `immagini`
  ADD PRIMARY KEY (`idImmagine`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD KEY `prenotazione_appuntamento` (`idAppuntamento`),
  ADD KEY `prenotazione_attivita` (`idAttivita`);

--
-- Indici per le tabelle `servizi`
--
ALTER TABLE `servizi`
  ADD PRIMARY KEY (`idServizio`);

--
-- Indici per le tabelle `slider`
--
ALTER TABLE `slider`
  ADD KEY `slider_immagini` (`idImmagine`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`idUtente`);

--
-- Indici per le tabelle `utentiGruppi`
--
ALTER TABLE `utentiGruppi`
  ADD KEY `utentiGruppi_utenti` (`idUtente`),
  ADD KEY `utentiGruppi_gruppi` (`idGruppo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `appuntamento`
--
ALTER TABLE `appuntamento`
  MODIFY `idAppuntamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `attivita`
--
ALTER TABLE `attivita`
  MODIFY `idAttivita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `categoriaAttivita`
--
ALTER TABLE `categoriaAttivita`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `dipendenti`
--
ALTER TABLE `dipendenti`
  MODIFY `idDipendente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `gruppi`
--
ALTER TABLE `gruppi`
  MODIFY `idGruppo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `immagini`
--
ALTER TABLE `immagini`
  MODIFY `idImmagine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `servizi`
--
ALTER TABLE `servizi`
  MODIFY `idServizio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `idUtente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD CONSTRAINT `appuntamento_utenti` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`idUtente`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `attivita`
--
ALTER TABLE `attivita`
  ADD CONSTRAINT `servizi_categoriaServizi` FOREIGN KEY (`idCategoria`) REFERENCES `categoriaAttivita` (`idCategoria`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `dipendenti`
--
ALTER TABLE `dipendenti`
  ADD CONSTRAINT `barbieri_immagini` FOREIGN KEY (`idImmagine`) REFERENCES `immagini` (`idImmagine`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `galleria`
--
ALTER TABLE `galleria`
  ADD CONSTRAINT `galleria_immagine` FOREIGN KEY (`idImmagine`) REFERENCES `immagini` (`idImmagine`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `gruppiServizi`
--
ALTER TABLE `gruppiServizi`
  ADD CONSTRAINT `gruppiServices_gruppi` FOREIGN KEY (`idGruppo`) REFERENCES `gruppi` (`idGruppo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `gruppiServices_services` FOREIGN KEY (`idServizio`) REFERENCES `servizi` (`idServizio`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_appuntamento` FOREIGN KEY (`idAppuntamento`) REFERENCES `appuntamento` (`idAppuntamento`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `prenotazione_attivita` FOREIGN KEY (`idAttivita`) REFERENCES `attivita` (`idAttivita`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `slider`
--
ALTER TABLE `slider`
  ADD CONSTRAINT `slider_immagini` FOREIGN KEY (`idImmagine`) REFERENCES `immagini` (`idImmagine`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `utentiGruppi`
--
ALTER TABLE `utentiGruppi`
  ADD CONSTRAINT `utentiGruppi_gruppi` FOREIGN KEY (`idGruppo`) REFERENCES `gruppi` (`idGruppo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `utentiGruppi_utenti` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`idUtente`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
