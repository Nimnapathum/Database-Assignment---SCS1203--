-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 15, 2023 at 12:07 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employeecaredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

DROP TABLE IF EXISTS `applicant`;
CREATE TABLE IF NOT EXISTS `applicant` (
  `applicantid` varchar(6) NOT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `contactno` varchar(10) DEFAULT NULL,
  `eduQualify` varchar(255) DEFAULT NULL,
  `jobid` varchar(5) DEFAULT NULL,
  `status` varchar(3) DEFAULT 'NO',
  PRIMARY KEY (`applicantid`),
  KEY `fk_jobapply` (`jobid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`applicantid`, `resume`, `contactno`, `eduQualify`, `jobid`, `status`) VALUES
('APL001', 'JohnDoe_Resume', '5551234567', 'Bachelor of Science in Computer Science', 'HRM', 'YES'),
('APL002', 'JaneSmith_Resume', '5552345678', 'Master of Business Administration', 'MKT', 'YES'),
('APL003', 'SamJohnson_Resume', '5553456789', 'Bachelor of Engineering in Electrical Engineering', 'ADM', 'YES'),
('APL004', 'EmilyWilson_Resume', '5554567890', 'Master of Science in Data Science', 'IT1', 'YES'),
('APL005', 'ChrisBrown_Resume', '5555678901', 'Bachelor of Arts in Marketing', 'IT2', 'YES'),
('APL006', 'LisaDavis_Resume', '5556789012', 'Master of Computer Science', 'SLR', 'YES'),
('APL007', 'ushh', '9378379849', 'AL', 'HRM', 'YES'),
('APL008', 'ushh', '9378379849', 'AL', 'HRM', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `employeeid` varchar(6) NOT NULL,
  `attendancedate` date NOT NULL,
  `arrivaltimehour` int(2) DEFAULT NULL,
  `arrivaltimeminiute` int(2) DEFAULT NULL,
  `departuretimehour` int(2) DEFAULT NULL,
  `departuretimeminiute` int(2) DEFAULT NULL,
  PRIMARY KEY (`employeeid`,`attendancedate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`employeeid`, `attendancedate`, `arrivaltimehour`, `arrivaltimeminiute`, `departuretimehour`, `departuretimeminiute`) VALUES
('EMP001', '2023-11-01', 8, 30, 17, 15),
('EMP001', '2023-11-02', 8, 45, 17, 30),
('EMP001', '2023-11-03', 9, 0, 17, 45),
('EMP001', '2023-11-04', 8, 15, 18, 0),
('EMP001', '2023-11-05', 8, 0, 16, 45),
('EMP002', '2023-11-01', 9, 0, 18, 0),
('EMP002', '2023-11-02', 9, 30, 17, 45),
('EMP002', '2023-11-03', 8, 45, 17, 15),
('EMP002', '2023-11-04', 9, 15, 17, 30),
('EMP002', '2023-11-05', 8, 30, 16, 45),
('EMP003', '2023-11-01', 8, 30, 17, 15),
('EMP003', '2023-11-02', 8, 45, 17, 30),
('EMP004', '2023-11-01', 9, 0, 18, 0),
('EMP004', '2023-11-02', 9, 30, 17, 45),
('EMP005', '2023-11-01', 8, 30, 17, 15),
('EMP005', '2023-11-02', 8, 45, 17, 30),
('EMP020', '2023-11-01', 8, 30, 17, 15),
('EMP006', '2023-11-01', 8, 30, 17, 15),
('EMP006', '2023-11-02', 8, 45, 17, 30),
('EMP007', '2023-11-03', 9, 0, 17, 45),
('EMP007', '2023-11-04', 8, 15, 18, 0),
('EMP007', '2023-11-05', 8, 0, 16, 45),
('EMP008', '2023-11-01', 9, 0, 18, 0),
('EMP008', '2023-11-02', 9, 30, 17, 45),
('EMP009', '2023-11-03', 8, 45, 17, 15),
('EMP009', '2023-11-04', 9, 15, 17, 30),
('EMP010', '2023-11-05', 8, 30, 16, 45),
('EMP011', '2023-11-01', 8, 30, 17, 15),
('EMP011', '2023-11-02', 8, 45, 17, 30),
('EMP012', '2023-11-01', 9, 0, 18, 0),
('EMP012', '2023-11-02', 9, 30, 17, 45),
('EMP013', '2023-11-01', 8, 30, 17, 15),
('EMP013', '2023-11-02', 8, 45, 17, 30),
('EMP014', '2023-11-01', 8, 30, 17, 15),
('EMP014', '2023-11-02', 8, 45, 17, 30),
('EMP015', '2023-11-03', 9, 0, 17, 45),
('EMP015', '2023-11-04', 8, 15, 18, 0),
('EMP015', '2023-11-05', 8, 0, 16, 45),
('EMP016', '2023-11-01', 9, 0, 18, 0),
('EMP016', '2023-11-02', 9, 30, 17, 45),
('EMP017', '2023-11-03', 8, 45, 17, 15),
('EMP018', '2023-11-04', 9, 15, 17, 30),
('EMP018', '2023-11-05', 8, 30, 16, 45),
('EMP018', '2023-11-01', 8, 30, 17, 15),
('EMP019', '2023-11-01', 8, 30, 17, 15),
('EMP019', '2023-11-02', 8, 45, 17, 30),
('EMP008', '2023-11-12', 1, 1, 1, 1),
('EMP002', '2023-11-12', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `departmentid` varchar(5) NOT NULL,
  `departmentName` varchar(50) NOT NULL,
  PRIMARY KEY (`departmentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentid`, `departmentName`) VALUES
('DEP01', 'Human Resource'),
('DEP02', 'Administraion'),
('DEP03', 'Accounting'),
('DEP04', 'Marketing'),
('DEP05', 'IT support'),
('DEP06', 'Sales');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employeeid` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contactno` varchar(10) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `managerid` varchar(6) DEFAULT NULL,
  `joiningDate` date DEFAULT NULL,
  `departmentid` varchar(5) DEFAULT NULL,
  `rollid` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`employeeid`),
  KEY `fk_empJob` (`rollid`),
  KEY `fk_empDep` (`departmentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeid`, `name`, `address`, `gender`, `email`, `contactno`, `DOB`, `managerid`, `joiningDate`, `departmentid`, `rollid`) VALUES
('EMP001', 'John Smith', '123 Main St, City, Country', 'Male', 'john.smith@email.com', '1234567890', '1990-05-15', NULL, '2023-01-10', 'DEP01', 'HRM'),
('EMP002', 'Alice Johnson jk', '456 Elm St, City, Country', 'Female', 'alice.johnson123@email.com', '9876543210', '1985-08-20', NULL, '2022-12-05', 'DEP02', 'ADM'),
('EMP003', 'David Wilson', '789 Oak St, City, Country', 'Male', 'david.wilson@email.com', '5551112222', '1995-03-30', NULL, '2023-02-20', 'DEP03', 'ACC'),
('EMP004', 'Sara Davis', '101 Pine St, City, Country', 'Female', 'sara.davis@email.com', '3337778888', '1988-11-12', NULL, '2023-03-15', 'DEP04', 'MKT'),
('EMP005', 'Mike Brown', '234 Cedar St, City, Country', 'Male', 'mike.brown@email.com', '7774445555', '1992-07-25', NULL, '2023-04-01', 'DEP05', 'IT1'),
('EMP006', 'Julia White', '567 Birch St, City, Country', 'Female', 'julia.white@email.com', '2223334444', '1980-04-10', NULL, '2023-05-10', 'DEP06', 'SLR'),
('EMP007', 'Michael Johnson', '789 Elm St, City, Country', 'Male', 'michael.johnson@email.com', '9998887777', '1993-06-18', 'EMP001', '2023-06-05', 'DEP01', 'HRG'),
('EMP008', 'Emily Wilson', '456 Oak St, City, Country', 'Female', 'emily.wilson@email.com', '1112223333', '1991-02-28', 'EMP001', '2023-06-20', 'DEP01', 'HRG'),
('EMP009', 'Chris Anderson', '321 Maple St, City, Country', 'Male', 'chris.anderson@email.com', '5556667777', '1994-03-22', 'EMP001', '2023-07-10', 'DEP01', 'HRG'),
('EMP010', 'Lisa Martinez', '987 Birch St, City, Country', 'Female', 'lisa.martinez@email.com', '3332221111', '1998-09-05', 'EMP001', '2023-07-15', 'DEP01', 'HRG'),
('EMP011', 'Daniel Adams', '432 Cedar St, City, Country', 'Male', 'daniel.adams@email.com', '6669995555', '1997-11-30', 'EMP002', '2023-08-01', 'DEP02', 'ADM'),
('EMP012', 'Sophia Clark', '765 Elm St, City, Country', 'Female', 'sophia.clark@email.com', '8887776666', '1987-05-12', 'EMP002', '2023-08-15', 'DEP02', 'ADM'),
('EMP013', 'Matthew Turner', '123 Pine St, City, Country', 'Male', 'matthew.turner@email.com', '4447778888', '1996-03-10', 'EMP002', '2023-09-01', 'DEP02', 'ADM'),
('EMP014', 'Olivia Harris', '987 Oak St, City, Country', 'Female', 'olivia.harris@email.com', '5556663333', '1995-08-20', 'EMP002', '2023-09-15', 'DEP02', 'ADM'),
('EMP015', 'James Wilson', '345 Cedar St, City, Country', 'Male', 'james.wilson@email.com', '1234567890', '1990-04-15', 'EMP003', '2023-10-10', 'DEP03', 'ACC2'),
('EMP016', 'Ella Anderson', '654 Pine St, City, Country', 'Female', 'ella.anderson@email.com', '9876543210', '1993-03-30', 'EMP003', '2023-10-20', 'DEP03', 'ACC2'),
('EMP017', 'Jacob Davis', '876 Elm St, City, Country', 'Male', 'jacob.davis@email.com', '5551112222', '1998-01-05', 'EMP003', '2023-11-05', 'DEP03', 'ACC2'),
('EMP018', 'Ava Johnson', '234 Oak St, City, Country', 'Female', 'ava.johnson@email.com', '3337778888', '1995-07-12', 'EMP003', '2023-11-20', 'DEP03', 'ACC2'),
('EMP019', 'William Smith', '543 Birch St, City, Country', 'Male', 'william.smith@email.com', '7774445555', '1991-09-25', 'EMP004', '2023-12-01', 'DEP04', 'MKT2'),
('EMP020', 'Charlotte White', '567 Cedar St, City, Country', 'Female', 'charlotte.white@email.com', '2223334444', '1988-08-10', 'EMP004', '2023-12-10', 'DEP04', 'MKT2');

-- --------------------------------------------------------

--
-- Table structure for table `jobroll`
--

DROP TABLE IF EXISTS `jobroll`;
CREATE TABLE IF NOT EXISTS `jobroll` (
  `roleid` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `departmentid` varchar(5) DEFAULT NULL,
  `jobopening` varchar(3) NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`roleid`),
  KEY `fk_jobDep` (`departmentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobroll`
--

INSERT INTO `jobroll` (`roleid`, `title`, `description`, `departmentid`, `jobopening`) VALUES
('HRM', 'HR Manager', 'Oversees HR department', 'DEP01', 'YES'),
('HRG', 'HR Generalist', 'Supports HR functions', 'DEP01', 'NO'),
('ADM', 'Office Manager', 'Manages administrative tasks', 'DEP02', 'NO'),
('ACC', 'Accountant', 'Handles financial accounting', 'DEP03', 'NO'),
('MKT', 'Marketing Manager', 'Leads marketing efforts', 'DEP04', 'NO'),
('IT1', 'IT Support Specialist', 'Provides IT support', 'DEP05', 'NO'),
('SLR', 'Sales Representative', 'Sells products/services', 'DEP06', 'NO'),
('ACC2', 'Financial Analyst', 'Analyzes financial data', 'DEP03', 'NO'),
('ADM2', 'Administrative Assistant', 'Provides admin support', 'DEP02', 'NO'),
('MKT2', 'Digital Marketing Specialist', 'Manages digital marketing', 'DEP04', 'NO'),
('IT2', 'Help Desk Technician', 'Provides IT helpdesk support', 'DEP05', 'NO'),
('SLM', 'Sales Manager', 'Manages sales team', 'DEP06', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE IF NOT EXISTS `leaves` (
  `employeeid` varchar(6) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `leavebalance` int(2) DEFAULT NULL,
  `approverid` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`employeeid`,`startdate`,`enddate`),
  KEY `fk_approver` (`approverid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`employeeid`, `startdate`, `enddate`, `type`, `leavebalance`, `approverid`) VALUES
('EMP001', '2023-01-15', '2023-01-20', 'Vacation', 4, 'EMP007'),
('EMP002', '2023-02-10', '2023-02-15', 'Sick Leave', 3, 'EMP008'),
('EMP003', '2023-03-05', '2023-03-10', 'Vacation', 5, 'EMP009'),
('EMP004', '2023-04-20', '2023-04-25', 'Sick Leave', 2, 'EMP010'),
('EMP005', '2023-05-15', '2023-05-20', 'Vacation', 3, 'EMP011'),
('EMP006', '2023-06-10', '2023-06-15', 'Sick Leave', 4, 'EMP012'),
('EMP007', '2023-07-05', '2023-07-10', 'Vacation', 5, 'EMP001'),
('EMP008', '2023-08-20', '2023-08-25', 'Sick Leave', 3, 'EMP001'),
('EMP009', '2023-09-15', '2023-09-20', 'Vacation', 4, 'EMP002'),
('EMP010', '2023-10-10', '2023-10-15', 'Sick Leave', 1, 'EMP002'),
('EMP011', '2023-11-20', '2023-11-22', 'Vacation', 2, 'EMP002'),
('EMP012', '2023-12-01', '2023-12-05', 'Sick Leave', 3, 'EMP002'),
('EMP008', '2023-11-21', '2023-11-30', 'Vacation', 2, 'EMP002'),
('EMP008', '2023-11-29', '2023-12-01', 'Vacation', 1, 'EMP002'),
('EMP009', '2023-12-01', '2023-12-07', 'Vacation', 3, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `managerids`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `managerids`;
CREATE TABLE IF NOT EXISTS `managerids` (
`managerid` varchar(6)
);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

DROP TABLE IF EXISTS `salary`;
CREATE TABLE IF NOT EXISTS `salary` (
  `salaryid` varchar(6) NOT NULL,
  `employeeid` varchar(6) NOT NULL,
  `salaryAmount` decimal(10,2) DEFAULT NULL,
  `allowance` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`salaryid`),
  KEY `fk_salary` (`employeeid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salaryid`, `employeeid`, `salaryAmount`, `allowance`, `bonus`) VALUES
('SAL001', 'EMP001', '60000.00', '3000.00', '5000.00'),
('SAL002', 'EMP002', '55000.00', '2500.00', '4500.00'),
('SAL003', 'EMP003', '65000.00', '3200.00', '5500.00'),
('SAL004', 'EMP004', '58000.00', '2700.00', '4800.00'),
('SAL005', 'EMP005', '62000.00', '2900.00', '5200.00'),
('SAL006', 'EMP006', '57000.00', '2600.00', '4400.00'),
('SAL007', 'EMP007', '59000.00', '2700.00', '4600.00'),
('SAL008', 'EMP008', '56000.00', '2400.00', '4200.00'),
('SAL009', 'EMP009', '67000.00', '3300.00', '5600.00'),
('SAL010', 'EMP010', '61000.00', '2800.00', '5000.00'),
('SAL011', 'EMP011', '62000.00', '2900.00', '5200.00'),
('SAL012', 'EMP012', '57000.00', '2600.00', '4400.00'),
('SAL013', 'EMP013', '60000.00', '3000.00', '5000.00'),
('SAL014', 'EMP014', '55000.00', '2500.00', '4500.00'),
('SAL015', 'EMP015', '65000.00', '3200.00', '5500.00'),
('SAL016', 'EMP016', '58000.00', '2700.00', '4800.00'),
('SAL017', 'EMP017', '62000.00', '2900.00', '5200.00'),
('SAL018', 'EMP018', '57000.00', '2600.00', '4400.00'),
('SAL019', 'EMP019', '59000.00', '2700.00', '4600.00'),
('SAL020', 'EMP020', '56000.00', '2400.00', '4200.00');

-- --------------------------------------------------------

--
-- Structure for view `managerids`
--
DROP TABLE IF EXISTS `managerids`;

DROP VIEW IF EXISTS `managerids`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `managerids`  AS SELECT DISTINCT `employee`.`managerid` AS `managerid` FROM `employee` WHERE (`employee`.`managerid` is not null) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
