CREATE TABLE `orderbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zdrojova_mena` varchar(3) NOT NULL,
  `cielova_mena` varchar(3) NOT NULL,
  `cena` float NOT NULL,
  `priznak` varchar(4) NOT NULL,
  `casova_peciatka` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12201 DEFAULT CHARSET=utf8mb4