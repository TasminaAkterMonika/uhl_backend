-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 20, 2022 at 08:27 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `doctor_id` int(191) UNSIGNED DEFAULT NULL,
  `doctor_name` varchar(191) NOT NULL,
  `degree` varchar(191) NOT NULL,
  `uhl_id` varchar(191) NOT NULL,
  `bmdc_id` varchar(191) NOT NULL,
  `dept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `doctor_id`, `doctor_name`, `degree`, `uhl_id`, `bmdc_id`, `dept_id`) VALUES
(1, NULL, 'Dr. Kaisar Nasrullah Khan\r\n', '', 'EID-10315\r\n', 'A-21955\r\n', 16),
(2, NULL, 'Dr. Mohammad Mahabub -Ul- Amin\r\n', '', 'EID-10519', 'A-22397', 16),
(3, NULL, 'Dr. Jahangir  Kabir\r\n', '', 'EID-10585', 'A-11655', 15),
(4, NULL, 'Dr. Rezaul  Hassan\r\n', '', 'EID-10589', 'A-16754', 15),
(5, NULL, 'Dr. Reazur  Rahman\r\n', '', 'EID-10644', 'A-24169', 16),
(6, NULL, 'Dr. Naseem  Mahmud\r\n', '', 'EID-10659', 'A-14212', 85),
(7, NULL, 'Dr. Fatema  Begum\r\n', '', 'EID-10753', 'A-17435', 16),
(8, NULL, 'Dr. N. A. M.  Momenuzzaman\r\n', 'MBBS, D-Card. MD (Card)', 'EID-10754', 'A-12492', 16),
(9, NULL, 'Dr. Md. Sayedur Rahman Khan\r\n', '', 'EID-11048', 'A-26277', 15),
(10, NULL, 'Dr. Afsana  Begum\r\n', '', 'EID-11245', 'A-31470', 64),
(11, NULL, 'Dr. Aminul  Hashan\r\n', '', 'EID-11252', '1312', 90),
(12, NULL, 'Dr. Syed Sayed Ahmed\r\n', '', 'EID-11430', 'A 11613', 80),
(13, NULL, 'Dr. Nusrat  Zaman\r\n', '', 'EID-11727', 'A 10707', 85),
(14, NULL, 'Dr. Mahfuza  Khanam\r\n', '', 'EID-11787', 'A-19580', 85),
(15, NULL, 'Dr. Halima  Akhtar\r\n', '', 'EID-11828', 'A-23079', 85),
(16, NULL, 'Dr. Nargis Ara Begum\r\n', '', 'EID-11836', 'A-17098', 77),
(17, NULL, 'Dr. Pradip Ranjan Saha\r\n', '', 'EID-12072', '6481', 64),
(18, NULL, 'Dr. Shahnaz Parvin Siddiqua\r\n', '', 'EID-12189', 'A-24060', 92),
(19, NULL, 'Dr. Mohammad Abdur Rahman\r\n', '', 'EID-12306', 'A-35056', 77),
(20, NULL, 'Dr. Md. Iqbal Hossain\r\n', '', 'EID-12321', 'A-15506', 64),
(21, NULL, 'Dr. Nighat  Ara\r\n', '', 'EID-12346', 'A-30069', 85),
(22, NULL, 'Dr. Md. Rashid Un Nabi\n', '', 'EID-12382', 'A-19160', 86),
(23, NULL, 'Dr. Afsari  Ahmad\n', '', 'EID-12716', 'A29982', 85),
(24, NULL, 'Dr. Syeda Fahmida Hossain\n', '', 'EID-12800', 'A-40893', 64),
(25, NULL, 'Prof. Brig Gen Zahid Mahmud (Retd)\n', 'FCPS(Haematology)', 'EID-12829', '8608', 54),
(26, NULL, 'Dr. Ashim Kumar Sengupta\n', '', 'EID-13037', 'A 29369', 86),
(27, NULL, 'Dr. Mohammad Moshiur Rahman\n', '', 'EID-13070', '7368', 92),
(28, NULL, 'Dr. Md. Mahbub Alam\n', '', 'EID-13202', '6653', 47),
(29, NULL, 'Dr. Runa  Laila\n', '', 'EID-13417', 'A-42108', 92),
(30, NULL, 'Dr. Mohammad Jahangir Talukder\n', '', 'EID-13426', 'A 7322', 64),
(31, NULL, 'Dr. Polly  Ahmed\r\n', '', 'EID-13635\r\n', 'A-38347\r\n', 85),
(32, NULL, 'Dr. Sharif  Ahmed\r\n', '', 'EID-13695\r\n', 'A-41561\r\n', 86),
(33, NULL, 'Dr. Md. Rakib Hossain\r\n', '', 'EID-13724\r\n', 'A-38976\r\n', 38),
(34, NULL, 'Dr. S. M. Zakir Khaled\r\n', '', 'EID-14136\r\n', 'A-31925\r\n', 15),
(35, NULL, 'Dr. Afreed Jahan\r\n', '', 'EID-14233\r\n', 'A-42289\r\n', 16),
(36, NULL, 'Dr. Tania Mahbub\r\n', '', 'EID-14247\r\n', 'A-37115\r\n', 78),
(37, NULL, 'Dr. Tanveer Bin Latif\r\n', '', 'EID-14396\r\n', 'A-32346\r\n', 78),
(38, NULL, 'Dr. Sonjoy Biswas\r\n', '', 'EID-14407\r\n', 'A-34114\r\n', 15),
(39, NULL, 'Dr. Tunaggina Afrin Khan\r\n', '', 'EID-14430\r\n', 'A-43196\r\n', 16),
(40, NULL, 'Dr. Md. Shakhawat  Hossain\r\n', '', 'EID-14450\r\n', 'A-44290\r\n', 15),
(41, NULL, 'Dr. Mohammad Nadim Bin\r\n', '', 'EID-14455\r\n', 'A-57708\r\n', 35),
(42, NULL, 'Dr. Zeenat  Sultana\r\n', '', 'EID-14526\r\n', 'A-40945\r\n', 64),
(43, NULL, 'Dr. Khan Md. Sayeduzzaman\r\n', '', 'EID-14664\r\n', 'A-15952\r\n', 116),
(44, NULL, 'Dr. Ajmal Quader Chowdhury\r\n', '', 'EID-14711\r\n', 'A-39068\r\n', 51),
(45, NULL, 'Dr. Salina Akter\r\n', '', 'EID-14712\r\n', 'A-51439\r\n', 78),
(46, NULL, 'Dr. Arif Ahmed Mohiuddin\r\n', '', 'EID-14715\r\n', 'A-39898\r\n', 15),
(47, NULL, 'Prof. Dr. Brig. Gen. Md. Abdul Mannan (Retd)\r\n', '', 'EID-14758\r\n', 'A-14955\r\n', 90),
(48, NULL, 'Dr. Sultan  Mahmud\r\n', '', 'EID-15497\r\n', 'A-42022\r\n', 51),
(49, NULL, 'Dr. Soumen Chakraborty\r\n', '', 'EID-15681\r\n', 'A-43898\r\n', 16),
(50, NULL, 'Dr. Md. Helal Uddin\r\n', '', 'EID-15769\r\n', 'A-27282\r\n', 16),
(51, NULL, 'Dr. Mohammad Rafiur Rahman\r\n', '', 'EID-15861\r\n', 'A38844\r\n', 15),
(52, NULL, 'Dr. S.M. Sadlee\r\n', '', 'EID-16015\r\n', 'A53671\r\n', 79),
(53, NULL, 'Dr. Naima Siddiquee\r\n', '', 'EID-16210\r\n', 'A-48195\r\n', 104),
(54, NULL, 'Dr. Md. Matiur Rahman\r\n', '', 'EID-16234\r\n', 'A-46186\r\n', 16),
(55, NULL, 'Dr. Mohammad Arman Hossain\r\n', '', 'EID-16253\r\n', 'A-34156\r\n', 15),
(56, NULL, 'Dr. Amina Sultana\r\n', '', 'EID-16391\r\n', 'A-34371\r\n', 61),
(57, NULL, 'Dr. Rawshan Arra Khanam\r\n', '', 'EID-16561\r\n', 'A-38841\r\n', 116),
(58, NULL, 'Dr. Mirza Abul Kalam Mohiuddin\r\n', '', 'EID-16603\r\n', 'A-18028\r\n', 15),
(59, NULL, 'Dr. Shirin Akter\r\n', '', 'EID-16753\r\n', 'A-37348\r\n', 77),
(60, NULL, 'Prof. Dr. S. M. G. Kibria\r\n', '', 'EID-16948\r\n', 'A-14210\r\n', 51),
(61, NULL, 'Dr. Md. Ali  Zulkifl\r\n', '', 'EID-17169\r\n', 'A-12884\r\n', 132),
(62, NULL, 'Dr. Ashia  Ali\r\n', '', 'EID-17170\r\n', 'A-17645\r\n', 48),
(63, NULL, 'Dr. Abu Mohammed Shafique\r\n', 'MBBS, MD (Cardiology)', 'EID-17197\r\n', 'A-22408\r\n', 16),
(64, NULL, 'Dr. Nusrat  Jahan\r\n', '', 'EID-17431\r\n', 'A-40979\r\n', 64),
(65, NULL, 'Dr. Mohammad Rabiul Karim Khan\r\n', 'MBBS, FCPS (Plastic & Reconstructive Surgery)', 'EID-17873\r\n', '34539\r\n', 106),
(66, NULL, 'Prof. Dr. Md. Monwar  Hossain\r\n', '', 'EID-17874\r\n', '12853\r\n', 38),
(67, NULL, 'Dr. Shahpar  Nahrir\r\n', '', 'EID-17888\r\n', '26226\r\n', 79),
(68, NULL, 'Prof. Dr. Suraiya  Begum\r\n', '', 'EID-17997\r\n', '13082\r\n', 92),
(69, NULL, 'Prof. Dr. A.Q.M  Mohsen\r\n', '', 'EID-18156\r\n', '', 47),
(70, NULL, 'Prof. Dr. Quorrata Eynul Forhad\r\n', '', 'EID-18167\r\n', '23941\r\n', 85),
(71, NULL, 'Dr. Nazmul  Haque\r\n', '', 'EID-18168\r\n', 'A-32735\r\n', 92),
(72, NULL, 'Prof. Dr. Muhammad Hafizur Rahman\r\n', '', 'EID-18173\r\n', 'A-24001\r\n', 36),
(73, NULL, 'Dr. Asma  Siddique\r\n', '', 'EID-18174\r\n', '', 86),
(74, NULL, 'Dr. Alim Akhtar Bhuiyan\r\n', '', 'EID-18177\r\n', 'A-17824\r\n', 79),
(75, NULL, 'Prof. Dr. Md. Delwar  Hossain\r\n', '', 'EID-18218\r\n', '', 92),
(76, NULL, 'Prof. Dr. Nilufar  Sultana\r\n', '', 'EID-18219\r\n', 'A14484\r\n', 85),
(77, NULL, 'Dr. Tangia  Muquith\r\n', '', 'EID-18307\r\n', 'A54412\r\n', 54),
(78, NULL, 'Brig. Gen.(Retd.) Prof. Dr. Reza-ul Karim, SUP.\r\n', 'MBBS, MS (Ortho)', 'EID-18343\r\n', 'A 16602\r\n', 90),
(79, NULL, 'Prof. Dr. Chowdhury Md Ali\r\n', '', 'EID-18378\r\n', 'A10800\r\n', 32),
(80, NULL, 'Dr. Syeda  Nur-E-Jannat\r\n', '', 'EID-18664\r\n', '37015\r\n', 47),
(81, NULL, 'Prof. Dr. Shahrukh  Ahmed\r\n', '', 'EID-18707\r\n', '11726\r\n', 79),
(82, NULL, 'Mst. Hasina  Khatun\r\n', '', 'EID-18711\r\n', '', 109),
(83, NULL, 'Prof. Dr. Md. Omar Ali\r\n', '', 'EID-18741\r\n', '5820\r\n', 51),
(84, NULL, 'Maj Gen Prof. Dr. Md. Shahidul Islam\r\n', '', 'EID-18974\r\n', '', 132),
(85, NULL, 'Dr. Fazle  Mahmud\r\n', '', 'EID-19402\r\n', '', 80),
(86, NULL, 'Prof. Dr. Rafiques  Salehin\r\n', '. MBBS, FCPS(BD), FRCS(Glasg), FRCS(Edin)', 'EID-19404\r\n', 'A-16765\r\n', 51),
(87, NULL, 'Dr. Tahrima Hedayet Hema\r\n', '', 'EID-19411\r\n', '', 115),
(88, NULL, 'Dr. Minhaj  Bhuiyan\r\n', '', 'EID-19432\r\n', '28590\r\n', 0),
(89, NULL, 'Dr. Mir N Anwar\r\n', '', 'EID-19461', '', 92),
(90, NULL, 'Dr. Aminur  Rahman\r\n', 'MBBS, FCPS (Medicine), MD (Neurology)\n', 'EID-19600\r\n', '', 79),
(91, NULL, 'Dr. Farhana  Salam\r\n', '', 'EID-19601\r\n', '', 51),
(92, NULL, 'Dr. Md. Tarek  Alam\r\n', '', 'HS00029\r\n', 'A 20150\r\n', 116),
(93, NULL, 'Prof. Dr. Kazi A. Karim\r\n', '', 'HS00044\r\n', '6727\r\n', 32),
(94, NULL, 'Dr. Moral Nazrul Islam\r\n', '', 'HS00046\r\n', 'A-23641\r\n', 32),
(95, NULL, 'Dr. Ashraf A. Sheikh\r\n', '', 'HS00058\r\n', '4989\r\n', 92),
(96, NULL, 'Prof. Dr. Zahir Uddin Ahmad\r\n', '', 'HS00112\r\n', '6706\r\n', 108),
(97, NULL, 'Dr. Md. Abdul Mabin\r\n', '', 'HS00131\r\n', '6380\r\n', 106),
(98, NULL, 'Prof. Md. Salim Shakur\r\n', '', 'HS00145\r\n', '8602\r\n', 92),
(99, NULL, 'Dr. Rumana  Dowla\r\n', '', 'HS00395\r\n', '', 86),
(100, NULL, 'Prof. Dr.Zahidul  Haq\r\n', '', 'HS00610\r\n', 'A-10746\r\n', 51),
(101, NULL, 'Dr. Iqbal Hasan Mahmood\r\n', '', 'HS00611\r\n', '8097\r\n', 116),
(102, NULL, 'Dr. Md. Nazrul  Islam\r\n', 'BDS, MSc (Singapore)\r\n', 'HS00665\r\n', '1006\r\n', 31),
(103, NULL, 'Dr. Lutfun  Nahar\r\n', 'BDS, MSc (Singapore)\r\n', 'HS00666\r\n', '894\r\n', 31),
(104, NULL, 'Dr. A. F. M. Kamal Uddin\r\n', '', 'HS00710\r\n', 'A-21136\r\n', 86),
(105, NULL, 'Dr. Rezoana  Rima\r\n', '', 'HS00755\r\n', 'A-28596\r\n', 16),
(106, NULL, 'Prof. Dr. Faridul  Hasan\r\n', '', 'HS00766\r\n', 'A-13802\r\n', 89),
(107, NULL, 'Dr. Lubna  Mariam\r\n', '', 'HS00784\r\n', 'A-34590\r\n', 86),
(108, NULL, 'Dr. M Al Amin  Salek\r\n', '', 'HS00795\r\n', 'A-27451\r\n', 80),
(109, NULL, 'Prof. Dr.Md. Afzalur Rahman\r\n', '', 'HS00827\r\n', 'A-14911\r\n', 16),
(110, NULL, 'Prof. Col. Dr. M Nurul Azim (Retd.)\r\n', '', 'HS00840\r\n', '5319\r\n', 108),
(111, NULL, 'Prof. Dr. Abdul Hanif (Tablu)\r\n', '', 'HS00876\r\n', 'A-6380\r\n', 97),
(112, NULL, 'Prof. Dr. Kaniz Hasina Sheuli\r\n', '', 'HS00887\r\n', 'A-20450\r\n', 97),
(113, NULL, 'Prof. Dr. Selina  Akter\r\n', '', 'HS00988\r\n', 'A-28076\r\n', 85),
(114, NULL, 'Prof. Dr. Anisur  Rahman\r\n', '', 'HS01097\r\n', 'A-11404\r\n', 51),
(115, NULL, 'Prof. Dr. Kaniz  Moula\r\n', '', 'HS01105\r\n', '183\r\n', 64),
(116, NULL, 'Prof. M A  Majid\r\n', '', 'HS01110\r\n', '3087\r\n', 51),
(117, NULL, 'Prof. Dr. Mesbah Uddin Ahmed\r\n', '', 'HS01352\r\n', 'A-11371\r\n', 38),
(118, NULL, 'Dr. Col. Anjuman Ara Beauty\r\n', '', 'HS01405\r\n', 'A 18665\r\n', 92),
(119, NULL, 'Prof. Dr. Md. Shamsul  Alam\r\n', '', 'HS01432\r\n', 'A-11367\r\n', 125),
(120, NULL, 'Dr. Mostafa Aziz Sumon\r\n', '', 'HS01463\r\n', '', 86),
(121, NULL, 'Dr. Brig. Gen.Dr. S.M. Shameem  Waheed\r\n', '', 'HS01540\r\n', '', 132),
(122, NULL, 'Prof. Dr. Taimor  Nawaz\r\n', 'MBBS (DMC), MRCP (UK)', 'HS01575\r\n', 'A-11443\r\n', 64),
(123, NULL, 'Prof. Dr. Shameem Anwarul Hoque\r\n', '', 'HS01592\r\n', 'A-18030\r\n', 38),
(124, NULL, 'Dr. Reyan  Anis\r\n', '', 'HS01622\r\n', 'A-15647\r\n', 16),
(125, NULL, 'Prof. Dr. Mostaque Hassan\r\n', 'BDS, DDS, MCPS, FICCDE, FICD\r\n', 'HS01643\r\n', '372\r\n', 31),
(126, NULL, 'Dr. Prashanta Prasun Dey\r\n', 'MBBS, MD (Endocrinology)\r\n', 'HS01724\r\n', 'A-16045\r\n', 36),
(127, NULL, 'Dr. Nasrin  Hossain\r\n', '', 'HS01725\r\n', 'A-29217\r\n', 85),
(128, NULL, 'Prof. Dr. Hazera  Khatun\r\n', '', 'HS01741\r\n', 'A-13796\r\n', 85),
(129, NULL, 'Dr. Amit  Wazib\r\n', '', 'HS01763\r\n', 'A-37004\r\n', 79),
(130, NULL, 'Prof. Md. Aminul  Islam\r\n', '', 'HS01775\r\n', 'A-20653\r\n', 80),
(131, NULL, 'Dr. Md. Atiar  Rahman\r\n', '', 'HS01776\r\n', 'A 22842\r\n', 92),
(132, NULL, 'Dr. Nur-Us-Sama  Loba\r\n', '', 'HS01789\r\n', 'A-55814\r\n', 32),
(133, NULL, 'Prof. Maj Gen Dr. Munshi  Md Mojibur\r\n', '', 'HS01796\r\n', 'A-14440\r\n', 15),
(134, NULL, 'Prof. Dr. Nishat  Begum\r\n', '', 'HS01863\r\n', 'A-9610\r\n', 51),
(135, NULL, 'Dr. Sohana  Siddique\r\n', '', 'HS01864\r\n', 'A-35961\r\n', 85),
(136, NULL, 'Dr. Spina Luna Biswas\r\n', 'BDS, FCPS (Oral & Maxillofacial Surgery)', 'HS01885\r\n', '2146\r\n', 31),
(137, NULL, 'Prof. Dr. Nazrina  Khatun\r\n', '', 'HS01892\r\n', 'A-20509\r\n', 86),
(138, NULL, 'Dr. Ashis Kumar Biswas\r\n', 'BDS, MCPS (Dental Surgery), FCPS (Orthodontic & Dentofacial Orthopaedics)', 'HS01899\r\n', '2581\r\n', 31),
(139, NULL, 'Prof. Dr. Md.Nurul  Islam\r\n', '', 'HS01902\r\n', '7705\r\n', 78),
(140, NULL, 'Dr. Imam Gaziul Haque\r\n', '', 'HS01923\r\n', 'A-475157\r\n', 90),
(141, NULL, 'Dr. Kazi Ali Hassan\r\n', 'MBBS, M.Phil (EM), MRCP (UK)\r\n', 'HS01936\r\n', 'A-12869\r\n', 36),
(142, NULL, 'Prof. Dr. Zeenat  Meraj\r\n', '', 'HS01944\r\n', 'A-14363\r\n', 32);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
