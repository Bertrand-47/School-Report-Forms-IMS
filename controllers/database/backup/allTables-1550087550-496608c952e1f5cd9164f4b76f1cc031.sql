DROP TABLE IF EXISTS accounts;

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `permission` varchar(100) NOT NULL,
  `school` varchar(50) NOT NULL,
  `school_level` int(11) NOT NULL,
  `default_password` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

INSERT INTO accounts VALUES("4","Admin","admin@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Administrator","1","0","1","2018-07-17 12:25:52"),
("33","test teacher","test@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","1","0","2019-02-07 13:35:36"),
("34","irene","ira@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","2","0","2019-02-07 15:46:54"),
("37","Kibugenza Didier","kibugenzad@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Administrator","1","1","0","2019-02-10 14:59:10"),
("38","test","tesrererert@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Administrator","1","1","0","2019-02-10 15:01:23");



DROP TABLE IF EXISTS attendance;

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `type` varchar(40) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS classes;

CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `session` int(11) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `numbericname` varchar(20) NOT NULL,
  `section` varchar(10) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

INSERT INTO classes VALUES("29","1","7","1","1","a","2019-02-13 10:03:51"),
("30","1","7","1","2","a","2019-02-13 10:32:09"),
("31","1","8","2","1","a","2019-02-13 21:45:57"),
("32","1","8","2","2","a","2019-02-13 21:46:13");



DROP TABLE IF EXISTS courses;

CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `school_level` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `subjectname` int(11) NOT NULL,
  `coursename` varchar(200) NOT NULL,
  `maxcat` int(11) NOT NULL,
  `maxexam` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

INSERT INTO courses VALUES("115","1","1","7","16","Kwandika","10","10","2147483647"),
("116","1","1","7","16","Gusoma","20","20","2147483647"),
("119","1","2","8","0","test","0","0","2147483647"),
("120","1","2","8","0","TEST2","0","0","2147483647");



DROP TABLE IF EXISTS database_backups;

CREATE TABLE `database_backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolkey` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `filename` text NOT NULL,
  `file_url` text NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS nursery_marks;

CREATE TABLE `nursery_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` int(11) NOT NULL,
  `school_level` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `quotation` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

INSERT INTO nursery_marks VALUES("33","1","2","28","8","20","50","100","EXCELENT NO COLOR","2019-02-08 23:30:21"),
("34","1","2","28","8","20","50","101","VERY GOOD NO COLOR","2019-02-08 23:34:21"),
("35","1","2","28","8","31","62","119","EXCELENT NO COLOR","2019-02-13 21:51:52"),
("36","1","2","28","8","31","62","120","GOOD COLOR","2019-02-13 21:51:55");



DROP TABLE IF EXISTS school_levels;

CREATE TABLE `school_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO school_levels VALUES("1","Primary"),
("2","Nursery");



DROP TABLE IF EXISTS schools;

CREATE TABLE `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolname` text NOT NULL,
  `schoollogo` text NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO schools VALUES("1","Imena","","2018-08-10 00:00:00");



DROP TABLE IF EXISTS sections;

CREATE TABLE `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `class` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `teacher` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS sessions;

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `school_level` int(11) NOT NULL,
  `academic_year` varchar(100) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO sessions VALUES("7","1","1","2019","2019-02-12","2019-02-20","Current","2019-02-07 12:51:28"),
("8","1","2","2019","2019-02-07","2019-03-01","Current","2019-02-07 15:22:19");



DROP TABLE IF EXISTS student_comments;

CREATE TABLE `student_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO student_comments VALUES("1","49","7","18","25","sdsdsdsdsd","2019-02-09 01:13:29");



DROP TABLE IF EXISTS student_marks;

CREATE TABLE `student_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `session` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `cat` varchar(100) NOT NULL,
  `exam` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

INSERT INTO student_marks VALUES("20","1","7","18","25","71","45","5.2","6.4","2019-02-07 13:41:08"),
("21","1","7","18","25","72","45","40","34","2019-02-07 13:41:18"),
("22","1","7","18","25","73","45","12","14","2019-02-07 13:41:27"),
("23","1","7","18","25","71","46","7","8","2019-02-07 13:41:37"),
("24","1","7","18","25","72","46","43","47","2019-02-07 13:41:45"),
("25","1","7","18","25","73","46","12","16","2019-02-07 13:41:52"),
("26","1","7","18","25","71","47","4","2","2019-02-07 13:42:02"),
("27","1","7","18","25","72","47","45","6","2019-02-07 13:42:12"),
("28","1","7","18","25","73","47","3","14","2019-02-07 13:42:19"),
("29","1","7","18","25","71","49","5","6","2019-02-07 15:00:41"),
("30","1","7","18","25","72","49","43","35","2019-02-07 15:00:53"),
("31","1","7","18","25","73","49","12","18","2019-02-07 15:01:03"),
("32","1","7","18","25","86","45","4","2","2019-02-07 15:09:34"),
("33","1","7","18","25","86","46","3","4","2019-02-07 15:09:43"),
("34","1","7","18","25","86","46","3","0","2019-02-07 15:09:43"),
("35","1","7","18","25","86","46","3","0","2019-02-07 15:09:43"),
("36","1","7","18","25","86","47","5","3","2019-02-07 15:09:52"),
("37","1","7","18","25","87","45","2","3","2019-02-07 15:09:59"),
("38","1","7","18","25","87","45","2","0","2019-02-07 15:09:59"),
("39","1","7","18","25","87","45","2","0","2019-02-07 15:10:00"),
("40","1","7","18","25","87","46","4","2","2019-02-07 15:10:13"),
("41","1","7","18","25","87","47","0","1","2019-02-07 15:10:20"),
("42","1","7","18","25","87","47","0","0","2019-02-07 15:10:20"),
("43","1","7","18","25","87","47","0","0","2019-02-07 15:10:20"),
("44","1","7","18","25","86","49","2","4","2019-02-07 15:10:28"),
("45","1","7","18","25","87","49","4","3","2019-02-07 15:10:33"),
("46","1","7","19","25","86","48","3","2","2019-02-07 15:15:33"),
("47","1","7","19","25","87","48","1","4","2019-02-07 15:15:40"),
("48","1","7","19","25","87","48","1","0","2019-02-07 15:15:40"),
("49","1","7","19","25","87","48","1","0","2019-02-07 15:15:40"),
("50","1","7","29","25","116","60","12","","2019-02-13 21:42:08"),
("51","1","7","29","25","115","60","5","","2019-02-13 21:42:35");



DROP TABLE IF EXISTS student_positions;

CREATE TABLE `student_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_level` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` varchar(100) NOT NULL,
  `class` int(11) NOT NULL,
  `percentage` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

INSERT INTO student_positions VALUES("92","1","45","7","25","18","15.3"),
("93","1","45","7","y_0","18","5.1"),
("94","1","46","7","25","18","18.3"),
("95","1","46","7","y_0","18","6.1"),
("96","1","47","7","25","18","10.4"),
("97","1","47","7","y_0","18","3.5"),
("98","1","49","7","25","18","16.5"),
("99","1","49","7","y_0","18","5.5"),
("100","1","48","7","25","19","1.3"),
("101","1","48","7","y_0","19","0.4"),
("102","1","60","7","25","29","28.3");



DROP TABLE IF EXISTS student_remarques;

CREATE TABLE `student_remarques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `remarques` text NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS students;

CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `school_level` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `classname` int(11) NOT NULL,
  `date_birth` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `fathername` varchar(100) NOT NULL,
  `mothername` varchar(100) NOT NULL,
  `phonenumber` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

INSERT INTO students VALUES("60","1","1","7","yves","Didier","29","2019-02-01","Male","","","","KG 562 St, Kigali","2019-02-13 21:31:47"),
("61","1","1","7","Kibugenzadsdsd","Didiersdsdsd","30","2019-02-01","Male","sdsdsd","sdsd","sdsdsd","KG 562 St, Kigali","2019-02-13 21:37:18"),
("62","1","2","8","Kibugenza","Didier","31","2019-02-01","Male","","","","KG 562 St, Kigali","2019-02-13 21:50:54");



DROP TABLE IF EXISTS subjects;

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `session` int(11) NOT NULL,
  `school_level` int(11) NOT NULL,
  `subjectname` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO subjects VALUES("11","1","7","1","Mathematics","2019-02-07 12:58:14"),
("12","1","7","1","English","2019-02-07 12:58:25"),
("13","1","7","1","science & ICT","2019-02-07 12:58:43"),
("14","1","7","1","SOCIAL STUDIES & RELIGION","2019-02-07 12:59:04"),
("15","1","7","1","FRANCAIS","2019-02-07 12:59:11"),
("16","1","7","1","KINYARWANDA","2019-02-07 12:59:21"),
("17","1","7","1","CREATIVE ARTS","2019-02-07 12:59:31");



DROP TABLE IF EXISTS teacher_classes;

CREATE TABLE `teacher_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_key` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `school_level` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO teacher_classes VALUES("7","60","29","7","1","2019-02-13 10:30:34"),
("8","60","30","7","1","2019-02-13 10:32:09"),
("9","61","31","8","2","2019-02-13 21:45:57"),
("10","61","32","8","2","2019-02-13 21:46:13");



DROP TABLE IF EXISTS teacher_courses;

CREATE TABLE `teacher_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_key` varchar(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `school_level` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO teacher_courses VALUES("9","708021","115","7","1","2019-02-13 20:48:20"),
("10","708021","116","7","1","2019-02-13 21:08:31"),
("11","776706","119","8","2","2019-02-13 21:50:34"),
("12","776706","120","8","2","2019-02-13 21:51:32");



DROP TABLE IF EXISTS teachers;

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_key` int(11) NOT NULL,
  `school` varchar(100) NOT NULL,
  `school_level` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

INSERT INTO teachers VALUES("60","708021","1","1","7","test teacher","0785609090","test@gmail.com","2019-02-07 13:35:36"),
("61","776706","1","2","8","irene","0785609090","ira@gmail.com","2019-02-07 15:46:54");



DROP TABLE IF EXISTS terms;

CREATE TABLE `terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term` varchar(100) NOT NULL,
  `startingdate` date NOT NULL,
  `endingdate` date NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

INSERT INTO terms VALUES("25","1","7","Term 1","2019-02-07","2019-02-21","2019-02-07 13:38:51"),
("26","1","7","Term 2","2019-02-25","2019-03-08","2019-02-07 13:39:15"),
("27","1","7","Term 3","2019-03-13","2019-03-20","2019-02-07 13:39:37"),
("28","1","8","Term 1","2019-02-07","2019-02-21","2019-02-07 15:48:26");



