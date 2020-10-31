-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-10-31 08:46:44
-- 服务器版本： 10.4.13-MariaDB
-- PHP 版本： 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `blog`;

-- --------------------------------------------------------

--
-- 表的结构 `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '介绍',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章内容',
  `img` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '封面',
  `classty` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '分类',
  `channels` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '多端发布',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '作者',
  `click` int(11) NOT NULL DEFAULT 0 COMMENT '浏览量',
  `like` int(11) NOT NULL DEFAULT 0 COMMENT '喜欢量',
  `is_show` int(11) NOT NULL DEFAULT 1 COMMENT '首页显示',
  `head_show` int(11) NOT NULL DEFAULT 1 COMMENT '头部显示',
  `share_show` int(11) DEFAULT 1 COMMENT '分享显示',
  `copyright_show` int(11) DEFAULT 1 COMMENT '版权显示',
  `message_show` int(11) DEFAULT 1 COMMENT '留言显示',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `homes`
--

CREATE TABLE `homes` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `info` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `link` text COLLATE utf8_bin DEFAULT NULL,
  `img_url` text COLLATE utf8_bin NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `labels`
--

CREATE TABLE `labels` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标签名',
  `article_id` int(11) NOT NULL COMMENT '文章id',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `links`
--

CREATE TABLE `links` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '网站名称',
  `type` int(11) NOT NULL DEFAULT 0,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '网站链接',
  `imgUrl` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图标',
  `info` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '信息',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '留言',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `article_id` int(11) NOT NULL DEFAULT 0 COMMENT '文章id,0为网站留言',
  `tourist` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '游客留言',
  `qq` int(11) DEFAULT NULL COMMENT 'qq用于获取头像',
  `ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `musics`
--

CREATE TABLE `musics` (
  `id` int(10) UNSIGNED NOT NULL,
  `music_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '音乐id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '音乐标题',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '音乐作者',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'qq' COMMENT '音乐位置',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `replies`
--

CREATE TABLE `replies` (
  `id` int(10) UNSIGNED NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回复内容',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '0为管理员回复',
  `mess_id` int(11) NOT NULL COMMENT '回复留言id',
  `mess_reply_id` int(11) DEFAULT NULL,
  `ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `routes`
--

CREATE TABLE `routes` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日期',
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '类别',
  `content` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `sysmess`
--

CREATE TABLE `sysmess` (
  `id` int(11) NOT NULL,
  `title` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `content` text COLLATE utf8_bin DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键自增id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email邮箱',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码',
  `avatar_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像地址',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `captcha` int(11) DEFAULT NULL COMMENT '验证码',
  `intro` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '介绍',
  `is_admin` int(255) DEFAULT 0 COMMENT '是否为管理员',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `user_auths`
--

CREATE TABLE `user_auths` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '登录类型',
  `login_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '登录名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '登录密码',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转储表的索引
--

--
-- 表的索引 `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `homes`
--
ALTER TABLE `homes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `links_name_unique` (`name`),
  ADD UNIQUE KEY `links_link_unique` (`link`) USING HASH,
  ADD UNIQUE KEY `links_imgurl_unique` (`imgUrl`) USING HASH;

--
-- 表的索引 `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `musics`
--
ALTER TABLE `musics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `musics_music_id_unique` (`music_id`),
  ADD UNIQUE KEY `musics_title_unique` (`title`),
  ADD UNIQUE KEY `musics_name_unique` (`name`);

--
-- 表的索引 `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- 表的索引 `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sysmess`
--
ALTER TABLE `sysmess`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- 表的索引 `user_auths`
--
ALTER TABLE `user_auths`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `homes`
--
ALTER TABLE `homes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `labels`
--
ALTER TABLE `labels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `links`
--
ALTER TABLE `links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键';

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `musics`
--
ALTER TABLE `musics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `sysmess`
--
ALTER TABLE `sysmess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键自增id';

--
-- 使用表AUTO_INCREMENT `user_auths`
--
ALTER TABLE `user_auths`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
