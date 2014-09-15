-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2014 at 07:56 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

drop database g8;
create database g8;
use g8;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `g8`
--

-- --------------------------------------------------------

--
-- Table structure for table `audiomedia`
--

CREATE TABLE IF NOT EXISTS `audiomedia` (
  `audioid` int(10) NOT NULL AUTO_INCREMENT,
  `uploadname` varchar(20) NOT NULL,
  `title` varchar(40) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `description` varchar(100) NOT NULL,
  `updatetime` date NOT NULL,
  `uploadpath` varchar(100) NOT NULL,
  `uploadprefix` varchar(100) NOT NULL,
  `coverpath` varchar(100) NOT NULL,
  `viewtimes` int(10) DEFAULT NULL,
  `downloadtimes` int(10) DEFAULT NULL,
  `likes` int(10) DEFAULT NULL,
  `dislikes` int(10) DEFAULT NULL,
  `isshare` int(10) DEFAULT NULL,
  `security` int(10) DEFAULT NULL,
  PRIMARY KEY (`audioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `audiomedia`
--

INSERT INTO `audiomedia` (`audioid`, `uploadname`, `title`, `keywords`, `description`, `updatetime`, `uploadpath`, `uploadprefix`, `coverpath`, `viewtimes`, `downloadtimes`, `likes`, `dislikes`, `isshare`, `security`) VALUES
(17, 'aa', '1', '1,,', '1', '2014-04-16', 'audios/eyesoftheclown2.mp3', 'audios/eyesoftheclown2', 'images/default_cover.jpg', 2, 0, 0, 0, 0, 0),
(18, 'aa', '1', '1,,', '1', '2014-04-16', 'audios/eyesoftheclown3.mp3', 'audios/eyesoftheclown3', 'images/default_cover.jpg', 2, 0, 0, 0, 0, 0),
(19, 'aa', '1', '1,,', '1', '2014-04-16', 'audios/eyesoftheclown.mp3', 'audios/eyesoftheclown', 'images/default_cover.jpg', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chatgroup`
--

CREATE TABLE IF NOT EXISTS `chatgroup` (
  `groupid` int(10) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(20) NOT NULL,
  `description` varchar(40) DEFAULT NULL,
  `createtime` date NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `chatgroup`
--

INSERT INTO `chatgroup` (`groupid`, `groupname`, `description`, `createtime`) VALUES
(1, 'animation', 'animation', '2014-03-30'),
(2, 'animation', 'animation', '2014-03-30'),
(3, 'animation', 'animation', '2014-03-30'),
(4, 'animation', 'animation', '2014-03-30'),
(5, 'animation', 'a', '2014-03-30'),
(6, 'animation', 'animation', '2014-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `parent` int(10) DEFAULT NULL,
  `commentid` int(10) NOT NULL AUTO_INCREMENT,
  `mediatype` int(1) NOT NULL,
  `mediaid` int(10) NOT NULL,
  `commenter` varchar(20) NOT NULL,
  `content` varchar(200) NOT NULL,
  `posttime` date NOT NULL,
  `children` int(10) DEFAULT NULL,
  PRIMARY KEY (`commentid`),
  KEY `commenter` (`commenter`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`parent`, `commentid`, `mediatype`, `mediaid`, `commenter`, `content`, `posttime`, `children`) VALUES
(NULL, 1, 1, 10, 'aa', 'i like flower', '2014-03-20', NULL),
(NULL, 2, 3, 7, 'aa', 'i like symfony!', '2014-03-21', NULL),
(NULL, 11, 1, 10, 'aa', 'my new comment', '2014-03-21', NULL),
(NULL, 13, 1, 10, 'aa', 'I like picture', '2014-03-21', NULL),
(NULL, 18, 2, 5, 'aa', 'nice day', '2014-03-21', NULL),
(NULL, 19, 2, 5, 'aa', 'nicedayyyyyyyyyyyyyyyyyyy', '2014-03-21', NULL),
(NULL, 21, 2, 5, 'aa', 'helllooooooooooooooo', '2014-03-21', NULL),
(NULL, 22, 2, 5, 'aa', 'chongsun', '2014-03-21', NULL),
(NULL, 23, 2, 5, 'aa', 'nihaoooooooooooooooo', '2014-03-21', NULL),
(1, 39, 1, 10, 'aa', 'i like flowerrrrrrrrrrrrrrrrr', '2014-03-21', NULL),
(1, 40, 1, 10, 'aa', 'aaa', '2014-03-21', NULL),
(1, 41, 1, 10, 'aa', 'i want to killl lllllllllllllllllll', '2014-03-21', NULL),
(NULL, 42, 1, 10, 'aa', 'aaa', '2014-04-01', NULL),
(NULL, 43, 1, 10, 'aa', 'aaa', '2014-04-01', NULL),
(NULL, 44, 1, 10, 'aa', 'aaa', '2014-04-01', NULL),
(NULL, 45, 1, 10, 'aa', 'aaa', '2014-04-01', NULL),
(NULL, 46, 1, 10, 'aa', 'aaa', '2014-04-01', NULL),
(NULL, 47, 1, 10, 'aa', 'aaa', '2014-04-01', NULL),
(NULL, 48, 3, 8, 'aa', 'nice ppt', '2014-04-12', NULL),
(NULL, 49, 3, 8, 'aa', 'nice ppt', '2014-04-12', NULL),
(48, 50, 3, 8, 'aa', 'nice ppt', '2014-04-12', NULL),
(NULL, 51, 4, 52, 'aa', 'spiderman', '2014-04-12', NULL),
(NULL, 52, 1, 42, 'aa', 'I love animation', '2014-04-14', NULL),
(NULL, 53, 1, 39, 'aa', 'aa', '2014-04-19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contactlist`
--

CREATE TABLE IF NOT EXISTS `contactlist` (
	contactid int(10) not null auto_increment primary key,
  `fromname` varchar(20) NOT NULL,
  `toname` varchar(20) NOT NULL,
  `isfriend` int(10) DEFAULT '0',
  `block` int(10) DEFAULT '0',
  `blocktype` int(10) DEFAULT NULL,
  `blockcontent` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into contactlist(fromname, toname, isfriend, block, blocktype, blockcontent) values('yaolinz', 'ayumilong41', 1, 1, 0, '');
insert into contactlist(fromname, toname, isfriend, block, blocktype, blockcontent) values('ayumilong41', 'yaolinz', 1, 0, 0, '');
insert into contactlist(fromname, toname, isfriend, block, blocktype, blockcontent) values('bgvh', 'yaolinz', 0, 0, 0, '');
insert into contactlist(fromname, toname, isfriend, block, blocktype, blockcontent) values('yaolinz', 'ayumilong', 0, 0, 0, '');
insert into contactlist(fromname, toname, isfriend, block, blocktype, blockcontent) values('yaolinz', 'sa612244', 2, 0, 0, '');

insert into contactlist(fromname, toname, isfriend, block, blocktype, blockcontent) values('yaolinz', 'aa', 2, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--



CREATE TABLE IF NOT EXISTS `history` (
  `historyid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `mediatype` int(1) NOT NULL,
  `mediaid` int(10) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `browsetime` date DEFAULT NULL,
  PRIMARY KEY (`historyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`historyid`, `username`, `mediatype`, `mediaid`, `keywords`, `browsetime`) VALUES
(5, 'aa', 1, 26, 'food,chinese,', '2014-04-18'),
(6, 'aa', 4, 69, 'liyue,,', '2014-04-18'),
(7, 'anonym', 1, 26, 'food,chinese,', '2014-04-19'),
(8, 'anonym', 1, 27, 'food,american,', '2014-04-19'),
(9, 'anonym', 1, 26, 'food,chinese,', '2014-04-19'),
(10, 'anonym', 4, 69, 'liyue,,', '2014-04-19'),
(11, 'aa', 1, 26, 'food,chinese,', '2014-04-19'),
(12, 'aa', 1, 26, 'food,chinese,', '2014-04-19'),
(13, 'aa', 4, 69, 'liyue,,', '2014-04-19'),
(14, 'aa', 4, 69, 'liyue,,', '2014-04-19'),
(15, 'aa', 1, 39, 'animal,white,cute', '2014-04-19'),
(16, 'aa', 1, 39, 'animal,white,cute', '2014-04-19');

-- --------------------------------------------------------

--
-- Table structure for table `imagemedia`
--

CREATE TABLE IF NOT EXISTS `imagemedia` (
  `imageid` int(10) NOT NULL AUTO_INCREMENT,
  `uploadname` varchar(20) NOT NULL,
  `uploadpath` varchar(100) NOT NULL,
  `title` varchar(40) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `description` varchar(100) NOT NULL,
  `updatetime` date NOT NULL,
  `viewtimes` int(10) DEFAULT NULL,
  `downloadtimes` int(10) DEFAULT NULL,
  `likes` int(10) DEFAULT NULL,
  `dislikes` int(10) DEFAULT NULL,
  `isshare` int(10) DEFAULT NULL,
  `security` int(10) DEFAULT NULL,
  PRIMARY KEY (`imageid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `imagemedia`
--

INSERT INTO `imagemedia` (`imageid`, `uploadname`, `uploadpath`, `title`, `keywords`, `description`, `updatetime`, `viewtimes`, `downloadtimes`, `likes`, `dislikes`, `isshare`, `security`) VALUES
(26, 'aa', 'images/food1.png', 'food', 'food,chinese,', 'food', '2014-04-11', 161, 0, 0, 0, 0, 1),
(27, 'aa', 'images/food2.png', 'food', 'food,american,', 'food', '2014-04-11', 1, 0, 0, 0, 0, 1),
(28, 'aa', 'images/food3.png', 'cake', 'food,stweet,', 'afternoon', '2014-04-11', 0, 0, 0, 0, 0, 1),
(29, 'aa', 'images/food4.png', 'meat', 'food,american,meat', 'food', '2014-04-11', 0, 0, 0, 0, 0, 0),
(30, 'aa', 'images/food5.png', 'bread', 'food,american,', 'morning', '2014-04-11', 0, 0, 0, 0, 0, 0),
(31, 'aa', 'images/food6.png', 'cake', 'food,sweet,', 'cake', '2014-04-11', 0, 0, 0, 0, 0, 0),
(32, 'aa', 'images/food7.png', 'cake', 'food,american,', 'food', '2014-04-11', 0, 0, 0, 0, 0, 0),
(33, 'aa', 'images/food8.png', 'cake', 'food,american,', 'food', '2014-04-11', 0, 0, 0, 0, 0, 0),
(34, 'aa', 'images/glasses1.png', 'glasses', 'spring,rain,flowers', 'green', '2014-04-11', 1, 0, 0, 0, 0, 0),
(35, 'aa', 'images/lizard1.png', 'lizard', 'animal,green,prayer', 'change color', '2014-04-11', 0, 0, 0, 0, 0, 0),
(36, 'aa', 'images/tree1.png', 'tree', 'green,wild,', 'tree', '2014-04-11', 0, 0, 0, 0, 0, 0),
(37, 'aa', 'images/flower1.png', 'flower', 'flower,small,green', 'green', '2014-04-11', 1, 0, 0, 0, 0, 0),
(38, 'aa', 'images/flower2.png', 'flower', 'pink,rain,spring', 'beatiful', '2014-04-11', 1, 0, 0, 0, 0, 0),
(39, 'aa', 'images/cat1.png', 'cat', 'animal,white,cute', 'cat', '2014-04-11', 11, 0, 0, 0, 0, 0),
(40, 'aa', 'images/cat2.png', 'cat', 'computer,cat,cute', 'cats', '2014-04-11', 0, 0, 0, 0, 0, 0),
(41, 'aa', 'images/bird1.png', 'birds', 'colorful,flowers,mother', 'birds', '2014-04-11', 0, 0, 0, 0, 0, 0),
(42, 'aa', 'images/animation1.png', 'girls', 'animation,beauty,', 'girls', '2014-04-11', 2, 0, 0, 0, 0, 0),
(43, 'aa', 'images/animation2.png', 'girl', 'cute,animation,winter', 'girl', '2014-04-11', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `messageid` int(10) NOT NULL AUTO_INCREMENT,
  `sender` varchar(20) NOT NULL,
  `receivor` varchar(20) NOT NULL,
  `subject` varchar(40) DEFAULT NULL,
  `content` varchar(200) DEFAULT NULL,
  `sendtime` date DEFAULT NULL,
  `receivetime` date DEFAULT NULL,
  `isread` int(4) DEFAULT NULL,
  PRIMARY KEY (`messageid`),
  KEY `sender` (`sender`),
  KEY `receivor` (`receivor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageid`, `sender`, `receivor`, `subject`, `content`, `sendtime`, `receivetime`, `isread`) VALUES
(20, 'aa', 'aa', 'aa', 'YWE=', '2014-04-19', '2012-11-03', 1),
(21, 'aa', 'aa', 'Re:aa', 'bmloYW8KCi0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpmcm9tOmFhCnRvOmFhCnN1YmplY3Q6YWEKc2VuZHRpbWU6MjAxNC0wNC0xOQpjb250ZW50OgoKYWE=', '2014-04-19', '2014-04-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `plid` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `isfavorate` int(10) DEFAULT '0',
  `audiocontent` varchar(200) DEFAULT NULL,
  `vediocontent` varchar(200) DEFAULT NULL,
  `creator` varchar(20) NOT NULL,
  PRIMARY KEY (`plid`),
  KEY `creator` (`creator`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`plid`, `title`, `isfavorate`, `audiocontent`, `vediocontent`, `creator`) VALUES
(1, 'new human', 1, '17,18,19', '69,', 'aa'),
(2, 'food', 2, '', '69', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `parent` int(10) DEFAULT NULL,
  `replyto` varchar(20) DEFAULT NULL,
  `postid` int(10) NOT NULL AUTO_INCREMENT,
  `content` varchar(200) NOT NULL,
  `createtime` date NOT NULL,
  `poster` varchar(20) NOT NULL,
  `topicid` int(10) NOT NULL,
  PRIMARY KEY (`postid`),
  KEY `poster` (`poster`),
  KEY `topicid` (`topicid`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`parent`, `replyto`, `postid`, `content`, `createtime`, `poster`, `topicid`) VALUES
(NULL, NULL, 1, 'vampire diary', '2014-03-30', 'aa', 2),
(NULL, NULL, 2, 'I love it ,tooooooooooooooo', '2014-03-30', 'aa', 2),
(NULL, NULL, 3, 'me tooooooooooooo', '2014-03-30', 'aa', 2),
(1, 'aa', 4, 'test', '2014-03-30', 'aa', 2),
(1, 'aa', 5, 'test2', '2014-03-30', 'aa', 2),
(1, 'aa', 6, 'aaa', '2014-04-01', 'aa', 2),
(1, 'aa', 7, 'aaaa', '2014-04-01', 'aa', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `rateid` int(10) NOT NULL AUTO_INCREMENT,
  `mediatype` int(1) NOT NULL,
  `mediaid` int(10) NOT NULL,
  `stars` decimal(10,0) NOT NULL,
  `rater` varchar(20) NOT NULL,
  PRIMARY KEY (`rateid`),
  KEY `rater` (`rater`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscribechannel`
--

CREATE TABLE IF NOT EXISTS `subscribechannel` (
	subscribid int(10) not null auto_increment primary key,
  `publisher` varchar(20) NOT NULL,
  `observer` varchar(20) NOT NULL,
  channeltype varchar(20) not null /*text, image, audio, vedio*/
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `textmedia`
--

CREATE TABLE IF NOT EXISTS `textmedia` (
  `textid` int(10) NOT NULL AUTO_INCREMENT,
  `uploadname` varchar(20) NOT NULL,
  `title` varchar(40) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `description` varchar(100) NOT NULL,
  `updatetime` date NOT NULL,
  `uploadpath` varchar(100) NOT NULL,
  `viewtimes` int(10) DEFAULT NULL,
  `downloadtimes` int(10) DEFAULT NULL,
  `likes` int(10) DEFAULT NULL,
  `dislikes` int(10) DEFAULT NULL,
  `isshare` int(10) DEFAULT NULL,
  `security` int(10) DEFAULT NULL,
  PRIMARY KEY (`textid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `textmedia`
--

INSERT INTO `textmedia` (`textid`, `uploadname`, `title`, `keywords`, `description`, `updatetime`, `uploadpath`, `viewtimes`, `downloadtimes`, `likes`, `dislikes`, `isshare`, `security`) VALUES
(6, 'aa', 'symfony quick tour', 'sf2,education,', 'symfony quick tour 2.4', '2014-03-17', 'texts/phpfMmuQV', 2, 0, 0, 0, 0, 0),
(7, 'aa', 'symfony quick tour', 'sy2,education,', 'symfony quick tour', '2014-03-18', 'texts/phpi70llw', 30, 0, 0, 0, 0, 0),
(8, 'aa', '662 ppt', '662,,', '662 ppt', '2014-04-10', 'texts/phpKWoNmx', 25, 0, 0, 0, 0, 0),
(9, 'aa', '662 ppt', '662,,', '662 ppt', '2014-04-10', 'texts/phpKWoNmx', 6, 0, 0, 0, 0, 0),
(10, 'aa', '662 ppt', '662,,', '662 ppt', '2014-04-10', 'texts/phpKWoNmx', 5, 0, 0, 0, 0, 0),
(11, 'aa', '662 ppt', '662,,', '662 ppt', '2014-04-10', 'texts/phpKWoNmx', 6, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topicid` int(10) NOT NULL AUTO_INCREMENT,
  `topicname` varchar(20) NOT NULL,
  `description` varchar(40) DEFAULT NULL,
  `createtime` date NOT NULL,
  PRIMARY KEY (`topicid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`topicid`, `topicname`, `description`, `createtime`) VALUES
(2, 'animation show', 'animation show', '2014-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `topics_groups`
--

CREATE TABLE IF NOT EXISTS `topics_groups` (
  `topicid` int(10) NOT NULL DEFAULT '0',
  `groupid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topicid`,`groupid`),
  KEY `groupid` (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics_groups`
--

INSERT INTO `topics_groups` (`topicid`, `groupid`) VALUES
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(20) NOT NULL,
  `passwd` varchar(10) NOT NULL,
  `address` varchar(40) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `photopath` varchar(100) DEFAULT NULL,
	sex char not null default 'F',
 texts int(10) not null default 0,
 images int(10) not null default 0,
 audios int(10) not null default 0,
  `vedios` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
active char not null default 'N',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `passwd`, `address`, `email`, `photopath`, `vedios`, `status`) VALUES
('aa', 'aa', NULL, 'aa@gmail.com', 'profiles/profile1.JPG', NULL, NULL);
insert into user(username, passwd, address, email, sex, photopath) values("yaolinz", "ayumilong", "206B Campus Drive", "yaolinz@clemson.edu", "M", "profiles/default.jpg");
insert into user(username, passwd, address, email, sex, photopath) values("ayumilong41", "ayumilong", "206B Campus Drive", "ayumilong41@gmail.com", "M", "profiles/default.jpg");
insert into user(username, passwd, address, email, sex, photopath) values("sa612244", "ayumilong", "206B Campus Drive", "sa612244@mail.ustc.com", "M", "profiles/default.jpg");
insert into user(username, passwd, address, email, sex, photopath) values("bgvh", "ayumilong", "206B Campus Drive", "bgvh@qq.com", "M", "profiles/default.jpg");
insert into user(username, passwd, address, email, sex, photopath) values("ayumilong", "ayumilong", "206B Campus Drive", "ayumilong@hotmail.com", "F", "profiles/default.jpg");

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `username` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `groupid` int(4) NOT NULL,
  `isadmin` int(4) DEFAULT NULL,
  PRIMARY KEY (`username`,`groupid`),
  KEY `username` (`username`,`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`username`, `groupid`, `isadmin`) VALUES
('aa', 4, 1),
('aa', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vediomedia`
--

CREATE TABLE IF NOT EXISTS `vediomedia` (
  `vedioid` int(10) NOT NULL AUTO_INCREMENT,
  `uploadname` varchar(20) NOT NULL,
  `title` varchar(40) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `description` varchar(100) NOT NULL,
  `updatetime` date NOT NULL,
  `uploadpath` varchar(100) NOT NULL,
  `framepath` varchar(100) NOT NULL,
  `uploadprefix` varchar(100) NOT NULL,
  `viewtimes` int(10) DEFAULT NULL,
  `downloadtimes` int(10) DEFAULT NULL,
  `likes` int(10) DEFAULT NULL,
  `dislikes` int(10) DEFAULT NULL,
  `isshare` int(10) DEFAULT NULL,
  `security` int(10) DEFAULT NULL,
  PRIMARY KEY (`vedioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `vediomedia`
--

INSERT INTO `vediomedia` (`vedioid`, `uploadname`, `title`, `keywords`, `description`, `updatetime`, `uploadpath`, `framepath`, `uploadprefix`, `viewtimes`, `downloadtimes`, `likes`, `dislikes`, `isshare`, `security`) VALUES
(69, 'aa', 'liyue', 'liyue,,', 'liyue', '2014-04-15', 'videos/liyue1.mov', 'videos/liyue1.mov.png', 'videos/liyue1', 237, 0, 0, 0, 0, 0);


create table if not exists downloadvedio(
	downloadid	int(10) not null auto_increment primary key,
	downloadvedioid int(10) not null references vediomedia(vedioid),
	downloadname	varchar(20) not null references user(username),
	downloadtime	date not null
)ENGINE=InnoDB;

create table if not exists downloadaudio(
	downloadid	int(10) not null auto_increment primary key,
	downloadaudioid int(10) not null references audiomedia(audioid),
	downloadname	varchar(20) not null references user(username),
	downloadtime	date not null
)ENGINE=InnoDB;

create table if not exists downloadimage(
	downloadid	int(10) not null auto_increment primary key,
	downloadimageid	int(10) not null references imagemedia(imageid),
	downloadname	varchar(20) not null references user(username),
	downloadtime	date not null
)ENGINE=InnoDB;

create table if not exists downloadtext(
	downloadid	int(10) not null auto_increment primary key,
	downloadtextid	int(10) not null references textmedia(textid),
	downloadname	varchar(20) not null references user(username),
	downloadtime	date not null
)ENGINE=InnoDB;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`commenter`) REFERENCES `user` (`username`);

--
-- Constraints for table `contactlist`
--
ALTER TABLE `contactlist`
  ADD CONSTRAINT `contactlist_ibfk_1` FOREIGN KEY (`fromname`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `contactlist_ibfk_2` FOREIGN KEY (`toname`) REFERENCES `user` (`username`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receivor`) REFERENCES `user` (`username`);

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `user` (`username`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`poster`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`topicid`) REFERENCES `topic` (`topicid`),
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`parent`) REFERENCES `post` (`postid`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`rater`) REFERENCES `user` (`username`);

--
-- Constraints for table `subscribechannel`
--
ALTER TABLE `subscribechannel`
  ADD CONSTRAINT `subscribechannel_ibfk_1` FOREIGN KEY (`publisher`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `subscribechannel_ibfk_2` FOREIGN KEY (`observer`) REFERENCES `user` (`username`);

--
-- Constraints for table `topics_groups`
--
ALTER TABLE `topics_groups`
  ADD CONSTRAINT `topics_groups_ibfk_1` FOREIGN KEY (`topicid`) REFERENCES `topic` (`topicid`),
  ADD CONSTRAINT `topics_groups_ibfk_2` FOREIGN KEY (`groupid`) REFERENCES `chatgroup` (`groupid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
