

CREATE TABLE `tb_login` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `Teacher_id` int(6) DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(8) DEFAULT NULL,
  `Role` enum('admin','user') DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `tb_login` (`id`, `Teacher_id`, `Username`, `Password`, `Role`, `date`) VALUES ('1', '', 'Chamroeun', '1111', '', '2024-09-04');
INSERT INTO `tb_login` (`id`, `Teacher_id`, `Username`, `Password`, `Role`, `date`) VALUES ('2', '', 'Tii', '2222', 'admin', '');
INSERT INTO `tb_login` (`id`, `Teacher_id`, `Username`, `Password`, `Role`, `date`) VALUES ('4', '', 'Chet', '3333', 'user', '');
INSERT INTO `tb_login` (`id`, `Teacher_id`, `Username`, `Password`, `Role`, `date`) VALUES ('5', '', 'admin', 'admin', 'admin', '');


