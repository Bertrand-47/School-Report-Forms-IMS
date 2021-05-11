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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

INSERT INTO accounts VALUES("4","Admin","admin@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Administrator","1","0","1","2018-07-17 12:25:52"),
("5","Demo Teacher","teacher@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","1","1","2018-09-08 13:38:33"),
("7","Test teacher","testteacher@gmail.com","d41d8cd98f00b204e9800998ecf8427e","Teacher","1","2","0","2018-12-04 20:29:30"),
("8","Test teacher","t@gmail.com","d41d8cd98f00b204e9800998ecf8427e","Teacher","1","2","0","2018-12-04 20:33:38"),
("9","Test teacher","gfgfgfg@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","2","0","2018-12-04 20:43:58"),
("10","cxcxcxcxc","sdsdsdsd@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","2","0","2018-12-04 20:44:45"),
("11","cxcxcxcxc","test@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","1","0","2019-01-23 14:58:54"),
("12","onesphore","one@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","1","0","2019-01-23 15:08:59"),
("18","Kibugenza Didier","kibugenza@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","1","0","2019-02-05 21:21:07"),
("21","Kibugenza Didier","kibasasasugenzad@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Administrator","1","1","0","2019-02-05 23:11:34"),
("29","asasas","asasas@gmail.com","fe01ce2a7fbac8fafaed7c982a04e229","Teacher","1","1","0","2019-02-05 23:21:58"),
("32","Kibugenza Didiers","kibugenzan@gmail.com","d92ae8be73a767788c541f961862d550","Teacher","1","2","1","2019-02-06 23:03:54");



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
  `teacher` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO classes VALUES("11","1","4","2","1","A","0","2018-10-30 15:30:38"),
("12","1","6","2","1","A","50","2018-11-03 12:40:24"),
("13","1","5","1","1","A","44","2018-11-18 13:59:41"),
("14","1","6","2","2","b","31","2018-12-04 21:55:28"),
("15","1","7","1","1","b","0","2019-01-23 14:28:24"),
("16","1","5","1","1","b","37","2019-02-05 13:52:49"),
("17","1","5","1","2","a","44","2019-02-05 22:15:20");



DROP TABLE IF EXISTS courses;

CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `school_level` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `subjectname` int(11) NOT NULL,
  `coursename` varchar(200) NOT NULL,
  `teacher` int(11) NOT NULL,
  `assistant` int(11) NOT NULL,
  `maxcat` int(11) NOT NULL,
  `maxexam` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

INSERT INTO courses VALUES("42","1","2","6","0","FRANCAIS:EXPRESSION","316808","904548","0","0","2147483647"),
("43","1","2","6","0","PRE-ECRITURE","998334","0","0","0","2147483647"),
("44","1","2","6","0","PRE-CALC","998334","0","0","0","2147483647"),
("45","1","2","6","0","ACTIVITES MANUELLES","904548","0","0","0","2147483647"),
("46","1","2","6","0","SPORT","650863","650863","0","0","2147483647"),
("47","1","2","6","0","ACTIVITES SENSORIELLES","316808","0","0","0","2147483647"),
("48","1","2","6","0","POLITESSE SOCIABILITE MORALE","650863","650863","0","0","2147483647"),
("49","1","2","6","0","ANGLAIS EXPRESSION","650863","650863","0","0","2147483647"),
("51","1","1","5","2","Mental Calculation","0","0","10","10","2147483647"),
("52","1","1","5","2","Written Calculation","0","0","50","50","2147483647"),
("53","1","1","5","2","geometry","421134","0","20","20","2147483647"),
("54","1","1","5","2","metric System","0","0","20","20","2147483647"),
("55","1","1","5","3","Reading and Speaking","0","0","10","10","2147483647"),
("56","1","1","5","3","writing","0","0","40","40","2147483647"),
("57","1","1","5","4","Science","0","0","50","50","2147483647"),
("58","1","1","5","4","iCT","0","0","25","25","2147483647"),
("59","1","1","5","5","Social Studies","0","0","40","40","2147483647"),
("60","1","1","5","5","religion","0","0","20","20","2147483647"),
("61","1","1","5","1","Lecture -Elocution","0","0","10","10","2147483647"),
("62","1","1","5","1","ecris","395437","0","40","40","2147483647"),
("63","1","1","5","6","Gusoma","421134","0","10","10","2147483647"),
("64","1","1","5","6","kwandika","0","0","40","40","2147483647"),
("65","1","1","5","7","Drawing","395437","0","5","5","2147483647"),
("66","1","1","5","7","music and drama","0","0","5","5","2147483647"),
("67","1","1","5","7","sport","671532","0","5","5","2147483647"),
("68","1","1","7","8","orale","0","0","10","10","2147483647"),
("70","1","1","7","8","geometry","251952","0","10","10","2147483647");



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
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;

INSERT INTO nursery_marks VALUES("122","1","2","19","6","12","14","51","EXCELENT NO COLOR","2019-02-06 21:24:13"),
("123","1","2","19","6","12","14","52","VERY GOOD NO COLOR","2019-02-06 21:38:18"),
("124","1","2","19","6","12","14","43","EXCELENT NO COLOR","2019-02-06 22:03:38"),
("125","1","2","19","6","12","14","44","FAIL COLOR","2019-02-06 22:03:42");



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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO sessions VALUES("5","1","1","2018","2018-11-03","2019-01-19","Current","2018-11-03 12:39:35"),
("6","1","2","2018","2018-11-03","2019-01-26","Current","2018-11-03 12:39:58");



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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS student_marks;

CREATE TABLE `student_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `session` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `cat` text NOT NULL,
  `exam` text NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

INSERT INTO student_marks VALUES("10","1","5","13","22","51","15","2","2","2019-02-06 12:32:29"),
("11","1","5","13","22","51","16","7","7","2019-02-06 12:42:49"),
("13","1","5","13","23","51","16","3","9","2019-02-06 12:45:01"),
("14","1","5","13","24","51","15","10","5","2019-02-06 13:09:19"),
("15","1","5","13","24","51","16","5","","2019-02-06 13:14:45"),
("17","1","5","13","22","67","15","5","5","2019-02-06 13:52:53"),
("18","1","5","13","23","67","16","4","","2019-02-06 13:54:50"),
("19","1","5","13","22","67","41","","","2019-02-06 14:16:46");



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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

INSERT INTO student_positions VALUES("79","1","15","5","22","13","1.8"),
("81","1","16","5","22","13","2.3"),
("82","1","16","5","23","13","2"),
("84","1","16","5","24","13","0.6"),
("85","1","15","5","23","13","0.5"),
("86","1","15","5","24","13","1.9"),
("89","1","15","5","y_0","13","1.2"),
("90","1","16","5","y_0","13","1.6"),
("91","1","41","5","y_0","13","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;




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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

INSERT INTO students VALUES("13","1","2","4","Demo","audrey","11","2018-10-10","Female","test","demo","0788345678","kacyiru","2018-10-30 15:35:08"),
("14","1","2","6","Demo","Dm","12","2018-11-01","Male","","","","","2018-11-03 12:50:05"),
("15","1","1","5","Demo","Allegra","13","2018-11-05","Female","test","demo","0788345678","remera","2018-11-18 14:00:20"),
("16","1","1","5","Demo","audrey","13","2018-09-06","Male","test","test","0788345678","kacyiru","2018-11-18 19:02:27"),
("17","1","1","5","iriza","Dm","13","2018-09-02","Male","demo","test","0788345678","kacyiru","2018-11-18 19:02:46"),
("19","1","2","6","gihozo","audrey","12","2018-12-08","Female","","","","","2018-12-04 21:55:02"),
("20","1","2","6","test","audrey","14","2018-12-06","Female","","","","","2018-12-04 21:56:54"),
("21","1","1","7","Demo","Allegra","15","2019-01-08","Female","demo","test","0788345678","kacyiru","2019-01-23 14:31:20"),
("40","1","1","5","aud","gih","13","2/4/1000","F","xx","xf","78000000","kk","2019-01-29 19:54:51"),
("41","1","1","5","didier","kibugenza","13","25/10/1992","M","TEST","TEST","78000000","TEST","2019-01-29 19:54:52"),
("42","1","1","5","Kibugenza","Didier","13","2018-05-01","Male","","","","KG 562 St, Kigali","2019-02-05 17:16:09"),
("43","1","1","5","yves","Mazimpaka","16","1994-10-10","Male","","","","","2019-02-05 23:23:26"),
("44","1","1","5","kiberinka","josee","17","1991-10-28","Female","","","","","2019-02-05 23:23:54");



DROP TABLE IF EXISTS subjects;

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) NOT NULL,
  `session` int(11) NOT NULL,
  `school_level` int(11) NOT NULL,
  `subjectname` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO subjects VALUES("1","1","5","1","french","2018-11-18 13:59:51"),
("2","1","5","1","Mathematics","2018-12-04 17:47:10"),
("3","1","5","1","english","2018-12-04 17:47:16"),
("4","1","5","1","Science & ICT","2018-12-04 17:48:38"),
("5","1","5","1","Social studies & Religion","2018-12-04 17:48:43"),
("6","1","5","1","Kinyarwanda","2018-12-04 17:48:51"),
("7","1","5","1","Creative Arts","2018-12-04 17:48:56"),
("8","1","7","1","english","2019-01-23 14:28:54"),
("9","1","7","1","calcule","2019-01-23 14:28:58");



DROP TABLE IF EXISTS teacher_classes;

CREATE TABLE `teacher_classes` (
  `id` int(11) NOT NULL,
  `teacher_key` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

INSERT INTO teachers VALUES("21","373394","1","2","4","demo teacher","0787000000","attdmin@gmail.com","2018-09-27 19:30:18"),
("24","395437","1","1","5","Demo Teacher","","teacher@gmail.com","2018-12-04 18:56:16"),
("30","316808","1","2","6","Test teacher","0787000000","gfgfgfg@gmail.com","2018-12-04 20:43:58"),
("31","904548","1","2","6","cxcxcxcxc","0787000000","sdsdsdsd@gmail.com","2018-12-04 20:44:45"),
("33","619370","1","1","7","Test teacher","0788657493","asssdmin@gmail.com","2019-01-23 14:38:35"),
("36","421134","1","1","5","cxcxcxcxc","","test@gmail.com","2019-01-23 14:58:55"),
("37","835320","1","1","5","onesphore","","one@gmail.com","2019-01-23 15:08:59"),
("44","671532","1","1","5","Kibugenza Didier","0787393488","kibugenza@gmail.com","2019-02-05 21:21:07"),
("49","190405","1","1","5","asasas","","asasas@gmail.com","2019-02-05 23:21:58"),
("59","517956","1","2","6","Kibugenza Didiers","0787393499","kibugenzan@gmail.com","2019-02-06 23:03:54");



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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO terms VALUES("17","1","4","Term 1","2018-10-30","2018-11-01","2018-10-30 16:02:18"),
("19","1","6","Term 1","2018-11-03","2018-11-05","2018-11-03 12:52:07"),
("20","1","6","Term 2","2018-11-11","2018-11-23","2018-11-03 12:52:22"),
("21","1","6","Term 3","2018-11-30","2018-12-01","2018-11-03 12:52:33"),
("22","1","5","Term 1","2018-11-18","2018-11-20","2018-11-18 14:00:33"),
("23","1","5","Term 2","2018-12-04","2018-12-25","2018-12-04 18:52:59"),
("24","1","5","Term 3","2019-01-30","2019-02-06","2019-01-23 14:42:30");



DROP TABLE IF EXISTS test_period;

CREATE TABLE `test_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_key` int(11) NOT NULL,
  `school_level` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `starting_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS test_period_courses;

CREATE TABLE `test_period_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL,
  `courname` varchar(100) NOT NULL,
  `maxmark` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS test_period_marks;

CREATE TABLE `test_period_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




