-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2025-03-29 22:42:17
-- 服务器版本： 5.7.44-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `ts_cb`
--

-- --------------------------------------------------------

--
-- 表的结构 `kamiusage`
--

CREATE TABLE `kamiusage` (
  `id` int(11) NOT NULL,
  `kami` varchar(255) NOT NULL,
  `days` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_used` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `kamiusage`
--

INSERT INTO `kamiusage` (`id`, `kami`, `days`, `created_at`, `first_used`) VALUES
(1, 'H3UB2SDFZ7ZZTYPD', 300, '2025-03-29 14:37:00', '2025-03-29 14:37:28'),
(2, 'CENPHTBEZ5VMH4HT', 300, '2025-03-29 14:40:26', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `keys_table`
--

CREATE TABLE `keys_table` (
  `id` int(11) NOT NULL,
  `random_string` varchar(5) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `domainname` varchar(255) DEFAULT NULL,
  `km` varchar(255) NOT NULL,
  `expiry_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `keys_table`
--

INSERT INTO `keys_table` (`id`, `random_string`, `secret_key`, `domainname`, `km`, `expiry_date`) VALUES
(1, 'DCKGX', '123456-7b81-4a32-987d-123456', '123456.com', 'H3UB2SDFZ7ZZTYPD', '2026-01-23 22:37:28');

--
-- 转储表的索引
--

--
-- 表的索引 `kamiusage`
--
ALTER TABLE `kamiusage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kami` (`kami`);

--
-- 表的索引 `keys_table`
--
ALTER TABLE `keys_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `secret_key` (`secret_key`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `kamiusage`
--
ALTER TABLE `kamiusage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `keys_table`
--
ALTER TABLE `keys_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
