

CREATE TABLE `tb_class` (
  `ClassID` int(6) NOT NULL AUTO_INCREMENT,
  `Class_name` varchar(30) DEFAULT NULL,
  `Class_Type` varchar(1) DEFAULT NULL,
  `Teacher_id` int(6) DEFAULT NULL,
  `course_id` int(6) DEFAULT NULL,
  `Time_in` varchar(10) DEFAULT NULL,
  `Time_out` varchar(10) DEFAULT NULL,
  `Shift` varchar(15) DEFAULT NULL,
  `Start_class` date DEFAULT NULL,
  `End_class` date DEFAULT NULL,
  `Create_at` timestamp(5) NULL DEFAULT NULL,
  `Update_at` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ClassID`) USING BTREE,
  KEY `Teacher_id` (`Teacher_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `tb_class_ibfk_1` FOREIGN KEY (`Teacher_id`) REFERENCES `tb_teacher` (`id`),
  CONSTRAINT `tb_class_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `tb_course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `tb_class` (`ClassID`, `Class_name`, `Class_Type`, `Teacher_id`, `course_id`, `Time_in`, `Time_out`, `Shift`, `Start_class`, `End_class`, `Create_at`, `Update_at`, `status`) VALUES ('16', 'A001', '', '12', '164', '7', '9', 'PM', '', '2024-10-14', '', '', 'active');
INSERT INTO `tb_class` (`ClassID`, `Class_name`, `Class_Type`, `Teacher_id`, `course_id`, `Time_in`, `Time_out`, `Shift`, `Start_class`, `End_class`, `Create_at`, `Update_at`, `status`) VALUES ('17', 'A002', '', '13', '165', '9', '11', 'AM', '', '0000-00-00', '', '', 'active');
INSERT INTO `tb_class` (`ClassID`, `Class_name`, `Class_Type`, `Teacher_id`, `course_id`, `Time_in`, `Time_out`, `Shift`, `Start_class`, `End_class`, `Create_at`, `Update_at`, `status`) VALUES ('18', 'A003', '', '12', '164', '7', '9', 'PM', '', '2024-10-14', '', '', 'active');
INSERT INTO `tb_class` (`ClassID`, `Class_name`, `Class_Type`, `Teacher_id`, `course_id`, `Time_in`, `Time_out`, `Shift`, `Start_class`, `End_class`, `Create_at`, `Update_at`, `status`) VALUES ('19', 'A001', '', '13', '166', '', '', 'AM', '', '2024-12-15', '', '', 'disable');
INSERT INTO `tb_class` (`ClassID`, `Class_name`, `Class_Type`, `Teacher_id`, `course_id`, `Time_in`, `Time_out`, `Shift`, `Start_class`, `End_class`, `Create_at`, `Update_at`, `status`) VALUES ('21', '', '', '', '', '', '', 'AM', '', '0000-00-00', '', '', 'disable');


