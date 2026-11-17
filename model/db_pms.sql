-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2021 at 03:46 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_adminuser`
--

CREATE TABLE `tb_adminuser` (
  `user_ID` int(11) NOT NULL,
  `user_NIC` varchar(45) DEFAULT NULL,
  `user_Name` varchar(45) DEFAULT NULL,
  `user_Tel` varchar(45) DEFAULT NULL,
  `user_Address` varchar(45) DEFAULT NULL,
  `user_Role` varchar(45) DEFAULT NULL,
  `user_Uname` varchar(45) DEFAULT NULL,
  `user_Password` varchar(45) DEFAULT NULL,
  `user_Active` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_adminuser`
--

INSERT INTO `tb_adminuser` (`user_ID`, `user_NIC`, `user_Name`, `user_Tel`, `user_Address`, `user_Role`, `user_Uname`, `user_Password`, `user_Active`) VALUES
(1, '982232929V', 'Jayashanka Anushan', '0774561343', 'No. 33, Walikdahaena, Polgahawela.', '0', 'jmax', '1234', '1'),
(2, '7894561230', 'Anushan', '0774561235', 'Ki', '2', 'keep', '1234', '1'),
(5, '256236526V', 'Anushan', '7894561230', 'Polgahawela', '3', 'cash', '1234', '1'),
(6, '745148882v', 'AdminJayashanka', '0774561343', 'Polgahawela', '1', 'admin', '1234', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_agent`
--

CREATE TABLE `tb_agent` (
  `Agent_ID` int(11) NOT NULL,
  `Agent_NIC` varchar(45) DEFAULT NULL,
  `Agent_Name` varchar(45) DEFAULT NULL,
  `Agent_Tel` varchar(45) DEFAULT NULL,
  `Agent_Address` varchar(45) DEFAULT NULL,
  `Agent_Active` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_agent`
--

INSERT INTO `tb_agent` (`Agent_ID`, `Agent_NIC`, `Agent_Name`, `Agent_Tel`, `Agent_Address`, `Agent_Active`) VALUES
(1, '5895412565', 'Saman Jayathilaka', '0895623145', 'Kurunegala', '1'),
(2, '7894561330', 'Nimal', '7458963210', 'Polgahawela', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cashondeliverycomplete`
--

CREATE TABLE `tb_cashondeliverycomplete` (
  `CashOnDelivery_ID` int(11) NOT NULL,
  `CashOnDelivery_Date` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_company`
--

CREATE TABLE `tb_company` (
  `Company_ID` int(11) NOT NULL,
  `Company_Name` varchar(45) DEFAULT NULL,
  `Company_Tel` varchar(45) DEFAULT NULL,
  `Company_Address` varchar(45) DEFAULT NULL,
  `Company_Active` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_company`
--

INSERT INTO `tb_company` (`Company_ID`, `Company_Name`, `Company_Tel`, `Company_Address`, `Company_Active`) VALUES
(1, 'ABC pvt Ltd', '0774561343', 'Polgahawela', '1'),
(2, 'Max pvt Ltd', '0372242589', 'Kurunegala', '1'),
(3, 'Saman Dewanpiya', '0372242485', 'Polgahawela', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_inventory`
--

CREATE TABLE `tb_inventory` (
  `Inventory_ID` int(11) NOT NULL,
  `Inventory_InvoiceNumber` varchar(45) DEFAULT NULL,
  `tb_Product_Product_ID` int(11) NOT NULL,
  `Inventory_ImportQty` int(11) DEFAULT NULL,
  `Inventory_ReturnQty` int(11) DEFAULT NULL,
  `Inventory_CurrentQty` int(11) DEFAULT NULL,
  `Inventory_UnitCost` float DEFAULT NULL,
  `Inventory_UnitSellingPrice` int(11) DEFAULT NULL,
  `Inventory_ManufactureDate` date DEFAULT NULL,
  `Inventory_ExpireDate` date DEFAULT NULL,
  `Inventory_Active` varchar(45) DEFAULT NULL,
  `tb_Purchase_Purchase_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_inventory`
--

INSERT INTO `tb_inventory` (`Inventory_ID`, `Inventory_InvoiceNumber`, `tb_Product_Product_ID`, `Inventory_ImportQty`, `Inventory_ReturnQty`, `Inventory_CurrentQty`, `Inventory_UnitCost`, `Inventory_UnitSellingPrice`, `Inventory_ManufactureDate`, `Inventory_ExpireDate`, `Inventory_Active`, `tb_Purchase_Purchase_ID`) VALUES
(1, '589', 1, 25, 2, 23, 1.25, 5, '2020-10-26', '2020-12-05', '1', 1),
(2, '589', 2, 56, 0, 56, 2, 10, '2020-10-28', '2020-12-05', '1', 1),
(3, '478', 1, 100, 0, 100, 1, 3, '2020-11-04', '2020-11-27', '1', 2),
(4, '485', 3, 25, 0, 25, 1, 2, '2020-11-02', '2021-01-11', '1', 3),
(5, '485', 4, 50, 0, 50, 15, 20, '2020-01-11', '2020-11-27', '1', 3),
(6, '485', 5, 20, 0, 20, 25, 30, '2020-01-11', '2020-12-05', '1', 3),
(7, '485', 6, 20, 0, 20, 15, 20, '2020-10-02', '2020-11-28', '1', 3),
(8, '485', 7, 50, 0, 50, 2, 3, '2020-06-11', '2020-12-25', '1', 3),
(9, '485', 8, 100, 0, 100, 1, 1, '2020-11-02', '2021-02-28', '1', 3),
(10, '485', 9, 120, 0, 120, 3, 4, '2020-10-30', '2021-06-05', '1', 3),
(11, '485', 10, 200, 0, 200, 4, 5, '2020-10-11', '2020-12-05', '1', 3),
(12, '556', 11, 25, 0, 25, 10, 15, '2020-11-04', '2020-12-06', '1', 4),
(13, '556', 12, 100, 0, 100, 1, 3, '2020-10-26', '2020-12-05', '1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_login_history`
--

CREATE TABLE `tb_login_history` (
  `login_History_ID` int(11) NOT NULL,
  `login_History_User_ID` varchar(45) DEFAULT NULL,
  `login_History_LogDate` varchar(45) DEFAULT NULL,
  `tb_user_user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_login_history`
--

INSERT INTO `tb_login_history` (`login_History_ID`, `login_History_User_ID`, `login_History_LogDate`, `tb_user_user_ID`) VALUES
(1, '1', '2020/11/09', 1),
(2, '1', '2020/11/09', 1),
(3, '1', '2020/11/10', 1),
(4, '2', '2020/11/10', 2),
(5, '2', '2020/11/10', 2),
(6, '1', '2020/11/10', 1),
(7, '2', '2020/11/10', 2),
(8, '2', '2020/11/10', 2),
(9, '2', '2020/11/10', 2),
(10, '1', '2020/11/10', 1),
(11, '6', '2020/11/10', 6),
(12, '5', '2020/11/10', 5),
(13, '2', '2020/11/10', 2),
(14, '1', '2020/11/10', 1),
(15, '5', '2020/11/10', 5),
(16, '1', '2020/11/10', 1),
(17, '5', '2020/11/10', 5),
(18, '1', '2020/11/10', 1),
(19, '6', '2020/11/10', 6),
(20, '1', '2020/11/10', 1),
(21, '5', '2020/11/10', 5),
(22, '1', '2020/11/10', 1),
(23, '6', '2020/11/10', 6),
(24, '1', '2020/11/11', 1),
(25, '5', '2020/11/11', 5),
(26, '1', '2020/11/11', 1),
(27, '6', '2021/05/25', 6),
(28, '6', '2021/05/27', 6),
(29, '6', '2021/05/27', 6),
(30, '6', '2021/05/28', 6),
(31, '6', '2021/05/28', 6),
(32, '6', '2021/05/28', 6),
(33, '1', '2021/07/29', 1),
(34, '6', '2021/07/29', 6),
(35, '2', '2021/07/29', 2),
(36, '5', '2021/07/29', 5),
(37, '6', '2021/08/02', 6),
(38, '6', '2021/08/12', 6),
(39, '1', '2021/08/12', 1),
(40, '1', '2021/08/12', 1),
(41, '6', '2021/08/12', 6),
(42, '2', '2021/08/12', 2),
(43, '5', '2021/08/12', 5),
(44, '1', '2021/08/12', 1),
(45, '1', '2021/08/12', 1),
(46, '1', '2021/08/12', 1),
(47, '1', '2021/08/12', 1),
(48, '1', '2021/08/13', 1),
(49, '1', '2021/08/16', 1),
(50, '1', '2021/08/20', 1),
(51, '1', '2021/08/20', 1),
(52, '6', '2021/08/20', 6),
(53, '1', '2021/08/20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_maincategory`
--

CREATE TABLE `tb_maincategory` (
  `MainCategory_ID` int(11) NOT NULL,
  `MainCategory_Name` varchar(45) DEFAULT NULL,
  `MainCategory_Active` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_maincategory`
--

INSERT INTO `tb_maincategory` (`MainCategory_ID`, `MainCategory_Name`, `MainCategory_Active`) VALUES
(1, 'Medicine', '1'),
(2, 'Food', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_onlinesellinvoices`
--

CREATE TABLE `tb_onlinesellinvoices` (
  `OnlineSellInvoices_ID` int(11) NOT NULL,
  `OnlineSellInvoices_Date` date DEFAULT NULL,
  `OnlineSellInvoices_CustomerName` varchar(50) DEFAULT NULL,
  `OnlineSellInvoices_BillingAddress` varchar(100) DEFAULT NULL,
  `OnlineSellInvoices_Tel` varchar(45) DEFAULT NULL,
  `OnlineSellInvoices_Email` varchar(100) DEFAULT NULL,
  `OnlineSellInvoices_PymntStatus` varchar(45) DEFAULT NULL,
  `OnlineSellInvoices_OrderStatus` varchar(45) DEFAULT NULL,
  `OnlineSellInvoices_Active` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_onlinesellinvoices`
--

INSERT INTO `tb_onlinesellinvoices` (`OnlineSellInvoices_ID`, `OnlineSellInvoices_Date`, `OnlineSellInvoices_CustomerName`, `OnlineSellInvoices_BillingAddress`, `OnlineSellInvoices_Tel`, `OnlineSellInvoices_Email`, `OnlineSellInvoices_PymntStatus`, `OnlineSellInvoices_OrderStatus`, `OnlineSellInvoices_Active`) VALUES
(1, '2020-11-09', 'Anushan', 'Polgahawela', '0774561343', 'jmax@gmail.com', '0', '0', '1'),
(2, '2020-11-09', 'Jmax', 'Polgahawela', '0774561343', 'jmax@gmail.com', '1', '0', '1'),
(3, '2020-11-09', 'Jayashanka', 'Polgahawela', '0774561343', 'jmax@gmail.com', '0', '0', '1'),
(4, '2020-11-09', 'Jayashanka Anushan', 'Polgahawela', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(5, '2020-11-09', 'Jayashanka Anushan', 'Polgahawela', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(6, '2020-11-10', 'Jayashanka Anushan', 'Polgahawela.', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(7, '2020-11-11', 'Jayashanka Anushan', 'No.13/B, Colombo.', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(8, '2020-11-11', 'Jayashanka Anushan', 'No.13/B, Colombo.', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(9, '2020-11-11', 'Jayashanka Anushan', 'No.13/B, Colombo.', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(10, '2020-11-11', 'Jayashanka Anushan', 'No.13/B, Colombo.', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(11, '2020-11-11', 'Jayashanka Anushan', 'No.13/B, Colombo.', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(12, '2020-11-11', 'Jayashanka Anushan', 'No.13/B, Colombo.', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(13, '2020-11-11', 'Jayashanka Anushan', 'Polgahawela', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(14, '2020-11-11', 'Jayashanka Anushan', 'Polgahawela', '0774561343', 'jmaxut@gmail.com', '0', '0', '1'),
(15, '2020-11-11', 'Jayashanka Anushan', 'Polgahawela', '0774561343', 'jmaxut@gmail.com', '0', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE `tb_payment` (
  `Payment_ID` int(11) NOT NULL,
  `Payment_InvoiceNumber` varchar(45) DEFAULT NULL,
  `Payment_SubPaymentMethod` varchar(45) DEFAULT NULL,
  `Payment_Amount` varchar(45) DEFAULT NULL,
  `Payment_Date` date DEFAULT NULL,
  `tb_Purchase_Purchase_ID` int(11) NOT NULL,
  `tb_Purchase_tb_user_user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_payment`
--

INSERT INTO `tb_payment` (`Payment_ID`, `Payment_InvoiceNumber`, `Payment_SubPaymentMethod`, `Payment_Amount`, `Payment_Date`, `tb_Purchase_Purchase_ID`, `tb_Purchase_tb_user_user_ID`) VALUES
(1, '485', '0', '2934', '2021-07-29', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pharmacy`
--

CREATE TABLE `tb_pharmacy` (
  `pharmacy_id` int(11) NOT NULL,
  `pharmacy_Name` varchar(45) DEFAULT NULL,
  `pharmacy_Tel` varchar(45) DEFAULT NULL,
  `pharmacy_Address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `Product_ID` int(11) NOT NULL,
  `Product_ProductName` varchar(45) DEFAULT NULL,
  `Product_ExpireRemainDates` int(11) DEFAULT NULL,
  `Product_ReOrderLevelQty` int(11) DEFAULT NULL,
  `Product_Active` varchar(45) DEFAULT NULL,
  `Product_OpenSale` varchar(45) DEFAULT NULL,
  `Product_ImageLocation` varchar(255) DEFAULT NULL,
  `tb_Company_Company_ID` int(11) NOT NULL,
  `tb_SubCategory_SubCategory_ID` int(11) NOT NULL,
  `tb_Agent_Agent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`Product_ID`, `Product_ProductName`, `Product_ExpireRemainDates`, `Product_ReOrderLevelQty`, `Product_Active`, `Product_OpenSale`, `Product_ImageLocation`, `tb_Company_Company_ID`, `tb_SubCategory_SubCategory_ID`, `tb_Agent_Agent_ID`) VALUES
(1, 'Amoxicillin 500mg', 30, 30, '1', '1', '1604935576-Amoxicillin 500mg.jpg', 1, 1, 1),
(2, 'Aspirine 75mg', 30, 85, '1', '1', '1604935603-Aspirine 75mg.jpg', 1, 1, 1),
(3, 'Beclate 400mg', 30, 20, '1', '1', '1604935631-Beclate 400mg.jpg', 1, 2, 2),
(4, 'Zero milk chocolate', 30, 50, '1', '1', '1604935686-Zero milk chocolate.jpg', 2, 3, 1),
(5, 'Oatees buiscuits', 30, 25, '1', '1', '1604935705-Oatees buiscuits.jpg', 1, 4, 2),
(6, 'Bata carol buiscuits', 30, 25, '1', '1', '1604973988-Bata carol buiscuits.jpeg', 1, 4, 2),
(7, 'Ezetrol 10mg', 30, 25, '1', '1', '1604974029-Ezetrol 10mg.jpg', 2, 1, 2),
(8, 'Panadol', 30, 50, '1', '1', '1604974073-Panadols.jpg', 1, 1, 2),
(9, 'Sinecod 50mg', 30, 50, '1', '1', '1604974099-Sinecod 50mg.jpg', 1, 2, 2),
(10, 'Zinc 50mg', 30, 25, '1', '1', '1604974125-Zinc 50mg.jpg', 1, 2, 1),
(11, 'Cetirizine 10mg', 30, 20, '1', '1', '1605062467-Cetirizine 10mg.jpg', 2, 1, 2),
(12, 'Levitra 10mg', 30, 20, '1', '1', '1605062495-Levitra 10mg.jpg', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_purchase`
--

CREATE TABLE `tb_purchase` (
  `Purchase_ID` int(11) NOT NULL,
  `Purchase_InvoiceDate` date DEFAULT NULL,
  `Purchase_InvoiceNumber` varchar(45) DEFAULT NULL,
  `Purchase_Agent` varchar(45) DEFAULT NULL,
  `Purchase_PaymentMethod` varchar(45) DEFAULT NULL,
  `Purchase_Active` varchar(45) DEFAULT NULL,
  `tb_Company_Company_ID` int(11) NOT NULL,
  `tb_Adminuser_user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_purchase`
--

INSERT INTO `tb_purchase` (`Purchase_ID`, `Purchase_InvoiceDate`, `Purchase_InvoiceNumber`, `Purchase_Agent`, `Purchase_PaymentMethod`, `Purchase_Active`, `tb_Company_Company_ID`, `tb_Adminuser_user_ID`) VALUES
(1, '2020-11-09', '589', '2', '0', '1', 1, 1),
(2, '2020-11-13', '478', '1', '0', '1', 1, 1),
(3, '2020-11-06', '485', '2', '2', '1', 2, 1),
(4, '2020-11-10', '556', '2', '2', '1', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_purchasereturn`
--

CREATE TABLE `tb_purchasereturn` (
  `PurchaseReturn_ID` int(11) NOT NULL,
  `PurchaseReturn_Date` date NOT NULL,
  `PurchaseReturn_InvoiceNumber` varchar(45) DEFAULT NULL,
  `PurchaseReturn_Reason` varchar(45) DEFAULT NULL,
  `tb_Purchase_Purchase_ID` int(11) NOT NULL,
  `tb_Purchase_tb_user_user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_purchasereturn`
--

INSERT INTO `tb_purchasereturn` (`PurchaseReturn_ID`, `PurchaseReturn_Date`, `PurchaseReturn_InvoiceNumber`, `PurchaseReturn_Reason`, `tb_Purchase_Purchase_ID`, `tb_Purchase_tb_user_user_ID`) VALUES
(4, '2021-08-16', '589', 'aaaaaa', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_saleinvoice`
--

CREATE TABLE `tb_saleinvoice` (
  `SaleInvoice_ID` int(11) NOT NULL,
  `SaleInvoice_Date` date DEFAULT NULL,
  `SaleInvoice_CustomerNameorNIC` varchar(45) DEFAULT NULL,
  `SaleInvoice_Discount` int(11) DEFAULT NULL,
  `SaleInvoice_PaymentMethod` varchar(45) DEFAULT NULL,
  `SaleInvoice_PaymentCash` int(11) DEFAULT NULL,
  `SaleInvoice_PaymentCardNo` varchar(45) DEFAULT NULL,
  `SaleInvoice_PaymentOnDeliveryReceived` varchar(45) DEFAULT NULL,
  `SaleInvoice_Balance` int(11) DEFAULT NULL,
  `SalesInvoice_Active` varchar(45) DEFAULT NULL,
  `tb_Adminuser_user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_saleinvoice`
--

INSERT INTO `tb_saleinvoice` (`SaleInvoice_ID`, `SaleInvoice_Date`, `SaleInvoice_CustomerNameorNIC`, `SaleInvoice_Discount`, `SaleInvoice_PaymentMethod`, `SaleInvoice_PaymentCash`, `SaleInvoice_PaymentCardNo`, `SaleInvoice_PaymentOnDeliveryReceived`, `SaleInvoice_Balance`, `SalesInvoice_Active`, `tb_Adminuser_user_ID`) VALUES
(1, '2020-11-11', 'Anushan Bill 1', 2, '0', 1000, '0', '1', 992, '1', 1),
(2, '2021-07-29', 'Jayashanka Bill 2', 0, '0', 100, '0', '1', 88, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_saleinvoiceitems`
--

CREATE TABLE `tb_saleinvoiceitems` (
  `SaleInvoiceItems_ID` int(11) NOT NULL,
  `SaleInvoiceItems_InventoryID` varchar(45) DEFAULT NULL,
  `SaleInvoiceItems_UnitCost` int(11) DEFAULT NULL,
  `SaleInvoiceItems_UnitSellingCost` int(11) DEFAULT NULL,
  `SaleInvoiceItems_Qty` int(11) DEFAULT NULL,
  `tb_SaleInvoice_SaleInvoice_ID` int(11) DEFAULT NULL,
  `tb_OnlineSellInvoices_OnlineSellInvoices_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_saleinvoiceitems`
--

INSERT INTO `tb_saleinvoiceitems` (`SaleInvoiceItems_ID`, `SaleInvoiceItems_InventoryID`, `SaleInvoiceItems_UnitCost`, `SaleInvoiceItems_UnitSellingCost`, `SaleInvoiceItems_Qty`, `tb_SaleInvoice_SaleInvoice_ID`, `tb_OnlineSellInvoices_OnlineSellInvoices_ID`) VALUES
(1, '1', 1, 2, 1, 0, 1),
(2, '1', 1, 2, 2, 0, 2),
(3, '1', 1, 2, 2, 0, 3),
(4, '1', 1, 2, 4, 0, 4),
(5, '1', 1, 2, 2, 0, 5),
(6, '1', 1, 2, 3, 0, 6),
(7, '1', 1, 5, 1, 0, 7),
(8, '2', 2, 10, 2, 0, 7),
(9, '1', 1, 5, 1, 0, 13),
(10, '1', 1, 5, 2, 0, 15),
(11, '1', 1, 5, 2, 1, NULL),
(12, '1', 1, 5, 2, 2, NULL),
(13, '9', 1, 1, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_salesreturn`
--

CREATE TABLE `tb_salesreturn` (
  `SalesReturn_ID` int(11) NOT NULL,
  `SalesReturn_Date` date DEFAULT NULL,
  `SalesReturn_Reason` varchar(45) DEFAULT NULL,
  `SalesReturn_Active` varchar(45) DEFAULT NULL,
  `tb_SaleInvoice_SaleInvoice_ID` int(11) NOT NULL,
  `tb_SaleInvoice_tb_Adminuser_user_ID` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_salesreturn`
--

INSERT INTO `tb_salesreturn` (`SalesReturn_ID`, `SalesReturn_Date`, `SalesReturn_Reason`, `SalesReturn_Active`, `tb_SaleInvoice_SaleInvoice_ID`, `tb_SaleInvoice_tb_Adminuser_user_ID`) VALUES
(13, '2021-08-16', 'ascascascas ', '1', 1, '1'),
(14, '2021-08-16', '', '1', 2, '1'),
(18, '2021-08-16', '', '1', 2, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_salesreturnitems`
--

CREATE TABLE `tb_salesreturnitems` (
  `SalesReturnItems_ID` int(10) NOT NULL,
  `SalesReturnItems_InventoryID` varchar(10) NOT NULL,
  `SalesReturnItems_UnitCostPrice` int(10) NOT NULL,
  `SalesReturnItems_UnitSellingPrice` int(10) NOT NULL,
  `SalesReturnItems_ReturnQty` int(10) NOT NULL,
  `tb_salesreturn_SalesReturn_ID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_salesreturnitems`
--

INSERT INTO `tb_salesreturnitems` (`SalesReturnItems_ID`, `SalesReturnItems_InventoryID`, `SalesReturnItems_UnitCostPrice`, `SalesReturnItems_UnitSellingPrice`, `SalesReturnItems_ReturnQty`, `tb_salesreturn_SalesReturn_ID`) VALUES
(13, '1', 1, 5, 2, 13),
(14, '1', 1, 5, 1, 14),
(15, '9', 1, 1, 0, 14),
(22, '1', 1, 5, 1, 18),
(23, '9', 1, 1, 0, 18);

-- --------------------------------------------------------

--
-- Table structure for table `tb_subcategory`
--

CREATE TABLE `tb_subcategory` (
  `SubCategory_ID` int(11) NOT NULL,
  `SubCategory_Name` varchar(45) DEFAULT NULL,
  `SubCategory_Active` varchar(45) DEFAULT NULL,
  `tb_MainCategory_MainCategory_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_subcategory`
--

INSERT INTO `tb_subcategory` (`SubCategory_ID`, `SubCategory_Name`, `SubCategory_Active`, `tb_MainCategory_MainCategory_ID`) VALUES
(1, 'Tablet', '1', 1),
(2, 'Captuler', '1', 1),
(3, 'Chocolate', '1', 2),
(4, 'Buiscut', '1', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_adminuser`
--
ALTER TABLE `tb_adminuser`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `user_NIC_UNIQUE` (`user_NIC`),
  ADD UNIQUE KEY `user_Uname_UNIQUE` (`user_Uname`);

--
-- Indexes for table `tb_agent`
--
ALTER TABLE `tb_agent`
  ADD PRIMARY KEY (`Agent_ID`);

--
-- Indexes for table `tb_cashondeliverycomplete`
--
ALTER TABLE `tb_cashondeliverycomplete`
  ADD PRIMARY KEY (`CashOnDelivery_ID`);

--
-- Indexes for table `tb_company`
--
ALTER TABLE `tb_company`
  ADD PRIMARY KEY (`Company_ID`);

--
-- Indexes for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  ADD PRIMARY KEY (`Inventory_ID`,`tb_Product_Product_ID`,`tb_Purchase_Purchase_ID`),
  ADD KEY `fk_tb_Inventory_tb_Purchase1_idx` (`tb_Purchase_Purchase_ID`),
  ADD KEY `fk_tb_Inventory_tb_Product1_idx` (`tb_Product_Product_ID`);

--
-- Indexes for table `tb_login_history`
--
ALTER TABLE `tb_login_history`
  ADD PRIMARY KEY (`login_History_ID`,`tb_user_user_ID`),
  ADD KEY `fk_tb_login_History_tb_user_idx` (`tb_user_user_ID`);

--
-- Indexes for table `tb_maincategory`
--
ALTER TABLE `tb_maincategory`
  ADD PRIMARY KEY (`MainCategory_ID`);

--
-- Indexes for table `tb_onlinesellinvoices`
--
ALTER TABLE `tb_onlinesellinvoices`
  ADD PRIMARY KEY (`OnlineSellInvoices_ID`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD PRIMARY KEY (`Payment_ID`,`tb_Purchase_Purchase_ID`,`tb_Purchase_tb_user_user_ID`),
  ADD KEY `fk_tb_Payment_tb_Purchase1_idx` (`tb_Purchase_Purchase_ID`,`tb_Purchase_tb_user_user_ID`);

--
-- Indexes for table `tb_pharmacy`
--
ALTER TABLE `tb_pharmacy`
  ADD PRIMARY KEY (`pharmacy_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`Product_ID`,`tb_Company_Company_ID`,`tb_SubCategory_SubCategory_ID`,`tb_Agent_Agent_ID`),
  ADD KEY `fk_tb_Product_tb_SubCategory1_idx` (`tb_SubCategory_SubCategory_ID`),
  ADD KEY `fk_tb_Product_tb_Agent1_idx` (`tb_Agent_Agent_ID`),
  ADD KEY `fk_tb_Product_tb_Company1_idx` (`tb_Company_Company_ID`);

--
-- Indexes for table `tb_purchase`
--
ALTER TABLE `tb_purchase`
  ADD PRIMARY KEY (`Purchase_ID`,`tb_Company_Company_ID`,`tb_Adminuser_user_ID`),
  ADD UNIQUE KEY `Purchase_InvoiceNumber_UNIQUE` (`Purchase_InvoiceNumber`),
  ADD KEY `fk_tb_Purchase_tb_Company1_idx` (`tb_Company_Company_ID`),
  ADD KEY `fk_tb_Purchase_tb_Adminuser1_idx` (`tb_Adminuser_user_ID`);

--
-- Indexes for table `tb_purchasereturn`
--
ALTER TABLE `tb_purchasereturn`
  ADD PRIMARY KEY (`PurchaseReturn_ID`,`tb_Purchase_Purchase_ID`,`tb_Purchase_tb_user_user_ID`),
  ADD KEY `fk_tb_PurchaseReturn_tb_Purchase1_idx` (`tb_Purchase_Purchase_ID`,`tb_Purchase_tb_user_user_ID`);

--
-- Indexes for table `tb_saleinvoice`
--
ALTER TABLE `tb_saleinvoice`
  ADD PRIMARY KEY (`SaleInvoice_ID`);

--
-- Indexes for table `tb_saleinvoiceitems`
--
ALTER TABLE `tb_saleinvoiceitems`
  ADD PRIMARY KEY (`SaleInvoiceItems_ID`);

--
-- Indexes for table `tb_salesreturn`
--
ALTER TABLE `tb_salesreturn`
  ADD PRIMARY KEY (`SalesReturn_ID`,`tb_SaleInvoice_SaleInvoice_ID`),
  ADD KEY `fk_tb_SalesReturn_tb_SaleInvoice1_idx` (`tb_SaleInvoice_SaleInvoice_ID`);

--
-- Indexes for table `tb_salesreturnitems`
--
ALTER TABLE `tb_salesreturnitems`
  ADD PRIMARY KEY (`SalesReturnItems_ID`);

--
-- Indexes for table `tb_subcategory`
--
ALTER TABLE `tb_subcategory`
  ADD PRIMARY KEY (`SubCategory_ID`,`tb_MainCategory_MainCategory_ID`),
  ADD KEY `fk_tb_SubCategory_tb_MainCategory1_idx` (`tb_MainCategory_MainCategory_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_adminuser`
--
ALTER TABLE `tb_adminuser`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_agent`
--
ALTER TABLE `tb_agent`
  MODIFY `Agent_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_cashondeliverycomplete`
--
ALTER TABLE `tb_cashondeliverycomplete`
  MODIFY `CashOnDelivery_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_company`
--
ALTER TABLE `tb_company`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  MODIFY `Inventory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_login_history`
--
ALTER TABLE `tb_login_history`
  MODIFY `login_History_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tb_maincategory`
--
ALTER TABLE `tb_maincategory`
  MODIFY `MainCategory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_onlinesellinvoices`
--
ALTER TABLE `tb_onlinesellinvoices`
  MODIFY `OnlineSellInvoices_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_payment`
--
ALTER TABLE `tb_payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_purchase`
--
ALTER TABLE `tb_purchase`
  MODIFY `Purchase_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_purchasereturn`
--
ALTER TABLE `tb_purchasereturn`
  MODIFY `PurchaseReturn_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_saleinvoice`
--
ALTER TABLE `tb_saleinvoice`
  MODIFY `SaleInvoice_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_saleinvoiceitems`
--
ALTER TABLE `tb_saleinvoiceitems`
  MODIFY `SaleInvoiceItems_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_salesreturn`
--
ALTER TABLE `tb_salesreturn`
  MODIFY `SalesReturn_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_salesreturnitems`
--
ALTER TABLE `tb_salesreturnitems`
  MODIFY `SalesReturnItems_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_subcategory`
--
ALTER TABLE `tb_subcategory`
  MODIFY `SubCategory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  ADD CONSTRAINT `fk_tb_Inventory_tb_Product1` FOREIGN KEY (`tb_Product_Product_ID`) REFERENCES `tb_product` (`Product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_Inventory_tb_Purchase1` FOREIGN KEY (`tb_Purchase_Purchase_ID`) REFERENCES `tb_purchase` (`Purchase_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_login_history`
--
ALTER TABLE `tb_login_history`
  ADD CONSTRAINT `fk_tb_login_History_tb_user` FOREIGN KEY (`tb_user_user_ID`) REFERENCES `tb_adminuser` (`user_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD CONSTRAINT `fk_tb_Payment_tb_Purchase1` FOREIGN KEY (`tb_Purchase_Purchase_ID`) REFERENCES `tb_purchase` (`Purchase_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD CONSTRAINT `fk_tb_Product_tb_Agent1` FOREIGN KEY (`tb_Agent_Agent_ID`) REFERENCES `tb_agent` (`Agent_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_Product_tb_Company1` FOREIGN KEY (`tb_Company_Company_ID`) REFERENCES `tb_company` (`Company_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_Product_tb_SubCategory1` FOREIGN KEY (`tb_SubCategory_SubCategory_ID`) REFERENCES `tb_subcategory` (`SubCategory_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_purchase`
--
ALTER TABLE `tb_purchase`
  ADD CONSTRAINT `fk_tb_Purchase_tb_Adminuser1` FOREIGN KEY (`tb_Adminuser_user_ID`) REFERENCES `tb_adminuser` (`user_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_Purchase_tb_Company1` FOREIGN KEY (`tb_Company_Company_ID`) REFERENCES `tb_company` (`Company_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_purchasereturn`
--
ALTER TABLE `tb_purchasereturn`
  ADD CONSTRAINT `fk_tb_PurchaseReturn_tb_Purchase1` FOREIGN KEY (`tb_Purchase_Purchase_ID`) REFERENCES `tb_purchase` (`Purchase_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_salesreturn`
--
ALTER TABLE `tb_salesreturn`
  ADD CONSTRAINT `fk_tb_SalesReturn_tb_SaleInvoice1` FOREIGN KEY (`tb_SaleInvoice_SaleInvoice_ID`) REFERENCES `tb_saleinvoice` (`SaleInvoice_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_subcategory`
--
ALTER TABLE `tb_subcategory`
  ADD CONSTRAINT `fk_tb_SubCategory_tb_MainCategory1` FOREIGN KEY (`tb_MainCategory_MainCategory_ID`) REFERENCES `tb_maincategory` (`MainCategory_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
