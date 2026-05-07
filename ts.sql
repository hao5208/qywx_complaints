-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.7.40 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 导出  表 ts.complaints 结构
CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `content` text,
  `pic` text,
  `spt` varchar(50) DEFAULT NULL,
  `random` varchar(255) DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `isp` varchar(50) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.complaints 的数据：~2 rows (大约)
INSERT INTO `complaints` (`id`, `type`, `phone`, `content`, `pic`, `spt`, `random`, `user_ip`, `province`, `city`, `isp`, `create_time`) VALUES
	(1, '粉丝无底线追星行为', '18866665555', '123456876', 'http://kesu.xyz/upload/2025-04-16-20-12-31-2412.jpg', 'iqnx7', 'fde538ba27ac51097d9601a54c959bdb', '174.167.129.152', '北京', '北京', '中国联通', '2025-04-16 12:12:33'),
	(2, '发布仿冒品信息', '18888888888', '投诉测试', 'http://kesu.xyz/upload/2025-04-19-20-48-10-7271.jpg', '9ak8G', 'MaLaiMaQuZhuanZhuShangQiYingXiao', '174.167.145.1', '北京', '北京', '中国联通', '2025-04-19 12:48:13');

-- 导出  表 ts.kamiusage 结构
CREATE TABLE IF NOT EXISTS `kamiusage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kami` varchar(255) NOT NULL,
  `days` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_used` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kami` (`kami`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.kamiusage 的数据：~2 rows (大约)
INSERT INTO `kamiusage` (`id`, `kami`, `days`, `created_at`, `first_used`) VALUES
	(2, 'RMCJ58GA8HXS7S4V', 30, '2025-04-16 12:03:45', '2025-04-16 12:04:11'),
	(3, 'EGPF6VS9AY2EN82V', 365, '2025-04-17 11:37:02', '2025-04-21 15:55:59');

-- 导出  表 ts.keys_table 结构
CREATE TABLE IF NOT EXISTS `keys_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `random_string` varchar(5) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `domainname` varchar(255) DEFAULT NULL,
  `km` varchar(255) NOT NULL,
  `expiry_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `secret_key` (`secret_key`),
  UNIQUE KEY `km` (`km`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- 正在导出表  ts.keys_table 的数据：~1 rows (大约)
INSERT INTO `keys_table` (`id`, `random_string`, `secret_key`, `domainname`, `km`, `expiry_date`) VALUES
	(3, 'iqnx7', '888c4804-7b81-4a32-987d-2206f0', 'ts.tech', 'RMCJ58GA8HXS7S4V', '2026-05-16 20:04:00');

-- 导出  表 ts.typecho_comments 结构
CREATE TABLE IF NOT EXISTS `typecho_comments` (
  `coid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned DEFAULT '0',
  `created` int(10) unsigned DEFAULT '0',
  `author` varchar(150) DEFAULT NULL,
  `authorId` int(10) unsigned DEFAULT '0',
  `ownerId` int(10) unsigned DEFAULT '0',
  `mail` varchar(150) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `agent` varchar(511) DEFAULT NULL,
  `text` text,
  `type` varchar(16) DEFAULT 'comment',
  `status` varchar(16) DEFAULT 'approved',
  `parent` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`coid`),
  KEY `cid` (`cid`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.typecho_comments 的数据：~0 rows (大约)

-- 导出  表 ts.typecho_contents 结构
CREATE TABLE IF NOT EXISTS `typecho_contents` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `created` int(10) unsigned DEFAULT '0',
  `modified` int(10) unsigned DEFAULT '0',
  `text` longtext,
  `order` int(10) unsigned DEFAULT '0',
  `authorId` int(10) unsigned DEFAULT '0',
  `template` varchar(32) DEFAULT NULL,
  `type` varchar(16) DEFAULT 'post',
  `status` varchar(16) DEFAULT 'publish',
  `password` varchar(32) DEFAULT NULL,
  `commentsNum` int(10) unsigned DEFAULT '0',
  `allowComment` char(1) DEFAULT '0',
  `allowPing` char(1) DEFAULT '0',
  `allowFeed` char(1) DEFAULT '0',
  `parent` int(10) unsigned DEFAULT '0',
  `views` int(11) DEFAULT '0',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created` (`created`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.typecho_contents 的数据：~5 rows (大约)
INSERT INTO `typecho_contents` (`cid`, `title`, `slug`, `created`, `modified`, `text`, `order`, `authorId`, `template`, `type`, `status`, `password`, `commentsNum`, `allowComment`, `allowPing`, `allowFeed`, `parent`, `views`) VALUES
	(3, 'hosts文件无法修改或保存的解决办法&amp;整站迁移', '3', 1734405480, 1744809547, '<!--markdown-->Win + R键打开运行窗口，输入notepad，然后按下Ctrl + Shift + Enter键，以管理员身份运行文本编辑器。“文件”菜单选择“打开”，导航到hosts文件所在的目录，选择hosts。修改后即可保存。\r\n\r\n\r\n\r\n------------------------\r\n\r\n因阿里云流量异常导致无法使用，故整站迁移。文件、数据库迁移成功后，无故页面混乱，从数据库固定域名入手各种调试无果，后从网友问等得到启发，原来固定域名设定不在数据库中，而在配置文件里。\r\n\r\n折腾两天，只需删除配置文件的两行代码即可！', 0, 1, NULL, 'post', 'publish', NULL, 0, '1', '1', '1', 0, 639),
	(4, 'win11双屏显示时浏览器最大化遮挡任务栏', '4', 1740489660, 1744809729, '<!--markdown-->win11双屏显示时，浏览器最大化时默认全屏，遮挡住了任务栏，原因未知，各种设置未能解决，十分可恶。\r\n\r\n尝试：Win+L锁屏，再输入密码解锁。问题解决', 0, 1, NULL, 'post', 'publish', NULL, 0, '1', '1', '1', 0, 672),
	(5, 'Linux后台运行进程 ', '5', 1745248097, 1745248097, '<!--markdown-->概念\r\n当我们在终端或控制台工作时，可能不希望由于运行一个作业而占住了屏幕，因为可能还有更重要的事情要做，比如阅读电子邮件。对于密集访问磁盘的进程，我们更希望它能够在每天的非负荷高峰时间段运行(例如凌晨)。为了使这些进程能够在后台运行，也就是说不在终端屏幕上运行，有几种选择方法可供使用。\r\n\r\n回到顶部\r\n&方法\r\n使用[shell] &可以使进程在后台运行，但是用户终端退出时，进程结束，也就是当你连接的终端断开时，你后台运行的服务、命令等自动停止\r\n例如：\r\n\r\n# ping www.baidu.com的返回信息会输出到ping.log日志文件中，最后输出的jobnumber和PID\r\nroot@master-01:~#  ping www.baidu.com &>> ping.log  &\r\n[1] 1254658\r\n \r\n# 查看运行进程\r\nroot@master-01:~# jobs\r\n[1]+  Running                 ping www.baidu.com &>> ping.log &\r\nroot@master-01:~# ps -aux | grep ping\r\nroot     1254658  0.0  0.0   9048  1344 pts/0    S    19:10   0:00 ping www.baidu.com\r\n \r\n \r\n# 结束job，使用kill %jobid方式杀死job\r\nroot@master-01:~# kill %1', 0, 1, NULL, 'post', 'publish', NULL, 0, '1', '1', '1', 0, 905),
	(6, 'MCP Server Java 开发框架的体验比较（spring ai mcp 和 solon ai mcp） ', '6', 1742224140, 1745248240, '<!--markdown-->\r\n\r\n目前已知的两个 mcp-server java 应用开发框架（ID类的，封装后体验都比较简洁）：\r\n\r\nspring-ai-mcp，支持 java17 或以上\r\nsolon-ai-mcp，支持 java8 或以上（也支持集成到 springboot2, jfinal, vert.x 等第三方框架）\r\n下面分别用两个框架，构建一个天气查询的 mcp 工具服务。\r\n\r\n1、spring ai mcp server（支持 java17 或以上）\r\n添加关键的依赖包（版本号与 springboot 各自独立）\r\n\r\n<dependency>\r\n   <groupId>org.springframework.ai</groupId>\r\n   <artifactId>spring-ai-mcp-server-spring-boot-starter</artifactId>\r\n   <version>1.0.0-M6</version>\r\n</dependency>\r\n添加配置（为服务端点命名）\r\n\r\nspring.ai.mcp.server.name: jdbc-mcp-server\r\n示例代码（构建服务，然后发布为 ToolCallbackProvider）\r\n\r\n@Service\r\npublic class JdbcQueryService {\r\n    @Tool(description = "查询天气预报")\r\n    public String getWeather(@ToolParam(description = "城市位置") String location) {\r\n        return "晴，14度";\r\n    }\r\n}\r\n\r\n@Configuration\r\npublic class McpConfig {\r\n    @Bean\r\n    ToolCallbackProvider jdbcQueryTools(JdbcQueryService jdbcQueryService) {\r\n        return MethodToolCallbackProvider\r\n                .builder()\r\n                .toolObjects(jdbcQueryService)\r\n                .build();\r\n    }\r\n}\r\n2、solon ai mcp server（支持 java8 或以上）\r\n添加关键的依赖包（版本号随 solon 一致）\r\n\r\n<dependency>\r\n    <groupId>org.noear</groupId>\r\n    <artifactId>solon-ai-mcp</artifactId>\r\n    <version>3.2.0</version>\r\n</dependency>\r\n示例代码（跟 mvc 的开发非常像）\r\n\r\n@McpServerEndpoint(name="mcp-case1", sseEndpoint = "/case1/sse") \r\npublic class McpServerTool {\r\n    @ToolMapping(description = "查询天气预报")\r\n    public String getWeather(@ToolParam(description = "城市位置") String location) {\r\n        return "晴，14度";\r\n    }\r\n}\r\nsolon ai mcp server 支持多端点。就是一个服务就可提供多组工具（供不同的场景使用，灵活性更好）：\r\n\r\n可以有一组关于天气的工具\r\n可以再有一组关于地图的工具\r\n3、总结\r\n开发体验比较\r\n\r\n比较	srping-ai-mcp	solon-ai-mcp\r\n开发	基于组件开发	基于组件开发\r\n配置	通过 yaml 配置	组件，即是配置（也可引用 yaml 配置）\r\n发布	通过配置器发布为 ToolCallbackProvider	组件，即是发布\r\njdk要求	jdk17或以上	jdk8或以上\r\n端点支持	好像只能一个（一个服务内）	支持多端点（一个服务内）\r\nsolon-ai-mcp 的开发相对更简洁，三位一体。且支持多端点', 0, 1, NULL, 'post', 'publish', NULL, 0, '1', '1', '1', 0, 658),
	(7, '如何使用 Winget 更新 PowerShell：详细步骤与注意事项', '7', 1745413687, 1745413687, '<!--markdown-->本文详细介绍了如何使用Windows的命令行工具winget来安装和更新PowerShell，包括如何检查当前版本、搜索可用版本、安装最新稳定版或预览版，以及安装后的验证步骤。此方法让你能够快速通过命令行工具保持PowerShell的最新版本，减少手动下载安装的繁琐，提高工作效率。对于习惯使用命令行的开发者和IT管理员，使用winget更新PowerShell是一种快捷高效的方式。\r\n\r\n今天我的windows电脑提示powershell版本有更新，以前windows安装软件都是手动下载安装包来安装，但是在Windows 10和Windows 11中，使用命令行工具如winget、scoop和chocolatey等来安装和更新软件变得越来越方便。所以今天来使用winget更新到最新的PowerShell版本。但是有些命令记不住，来记录一下。\r\n\r\n\r\n想使用 winget 更新 PowerShell，可以按照以下步骤操作：\r\n\r\n检查 PowerShell 版本：\r\n\r\n在更新之前，可以先查看一下当前 PowerShell 的版本，以便确认是否需要更新。打开 PowerShell，输入以下命令：\r\n\r\n$PSVersionTable\r\n这会显示 PowerShell 的详细信息，包括版本号。\r\n\r\n搜索最新的 PowerShell 版本：\r\n\r\n使用 winget 搜索可用的 PowerShell 版本。在 PowerShell 中输入以下命令：\r\n\r\nwinget search Microsoft.PowerShell\r\n这会列出 PowerShell 的相关信息，包括最新的稳定版和预览版。\r\n\r\n名称               ID                           版本    源\r\n---------------------------------------------------------------\r\nPowerShell         Microsoft.PowerShell         7.5.0.0 winget\r\nPowerShell Preview Microsoft.PowerShell.Preview 7.6.0.2 winget\r\n安装或更新 PowerShell：\r\n\r\n安装最新稳定版：\r\n\r\n如果需要安装或更新到最新的稳定版 PowerShell，可以使用以下命令：\r\n\r\nwinget install --id Microsoft.PowerShell --source winget\r\n安装或更新到预览版：\r\n\r\n如果想尝试 PowerShell 的预览版，可以使用以下命令：\r\n\r\nwinget install --id Microsoft.PowerShell.Preview --source winget\r\n安装过程中，winget 会自动下载并安装 PowerShell。\r\n\r\n    已找到 PowerShell [Microsoft.PowerShell] 版本 7.5.0.0\r\n    此应用程序由其所有者授权给你。\r\n    Microsoft 对第三方程序包概不负责，也不向第三方程序包授予任何许可证。\r\n    正在下载 https://github.com/PowerShell/PowerShell/releases/download/v7.5.0/PowerShell-7.5.0-win-x64.msi\r\n    ███████████████████████████▊    99.8 MB /  107 MB\r\n验证更新：\r\n\r\n安装完成后，可以再次运行 $PSVersionTable 命令，确认 PowerShell 版本是否已更新。\r\n\r\nName                           Value\r\n----                           -----\r\nPSVersion                      7.5.0\r\nPSEdition                      Core\r\nGitCommitId                    7.5.0\r\nOS                             Microsoft Windows 10.0.26100\r\nPlatform                       Win32NT\r\nPSCompatibleVersions           {1.0, 2.0, 3.0, 4.0…}\r\nPSRemotingProtocolVersion      2.3\r\nSerializationVersion           1.1.0.1\r\nWSManStackVersion              3.0\r\n注意事项：\r\n\r\n管理员权限： 在运行 winget 命令时，可能需要以管理员身份运行 PowerShell。\r\n网络连接： 安装或更新 PowerShell 需要稳定的网络连接。\r\n版本选择： 可以根据自己的需求选择安装稳定版或预览版。预览版可能包含最新的功能，但也可能存在一些问题。', 0, 1, NULL, 'post', 'publish', NULL, 0, '1', '1', '1', 0, 886);

-- 导出  表 ts.typecho_fields 结构
CREATE TABLE IF NOT EXISTS `typecho_fields` (
  `cid` int(10) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(8) DEFAULT 'str',
  `str_value` text,
  `int_value` int(10) DEFAULT '0',
  `float_value` float DEFAULT '0',
  PRIMARY KEY (`cid`,`name`),
  KEY `int_value` (`int_value`),
  KEY `float_value` (`float_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.typecho_fields 的数据：~45 rows (大约)
INSERT INTO `typecho_fields` (`cid`, `name`, `type`, `str_value`, `int_value`, `float_value`) VALUES
	(3, 'CopyRight', 'str', 'on', 0, 0),
	(3, 'desc', 'str', '', 0, 0),
	(3, 'keywords', 'str', '', 0, 0),
	(3, 'NoCover', 'str', 'on', 0, 0),
	(3, 'ShowReward', 'str', 'off', 0, 0),
	(3, 'showTimeWarning', 'str', 'on', 0, 0),
	(3, 'ShowToc', 'str', 'show', 0, 0),
	(3, 'summaryContent', 'str', '', 0, 0),
	(3, 'thumb', 'str', '', 0, 0),
	(4, 'CopyRight', 'str', 'on', 0, 0),
	(4, 'desc', 'str', '', 0, 0),
	(4, 'keywords', 'str', '', 0, 0),
	(4, 'NoCover', 'str', 'on', 0, 0),
	(4, 'ShowReward', 'str', 'off', 0, 0),
	(4, 'showTimeWarning', 'str', 'on', 0, 0),
	(4, 'ShowToc', 'str', 'show', 0, 0),
	(4, 'summaryContent', 'str', '', 0, 0),
	(4, 'thumb', 'str', '', 0, 0),
	(5, 'CopyRight', 'str', 'on', 0, 0),
	(5, 'desc', 'str', '', 0, 0),
	(5, 'keywords', 'str', '', 0, 0),
	(5, 'NoCover', 'str', 'on', 0, 0),
	(5, 'ShowReward', 'str', 'off', 0, 0),
	(5, 'showTimeWarning', 'str', 'on', 0, 0),
	(5, 'ShowToc', 'str', 'show', 0, 0),
	(5, 'summaryContent', 'str', '', 0, 0),
	(5, 'thumb', 'str', '', 0, 0),
	(6, 'CopyRight', 'str', 'on', 0, 0),
	(6, 'desc', 'str', '', 0, 0),
	(6, 'keywords', 'str', '', 0, 0),
	(6, 'NoCover', 'str', 'on', 0, 0),
	(6, 'ShowReward', 'str', 'off', 0, 0),
	(6, 'showTimeWarning', 'str', 'on', 0, 0),
	(6, 'ShowToc', 'str', 'show', 0, 0),
	(6, 'summaryContent', 'str', '', 0, 0),
	(6, 'thumb', 'str', '', 0, 0),
	(7, 'CopyRight', 'str', 'on', 0, 0),
	(7, 'desc', 'str', '', 0, 0),
	(7, 'keywords', 'str', '', 0, 0),
	(7, 'NoCover', 'str', 'on', 0, 0),
	(7, 'ShowReward', 'str', 'off', 0, 0),
	(7, 'showTimeWarning', 'str', 'on', 0, 0),
	(7, 'ShowToc', 'str', 'show', 0, 0),
	(7, 'summaryContent', 'str', '', 0, 0),
	(7, 'thumb', 'str', '', 0, 0);

-- 导出  表 ts.typecho_metas 结构
CREATE TABLE IF NOT EXISTS `typecho_metas` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `type` varchar(32) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT '0',
  `order` int(10) unsigned DEFAULT '0',
  `parent` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.typecho_metas 的数据：~1 rows (大约)
INSERT INTO `typecho_metas` (`mid`, `name`, `slug`, `type`, `description`, `count`, `order`, `parent`) VALUES
	(1, '默认分类', 'default', 'category', '只是一个默认分类', 5, 0, 0);

-- 导出  表 ts.typecho_options 结构
CREATE TABLE IF NOT EXISTS `typecho_options` (
  `name` varchar(32) NOT NULL,
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `value` text,
  PRIMARY KEY (`name`,`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.typecho_options 的数据：~62 rows (大约)
INSERT INTO `typecho_options` (`name`, `user`, `value`) VALUES
	('actionTable', 0, 'a:0:{}'),
	('allowRegister', 0, '0'),
	('allowXmlRpc', 0, '2'),
	('attachmentTypes', 0, '@image@'),
	('autoSave', 0, '0'),
	('charset', 0, 'UTF-8'),
	('commentDateFormat', 0, 'F jS, Y \\a\\t h:i a'),
	('commentsAntiSpam', 0, '1'),
	('commentsAutoClose', 0, '0'),
	('commentsAvatar', 0, '1'),
	('commentsAvatarRating', 0, 'G'),
	('commentsCheckReferer', 0, '1'),
	('commentsHTMLTagAllowed', 0, NULL),
	('commentsListSize', 0, '10'),
	('commentsMarkdown', 0, '0'),
	('commentsMaxNestingLevels', 0, '5'),
	('commentsOrder', 0, 'ASC'),
	('commentsPageBreak', 0, '0'),
	('commentsPageDisplay', 0, 'last'),
	('commentsPageSize', 0, '20'),
	('commentsPostInterval', 0, '60'),
	('commentsPostIntervalEnable', 0, '1'),
	('commentsPostTimeout', 0, '2592000'),
	('commentsRequireMail', 0, '1'),
	('commentsRequireModeration', 0, '0'),
	('commentsRequireURL', 0, '0'),
	('commentsShowCommentOnly', 0, '0'),
	('commentsShowUrl', 0, '1'),
	('commentsThreaded', 0, '1'),
	('commentsUrlNofollow', 0, '1'),
	('commentsWhitelist', 0, '0'),
	('contentType', 0, 'text/html'),
	('defaultAllowComment', 0, '1'),
	('defaultAllowFeed', 0, '1'),
	('defaultAllowPing', 0, '1'),
	('defaultCategory', 0, '1'),
	('description', 0, ''),
	('editorSize', 0, '350'),
	('feedFullText', 0, '1'),
	('frontArchive', 0, '0'),
	('frontPage', 0, 'recent'),
	('generator', 0, 'Typecho 1.2.1'),
	('gzip', 0, '0'),
	('installed', 0, '1'),
	('keywords', 0, ''),
	('lang', 0, NULL),
	('markdown', 0, '1'),
	('pageSize', 0, '5'),
	('panelTable', 0, 'a:2:{s:5:"child";a:1:{i:1;a:1:{i:0;a:6:{i:0;s:18:"文章远程接口";i:1;s:18:"文章远程接口";i:2;s:43:"extending.php?panel=SkycaijiTye%2Fpanel.php";i:3;s:13:"administrator";i:4;b:0;i:5;s:0:"";}}}s:4:"file";a:1:{i:0;s:23:"SkycaijiTye%2Fpanel.php";}}'),
	('plugin:SkycaijiTye', 0, 'a:4:{s:6:"author";s:5:"admin";s:6:"apikey";s:14:"ts.au6l07.tech";s:7:"apitype";s:0:"";s:13:"html2markdown";s:7:"disable";}'),
	('plugins', 0, 'a:2:{s:9:"activated";a:1:{s:11:"SkycaijiTye";a:0:{}}s:7:"handles";a:0:{}}'),
	('postDateFormat', 0, 'Y-m-d'),
	('postsListSize', 0, '10'),
	('rewrite', 0, '0'),
	('routingTable', 0, 'a:26:{i:0;a:25:{s:5:"index";a:6:{s:3:"url";s:1:"/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:8:"|^[/]?$|";s:6:"format";s:1:"/";s:6:"params";a:0:{}}s:7:"archive";a:6:{s:3:"url";s:6:"/blog/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:13:"|^/blog[/]?$|";s:6:"format";s:6:"/blog/";s:6:"params";a:0:{}}s:2:"do";a:6:{s:3:"url";s:22:"/action/[action:alpha]";s:6:"widget";s:14:"\\Widget\\Action";s:6:"action";s:6:"action";s:4:"regx";s:32:"|^/action/([_0-9a-zA-Z-]+)[/]?$|";s:6:"format";s:10:"/action/%s";s:6:"params";a:1:{i:0;s:6:"action";}}s:4:"post";a:6:{s:3:"url";s:24:"/archives/[cid:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:26:"|^/archives/([0-9]+)[/]?$|";s:6:"format";s:13:"/archives/%s/";s:6:"params";a:1:{i:0;s:3:"cid";}}s:10:"attachment";a:6:{s:3:"url";s:26:"/attachment/[cid:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:28:"|^/attachment/([0-9]+)[/]?$|";s:6:"format";s:15:"/attachment/%s/";s:6:"params";a:1:{i:0;s:3:"cid";}}s:8:"category";a:6:{s:3:"url";s:17:"/category/[slug]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:25:"|^/category/([^/]+)[/]?$|";s:6:"format";s:13:"/category/%s/";s:6:"params";a:1:{i:0;s:4:"slug";}}s:3:"tag";a:6:{s:3:"url";s:12:"/tag/[slug]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:20:"|^/tag/([^/]+)[/]?$|";s:6:"format";s:8:"/tag/%s/";s:6:"params";a:1:{i:0;s:4:"slug";}}s:6:"author";a:6:{s:3:"url";s:22:"/author/[uid:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:24:"|^/author/([0-9]+)[/]?$|";s:6:"format";s:11:"/author/%s/";s:6:"params";a:1:{i:0;s:3:"uid";}}s:6:"search";a:6:{s:3:"url";s:19:"/search/[keywords]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:23:"|^/search/([^/]+)[/]?$|";s:6:"format";s:11:"/search/%s/";s:6:"params";a:1:{i:0;s:8:"keywords";}}s:10:"index_page";a:6:{s:3:"url";s:21:"/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:22:"|^/page/([0-9]+)[/]?$|";s:6:"format";s:9:"/page/%s/";s:6:"params";a:1:{i:0;s:4:"page";}}s:12:"archive_page";a:6:{s:3:"url";s:26:"/blog/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:27:"|^/blog/page/([0-9]+)[/]?$|";s:6:"format";s:14:"/blog/page/%s/";s:6:"params";a:1:{i:0;s:4:"page";}}s:13:"category_page";a:6:{s:3:"url";s:32:"/category/[slug]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:34:"|^/category/([^/]+)/([0-9]+)[/]?$|";s:6:"format";s:16:"/category/%s/%s/";s:6:"params";a:2:{i:0;s:4:"slug";i:1;s:4:"page";}}s:8:"tag_page";a:6:{s:3:"url";s:27:"/tag/[slug]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:29:"|^/tag/([^/]+)/([0-9]+)[/]?$|";s:6:"format";s:11:"/tag/%s/%s/";s:6:"params";a:2:{i:0;s:4:"slug";i:1;s:4:"page";}}s:11:"author_page";a:6:{s:3:"url";s:37:"/author/[uid:digital]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:33:"|^/author/([0-9]+)/([0-9]+)[/]?$|";s:6:"format";s:14:"/author/%s/%s/";s:6:"params";a:2:{i:0;s:3:"uid";i:1;s:4:"page";}}s:11:"search_page";a:6:{s:3:"url";s:34:"/search/[keywords]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:32:"|^/search/([^/]+)/([0-9]+)[/]?$|";s:6:"format";s:14:"/search/%s/%s/";s:6:"params";a:2:{i:0;s:8:"keywords";i:1;s:4:"page";}}s:12:"archive_year";a:6:{s:3:"url";s:18:"/[year:digital:4]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:19:"|^/([0-9]{4})[/]?$|";s:6:"format";s:4:"/%s/";s:6:"params";a:1:{i:0;s:4:"year";}}s:13:"archive_month";a:6:{s:3:"url";s:36:"/[year:digital:4]/[month:digital:2]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:30:"|^/([0-9]{4})/([0-9]{2})[/]?$|";s:6:"format";s:7:"/%s/%s/";s:6:"params";a:2:{i:0;s:4:"year";i:1;s:5:"month";}}s:11:"archive_day";a:6:{s:3:"url";s:52:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:41:"|^/([0-9]{4})/([0-9]{2})/([0-9]{2})[/]?$|";s:6:"format";s:10:"/%s/%s/%s/";s:6:"params";a:3:{i:0;s:4:"year";i:1;s:5:"month";i:2;s:3:"day";}}s:17:"archive_year_page";a:6:{s:3:"url";s:38:"/[year:digital:4]/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:33:"|^/([0-9]{4})/page/([0-9]+)[/]?$|";s:6:"format";s:12:"/%s/page/%s/";s:6:"params";a:2:{i:0;s:4:"year";i:1;s:4:"page";}}s:18:"archive_month_page";a:6:{s:3:"url";s:56:"/[year:digital:4]/[month:digital:2]/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:44:"|^/([0-9]{4})/([0-9]{2})/page/([0-9]+)[/]?$|";s:6:"format";s:15:"/%s/%s/page/%s/";s:6:"params";a:3:{i:0;s:4:"year";i:1;s:5:"month";i:2;s:4:"page";}}s:16:"archive_day_page";a:6:{s:3:"url";s:72:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:55:"|^/([0-9]{4})/([0-9]{2})/([0-9]{2})/page/([0-9]+)[/]?$|";s:6:"format";s:18:"/%s/%s/%s/page/%s/";s:6:"params";a:4:{i:0;s:4:"year";i:1;s:5:"month";i:2;s:3:"day";i:3;s:4:"page";}}s:12:"comment_page";a:6:{s:3:"url";s:53:"[permalink:string]/comment-page-[commentPage:digital]";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:36:"|^(.+)/comment\\-page\\-([0-9]+)[/]?$|";s:6:"format";s:18:"%s/comment-page-%s";s:6:"params";a:2:{i:0;s:9:"permalink";i:1;s:11:"commentPage";}}s:4:"feed";a:6:{s:3:"url";s:20:"/feed[feed:string:0]";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:4:"feed";s:4:"regx";s:17:"|^/feed(.*)[/]?$|";s:6:"format";s:7:"/feed%s";s:6:"params";a:1:{i:0;s:4:"feed";}}s:8:"feedback";a:6:{s:3:"url";s:31:"[permalink:string]/[type:alpha]";s:6:"widget";s:16:"\\Widget\\Feedback";s:6:"action";s:6:"action";s:4:"regx";s:29:"|^(.+)/([_0-9a-zA-Z-]+)[/]?$|";s:6:"format";s:5:"%s/%s";s:6:"params";a:2:{i:0;s:9:"permalink";i:1;s:4:"type";}}s:4:"page";a:6:{s:3:"url";s:12:"/[slug].html";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";s:4:"regx";s:22:"|^/([^/]+)\\.html[/]?$|";s:6:"format";s:8:"/%s.html";s:6:"params";a:1:{i:0;s:4:"slug";}}}s:5:"index";a:3:{s:3:"url";s:1:"/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:7:"archive";a:3:{s:3:"url";s:6:"/blog/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:2:"do";a:3:{s:3:"url";s:22:"/action/[action:alpha]";s:6:"widget";s:14:"\\Widget\\Action";s:6:"action";s:6:"action";}s:4:"post";a:3:{s:3:"url";s:24:"/archives/[cid:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:10:"attachment";a:3:{s:3:"url";s:26:"/attachment/[cid:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:8:"category";a:3:{s:3:"url";s:17:"/category/[slug]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:3:"tag";a:3:{s:3:"url";s:12:"/tag/[slug]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:6:"author";a:3:{s:3:"url";s:22:"/author/[uid:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:6:"search";a:3:{s:3:"url";s:19:"/search/[keywords]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:10:"index_page";a:3:{s:3:"url";s:21:"/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:12:"archive_page";a:3:{s:3:"url";s:26:"/blog/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:13:"category_page";a:3:{s:3:"url";s:32:"/category/[slug]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:8:"tag_page";a:3:{s:3:"url";s:27:"/tag/[slug]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:11:"author_page";a:3:{s:3:"url";s:37:"/author/[uid:digital]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:11:"search_page";a:3:{s:3:"url";s:34:"/search/[keywords]/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:12:"archive_year";a:3:{s:3:"url";s:18:"/[year:digital:4]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:13:"archive_month";a:3:{s:3:"url";s:36:"/[year:digital:4]/[month:digital:2]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:11:"archive_day";a:3:{s:3:"url";s:52:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:17:"archive_year_page";a:3:{s:3:"url";s:38:"/[year:digital:4]/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:18:"archive_month_page";a:3:{s:3:"url";s:56:"/[year:digital:4]/[month:digital:2]/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:16:"archive_day_page";a:3:{s:3:"url";s:72:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:12:"comment_page";a:3:{s:3:"url";s:53:"[permalink:string]/comment-page-[commentPage:digital]";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}s:4:"feed";a:3:{s:3:"url";s:20:"/feed[feed:string:0]";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:4:"feed";}s:8:"feedback";a:3:{s:3:"url";s:31:"[permalink:string]/[type:alpha]";s:6:"widget";s:16:"\\Widget\\Feedback";s:6:"action";s:6:"action";}s:4:"page";a:3:{s:3:"url";s:12:"/[slug].html";s:6:"widget";s:15:"\\Widget\\Archive";s:6:"action";s:6:"render";}}'),
	('secret', 0, '@YMt6$BnFnCeUaARD8o1uq20I5$&bwCp'),
	('siteUrl', 0, 'http://kesu.669222.xyz'),
	('theme', 0, 'butterfly'),
	('theme:butterfly', 0, 'a:80:{s:11:"sticky_cids";s:0:"";s:10:"slide_cids";s:0:"";s:9:"enableApi";s:3:"off";s:10:"StaticFile";s:3:"CDN";s:6:"CDNURL";s:0:"";s:12:"jsdelivrLink";s:18:"gcore.jsdelivr.net";s:10:"NewTabLink";s:2:"on";s:13:"showFramework";s:2:"on";s:6:"Defend";s:3:"off";s:13:"ThemePassword";s:0:"";s:4:"NoQQ";s:3:"off";s:8:"SiteLogo";s:0:"";s:11:"Sitefavicon";s:0:"";s:7:"logoUrl";s:5:"#null";s:18:"author_description";s:12:"作者描述";s:23:"author_site_description";s:12:"个人网站";s:11:"author_site";s:5:"#null";s:13:"author_bottom";s:0:"";s:12:"announcement";s:19:"这里是公告<br>";s:2:"AD";s:0:"";s:9:"headerimg";s:50:"https://s2.loli.net/2023/01/18/bIJTVaR3MLPzcZ7.jpg";s:15:"mobileHeaderImg";s:0:"";s:9:"buildtime";s:10:"2020/06/05";s:9:"outoftime";s:2:"15";s:11:"archivelink";s:5:"#null";s:8:"tagslink";s:5:"#null";s:12:"categorylink";s:5:"#null";s:13:"CloseComments";s:3:"off";s:19:"EnableCommentsLogin";s:3:"off";s:16:"ShowRelatedPosts";s:3:"off";s:15:"RelatedPostsNum";s:1:"3";s:15:"DefaultEncoding";s:1:"2";s:13:"themeFontSize";s:0:"";s:14:"GravatarSelect";s:27:"https://cravatar.cn/avatar/";s:15:"baidustatistics";s:0:"";s:13:"googleadsense";s:0:"";s:10:"EnablePjax";s:3:"off";s:12:"PjaxCallBack";s:0:"";s:9:"friendset";s:1:"0";s:7:"Friends";s:0:"";s:8:"LazyLoad";s:0:"";s:16:"ShowGlobalReward";s:3:"off";s:10:"RewardInfo";s:0:"";s:12:"sidebarBlock";a:9:{i:0;s:14:"ShowAuthorInfo";i:1;s:12:"ShowAnnounce";i:2;s:15:"ShowRecentPosts";i:3;s:18:"ShowRecentComments";i:4;s:12:"ShowCategory";i:5;s:7:"ShowTag";i:6;s:11:"ShowArchive";i:7;s:11:"ShowWebinfo";i:8;s:14:"ShowMobileSide";}s:16:"ShowOnlinePeople";s:3:"off";s:16:"sidderArchiveNum";s:1:"5";s:16:"PostSidebarBlock";a:4:{i:0;s:14:"ShowAuthorInfo";i:1;s:12:"ShowAnnounce";i:2;s:15:"ShowRecentPosts";i:3;s:11:"ShowWebinfo";}s:13:"beautifyBlock";a:7:{i:0;s:10:"ShowTopimg";i:1;s:14:"PostShowTopimg";i:2;s:14:"PageShowTopimg";i:3;s:14:"showLineNumber";i:4;s:12:"showSnackbar";i:5;s:16:"showLazyloadBlur";i:6;s:17:"showNoAlertSearch";}s:13:"coverPosition";s:5:"cross";s:12:"qweather_key";s:0:"";s:12:"gaud_map_key";s:0:"";s:10:"ShowLive2D";s:3:"off";s:16:"SnackbarPosition";s:8:"top-left";s:13:"CursorEffects";s:3:"off";s:14:"CustomSubtitle";s:0:"";s:12:"SubtitleLoop";s:4:"true";s:20:"EnableAutoHeaderLink";s:2:"on";s:16:"CustomHeaderLink";s:0:"";s:19:"CustomAuthenticated";s:0:"";s:9:"CustomCSS";s:0:"";s:12:"CustomScript";s:0:"";s:10:"CustomHead";s:0:"";s:13:"CustomBodyEnd";s:0:"";s:12:"Customfooter";s:0:"";s:10:"themeColor";s:4:"#eee";s:14:"darkModeSelect";s:1:"2";s:8:"darkTime";s:4:"7-20";s:17:"EnableCustomColor";s:5:"false";s:15:"CustomColorMain";s:7:"#49b1f5";s:19:"CustomColorButtonBG";s:7:"#49b1f5";s:22:"CustomColorButtonHover";s:7:"#ff7242";s:20:"CustomColorSelection";s:7:"#00c4b6";s:7:"siteKey";s:0:"";s:9:"secretKey";s:0:"";s:17:"hcaptchaSecretKey";s:0:"";s:14:"hcaptchaAPIKey";s:0:"";s:16:"turnstileSiteKey";s:0:"";s:12:"turnstileKey";s:0:"";s:11:"EnableCache";s:3:"off";s:9:"CacheTime";s:5:"86400";}'),
	('timezone', 0, '28800'),
	('title', 0, '我的个人博客'),
	('xmlrpcMarkdown', 0, '0');

-- 导出  表 ts.typecho_relationships 结构
CREATE TABLE IF NOT EXISTS `typecho_relationships` (
  `cid` int(10) unsigned NOT NULL,
  `mid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cid`,`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.typecho_relationships 的数据：~5 rows (大约)
INSERT INTO `typecho_relationships` (`cid`, `mid`) VALUES
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1);

-- 导出  表 ts.typecho_users 结构
CREATE TABLE IF NOT EXISTS `typecho_users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `mail` varchar(150) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `screenName` varchar(32) DEFAULT NULL,
  `created` int(10) unsigned DEFAULT '0',
  `activated` int(10) unsigned DEFAULT '0',
  `logged` int(10) unsigned DEFAULT '0',
  `group` varchar(16) DEFAULT 'visitor',
  `authCode` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  ts.typecho_users 的数据：~1 rows (大约)
INSERT INTO `typecho_users` (`uid`, `name`, `password`, `mail`, `url`, `screenName`, `created`, `activated`, `logged`, `group`, `authCode`) VALUES
	(1, 'admin', '$P$BhaL9oPfIh1iH6yyWQZgLQsuj5vSo1.', 'admin@1.xyz', 'http://kesu.xyz', 'admin', 1744804601, 1745414109, 1745248305, 'administrator', 'cca4635d86c5915e3bcdf55ea6defaaf');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
