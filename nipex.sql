-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2018 at 10:34 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nipex`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `supervising_officer_id` int(10) UNSIGNED DEFAULT NULL,
  `supervising_officer_show` enum('no','yes') DEFAULT NULL,
  `supervising_officer_action` enum('approve','disapprove') CHARACTER SET latin1 DEFAULT NULL,
  `supervising_officer_reason` text CHARACTER SET latin1,
  `supervising_officer_date` date DEFAULT NULL,
  `deputy_manager_id` int(10) UNSIGNED DEFAULT NULL,
  `deputy_manager_show` enum('no','yes') DEFAULT NULL,
  `deputy_manager_action` enum('approve','disapprove') CHARACTER SET latin1 DEFAULT NULL,
  `deputy_manager_reason` text CHARACTER SET latin1,
  `deputy_manager_date` date DEFAULT NULL,
  `manager_id` int(10) UNSIGNED DEFAULT NULL,
  `manager_show` enum('no','yes') DEFAULT NULL,
  `manager_action` enum('approve','disapprove') CHARACTER SET latin1 DEFAULT NULL,
  `manager_reason` text CHARACTER SET latin1,
  `manager_date` date DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `vendor_id`, `supervising_officer_id`, `supervising_officer_show`, `supervising_officer_action`, `supervising_officer_reason`, `supervising_officer_date`, `deputy_manager_id`, `deputy_manager_show`, `deputy_manager_action`, `deputy_manager_reason`, `deputy_manager_date`, `manager_id`, `manager_show`, `manager_action`, `manager_reason`, `manager_date`, `date`) VALUES
(1, 2, 13, 'no', 'disapprove', 'Pls full audit report', '2018-11-07', 10, 'no', 'disapprove', 'NJQS manager wants a proper report', '2018-11-07', 13, 'no', 'disapprove', 'submit a proper audit report', '2018-11-07', '2018-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `audit_report`
--

CREATE TABLE `audit_report` (
  `id` int(11) UNSIGNED NOT NULL,
  `vendor_id` int(11) UNSIGNED NOT NULL,
  `auditor_for_date` int(11) UNSIGNED DEFAULT NULL,
  `audit_date` date DEFAULT NULL,
  `auditor_for_report` int(11) UNSIGNED DEFAULT NULL,
  `report` longtext,
  `upload` text,
  `submission_date` date DEFAULT NULL,
  `creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `audit_report`
--

INSERT INTO `audit_report` (`id`, `vendor_id`, `auditor_for_date`, `audit_date`, `auditor_for_report`, `report`, `upload`, `submission_date`, `creation_date`) VALUES
(2, 2, 10, '2018-11-01', 10, 'Audit report of Alabian Solutions Ltd carried out on the 1st Nov&#039;18 by a team of expert of the audit department of Seplat Petroleum Development Company Plc. \r\n\r\nWill I survive til the mornin, to see the sun. I was given this world I didntt make it. Pour out some liquor and I reminsce, cause through the drama. And then they wonder why we crazy. And uhh, I know they like to beat ya down a lot.\r\n\r\nShe didn&#039;t realize. Dying inside, but outside you&#039;re looking fearless. She nearly gave her life, to raise me right. Pour out some liquor and I reminsce, cause through the drama. Everything will be alright if ya hold on.', '[{"file caption":"Warehouse Picture","filename":"12.pdf"},{"file caption":"Main office complex","filename":"22.pdf"}]', '2018-11-05', '2018-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE `fee` (
  `id` int(10) UNSIGNED NOT NULL,
  `fee` varchar(64) NOT NULL,
  `amount` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fee`
--

INSERT INTO `fee` (`id`, `fee`, `amount`) VALUES
(1, 'subscription', '25000'),
(2, 'renewal', '23500');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(16) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `password` char(64) NOT NULL,
  `default_password` enum('no','yes') DEFAULT NULL,
  `authority` enum('pre-vendor','vendor','review officer','supervising officer','deputy manager','manager','audit','IT','finance') NOT NULL,
  `status` enum('inactive','active') NOT NULL,
  `token` char(16) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `email`, `password`, `default_password`, `authority`, `status`, `token`, `date`) VALUES
(9, 'alabianltd', 'info@alabiansolutions.com', '$2a$12$q.g9b586NIDlO5mPl1y2CuLSIiw6HrKvHRfHObB9z5jIPjvtbFeIq', 'no', 'vendor', 'active', 'eotAHiNPC0laU3Vw', '2018-09-02'),
(10, 'alabi', 'alabi10@yahoo.com', '$2a$12$q.g9b586NIDlO5mPl1y2CuLSIiw6HrKvHRfHObB9z5jIPjvtbFeIq', 'no', 'audit', 'active', 'eotAHiNPC0laU3Vw', '2018-09-03'),
(13, 'opeyemi', 'opeyemi.oyekunle@alabiansolutions.com', '$2a$12$q.g9b586NIDlO5mPl1y2CuLSIiw6HrKvHRfHObB9z5jIPjvtbFeIq', 'no', 'supervising officer', 'active', '6nMVW0Tkl1Cx9zvr', '2018-09-03'),
(14, NULL, 'alabi101@yahoo.com', '$2a$12$q.g9b586NIDlO5mPl1y2CuLSIiw6HrKvHRfHObB9z5jIPjvtbFeIq', 'no', 'pre-vendor', 'active', 'e2F7VHswJEgOn9ir', '2018-09-03'),
(15, 'opeltd', 'info@opelimited.com', '$2a$12$q.g9b586NIDlO5mPl1y2CuLSIiw6HrKvHRfHObB9z5jIPjvtbFeIq', 'no', 'vendor', 'active', 'kg95tE2BMNGKTanl', '2018-09-04'),
(17, 'alcplc', 'info@alc.com', '$2a$12$q.g9b586NIDlO5mPl1y2CuLSIiw6HrKvHRfHObB9z5jIPjvtbFeIq', 'no', 'vendor', 'active', 'JLF0SnsGaxPpgzkX', '2018-09-18'),
(18, NULL, 'info@chinoso.com', '$2a$12$q.g9b586NIDlO5mPl1y2CuLSIiw6HrKvHRfHObB9z5jIPjvtbFeIq', 'no', 'pre-vendor', 'active', 'bvW9Mkpmyrwc3oqS', '2018-09-19');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `login_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(11,0) NOT NULL,
  `item` enum('subscription','renewal') NOT NULL,
  `other` text NOT NULL,
  `approver` int(10) UNSIGNED DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `date` date NOT NULL,
  `vendor` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `login_id`, `amount`, `item`, `other`, `approver`, `approval_date`, `date`, `vendor`) VALUES
(2, 9, '25000', 'subscription', '{"Amount":25000,"RRR":"2000-990-834","Bank Name":"Access Bank Plc","Account Name":"NIPEX Intl","Account No":"0987654321","Status":"Under Consideration"}', 13, '2018-09-03', '2018-09-03', 'yes'),
(3, 14, '25000', 'subscription', '{"Amount":25000,"RRR":"2000-990-911","Bank Name":"Access Bank Plc","Account Name":"NIPEX Intl","Account No":"0987654321","Status":"Under Consideration"}', 13, '2018-09-17', '2018-09-03', 'no'),
(4, 15, '25000', 'subscription', '{"Amount":25000,"RRR":"2000-990-119","Bank Name":"Access Bank Plc","Account Name":"NIPEX Intl","Account No":"0987654321","Status":"Under Consideration"}', 13, '2018-09-04', '2018-09-04', 'yes'),
(5, 17, '25000', 'subscription', '{"Amount":25000,"RRR":"2000-990-120","Bank Name":"Access Bank Plc","Account Name":"NIPEX Intl","Account No":"0987654321","Status":"Under Consideration"}', 13, '2018-09-18', '2018-09-18', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `pre_vendor`
--

CREATE TABLE `pre_vendor` (
  `id` int(10) UNSIGNED NOT NULL,
  `login_id` int(10) UNSIGNED NOT NULL,
  `document` text COMMENT 'json data of doc',
  `company_name` text NOT NULL,
  `cac_no` varchar(16) NOT NULL,
  `phone_no` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pre_vendor`
--

INSERT INTO `pre_vendor` (`id`, `login_id`, `document`, `company_name`, `cac_no`, `phone_no`) VALUES
(5, 9, '{"CAC":"yes","C02":"yes","C07":"yes","Tax Certificate":"yes","VAT Certificate":"yes","Bank Reference":"yes","DPR":"yes","ITF":"yes","PENCOM":"yes"}', 'Alabian Solutions Limited', '90000', '08034265103'),
(6, 14, '{"CAC":"yes","C02":"yes","C07":"yes","Tax Certificate":"yes","VAT Certificate":"yes","Bank Reference":"yes","DPR":"yes","ITF":"yes","PENCOM":"yes"}', 'Alabian Venture Ltd', '90001', '8034265105'),
(7, 15, '{"CAC":"yes","C02":"yes","C07":"yes","Tax Certificate":"yes","VAT Certificate":"yes","Bank Reference":"yes","DPR":"yes","ITF":"yes","PENCOM":"yes"}', 'Ope Limited', '90002', '08034265105'),
(8, 17, '{"CAC":"yes","C02":"yes","C07":"yes","Tax Certificate":"yes","VAT Certificate":"yes","Bank Reference":"yes","DPR":"yes","ITF":"yes","PENCOM":"yes"}', 'Alabian Consulting Plc', '90005', '08034265106'),
(9, 18, '{"CAC":"yes","C02":"yes","C07":"yes","Tax Certificate":"yes","VAT Certificate":"yes","Bank Reference":"yes","DPR":"yes","ITF":"yes","PENCOM":"yes"}', 'Chinoso Ventures', '90006', '08034265108');

-- --------------------------------------------------------

--
-- Table structure for table `product_code`
--

CREATE TABLE `product_code` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `service` varchar(64) NOT NULL,
  `category` enum('category1','category2','category3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_code`
--

INSERT INTO `product_code` (`id`, `code`, `service`, `category`) VALUES
(1, '1.1.1', 'Minor Welding', 'category1'),
(2, '1.1.2', 'Minor Plumbing', 'category1'),
(4, '2.1.1', 'IT Service Consultancy', 'category2');

-- --------------------------------------------------------

--
-- Table structure for table `que_declaration`
--

CREATE TABLE `que_declaration` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `completed_by` text,
  `last_changed_by` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_declaration`
--

INSERT INTO `que_declaration` (`id`, `vendor_id`, `completed_by`, `last_changed_by`, `date_modified`, `date_created`) VALUES
(1, 4, '{"Name":"Opeyemi","Position":"Secretary","Date":"2018-09-05","Phone Number":"07033389938"}', '{"Name":"Oyetunde","Position":"Manager","Date":"2018-09-14","Phone Number":"0403989759"}', '2018-10-02 10:23:37', '0000-00-00 00:00:00'),
(2, 6, '{"Name":"Opeyemi","Position":"Secretary","Date":"2018-09-18","Phone Number":"07033389938"}', '{"Name":"Oyetunde","Position":"Manager","Date":"2018-09-14","Phone Number":"07033389937"}', '2018-10-05 11:01:59', '0000-00-00 00:00:00'),
(4, 2, '{"Name":"Ben U","Position":"Operation Manager","Date":"2018-10-01","Phone Number":"08034265104"}', '{"Name":"Ben U","Position":"Operation Manage","Date":"2018-10-18","Phone Number":"08034265104"}', '2018-10-21 13:57:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `que_dpr`
--

CREATE TABLE `que_dpr` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `dpr_no` varchar(12) DEFAULT NULL,
  `dpr_tittle` varchar(20) DEFAULT NULL,
  `dpr_certificate_1` char(20) DEFAULT NULL,
  `dpr_certificate_2` char(20) DEFAULT NULL,
  `dpr_certificate_3` char(20) DEFAULT NULL,
  `dpr_certificate_4` char(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `que_finance`
--

CREATE TABLE `que_finance` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `year_one` text,
  `year_two` text,
  `year_three` text,
  `nsitf` enum('no','yes') DEFAULT NULL,
  `nsitf_certificate_no` varchar(32) DEFAULT NULL,
  `value_of_insurance` varchar(32) DEFAULT NULL,
  `commments` text,
  `banker` text,
  `auditor` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_finance`
--

INSERT INTO `que_finance` (`id`, `vendor_id`, `year_one`, `year_two`, `year_three`, `nsitf`, `nsitf_certificate_no`, `value_of_insurance`, `commments`, `banker`, `auditor`, `date_modified`, `date_created`) VALUES
(2, 4, '{"Accounting Year":"2013","Reporting Currency":"NAIRA","Year Ending Month":"December","Audited Accounts":"2016","Annual Turnover":"242","percent Turnover":"52","Profit before tax":"53,000","Total Assets":"450,000","Current Assets":"20,000","Total Short Term liabilities":"53,862,750","Total Net Assets":"100,000,000","Issued Share Capital":"100,000"}', '{"Accounting Year":"2009","Reporting Currency":"NAIRA","Year Ending Month":"December","Audited Accounts":"2016","Annual Turnover":"242","percent Turnover":"56","Profit before tax":"53,000","Total Assets":"450,000","Current Assets":"20,000","Total Short Term liabilities":"53,862,750","Total Net Assets":"100,000,000","Issued Share Capital":"100,000"}', '{"Accounting Year":"2010","Reporting Currency":"NAIRA","Year Ending Month":"December","Audited Accounts":"2015","Annual Turnover":"232","percent Turnover":"51","Profit before tax":"53,000","Total Assets":"450,000","Current Assets":"20,000","Total Short Term liabilities":"53,862,750","Total Net Assets":"100,000,000","Issued Share Capital":"100,000"}', 'no', '0', '', '', '{"Name":"Alabi","Address Line 1":"oluakerele","Address Line 2":"","Town":"ikeja","State":"Lagos","Post Code":"","Country":"Nigeria"}', '{"Name":"Anuoluwapo","Address Line 1":"Ikeja","Address Line 2":"","Town":"Ikeja","State":"Ikeja","Post Code":"","Country":"Nigeria"}', '2018-10-04 05:30:25', '2018-10-01 00:00:00'),
(4, 6, '{"Accounting Year":"2017","Reporting Currency":"","Year Ending Month":"","Audited Accounts":"2017","Annual Turnover":"","percent Turnover":"","Profit before tax":"","Total Assets":"","Current Assets":"","Total Short Term liabilities":"","Total Net Assets":"","Issued Share Capital":""}', '{"Accounting Year":"2016","Reporting Currency":"","Year Ending Month":"","Audited Accounts":"2016","Annual Turnover":"","percent Turnover":"","Profit before tax":"","Total Assets":"","Current Assets":"","Total Short Term liabilities":"","Total Net Assets":"","Issued Share Capital":""}', '{"Accounting Year":"2016","Reporting Currency":"","Year Ending Month":"","Audited Accounts":"2016","Annual Turnover":"","percent Turnover":"","Profit before tax":"","Total Assets":"","Current Assets":"","Total Short Term liabilities":"","Total Net Assets":"","Issued Share Capital":""}', 'no', '34567890', '5000', '', '{"Name":"Ope","Address Line 1":"Ikeja","Address Line 2":"","Town":"Ikeja","State":"Lagos","Post Code":"+234","Country":"Nigeria"}', '{"Name":"opeyemi oyekunle","Address Line 1":"ikeja","Address Line 2":"Ikeja","Town":"Ikeja","State":"Lagos","Post Code":"+234","Country":"Nigeria"}', '2018-10-05 11:04:25', '2018-10-04 10:15:59'),
(5, 2, '{"Accounting Year":"2016","Reporting Currency":"NAIRA","Year Ending Month":"December","Audited Accounts":"2017","Annual Turnover":"21000000","percent Turnover":"100","Profit before tax":"9500000","Total Assets":"43000000","Current Assets":"8000000","Total Short Term liabilities":"4000000","Total Net Assets":"19000000","Issued Share Capital":"1000000"}', '{"Accounting Year":"2015","Reporting Currency":"NAIRA","Year Ending Month":"December","Audited Accounts":"2016","Annual Turnover":"14000000","percent Turnover":"100","Profit before tax":"5000000","Total Assets":"23000000","Current Assets":"4000000","Total Short Term liabilities":"2000000","Total Net Assets":"9000000","Issued Share Capital":"1000000"}', '{"Accounting Year":"2016","Reporting Currency":"","Year Ending Month":"","Audited Accounts":"2016","Annual Turnover":"","percent Turnover":"","Profit before tax":"","Total Assets":"","Current Assets":"","Total Short Term liabilities":"","Total Net Assets":"","Issued Share Capital":""}', 'no', NULL, NULL, '', '{"Name":"Zenith Bank Plc","Address Line 1":"No 12, Oluakerele Street, Balogun Bus Stop","Address Line 2":"","Town":"Ikeja","State":"Lagos","Post Code":"112106","Country":"Nigeria"}', '{"Name":"Benedict Uwazie & Partner","Address Line 1":"No 12, Oluakerele Street, Balogun Bus Stop","Address Line 2":"","Town":"Ikeja","State":"Lagos","Post Code":"112106","Country":"Nigeria"}', '2018-10-19 06:19:21', '2018-10-19 07:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `que_general`
--

CREATE TABLE `que_general` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `head_office_address` text,
  `town_city` varchar(64) DEFAULT NULL,
  `post_code` int(10) DEFAULT NULL,
  `state_county` varchar(65) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `telephone1` varchar(15) DEFAULT NULL,
  `telephone2` varchar(15) DEFAULT NULL,
  `operational_address` text,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(65) DEFAULT NULL,
  `previous_company_name` varchar(100) DEFAULT NULL,
  `previous_company_address` varchar(100) DEFAULT NULL,
  `additional_information` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_general`
--

INSERT INTO `que_general` (`id`, `vendor_id`, `head_office_address`, `town_city`, `post_code`, `state_county`, `country`, `telephone1`, `telephone2`, `operational_address`, `email`, `website`, `previous_company_name`, `previous_company_address`, `additional_information`, `date_modified`, `date_created`) VALUES
(4, 4, 'No 12, Olu Akerele Street,\r\nOff Kofoworola Crecent off Obafemi Awolowo Way', 'Ikeja', 100001, 'Lagos State', 'Nigeria', '08034265103', '', '1, Solaru Street', 'info@opeltd.com.ng', 'opeltd.com.ng', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 6, '12 Olu Akerele Street, Ikeja Lagos', 'Ikeja', 100010, 'Lagos', 'Nigeria', '2348034265103', '2348034265105', 'Shipyard Apapa Lagos', 'info@alcplc.com', 'alcplc.com.ng', '', '', '', '2018-10-31 10:36:30', '2018-10-02 04:12:24'),
(7, 2, '1, Solaru Street', 'Sholuyi Gbagada', 100010, 'Lagos', 'Nigeria', '8034265103', '', '1, Solaru Street', 'alabi10@yahoo.com', 'alabians.com', '', '', '', '2018-10-19 06:08:16', '2018-10-19 07:07:47');

-- --------------------------------------------------------

--
-- Table structure for table `que_hse`
--

CREATE TABLE `que_hse` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `hse_policy` enum('No','Yes') NOT NULL,
  `last_review_date` varchar(36) DEFAULT NULL,
  `name_of_person` varchar(50) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `policy_objective` enum('No','Yes') DEFAULT NULL,
  `hards_risk` enum('No','Yes') DEFAULT NULL,
  `contigency_plan` enum('No','Yes') DEFAULT NULL,
  `reporting_procedure` enum('No','Yes') DEFAULT NULL,
  `adequate_ppe` enum('No','Yes') DEFAULT NULL,
  `minor_incident` enum('No','Yes') DEFAULT NULL,
  `training_of_hse` enum('No','Yes') DEFAULT NULL,
  `external_internaml` enum('No','Yes') DEFAULT NULL,
  `uptodate` enum('No','Yes') DEFAULT NULL,
  `subcontractors_competence` enum('No','Yes') DEFAULT NULL,
  `driving_transport` enum('No','Yes') DEFAULT NULL,
  `drugs_alcohol` enum('No','Yes') DEFAULT NULL,
  `hse_internal_audit` enum('No','Yes') DEFAULT NULL,
  `health_insurance_scheme` enum('No','Yes') DEFAULT NULL,
  `additional_info1` text,
  `additional_info3` text,
  `management_system` enum('No','Yes') DEFAULT NULL,
  `standards_guideline` enum('No','Yes') DEFAULT NULL,
  `system_certified` enum('No','Yes') DEFAULT NULL,
  `certifying_body` varchar(128) DEFAULT NULL,
  `certificate_number` varchar(32) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `your_company` enum('No','Yes') DEFAULT NULL,
  `year1` text,
  `year2` text,
  `year3` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_hse`
--

INSERT INTO `que_hse` (`id`, `vendor_id`, `hse_policy`, `last_review_date`, `name_of_person`, `phone_no`, `email`, `policy_objective`, `hards_risk`, `contigency_plan`, `reporting_procedure`, `adequate_ppe`, `minor_incident`, `training_of_hse`, `external_internaml`, `uptodate`, `subcontractors_competence`, `driving_transport`, `drugs_alcohol`, `hse_internal_audit`, `health_insurance_scheme`, `additional_info1`, `additional_info3`, `management_system`, `standards_guideline`, `system_certified`, `certifying_body`, `certificate_number`, `expiry_date`, `your_company`, `year1`, `year2`, `year3`, `date_modified`, `date_created`) VALUES
(12, 4, 'No', '2018-09-01', 'Alabi A', '+2348034265103', 'alabi10@yahoo.com', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '', '', 'Yes', 'Yes', 'Yes', 'NEBOSH', '9088U78', '2018-09-30 00:00:00', 'Yes', '{"calender year1":"2017","total manh1":"32000","lost time1":"0","number of facilities1":"1"}', '{"calender year2":"2016","total manh2":"18000","lost time2":"0","number of facilities2":"0"}', '{"calender year3":"2015","total manh3":"15000","lost time3":"0","number of facilities3":"0"}', '2018-10-02 10:31:45', '0000-00-00 00:00:00'),
(14, 6, 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'No', NULL, 'No', '', '', NULL, NULL, '{"calender year1":"2017","total manh1":"20","lost time1":"6","number of facilities1":"7"}', '{"calender year2":"2016","total manh2":"10","lost time2":"3","number of facilities2":"3"}', '{"calender year3":"2015","total manh3":"5","lost time3":"4","number of facilities3":"2"}', '2018-10-23 10:32:22', '0000-00-00 00:00:00'),
(17, 2, 'Yes', '2018-10-20', 'Alabi A', '+2348034265103', 'alabi10@yahoo.com', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'nothing to talk about', '', 'Yes', 'Yes', 'Yes', 'NEBOSH', '9088U78', '2018-10-31 00:00:00', 'Yes', '{"calender year1":"2017","total manh1":"0","lost time1":"0","number of facilities1":"0"}', '{"calender year2":"2016","total manh2":"0","lost time2":"0","number of facilities2":"0"}', '{"calender year3":"2015","total manh3":"0","lost time3":"0","number of facilities3":"0"}', '2018-10-21 14:52:29', '2018-10-20 07:38:54');

-- --------------------------------------------------------

--
-- Table structure for table `que_legal`
--

CREATE TABLE `que_legal` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `business_commencement_year` char(4) DEFAULT NULL,
  `company_type` varchar(128) DEFAULT NULL,
  `country_of_registration` varchar(15) DEFAULT NULL,
  `cac_no` char(8) DEFAULT NULL,
  `registration_year` char(4) DEFAULT NULL,
  `comments` text,
  `associated_company` varchar(30) DEFAULT NULL,
  `shareholder` text,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_legal`
--

INSERT INTO `que_legal` (`id`, `vendor_id`, `business_commencement_year`, `company_type`, `country_of_registration`, `cac_no`, `registration_year`, `comments`, `associated_company`, `shareholder`, `date_modified`, `date_created`) VALUES
(1, 4, '2018', 'Lim', 'Nigeria', '95879534', '2001', 'New comment', 'Ashafa', '[{"name1":"opeyemi oyekunle"},{"name2":"Wasiu"},{"name3":"Akinde"},{"name4":"Olaoluwa"}]', '2018-10-02 06:24:59', '2018-10-02 00:00:00'),
(4, 6, '2012', 'Limited', 'Nigeria', '345675', '2014', '', '', '[{"no":0,"director":"opeyemi oyekunle","nationality":"UK","gender":"Female","ownership":"5"},{"no":1,"director":"Adewusi Okoh","nationality":"Nigeria","gender":"Male","ownership":"7"}]', '2018-10-05 13:02:50', '2018-10-02 07:09:29'),
(5, 2, '2011', 'Ltd', 'Nigeria', '90009', '2011', '', '', '[{"no":0,"director":"Alabi A","nationality":"Nigerian","gender":"male","ownership":"90"},{"no":1,"director":"Ben U","nationality":"Nigerian","gender":"male","ownership":"4"},{"no":2,"director":"Asmiat O","nationality":"Togolese","gender":"female","ownership":"6"}]', '2018-10-19 07:10:31', '2018-10-19 07:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `que_nigeria_content`
--

CREATE TABLE `que_nigeria_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `nigerian_content_policy` enum('no','yes') DEFAULT NULL,
  `nigerian_contact_name` varchar(36) DEFAULT NULL,
  `email` varchar(36) DEFAULT NULL,
  `contact_phone` char(15) DEFAULT NULL,
  `pension_scheme` enum('no','yes') DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_nigeria_content`
--

INSERT INTO `que_nigeria_content` (`id`, `vendor_id`, `nigerian_content_policy`, `nigerian_contact_name`, `email`, `contact_phone`, `pension_scheme`, `date_modified`, `date_created`) VALUES
(5, 4, 'no', '', '', '', 'yes', '2018-10-02 10:34:28', '0000-00-00 00:00:00'),
(6, 6, 'no', 'opeyemi oyekunle', 'oye.opeyemi.oye@gmail.com', '07033389938', 'no', '2018-10-02 10:34:28', '0000-00-00 00:00:00'),
(8, 2, 'yes', 'Alabi A', 'alabi10@yahoo.com', '+2348034265103', 'no', '2018-10-21 13:49:05', '2018-10-21 14:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `que_personnel`
--

CREATE TABLE `que_personnel` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `title` char(4) DEFAULT NULL,
  `first_name` varchar(15) DEFAULT NULL,
  `surname` varchar(20) DEFAULT NULL,
  `other_name` varchar(20) DEFAULT NULL,
  `job_title` varchar(15) DEFAULT NULL,
  `address_1` varchar(100) DEFAULT NULL,
  `address_2` varchar(100) DEFAULT NULL,
  `town` varchar(32) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `postcode` int(11) DEFAULT NULL,
  `country` varchar(15) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(36) DEFAULT NULL,
  `comments` text,
  `executives` text,
  `current_year` text,
  `previous_year` text,
  `last_two_years` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_personnel`
--

INSERT INTO `que_personnel` (`id`, `vendor_id`, `title`, `first_name`, `surname`, `other_name`, `job_title`, `address_1`, `address_2`, `town`, `state`, `postcode`, `country`, `phone`, `email`, `comments`, `executives`, `current_year`, `previous_year`, `last_two_years`, `date_modified`, `date_created`) VALUES
(1, 4, 'mr', 'Anuoluwapo', 'Oderinlo', '', 'web', 'oluakerele', 'Anuoluwapo', 'ikeja', 'Lagos', 0, 'nigeria', '0703706156', 'alabi@gmail.com', '', '', '{"Number of staff":"7","Number of professional staff":"7","Number of non-professional staff":"5","Number of permanent staff":"3","Number of contract staff":"5","Number of expatriate staff":"1","Additional information\\/Comments":"this is just a comment"}', NULL, '{"Number of staff":"9","Number of professional staff":"9","Number of non-professional staff":"6","Number of permanent staff":"1","Number of contract staff":"5","Number of expatriate staff":"1","Additional information\\/Comments":"this is just a comment"}', '2018-10-03 12:52:27', '0000-00-00 00:00:00'),
(5, 6, 'Mr', 'Oyekunle', 'Opeyemi', '', 'manager', 'Ikeja', 'Oyekunle', 'Ikeja', 'Lagos', 234, 'Nigeria', '08103792761', 'opeyemi.oyekunle@alabiansolutions.co', '', '[{"no":0,"executivePosition":"CEO\\/MD","executiveTitle":"Mr","executiveFirstName":"Bankole","executiveSurname":"Korede","executiveEmail":"oye.opeyemi.oye@gmail.com","executiveNationality":"UK","executiveOtherName":"Riola"}]', '{"Number of staff":"2","Number of professional staff":"3","Number of non-professional staff":"","Number of permanent staff":"","Number of contract staff":"","Number of expatriate staff":"","Additional information\\/Comments":""}', '{"Number of staff":"4","Number of professional staff":"3","Number of non-professional staff":"","Number of permanent staff":"","Number of contract staff":"","Number of expatriate staff":"","Additional information\\/Comments":null}', '{"Number of staff":"4","Number of professional staff":"6","Number of non-professional staff":"","Number of permanent staff":"","Number of contract staff":"","Number of expatriate staff":"","Additional information\\/Comments":""}', '2018-10-05 12:03:08', '2018-10-04 11:45:34'),
(6, 2, 'Mr', 'Alabi', 'Adebayo', '', 'CEO', '1, Solaru Street', '', 'Ikeja', 'Lagos', 100010, 'Nigeria', '2348034265103', 'alabi10@yahoo.com', '', '[{"no":0,"executivePosition":"CEO\\/MD or GM","executiveTitle":"Mr","executiveFirstName":"Alabi","executiveSurname":"A","executiveEmail":"alabi10@yahoo.com","executiveNationality":"Nigerian","executiveOtherName":""},{"no":1,"executivePosition":"Technical\\/Ops Manager","executiveTitle":"Mr","executiveFirstName":"Ben ","executiveSurname":"U.","executiveEmail":"ben@yahoo.com","executiveNationality":"Nigerian","executiveOtherName":""},{"no":2,"executivePosition":"Finance Director","executiveTitle":"Miss","executiveFirstName":"Asmiat","executiveSurname":"Omobolanle","executiveEmail":"asimat@yahoo.com","executiveNationality":"Togolese","executiveOtherName":""}]', '{"Number of staff":"13","Number of professional staff":"9","Number of non-professional staff":"4","Number of permanent staff":"11","Number of contract staff":"2","Number of expatriate staff":"0","Additional information\\/Comments":""}', '{"Number of staff":"4","Number of professional staff":"4","Number of non-professional staff":"0","Number of permanent staff":"3","Number of contract staff":"1","Number of expatriate staff":"0","Additional information\\/Comments":null}', '{"Number of staff":"0","Number of professional staff":"0","Number of non-professional staff":"0","Number of permanent staff":"0","Number of contract staff":"0","Number of expatriate staff":"0","Additional information\\/Comments":""}', '2018-10-19 06:15:19', '2018-10-19 07:15:19');

-- --------------------------------------------------------

--
-- Table structure for table `que_product_and_services`
--

CREATE TABLE `que_product_and_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `products_code` varchar(10) DEFAULT NULL,
  `certificate` varchar(25) DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_product_and_services`
--

INSERT INTO `que_product_and_services` (`id`, `vendor_id`, `products_code`, `certificate`, `date_created`) VALUES
(14, 2, '1.1.2', '21.1.2.pdf', '2018-10-21 13:17:32'),
(16, 6, '1.1.1', '61.1.1.pdf', '2018-10-23 11:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `que_quality_management`
--

CREATE TABLE `que_quality_management` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `quality_mgt_system` enum('no','yes') DEFAULT NULL,
  `quality_policy` enum('no','yes') DEFAULT NULL,
  `last_review_date` date DEFAULT NULL,
  `staff_aware_policy` enum('no','yes') DEFAULT NULL,
  `certified_system` enum('no','yes') DEFAULT NULL,
  `third_party_accreditation` enum('no','yes') DEFAULT NULL,
  `relevant_standard` varchar(128) DEFAULT NULL,
  `certifying_authority` varchar(128) DEFAULT NULL,
  `certificate_number` varchar(32) DEFAULT NULL,
  `responsible_for_qms` varchar(36) DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `comments` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `que_quality_management`
--

INSERT INTO `que_quality_management` (`id`, `vendor_id`, `quality_mgt_system`, `quality_policy`, `last_review_date`, `staff_aware_policy`, `certified_system`, `third_party_accreditation`, `relevant_standard`, `certifying_authority`, `certificate_number`, `responsible_for_qms`, `phone`, `email`, `comments`, `date_modified`, `date_created`) VALUES
(3, 4, 'yes', 'no', '2018-09-04', 'no', 'yes', 'yes', NULL, NULL, NULL, 'ALABI', '7023', 'info@domain.com', 'this is just a comment', '2018-10-02 10:38:56', '0000-00-00 00:00:00'),
(7, 6, 'yes', 'yes', '0000-00-00', 'yes', 'yes', 'no', NULL, NULL, NULL, '', '', '', '', '2018-10-02 10:38:56', '0000-00-00 00:00:00'),
(8, 2, 'yes', 'yes', '2018-10-19', 'yes', 'yes', 'yes', 'British Satefy Board', 'NEBOSH', '1229UI', 'Alabi A.', '08034265103', 'alabi10@yahoo.com', '', '2018-10-31 21:45:08', '2018-10-19 10:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `review_officer_id` int(10) UNSIGNED DEFAULT NULL,
  `review_officer_show` enum('no','yes') DEFAULT NULL,
  `review_officer_action` enum('approve','disapprove') CHARACTER SET latin1 DEFAULT NULL,
  `review_officer_reason` text CHARACTER SET latin1,
  `review_officer_date` date DEFAULT NULL,
  `supervising_officer_id` int(10) UNSIGNED DEFAULT NULL,
  `supervising_officer_show` enum('no','yes') DEFAULT NULL,
  `supervising_officer_action` enum('approve','disapprove') CHARACTER SET latin1 DEFAULT NULL,
  `supervising_officer_reason` text CHARACTER SET latin1,
  `supervising_officer_date` date DEFAULT NULL,
  `deputy_manager_id` int(10) UNSIGNED DEFAULT NULL,
  `deputy_manager_show` enum('no','yes') DEFAULT NULL,
  `deputy_manager_action` enum('approve','disapprove') CHARACTER SET latin1 DEFAULT NULL,
  `deputy_manager_reason` text CHARACTER SET latin1,
  `deputy_manager_date` date DEFAULT NULL,
  `manager_id` int(10) UNSIGNED DEFAULT NULL,
  `manager_show` enum('no','yes') DEFAULT NULL,
  `manager_action` enum('approve','disapprove') CHARACTER SET latin1 DEFAULT NULL,
  `manager_reason` text CHARACTER SET latin1,
  `manager_date` date DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `vendor_id`, `review_officer_id`, `review_officer_show`, `review_officer_action`, `review_officer_reason`, `review_officer_date`, `supervising_officer_id`, `supervising_officer_show`, `supervising_officer_action`, `supervising_officer_reason`, `supervising_officer_date`, `deputy_manager_id`, `deputy_manager_show`, `deputy_manager_action`, `deputy_manager_reason`, `deputy_manager_date`, `manager_id`, `manager_show`, `manager_action`, `manager_reason`, `manager_date`, `date`) VALUES
(2, 6, 10, 'no', 'disapprove', 'Your country is showing Algeria instead of Nigeria, please correct this and send again', '2018-10-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-23'),
(3, 2, 10, 'no', 'disapprove', 'Please state the relevant standard of your quality management system', '2018-10-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-23'),
(4, 6, NULL, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-31'),
(5, 2, 10, 'no', 'disapprove', 'Please fix the entire questionnaire, it was reject by our manager', '2018-10-31', 10, 'no', 'disapprove', 'The manager said it all rubbish', '2018-10-31', 10, 'no', 'disapprove', 'The manager said it all rubbish', '2018-10-31', 10, 'no', 'disapprove', 'This is all rubbish', '2018-10-31', '2018-10-31'),
(6, 2, 10, 'no', 'approve', NULL, '2018-10-31', 10, 'no', 'approve', NULL, '2018-10-31', 10, 'no', 'approve', NULL, '2018-10-31', 10, 'no', 'approve', NULL, '2018-10-31', '2018-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `reviewii`
--

CREATE TABLE `reviewii` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `review_officer_id` int(10) UNSIGNED DEFAULT NULL,
  `review_officer_action` text CHARACTER SET latin1,
  `review_officer_reason` text CHARACTER SET latin1,
  `review_officer_date` date DEFAULT NULL,
  `supervising_officer_id` int(10) UNSIGNED DEFAULT NULL,
  `supervising_officer_action` text CHARACTER SET latin1,
  `supervising_officer_reason` text CHARACTER SET latin1,
  `supervising_officer_date` date DEFAULT NULL,
  `auditor_id` int(10) UNSIGNED DEFAULT NULL,
  `auditor_action` text CHARACTER SET latin1,
  `auditor_reason` text CHARACTER SET latin1,
  `auditor_date` date DEFAULT NULL,
  `deputy_manager_id` int(10) UNSIGNED DEFAULT NULL,
  `deputy_manager_action` text CHARACTER SET latin1,
  `deputy_manager_reason` text CHARACTER SET latin1,
  `deputy_manager_date` date DEFAULT NULL,
  `manager_id` int(10) UNSIGNED DEFAULT NULL,
  `manager_action` text CHARACTER SET latin1,
  `manager_reason` text CHARACTER SET latin1,
  `manager_date` date DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviewii`
--

INSERT INTO `reviewii` (`id`, `vendor_id`, `review_officer_id`, `review_officer_action`, `review_officer_reason`, `review_officer_date`, `supervising_officer_id`, `supervising_officer_action`, `supervising_officer_reason`, `supervising_officer_date`, `auditor_id`, `auditor_action`, `auditor_reason`, `auditor_date`, `deputy_manager_id`, `deputy_manager_action`, `deputy_manager_reason`, `deputy_manager_date`, `manager_id`, `manager_action`, `manager_reason`, `manager_date`, `date`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `login_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `passport` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `login_id`, `name`, `phone`, `passport`) VALUES
(1, 10, 'Alabi Adebayo', '08034265103', 'profile.png'),
(4, 13, 'Opeyemi Oyekunle', '08034265104', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(10) UNSIGNED NOT NULL,
  `login_id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(128) NOT NULL,
  `vendor_status` enum('registered','published','pre qualified','expired','review in progress','under audit','audit review') NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `que_submitted` enum('no','yes') NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `login_id`, `company_name`, `vendor_status`, `expiration_date`, `que_submitted`, `date_created`) VALUES
(2, 9, 'Alabian Solutions Ltd', 'under audit', '2019-02-02', 'yes', '0000-00-00 00:00:00'),
(4, 15, 'Ope Limited', 'registered', '2020-06-04', 'no', '0000-00-00 00:00:00'),
(6, 17, 'Alabian Consulting Plc', 'published', '2019-09-04', 'yes', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`,`supervising_officer_id`,`deputy_manager_id`,`manager_id`);

--
-- Indexes for table `audit_report`
--
ALTER TABLE `audit_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logger_id` (`login_id`),
  ADD KEY `approver` (`approver`);

--
-- Indexes for table `pre_vendor`
--
ALTER TABLE `pre_vendor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logger_id` (`login_id`);

--
-- Indexes for table `product_code`
--
ALTER TABLE `product_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `que_declaration`
--
ALTER TABLE `que_declaration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `que_dpr`
--
ALTER TABLE `que_dpr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `que_finance`
--
ALTER TABLE `que_finance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `que_general`
--
ALTER TABLE `que_general`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor_id` (`vendor_id`) USING BTREE;

--
-- Indexes for table `que_hse`
--
ALTER TABLE `que_hse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `que_legal`
--
ALTER TABLE `que_legal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `que_nigeria_content`
--
ALTER TABLE `que_nigeria_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `que_personnel`
--
ALTER TABLE `que_personnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `que_product_and_services`
--
ALTER TABLE `que_product_and_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_2` (`products_code`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `products_code` (`products_code`);

--
-- Indexes for table `que_quality_management`
--
ALTER TABLE `que_quality_management`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`,`review_officer_id`,`supervising_officer_id`,`deputy_manager_id`,`manager_id`);

--
-- Indexes for table `reviewii`
--
ALTER TABLE `reviewii`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`,`review_officer_id`,`supervising_officer_id`,`auditor_id`,`deputy_manager_id`,`manager_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logger_id` (`login_id`),
  ADD KEY `logger_id_2` (`login_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `audit_report`
--
ALTER TABLE `audit_report`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fee`
--
ALTER TABLE `fee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pre_vendor`
--
ALTER TABLE `pre_vendor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_code`
--
ALTER TABLE `product_code`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `que_declaration`
--
ALTER TABLE `que_declaration`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `que_dpr`
--
ALTER TABLE `que_dpr`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `que_finance`
--
ALTER TABLE `que_finance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `que_general`
--
ALTER TABLE `que_general`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `que_hse`
--
ALTER TABLE `que_hse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `que_legal`
--
ALTER TABLE `que_legal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `que_nigeria_content`
--
ALTER TABLE `que_nigeria_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `que_personnel`
--
ALTER TABLE `que_personnel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `que_product_and_services`
--
ALTER TABLE `que_product_and_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `que_quality_management`
--
ALTER TABLE `que_quality_management`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `reviewii`
--
ALTER TABLE `reviewii`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`approver`) REFERENCES `login` (`id`);

--
-- Constraints for table `pre_vendor`
--
ALTER TABLE `pre_vendor`
  ADD CONSTRAINT `pre_vendor_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `que_declaration`
--
ALTER TABLE `que_declaration`
  ADD CONSTRAINT `que_declaration_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `que_general`
--
ALTER TABLE `que_general`
  ADD CONSTRAINT `que_general_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `que_product_and_services`
--
ALTER TABLE `que_product_and_services`
  ADD CONSTRAINT `que_product_and_services_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
