-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 05 Juin 2017 à 17:39
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `virtualhosts`
--

-- --------------------------------------------------------

--
-- Structure de la table `host`
--

CREATE TABLE `host` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ipv4` varchar(15) DEFAULT NULL,
  `ipv6` varchar(45) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `host`
--

INSERT INTO `host` (`id`, `name`, `ipv4`, `ipv6`, `idUser`) VALUES
(1, 'srv1', '192.168.1.101', NULL, 2),
(2, 'srv2', '192.168.1.102', NULL, 2),
(40, 'test', 'ertert', NULL, 2),
(41, 'Machine location', '192.168.1.103', NULL, 1);

--
-- Déclencheurs `host`
--
DELIMITER $$
CREATE TRIGGER `Delete Host` BEFORE DELETE ON `host` FOR EACH ROW BEGIN

DELETE FROM server WHERE idHost = Old.id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `prority` int(11) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `property`
--

INSERT INTO `property` (`id`, `name`, `description`, `prority`, `required`) VALUES
(1, 'ServerName', 'Nom d\'hôte et port que le serveur utilise pour s\'authentifier lui-même', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'superadmin');

-- --------------------------------------------------------

--
-- Structure de la table `server`
--

CREATE TABLE `server` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `config` text,
  `configFile` varchar(255) DEFAULT NULL,
  `idHost` int(11) DEFAULT NULL,
  `idStype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `server`
--

INSERT INTO `server` (`id`, `name`, `config`, `configFile`, `idHost`, `idStype`) VALUES
(1, 'Apache2', NULL, NULL, 1, 1),
(2, 'nginX', NULL, NULL, 1, 2),
(3, 'serveur location', NULL, NULL, 41, 1);

--
-- Déclencheurs `server`
--
DELIMITER $$
CREATE TRIGGER `delete Server` BEFORE DELETE ON `server` FOR EACH ROW BEGIN

DELETE FROM virtualhost WHERE idServer = Old.id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `stype`
--

CREATE TABLE `stype` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `configTemplate` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `stype`
--

INSERT INTO `stype` (`id`, `name`, `configTemplate`) VALUES
(1, 'Apache 2', '<VirtualHost {{name}}>\n    {{properties}}\n</VirtualHost>'),
(2, 'nginX', 'server{\n	listen {{name}};\n	{{properties}}\n}');

-- --------------------------------------------------------

--
-- Structure de la table `stypeproperty`
--

CREATE TABLE `stypeproperty` (
  `idStype` int(11) NOT NULL,
  `idProperty` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `template` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `stypeproperty`
--

INSERT INTO `stypeproperty` (`idStype`, `idProperty`, `name`, `template`) VALUES
(1, 1, 'ServerName', 'ServerName {{value}}'),
(2, 1, 'server_name', 'server_name {{value}};');

-- --------------------------------------------------------

--
-- Structure de la table `url`
--

CREATE TABLE `url` (
  `id` int(11) NOT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `controller` varchar(45) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `subMenu` tinyint(1) DEFAULT NULL,
  `children` varchar(255) DEFAULT NULL,
  `tools` varchar(255) DEFAULT NULL,
  `roles` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `url`
--

INSERT INTO `url` (`id`, `icon`, `title`, `controller`, `action`, `subMenu`, `children`, `tools`, `roles`) VALUES
(1, NULL, 'Accueil', 'Index', 'index', 0, '1,2,4', NULL, NULL),
(2, NULL, 'VirtualHosts', 'Config', 'index', 0, '1,2,4', NULL, NULL),
(4, 'add square', 'Nouveau host', 'Config', 'addHost', 0, '1,2,4', NULL, NULL),
(5, NULL, 'Ajouter', 'Index', 'index', 0, '1', NULL, NULL),
(6, NULL, 'Supprimer', 'Index', 'index', 0, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `idrole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `firstname`, `name`, `email`, `idrole`) VALUES
(1, 'adminn', '0000', NULL, 'admin', 'admin@vhosts.net', 1),
(2, 'miles', '0000', 'Miles', 'DAVIS', 'miles.davis@music.com', 2),
(3, 'yaubry', '$2y$13$kqRFo6HgnQcCeUoqlQb6NeU6/Uusmy0ZvcsfYW', 'yann', 'aubry', 'yann.aubry@sts-sio-caen.info', 2),
(4, 'ttest', '$2y$13$ZzFULO7VEhOGUX7jqU6orOSOGm92Rvn5TeBExI3YEsDT5lEJmsNZ2', 'ttest', 'test', 'test@test.fr', 2);

-- --------------------------------------------------------

--
-- Structure de la table `virtualhost`
--

CREATE TABLE `virtualhost` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `config` text,
  `idServer` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `virtualhost`
--

INSERT INTO `virtualhost` (`id`, `name`, `config`, `idServer`, `idUser`) VALUES
(2, '*:80', NULL, 1, 2),
(3, '80 default_server', NULL, 2, 2),
(4, 'VH-test', NULL, 3, 2);

--
-- Déclencheurs `virtualhost`
--
DELIMITER $$
CREATE TRIGGER `delete VirtualHost` BEFORE DELETE ON `virtualhost` FOR EACH ROW BEGIN

DELETE FROM virtualhostproperty WHERE idVirtualhost = Old.id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `virtualhostproperty`
--

CREATE TABLE `virtualhostproperty` (
  `idVirtualhost` int(11) NOT NULL,
  `idProperty` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `comment` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `virtualhostproperty`
--

INSERT INTO `virtualhostproperty` (`idVirtualhost`, `idProperty`, `value`, `active`, `comment`) VALUES
(2, 1, 'www.virtualhosts.net', 1, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `host`
--
ALTER TABLE `host`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `idUserfk` (`idUser`);

--
-- Index pour la table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_server_host1_idx` (`idHost`),
  ADD KEY `fk_server_stype1_idx` (`idStype`);

--
-- Index pour la table `stype`
--
ALTER TABLE `stype`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stypeproperty`
--
ALTER TABLE `stypeproperty`
  ADD PRIMARY KEY (`idStype`,`idProperty`),
  ADD KEY `fk_stype_has_property_property1_idx` (`idProperty`),
  ADD KEY `fk_stype_has_property_stype1_idx` (`idStype`);

--
-- Index pour la table `url`
--
ALTER TABLE `url`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD KEY `fk_User_role1_idx` (`idrole`);

--
-- Index pour la table `virtualhost`
--
ALTER TABLE `virtualhost`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_virtualhost_server1_idx` (`idServer`),
  ADD KEY `fk_virtualhost_User1_idx` (`idUser`);

--
-- Index pour la table `virtualhostproperty`
--
ALTER TABLE `virtualhostproperty`
  ADD PRIMARY KEY (`idVirtualhost`,`idProperty`),
  ADD KEY `fk_virtualhost_has_property_property1_idx` (`idProperty`),
  ADD KEY `fk_virtualhost_has_property_virtualhost1_idx` (`idVirtualhost`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `host`
--
ALTER TABLE `host`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT pour la table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `stype`
--
ALTER TABLE `stype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `url`
--
ALTER TABLE `url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `virtualhost`
--
ALTER TABLE `virtualhost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `host`
--
ALTER TABLE `host`
  ADD CONSTRAINT `host_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `server`
--
ALTER TABLE `server`
  ADD CONSTRAINT `fk_server_stype1` FOREIGN KEY (`idStype`) REFERENCES `stype` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `server_ibfk_1` FOREIGN KEY (`idHost`) REFERENCES `host` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `stypeproperty`
--
ALTER TABLE `stypeproperty`
  ADD CONSTRAINT `fk_stype_has_property_property1` FOREIGN KEY (`idProperty`) REFERENCES `property` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_stype_has_property_stype1` FOREIGN KEY (`idStype`) REFERENCES `stype` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_role1` FOREIGN KEY (`idrole`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `virtualhost`
--
ALTER TABLE `virtualhost`
  ADD CONSTRAINT `fk_virtualhost_User1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_virtualhost_server1` FOREIGN KEY (`idServer`) REFERENCES `server` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `virtualhostproperty`
--
ALTER TABLE `virtualhostproperty`
  ADD CONSTRAINT `fk_virtualhost_has_property_property1` FOREIGN KEY (`idProperty`) REFERENCES `property` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_virtualhost_has_property_virtualhost1` FOREIGN KEY (`idVirtualhost`) REFERENCES `virtualhost` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
