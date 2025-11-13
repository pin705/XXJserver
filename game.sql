-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.stak.cn
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2020-01-05 13:35:54
-- Phiên bản máy chủ: 10.3.18-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng `boss`
--

CREATE TABLE IF NOT EXISTS `boss` (
  `bossname` text NOT NULL,
  `bossinfo` text NOT NULL,
  `bosslv` text NOT NULL,
  `bosshp` varchar(255) NOT NULL,
  `bossmaxhp` varchar(255) NOT NULL,
  `bossgj` varchar(255) NOT NULL,
  `bossfy` varchar(255) NOT NULL,
  `bossbj` varchar(255) NOT NULL,
  `bossxx` varchar(255) NOT NULL,
  `bosszb` varchar(255) NOT NULL,
  `bossdj` varchar(255) NOT NULL,
  `bossid` int(10) unsigned NOT NULL,
  `bs` int(255) NOT NULL,
  `bosstime` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gb2312;

-- --------------------------------------------------------

--
-- Cấu trúc bảng `bugcollect`
--

CREATE TABLE IF NOT EXISTS `bugcollect` (
  `id` int(11) NOT NULL,
  `uname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uptime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dữ liệu bảng `bugcollect`
--

INSERT INTO `bugcollect` (`id`, `uname`, `title`, `content`, `uptime`, `uid`) VALUES
(29, '冥羽', 'Thuốc máu', 'Đã đầy máu rồi vẫn còn dùng được, nếu tay lỡ nhấn thuốc cuối cùng khi đầy máu thì sẽ là một câu chuyện khác (tai nạn)', '2020-01-02 21:07:09', 424),
(28, '黑猫丶', 'Đạo cụ', 'Đạo cụ bán được 0 linh thạch', '2020-01-02 20:54:36 [done]', 431),
(27, '黑猫丶', 'Tên', 'Tên có thể trùng lặp', '2020-01-02 20:49:18 [done]', 431),
(26, '冥羽', 'Cái đó', 'Tôi nghĩ mình có thể tạo nhiều tài khoản nhỏ, rồi treo ít trang bị để kiếm tiền', '2020-01-02 20:48:15', 424),
(25, '黑猫丶', 'Về chiến đấu', 'Sau khi chiến đấu máu sẽ về đầy..', '2020-01-02 20:42:19 [lv<=10]', 431),
(24, '黑猫丶', 'Gửi bug', 'Khi gửi bug sẽ có mã nguồn xuất hiện', '2020-01-02 20:37:39 [done]', 431),
(21, '冥羽', 'Kinh nghiệm đánh quái có vấn đề, tiện đề xuất ý kiến', 'Mỗi cấp cao hơn sẽ thêm 10 điểm kinh nghiệm, thấp hơn nhân vật cấp 5 thì không có kinh nghiệm, giới hạn tăng kinh nghiệm là 100', '2020-01-02 18:16:43 [done]', 424),
(23, '黑猫丶', 'Trò chuyện trống', 'Trò chuyện sẽ xuất hiện khoảng trống', '2020-01-02 20:36:20 [done]', 431);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `clubname` varchar(255) NOT NULL,
  `clubinfo` varchar(255) NOT NULL,
  `clublv` varchar(255) NOT NULL,
  `clubid` int(11) NOT NULL,
  `clubno1` int(11) NOT NULL,
  `clubexp` int(11) NOT NULL,
  `clubyxb` int(11) NOT NULL,
  `clubczb` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `club`
--

INSERT INTO `club` (`clubname`, `clubinfo`, `clublv`, `clubid`, `clubno1`, `clubexp`, `clubyxb`, `clubczb`) VALUES
('Phong Vân', '111', '1', 1, 423, 0, 0, 0),
('Thành Vui Sống', 'Vui vẻ trọn đời', '1', 3, 422, 0, 0, 0),
('Minh Phụng', 'Phượng của u minh', '1', 4, 424, 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `clubplayer`
--

CREATE TABLE IF NOT EXISTS `clubplayer` (
  `clubid` int(11) NOT NULL,
  `sid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `uclv` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `clubplayer`
--

INSERT INTO `clubplayer` (`clubid`, `sid`, `uid`, `uclv`) VALUES
(1, '0268fe396bc44c608aa9a18d6a0cb549', 423, 1),
(3, '3c9d1d6c8f225e9e4139cccd830fdd00', 422, 1),
(4, 'f76c11b6601d3a6ce505c616b64ed478', 424, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `daoju`
--

CREATE TABLE IF NOT EXISTS `daoju` (
  `djname` varchar(255) NOT NULL,
  `djzl` varchar(255) NOT NULL,
  `djinfo` varchar(255) NOT NULL,
  `djid` int(11) NOT NULL,
  `djyxb` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `daoju`
--

INSERT INTO `daoju` (`djname`, `djzl`, `djinfo`, `djid`, `djyxb`) VALUES
('Đá cường hóa', '2', 'Đạo cụ dùng để cường hóa trang bị', 1, 10),
('Mảnh phù lục - Sơ cấp linh', '', 'Dùng để đổi phù lục', 6, 1),
('Mảnh phù lục - Sơ cấp ma', '', 'Đổi phù lục', 7, 1),
('Mật ong cánh cứng', '', 'Mật ong của ong cánh cứng', 8, 1),
('Mảnh phù lục - Sơ cấp man', '', 'Mảnh phù lục - Sơ cấp man', 9, 1),
('Mảnh phù lục - Trung cấp linh', '', 'Mảnh phù lục - Trung cấp linh', 10, 5),
('Ma linh sơ cấp', '', 'Ma linh sơ cấp', 11, 10),
('[Thần khí] Mảnh kiếm Yêu Vương', '', '[Thần khí] Mảnh kiếm Yêu Vương', 12, 100);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `duihuan`
--

CREATE TABLE IF NOT EXISTS `duihuan` (
  `dhm` varchar(255) NOT NULL,
  `dhzb` varchar(255) DEFAULT NULL,
  `dhdj` varchar(255) DEFAULT NULL,
  `dhyp` varchar(255) DEFAULT NULL,
  `dhyxb` int(11) NOT NULL,
  `dhczb` int(11) NOT NULL,
  `dhname` varchar(255) DEFAULT NULL,
  `dhexp` int(11) NOT NULL,
  `dhid` int(11) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `duihuan`
--

INSERT INTO `duihuan` (`dhm`, `dhzb`, `dhdj`, `dhyp`, `dhyxb`, `dhczb`, `dhname`, `dhexp`, `dhid`) VALUES
('49852B2FA355EA54', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('DA71AAF69D931648', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('2B5BAECC1CBA455C', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('C2BAF2D5ADF0C03E', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('870C85455682BC80', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('E3E4ED0CD757A3CF', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('1B958DC758D1570C', '', '1|50', '', 0, 0, '20', 0, 7),
('0D959B010FF1EF9D', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('240C93CAEA5F1FA9', '33', '1|100', '9|100', 0, 0, 'Gói nâng cấp tân thủ', 88888, 1),
('05EDE59AA14DD17A', '23,24,25,26,27,28,29', '', '', 0, 0, '12', 0, 3),
('BBAABF0C1E46ED70', '', '8|10,12|20', '', 0, 0, '30', 0, 17),
('EC13CD0E5601D140', '23,24,25,26,27,28,29', '', '', 0, 0, '12', 0, 6),
('98F01CDB439A05EF', '', '1|50', '', 0, 0, '20', 0, 9),
('C49212A00B3B11AB', '', '1|50', '', 0, 0, '20', 0, 10),
('26E3757F842DEABA', '', '8|10,12|20', '', 0, 0, '30', 0, 13),
('5FBC09F7745B3174', '', '8|10,12|20', '', 0, 0, '30', 0, 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `exp`
--

CREATE TABLE IF NOT EXISTS `exp` (
  `ulv` text NOT NULL,
  `uexp` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- --------------------------------------------------------

--
-- Cấu trúc bảng `fangshi_dj`
--

CREATE TABLE IF NOT EXISTS `fangshi_dj` (
  `djid` int(11) NOT NULL,
  `djcount` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `payid` int(11) unsigned NOT NULL,
  `djname` varchar(255) NOT NULL,
  `djinfo` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng `fangshi_zb`
--

CREATE TABLE IF NOT EXISTS `fangshi_zb` (
  `zbnowid` int(11) NOT NULL,
  `zbname` varchar(255) NOT NULL,
  `qianghua` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `payid` int(11) NOT NULL,
  `zbinfo` varchar(255) NOT NULL,
  `zbgj` int(11) NOT NULL,
  `zbfy` int(11) NOT NULL,
  `zbbj` int(11) NOT NULL,
  `zbxx` int(11) NOT NULL,
  `zbid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `zbhp` int(11) NOT NULL,
  `zblv` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `fangshi_zb`
--

INSERT INTO `fangshi_zb` (`zbnowid`, `zbname`, `qianghua`, `pay`, `payid`, `zbinfo`, `zbgj`, `zbfy`, `zbbj`, `zbxx`, `zbid`, `uid`, `sid`, `zbhp`, `zblv`) VALUES
(75679, 'Giáp nhẹ nhàng Bách Luyện', 0, 300, 4, 'Giáp nhẹ nhàng Bách Luyện', 0, 8, 0, 0, 28, 424, 0, 40, 0),
(75685, 'Hộ giáp thanh phong', 0, 100, 5, 'Lấy từ thanh phong thường bạn', 0, 5, 1, 0, 26, 424, 0, 25, 0),
(75687, 'Kiếm Thị Huyết sơ cấp', 0, 20, 6, 'Kiếm Thị Huyết sơ cấp', 2, 0, 1, 3, 29, 424, 0, 0, 0),
(75748, 'Giáp nhẹ nhàng Bách Luyện', 0, 100, 7, 'Giáp nhẹ nhàng Bách Luyện', 0, 8, 0, 0, 28, 434, 0, 40, 0),
(75749, 'Giáp nhẹ nhàng Bách Luyện', 0, 100, 8, 'Giáp nhẹ nhàng Bách Luyện', 0, 8, 0, 0, 28, 434, 0, 40, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `fb`
--

CREATE TABLE IF NOT EXISTS `fb` (
  `fbname` varchar(255) NOT NULL,
  `fbid` int(11) NOT NULL,
  `fbinfo` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dữ liệu bảng `fb`
--

INSERT INTO `fb` (`fbname`, `fbid`, `fbinfo`) VALUES
('Phó bản thử nghiệm', 0, 'Phó bản dùng để test');

-- --------------------------------------------------------

--
-- Cấu trúc bảng `fbmid`
--

CREATE TABLE IF NOT EXISTS `fbmid` (
  `fmname` varchar(255) NOT NULL,
  `fmid` int(11) NOT NULL,
  `fminfo` varchar(255) NOT NULL,
  `fmnpc` varchar(255) NOT NULL,
  `fmgw` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng `game1`
--

CREATE TABLE IF NOT EXISTS `game1` (
  `uid` int(11) NOT NULL,
  `sid` text CHARACTER SET utf8 NOT NULL,
  `token` text CHARACTER SET utf8 NOT NULL,
  `uname` text CHARACTER SET utf8 NOT NULL,
  `ulv` int(10) unsigned NOT NULL DEFAULT 1,
  `uyxb` int(11) NOT NULL DEFAULT 2000,
  `uczb` int(11) NOT NULL DEFAULT 100,
  `uexp` int(11) NOT NULL DEFAULT 0,
  `vip` int(11) NOT NULL DEFAULT 0,
  `uhp` int(11) NOT NULL DEFAULT 35,
  `umaxhp` int(11) NOT NULL DEFAULT 35,
  `ugj` int(11) NOT NULL DEFAULT 12,
  `ufy` int(11) NOT NULL DEFAULT 5,
  `usex` int(11) NOT NULL DEFAULT 1,
  `endtime` datetime NOT NULL,
  `nowmid` int(11) NOT NULL DEFAULT 225,
  `uwx` int(11) NOT NULL DEFAULT 0,
  `nowguaiwu` int(11) NOT NULL,
  `tool1` int(11) NOT NULL,
  `tool2` int(11) NOT NULL,
  `tool3` int(11) NOT NULL,
  `tool4` int(11) NOT NULL,
  `tool5` int(11) NOT NULL,
  `tool6` int(11) NOT NULL,
  `ubj` int(11) NOT NULL DEFAULT 0,
  `uxx` int(11) NOT NULL DEFAULT 0,
  `sfzx` int(11) NOT NULL DEFAULT 0,
  `qandaotime` datetime NOT NULL,
  `xiuliantime` datetime NOT NULL,
  `sfxl` int(11) NOT NULL DEFAULT 0,
  `yp1` int(11) NOT NULL,
  `yp2` int(11) NOT NULL,
  `yp3` int(11) NOT NULL,
  `cw` int(11) NOT NULL,
  `jn1` int(11) NOT NULL,
  `jn2` int(11) NOT NULL,
  `jn3` int(11) NOT NULL,
  `ispvp` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB AUTO_INCREMENT=438 DEFAULT CHARSET=gb2312;

--
-- Dữ liệu bảng `game1`
--

INSERT INTO `game1` (`uid`, `sid`, `token`, `uname`, `ulv`, `uyxb`, `uczb`, `uexp`, `vip`, `uhp`, `umaxhp`, `ugj`, `ufy`, `usex`, `endtime`, `nowmid`, `uwx`, `nowguaiwu`, `tool1`, `tool2`, `tool3`, `tool4`, `tool5`, `tool6`, `ubj`, `uxx`, `sfzx`, `qandaotime`, `xiuliantime`, `sfxl`, `yp1`, `yp2`, `yp3`, `cw`, `jn1`, `jn2`, `jn3`, `ispvp`) VALUES
(422, '3c9d1d6c8f225e9e4139cccd830fdd00', 'e8f07fd9dd9747eb7061440ea1f95577', '道长', 8, 797, 40, 79505, 0, 303, 257, 40, 31, 1, '2020-01-05 11:33:29', 225, 14, 0, 75683, 75709, 75715, 0, 0, 75717, 0, 0, 1, '0000-00-00 00:00:00', '2020-01-03 00:26:19', 1, 0, 0, 0, 3587, 0, 0, 0, 0),
(423, '0268fe396bc44c608aa9a18d6a0cb549', '634a3ef9c704b392f57961fe7f5b8dea', '道长1', 1, 2059, 100, 0, 0, 35, 35, 12, 5, 1, '2020-01-02 10:26:18', 273, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(424, 'f76c11b6601d3a6ce505c616b64ed478', '044ca22581d263964fd0158282fadb42', '冥羽', 11, 307, 48, 6020, 0, 247, 362, 55, 49, 2, '2020-01-03 19:50:50', 243, 20, 0, 75682, 75678, 75708, 75718, 75713, 75719, 0, 0, 1, '0000-00-00 00:00:00', '2020-01-02 17:43:00', 1, 6, 7, 0, 3590, 4, 5, 0, 0),
(426, '0ed4ce0a982475dad32cea331e8e50d7', '6b95038f4e35e4c204cd63c4291f47dc', '修罗', 3, 2438, 100, 543, 0, 32, 97, 20, 13, 1, '2020-01-02 17:55:11', 231, 4, 0, 75672, 0, 75669, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '2020-01-02 17:54:14', 0, 6, 0, 0, 0, 0, 0, 0, 0),
(427, '9f98bca6ec1fa9e5b63f70012148b511', 'c911094e95590dda0b8a0813dca6f27f', '无敌', 1, 1880, 0, 159, 0, 35, 35, 12, 5, 1, '2020-01-04 14:38:34', 231, 0, 0, 75674, 0, 0, 0, 0, 0, 0, 0, 1, '0000-00-00 00:00:00', '2020-01-02 18:00:23', 1, 0, 0, 0, 3589, 0, 0, 0, 0),
(428, '4cd1cb0fe7fde3575154e1948a8062bc', 'a3f9ecbb5e8f608ebbf0416a51004bc7', '提米', 1, 2000, 100, 0, 0, 35, 35, 12, 5, 1, '2020-01-02 18:02:23', 225, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(429, 'bb1ffa393e016ec1e03fb5956a33dbb5', 'b9066cad96a2d83cc94596bbb09e763c', '莫轻狂', 1, 2000, 100, 0, 0, 35, 35, 12, 5, 1, '2020-01-02 18:41:14', 225, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(430, 'bd2c1545c6284ceb5cd83c9cbe1f8ec7', '0bcbf80f605a7a4b32629e5080292a39', '啦啦啦', 1, 2002, 100, 16, 0, 30, 35, 12, 5, 1, '2020-01-02 19:43:01', 228, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(431, '3bfa14243cba16bb92e090b54cc5d544', '5bcf6db33b57444bec34f05cf5fab6e8', '黑猫丶', 5, 2405, 50, 96, 0, 194, 157, 27, 19, 1, '2020-01-03 08:25:57', 231, 8, 0, 75659, 0, 75711, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '2020-01-02 20:44:06', 1, 0, 0, 0, 3592, 0, 0, 0, 0),
(432, 'bdf741647eee48085f21de90ffcd99ba', 'a5318beda844395277cc8ca528f9cd16', '小焱夏', 1, 2000, 100, 0, 0, 35, 35, 12, 5, 1, '2020-01-02 20:44:26', 225, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(434, 'e14b6e0d27bea46402a112c75c170887', 'db7d71820512cabea82d964fb062e143', '太长', 5, 2816, 50, 583, 0, 175, 161, 27, 19, 1, '2020-01-03 06:33:11', 261, 8, 0, 75750, 0, 75747, 0, 0, 0, 0, 0, 1, '0000-00-00 00:00:00', '2020-01-03 00:32:54', 1, 0, 0, 0, 3591, 4, 0, 0, 0),
(435, '4f51a51d5a72504387e6fd56da3464fe', 'd9ffd17ec312dd7d906d3d0bd09e9c33', '代码李', 1, 2001, 100, 7, 0, 30, 35, 12, 5, 1, '2020-01-03 12:45:59', 228, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(436, 'f5c963924b0d34b2aca6761cdb32bbf3', '567e3d19771392bddf87d647b1c79370', '你大爷', 1, 2000, 100, 0, 0, 35, 35, 12, 5, 2, '2020-01-03 14:41:05', 225, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(437, '4cfb676f793c954980bab3c8ad2e2a5a', 'abec8758f4bb1bf557b0189d4e0ab5c6', '大梦想家', 1, 2001, 100, 9, 0, 30, 35, 12, 5, 1, '2020-01-05 11:19:22', 229, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `gameconfig`
--

CREATE TABLE IF NOT EXISTS `gameconfig` (
  `firstmid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dữ liệu bảng `gameconfig`
--

INSERT INTO `gameconfig` (`firstmid`) VALUES
(225);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `ggliaotian`
--

CREATE TABLE IF NOT EXISTS `ggliaotian` (
  `name` text NOT NULL,
  `msg` text CHARACTER SET utf8mb4 NOT NULL,
  `id` int(255) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4138 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `ggliaotian`
--

INSERT INTO `ggliaotian` (`name`, `msg`, `id`, `uid`) VALUES
('道长', '12121', 4059, 422),
('道长', '12121', 4058, 422),
('道长', 'Đạo trưởng Doãn Chí Bình đã sửa một đống bug, game đang cải tiến nâng cấp', 4057, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 冥羽 đã bước lên con đường tu tiên', 4060, 0),
('道长', 'Chào bạn', 4061, 422),
('冥羽', 'Chào', 4062, 424),
('道长', 'Chơi thử xem sao. Có bug giúp phản hồi nhé', 4063, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 黑猫丶 đã bước lên con đường tu tiên', 4064, 0),
('道长', '黑猫Chào bạn', 4065, 422),
('黑猫丶', 'Có ai không', 4066, 425),
('黑猫丶', 'Chơi thế nào', 4067, 425),
('道长', 'Có đây', 4068, 422),
('黑猫丶', '', 4069, 425),
('黑猫丶', 'cái nàyChơi thế nào？', 4070, 425),
('道长', 'Trước tiên tìm trưởng làng ở khu vực đầu tiên để đối thoại', 4071, 422),
('道长', 'Nhận nhiệm vụ rồi đi đánh quái', 4072, 422),
('黑猫丶', '', 4073, 425),
('黑猫丶', 'Ồ', 4074, 425),
('Thông báo hệ thống', 'Vạn trung vô nhất 修罗 đã bước lên con đường tu tiên', 4075, 0),
('道长', 'Ra nói chuyện nào', 4076, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 无敌 đã bước lên con đường tu tiên', 4077, 0),
('道长', '', 4078, 422),
('道长', 'Đã bán một kiếm Thị Huyết ở phường thị', 4079, 422),
('Bách Hiểu Sinh', 'Nghe nói Đạo trưởng đã giết Vô Địch', 4080, 0),
('Thông báo hệ thống', 'Vạn trung vô nhất 提米 đã bước lên con đường tu tiên', 4081, 0),
('道长', 'Đã bán mũ giáp ở phường thị', 4082, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 莫轻狂 đã bước lên con đường tu tiên', 4083, 0),
('Thông báo hệ thống', 'Vạn trung vô nhất 啦啦啦 đã bước lên con đường tu tiên', 4084, 0),
('冥羽', 'Phường thị treo một Ưng lôihộ giáp', 4085, 424),
('道长', 'Nói cho bạn biết bí mật, mang 6 dây chuyền Ưng Huyết Lệ rất mạnh', 4086, 422),
('冥羽', 'Đúng vậy', 4087, 424),
('冥羽', '5 dây chuyền 1 vũ khí', 4088, 424),
('冥羽', '4 dây chuyền 1 vũ khí 1 vẫn thiết cũng không tồi', 4089, 424),
('道长', '5 cáiDao găm hắc malợi hại', 4090, 422),
('道长', 'Còn có trang bị từ nhiệm vụ đánh 30 con kỳ lân thú, mang 6 cái càng mạnh', 4091, 422),
('冥羽', 'Đợi tôi đánh được đã', 4092, 424),
('道长', 'Bạn còn đủ tiền để đột phá cấp không, tôi bị kẹt ở cấp 8 không đủ tiền đột phá', 4093, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 黑猫丶 đã bước lên con đường tu tiên', 4094, 0),
('冥羽', 'Sắp hết tiền rồi', 4095, 424),
('黑猫丶', 'Đạo trưởng có thể tra dữ liệu không', 4096, 431),
('黑猫丶', 'Tôi không nhớ mật khẩu tài khoản cũ', 4097, 431),
('黑猫丶', '', 4098, 431),
('道长', 'Tài khoản cũ của bạn cũng mới cấp 1 thôi, không sao', 4099, 422),
('黑猫丶', 'Được thôi', 4100, 431),
('冥羽', 'Treo phường thị rồi', 4101, 424),
('道长', 'Tôi còn thiếu 2 trang bị', 4102, 422),
('冥羽', 'Đợi chút', 4103, 424),
('冥羽', 'Tôi farm sơn sao', 4104, 424),
('黑猫丶', 'Tôi nghĩ, nhấn nút đừng làm mới giao diện, hơi phiền', 4105, 431),
('道长', 'Đây là thực thi cmd, làm mới sau lấy kết quả', 4106, 422),
('黑猫丶', '', 4107, 431),
('道长', 'Thông thường chỉ có chat mới làm mới', 4108, 422),
('黑猫丶', 'Có thể như tấn công, không làm mới', 4109, 431),
('冥羽', 'Giết 50 chiến sĩ có hơi nhiều không', 4110, 424),
('道长', 'Không nhiều, trước tôi cứ farm, 6 thanh kiếm hút máu trung phẩm', 4111, 422),
('道长', 'Chat có vẻ có thể làm mới thủ công. Sẽ xem xét', 4112, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 小焱夏 đã bước lên con đường tu tiên', 4113, 0),
('黑猫丶', 'Điện thoại có thể dùng script không', 4114, 431),
('冥羽', 'Tải Auto Genie, tự làm script', 4115, 424),
('黑猫丶', 'Đạo trưởng không làm script à', 4116, 431),
('冥羽', 'Không biết, tôi toàn click chuột', 4117, 424),
('黑猫丶', 'Bán đồ rẻ', 4118, 431),
('冥羽', 'Tại sao đánh quái không rơi trang bị vậy', 4119, 424),
('黑猫丶', 'Có ai không', 4120, 425),
('道长', 'Tôi sắp sửa xong bug', 4121, 422),
('道长', 'thì có thể hỗ trợ chat không cần làm mới', 4122, 422),
('道长', 'Xong rồi', 4123, 422),
('道长', 'Bug trò chuyện đã sửa xong', 4124, 422),
('道长', 'các bạn gửibug，tôi đã thêm ghi chú ở sau thời gian là đã sửaXong rồi', 4125, 422),
('道长', '12121', 4126, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 道长 đã bước lên con đường tu tiên', 4127, 0),
('Thông báo hệ thống', 'Vạn trung vô nhất 太长 đã bước lên con đường tu tiên', 4128, 0),
('太长', 'Nổi bọt', 4129, 434),
('道长', 'Hehe, bây giờ chat sẽ không gửi ký tự trống nữa', 4130, 422),
('太长', 'Đưa ra một số tối ưu: 1. Nút tấn công trong màn hình chiến đấu có thể để ở góc dưới trái không, hoặc nút tấn công trong màn hình thông tin quái có thể để bên cạnh không: 2. Bán đồ hy vọng có thể cho thông báo, không thì tay lỡ nhấn bán là... 3. Nghĩ ra sẽ nói', 4131, 434),
('道长', 'Có thể gửi bug. Có nút', 4132, 422),
('黑猫丶', 'Được', 4133, 431),
('道长', 'Hôm nay có thời gian sửa bug, có ý tưởng làm trang quản lý người chơi để xóa dữ liệu', 4134, 422),
('Thông báo hệ thống', 'Vạn trung vô nhất 代码李 đã bước lên con đường tu tiên', 4135, 0),
('Thông báo hệ thống', 'Vạn trung vô nhất 你大爷 đã bước lên con đường tu tiên', 4136, 0),
('Thông báo hệ thống', 'Vạn trung vô nhất 大梦想家 đã bước lên con đường tu tiên', 4137, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `guaiwu`
--

CREATE TABLE IF NOT EXISTS `guaiwu` (
  `gname` text CHARACTER SET utf8 NOT NULL,
  `glv` text NOT NULL,
  `id` int(11) NOT NULL,
  `ginfo` text CHARACTER SET utf8 NOT NULL,
  `gsex` varchar(255) NOT NULL,
  `ghp` int(11) NOT NULL,
  `ggj` int(11) NOT NULL,
  `gfy` int(11) NOT NULL,
  `gbj` int(11) NOT NULL,
  `gxx` int(11) NOT NULL,
  `gzb` text NOT NULL,
  `dljv` int(11) NOT NULL,
  `gdj` text NOT NULL,
  `djjv` int(11) NOT NULL,
  `gyp` text NOT NULL,
  `ypjv` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=gb2312;

--
-- Dữ liệu bảng `guaiwu`
--

INSERT INTO `guaiwu` (`gname`, `glv`, `id`, `ginfo`, `gsex`, `ghp`, `ggj`, `gfy`, `gbj`, `gxx`, `gzb`, `dljv`, `gdj`, `djjv`, `gyp`, `ypjv`) VALUES
('Ong cánh cứng', '1', 55, 'Ong cánh cứng', 'Nam', 40, 5, 3, 0, 0, '23', 10, '8', 30, '6', 8),
('Lợn rừng', '1', 56, 'Lợn ở trên núi', 'Nam', 40, 4, 4, 0, 0, '24', 10, '1', 2, '', 0),
('Hổ', '2', 57, 'Hổ hung dữ', 'Đực', 70, 8, 6, 0, 0, '25', 10, '1', 3, '', 0),
('Yêu hoa', '3', 58, 'Yêu hoa, tiểu yêu', 'Nữ', 110, 15, 7, 0, 0, '26', 10, '1', 4, '', 0),
('Sói hoang hung bạo', '6', 62, 'Sói hoang hung bạo', 'Nam', 190, 23, 19, 0, 0, '28', 20, '1', 5, '', 0),
('Sói hoang thị huyết', '5', 61, 'Sói hoang thị huyết', 'Nam', 160, 22, 16, 0, 0, '28', 20, '1', 5, '', 0),
('Long tước', '7', 63, 'Long tước', 'Nữ', 220, 27, 22, 0, 0, '27', 20, '1,6', 8, '', 0),
('Long tước trăm tuổi', '8', 64, 'Long tước trăm tuổi', 'Nam', 250, 32, 25, 0, 0, '29', 20, '1,6', 7, '', 0),
('Ma hoa sen', '9', 65, 'Ma hoa sen', 'Nữ', 280, 35, 28, 0, 0, '30', 21, '6', 17, '', 0),
('Ưng huyết lôi', '12', 66, 'Ưng huyết lôi', 'Nam', 370, 46, 37, 0, 0, '32', 21, '1', 6, '', 0),
('Ưng lôi', '10', 67, 'Ưng lôi', 'Nam', 310, 38, 31, 0, 0, '31', 21, '1', 5, '', 0),
('Tu sĩ ma đạo', '13', 69, 'Tu sĩ ma đạo', 'Nam', 400, 49, 40, 0, 0, '', 22, '1', 6, '', 0),
('Vượn thông tý ma hóa', '16', 70, 'Vượn thông tý ma hóa', 'Nam', 490, 61, 50, 0, 0, '36', 22, '', 5, '6', 5),
('Khỉ linh ma hóa', '17', 71, 'Khỉ linh ma hóa', 'Nam', 520, 65, 53, 0, 0, '', 5, '1', 5, '', 5),
('Kiếm ma ma hóa', '18', 72, 'Kiếm ma ma hóa', 'Nam', 550, 68, 56, 0, 0, '', 5, '7', 20, '', 5),
('Miêu nữ nhũ trĩ ma hóa', '19', 73, 'Miêu nữ nhũ trĩ ma hóa', 'Nữ', 580, 72, 59, 0, 0, '37', 5, '1,7', 5, '7', 5),
('Nhân quạ ma hóa', '20', 74, 'Nhân quạ ma hóa', 'Nam', 610, 76, 62, 0, 0, '', 5, '7', 5, '', 5),
('Sơn tiêu ma hóa', '21', 75, 'Sơn tiêu ma hóa', 'Nam', 640, 80, 65, 0, 0, '33', 20, '1,7', 20, '7', 20),
('Chiến sĩ man tộc nhập ma', '21', 76, 'Chiến sĩ man tộc nhập ma', 'Nam', 640, 80, 65, 0, 0, '34,35', 7, '1', 7, '7', 7),
('Tế tự man tộc nhập ma', '22', 77, 'Tế tự man tộc nhập ma', 'Nữ', 670, 84, 68, 0, 0, '35', 7, '1', 7, '7', 7),
('Sói man ma hóa', '23', 78, 'Sói man ma hóa', 'Nam', 700, 87, 71, 0, 0, '', 7, '1', 6, '', 7),
('Sư tử cuồng ma hóa', '24', 79, 'Sư tử cuồng ma hóa', 'Nam', 730, 91, 74, 0, 0, '', 7, '1', 6, '', 7),
('Khống thú sư ma đạo', '26', 80, '', 'Nam', 790, 99, 81, 0, 0, '', 7, '1', 6, '', 7),
('Xà quái trăm năm', '27', 81, 'Xà quái tu luyện trăm năm', 'Nam', 820, 103, 84, 0, 0, '', 7, '1', 8, '', 7),
('Thú xích lân', '28', 82, 'Thú xích lân', 'Nam', 850, 106, 87, 0, 0, '', 7, '1,10', 7, '', 7),
('Chuột gai', '29', 83, 'Chuột gai', 'Nam', 880, 110, 90, 0, 0, '38', 7, '9', 20, '', 7),
('Oán linh', '30', 84, 'Oán linh', 'Nữ', 1510, 204, 183, 0, 0, '39', 8, '1', 9, '', 8),
('Nham ma', '31', 85, 'Nham ma', 'Nam', 1560, 211, 189, 0, 0, '40', 8, '1', 8, '', 8),
('Chuột yêu thị linh', '32', 86, 'Chuột yêu thị linh', 'Nam', 1610, 218, 195, 0, 0, '41', 8, '1', 9, '', 8),
('Xà yêu phúc xích luyện', '33', 87, 'Xà yêu phúc xích luyện', 'Nữ', 1660, 224, 201, 0, 0, '42', 9, '1', 9, '8', 9),
('Tê tê trăm năm', '34', 88, 'Tê tê trăm năm\r\nDa dày khí huyết cường thịnh', 'Nam', 2000, 150, 330, 0, 0, '44', 9, '1', 9, '8', 9),
('Hổ thanh cổ', '35', 89, 'Hổ thanh cổ', 'Nam', 1760, 238, 214, 0, 0, '', 5, '1', 5, '', 5),
('Ưng liệt châu', '37', 90, 'Ưng liệt châu', 'Nam', 1860, 252, 226, 0, 0, '', 5, '1', 5, '9', 5),
('Yêu bạch báo', '38', 91, 'Yêu bạch báo', 'Nam', 1910, 258, 232, 0, 0, '43', 5, '1', 5, '', 5),
('Yêu lôi la', '39', 92, 'Yêu lôi la', 'Nữ', 1960, 265, 238, 0, 0, '', 5, '1', 5, '', 5),
('Quạ huyết', '40', 93, 'Quạ huyết', 'Nam', 2010, 272, 244, 0, 0, '', 5, '1', 10, '', 5),
('Vua quạ huyết', '55', 94, 'Vua quạ huyết', 'Nam', 5860, 594, 558, 0, 0, '', 8, '12', 1, '', 8),
('Vua yêu hắc diễm', '56', 95, 'Vua yêu hắc diễm', 'Nữ', 4530, 653, 454, 0, 0, '', 5, '12', 1, '', 5),
('Kẻ kiếp sát', '45', 96, 'Kẻ kiếp sát', 'Nam', 2260, 306, 275, 0, 0, '46', 5, '1', 5, '', 5),
('Quân phản loạn tinh nhuệ', '47', 97, 'Quân phản loạn tinh nhuệ', 'Nam', 2360, 320, 287, 0, 0, '47', 5, '', 5, '', 5),
('Đội trưởng quân phản loạn', '50', 98, 'Đội trưởng quân phản loạn', 'Nam', 3510, 440, 405, 0, 0, '48', 5, '', 5, '', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `im`
--

CREATE TABLE IF NOT EXISTS `im` (
  `imuid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `im`
--

INSERT INTO `im` (`imuid`, `sid`, `uid`) VALUES
(423, 3, 422),
(424, 3, 422),
(426, 0, 424),
(422, 0, 424),
(431, 0, 424);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `imliaotian`
--

CREATE TABLE IF NOT EXISTS `imliaotian` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL,
  `imuid` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dữ liệu bảng `imliaotian`
--

INSERT INTO `imliaotian` (`id`, `name`, `msg`, `uid`, `imuid`) VALUES
(2, '道长', 'Có ai không', 422, 423),
(3, '道长', 'Có ai không', 422, 423),
(4, '道长', '', 422, 423);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `jineng`
--

CREATE TABLE IF NOT EXISTS `jineng` (
  `jnname` varchar(255) NOT NULL,
  `jnid` int(10) unsigned NOT NULL,
  `jngj` int(11) NOT NULL,
  `jnfy` int(11) NOT NULL,
  `jnbj` int(11) NOT NULL,
  `jnxx` int(11) NOT NULL,
  `jndj` int(11) NOT NULL,
  `djcount` int(11) NOT NULL,
  `xiaohao` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `jineng`
--

INSERT INTO `jineng` (`jnname`, `jnid`, `jngj`, `jnfy`, `jnbj`, `jnxx`, `jndj`, `djcount`, `xiaohao`) VALUES
('Chém tụ linh', 4, 10, 0, 0, 2, 6, 5, 0),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 7, 8, 0),
('Man lực phù thể', 6, 7, 7, 7, 7, 9, 8, 0),
('Nộ huyết bộc', 7, 12, 2, 20, 8, 10, 10, 0),
('Thuật thị huyết sơ cấp', 8, 1, 0, 0, 20, 11, 15, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `mid`
--

CREATE TABLE IF NOT EXISTS `mid` (
  `mname` text NOT NULL,
  `mid` int(11) unsigned NOT NULL,
  `mgid` text NOT NULL,
  `mnpc` text NOT NULL,
  `mgtime` datetime NOT NULL,
  `ms` int(11) NOT NULL,
  `midinfo` text NOT NULL,
  `midboss` int(11) NOT NULL,
  `mup` int(11) NOT NULL,
  `mdown` int(11) NOT NULL,
  `mleft` int(11) NOT NULL,
  `mright` int(11) NOT NULL,
  `mqy` int(11) NOT NULL,
  `playerinfo` varchar(255) NOT NULL,
  `ispvp` int(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=gb2312;

--
-- Dữ liệu bảng `mid`
--

INSERT INTO `mid` (`mname`, `mid`, `mgid`, `mnpc`, `mgtime`, `ms`, `midinfo`, `midboss`, `mup`, `mdown`, `mleft`, `mright`, `mqy`, `playerinfo`, `ispvp`) VALUES
('Quảng trường làng', 225, '', '11,17', '0000-00-00 00:00:00', 0, 'Quảng trường trong làng，Lúc rảnh có vẻ nhiều người quay lại đây', 0, 0, 0, 0, 226, 14, '大梦想家 hướng Phía đông làng đi tới', 0),
('Phía đông làng', 226, '', '18', '0000-00-00 00:00:00', 0, 'Phía đông làng', 0, 0, 0, 225, 228, 14, '道长 hướng Quảng trường làng đi tới', 0),
('Cửa làng[chiến đấu]', 228, '55|3,56|2', '', '2020-01-03 00:32:51', 0, 'Cửa làng，Thường có quái vật đến tấn công', 0, 0, 0, 226, 229, 14, '大梦想家 hướng Tiểu thụ lâm đi tới', 1),
('Tiểu thụ lâm', 229, '56|2,57|5', '', '2020-01-03 08:56:08', 0, '', 0, 0, 0, 228, 230, 14, '道长 hướng Sâu trong rừng đi tới', 0),
('Sâu trong rừng', 230, '58|4', '', '2020-01-03 08:56:13', 0, '', 0, 0, 0, 229, 231, 14, '道长 hướng Thành Viêm Dươngtrung tâm đi tới', 0),
('Vùng ngoại vi sơn lâm', 231, '62|3,61|2', '', '2020-01-03 08:25:57', 0, 'Vùng ngoại vi sơn lâm', 0, 0, 0, 230, 232, 14, '太长 hướng Hồ trong núi đi tới', 0),
('Hồ trong núi', 232, '63|2,64|5', '', '2020-01-03 08:24:27', 0, 'Hồ trong núi', 0, 0, 0, 231, 233, 14, '黑猫丶 hướng Vùng ngoại vi sơn lâm đi tới', 0),
('Đảo nhỏ giữa hồ', 233, '65|6', '', '2020-01-02 19:48:28', 0, 'Đảo nhỏ giữa hồ', 0, 0, 0, 232, 235, 14, '黑猫丶 hướng Hồ trong núi đi tới', 0),
('Lối ra phía đông sơn mạch', 235, '66|3,67|4', '', '2020-01-02 20:12:55', 0, '', 0, 0, 0, 233, 236, 14, '黑猫丶 hướng Đảo nhỏ giữa hồ đi tới', 0),
('Ngoại ô phía tây thành', 236, '69|5', '', '2020-01-02 20:18:56', 0, '', 0, 0, 0, 235, 237, 16, '黑猫丶 hướng Lối ra phía đông sơn mạch đi tới', 0),
('Phía tây Thành Tụ Tiên', 237, '', '13,14', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 236, 238, 16, '黑猫丶 hướng Ngoại ô phía tây thành đi tới', 0),
('Phố tây Tụ Tiên', 238, '', '15', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 237, 239, 16, '黑猫丶 hướng Phía tây Thành Tụ Tiên đi tới', 0),
('Trung tâm Thành Tụ Tiên', 239, '', '16,17', '0000-00-00 00:00:00', 0, '', 0, 0, 273, 238, 240, 16, '黑猫丶 hướng Phố tây Tụ Tiên đi tới', 0),
('Phố đông Tụ Tiên', 240, '', '23', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 239, 241, 16, '黑猫丶 hướng Trung tâm Thành Tụ Tiên đi tới', 0),
('Phía đông Thành Tụ Tiên', 241, '', '', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 240, 242, 16, '黑猫丶 hướng Phố đông Tụ Tiên đi tới', 0),
('thànhĐông giao', 242, '70|3,71|2', '', '2020-01-02 20:28:14', 0, '', 0, 0, 0, 241, 243, 16, '黑猫丶 hướng Phía đông Thành Tụ Tiên đi tới', 0),
('Động quật ma hóa', 243, '72|6', '', '2020-01-02 20:23:03', 0, '', 0, 246, 0, 242, 244, 16, '冥羽 hướng Sâu trong động quật đi tới', 0),
('Lối ra động quật', 244, '74|5', '', '2016-08-21 19:01:07', 0, '', 0, 0, 0, 243, 245, 17, '太长 hướng Bình nguyên ma hóa đi tới', 0),
('Bình nguyên ma hóa', 245, '73|4', '', '2020-01-02 21:08:42', 0, '', 0, 0, 0, 244, 247, 17, '太长 hướng Ngoại ô phía tây bộ lạc đi tới', 0),
('Sâu trong động quật', 246, '75|1', '', '2020-01-03 19:48:39', 200, '', 0, 0, 243, 0, 0, 17, '冥羽 hướng Động quật ma hóa đi tới', 0),
('Ngoại ô phía tây bộ lạc', 247, '76|4,77|2', '', '2020-01-02 21:06:03', 0, '', 0, 0, 0, 245, 248, 17, '太长 hướng Phía tây bộ lạc đi tới', 0),
('Phía tây bộ lạc', 248, '', '20', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 247, 249, 17, '太长 hướng Bộ lạctrung tâm đi tới', 0),
('Bộ lạctrung tâm', 249, '', '15,17,21', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 248, 250, 17, '太长 hướng Bộ lạcđông đi tới', 0),
('Bộ lạcđông', 250, '', '19,22', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 249, 251, 17, '太长 hướng Bộ lạcĐông giao đi tới', 0),
('Bộ lạcĐông giao', 251, '78|6', '', '2016-08-23 15:32:59', 0, '', 0, 0, 0, 250, 252, 17, '太长 hướng Bờ sông Man đi tới', 0),
('Bờ sông Man', 252, '78|2,79|4', '', '2016-08-21 13:16:30', 0, '', 0, 0, 0, 251, 253, 17, '太长 hướng Cảng qua sông đi tới', 0),
('Cảng qua sông', 253, '80|5', '', '2016-08-20 13:51:25', 0, '', 0, 0, 0, 252, 254, 17, '太长 hướng Bờ bên kia sông Man đi tới', 0),
('Bờ bên kia sông Man', 254, '81|6', '', '2016-08-20 13:53:02', 0, '', 0, 0, 0, 253, 255, 17, '太长 hướng Sơn lĩnh vị tri1 đi tới', 0),
('Sơn lĩnh vị tri1', 255, '82|7', '', '2016-08-22 06:55:18', 0, '', 0, 0, 0, 254, 256, 18, '太长 hướng Sơn lĩnh vị tri2 đi tới', 0),
('Sơn lĩnh vị tri2', 256, '83|5', '', '2016-08-22 06:55:32', 30, '', 0, 257, 0, 255, 258, 18, '太长 hướng Thành Viêm Dươngtrung tâm đi tới', 0),
('Động núi vô nhân', 257, '84|1', '', '2017-01-04 17:14:02', 200, '', 0, 0, 256, 0, 0, 18, 'Không có vai trò hướng Sơn lĩnh vị tri2 đi tới', 0),
('Sơn lĩnh vị tri3', 258, '85|6', '', '2016-08-21 17:26:27', 200, '', 0, 0, 0, 256, 259, 18, '冥羽 hướng Phía tây cổ trấn Phong Linh đi tới', 0),
('Phía tây cổ trấn Phong Linh', 259, '', '15', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 258, 260, 18, '冥羽 hướng Cổ trấn Phong Linh đi tới', 0),
('Cổ trấn Phong Linh', 260, '', '24', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 259, 261, 18, '冥羽 hướng Phía đông cổ trấn Phong Linh đi tới', 0),
('Phía đông cổ trấn Phong Linh', 261, '', '19', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 260, 262, 18, '冥羽 hướng Bên ngoài rừng yêu thú1 đi tới', 0),
('Bên ngoài rừng yêu thú1', 262, '86|3', '', '2016-08-23 14:30:22', 200, '', 0, 0, 0, 261, 263, 18, '太长 hướng Phía đông cổ trấn Phong Linh đi tới', 0),
('Bên ngoài rừng yêu thú2', 263, '87|7', '', '2016-08-21 09:46:46', 0, '', 0, 0, 0, 262, 264, 18, '太长 hướng Bên ngoài rừng yêu thú1 đi tới', 0),
('Núi yêu thú sâu trong rừng', 264, '88|5', '', '2016-08-23 11:54:01', 100, '', 0, 0, 0, 263, 265, 18, '太长 hướng Bên ngoài rừng yêu thú2 đi tới', 0),
('Chân Vạn Yêu Sơn', 265, '89|4,90|4', '', '2016-08-18 11:28:51', 0, '', 0, 0, 0, 264, 266, 18, '太长 hướng Núi yêu thú sâu trong rừng đi tới', 0),
('Sườn Vạn Yêu Sơn', 266, '91|3,92|5', '', '2016-08-19 10:05:38', 0, '', 0, 268, 267, 265, 269, 18, '太长 hướng Chân Vạn Yêu Sơn đi tới', 0),
('Điện Yêu Vươngngoại vi', 267, '94|3,95|3', '24', '2016-08-22 11:58:20', 0, '', 0, 266, 0, 0, 0, 20, '冥羽 hướng Sườn Vạn Yêu Sơn đi tới', 0),
('Đỉnh Vạn Yêu Sơn', 268, '93|7', '', '2016-08-23 15:34:56', 0, '', 0, 0, 266, 0, 0, 18, '道长 hướng Sườn Vạn Yêu Sơn đi tới', 0),
('Ngoại ô Viêm Dương', 269, '96|4,97|4', '', '2016-08-22 07:01:01', 0, '', 0, 0, 0, 266, 270, 21, '太长 hướng Sườn Vạn Yêu Sơn đi tới', 0),
('Ngoại ô phía tây Viêm Dương', 270, '98|7', '', '2016-08-23 15:33:16', 0, '', 0, 0, 0, 269, 271, 21, '太长 hướng Ngoại ô Viêm Dương đi tới', 0),
('Phố tây Viêm Dương', 271, '', '', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 270, 272, 21, '太长 hướng Ngoại ô phía tây Viêm Dương đi tới', 0),
('Thành Viêm Dươngtrung tâm', 272, '', '24,25', '0000-00-00 00:00:00', 0, '', 0, 0, 0, 271, 0, 21, '道长 hướng Quảng trường làng đi tới', 0),
('Nơi quản lý môn phái', 273, '', '26', '0000-00-00 00:00:00', 0, '', 0, 239, 0, 0, 0, 16, '太长 hướng Trung tâm Thành Tụ Tiên đi tới', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `midguaiwu`
--

CREATE TABLE IF NOT EXISTS `midguaiwu` (
  `id` int(10) unsigned NOT NULL,
  `gname` text NOT NULL,
  `ghp` text NOT NULL,
  `ggj` text NOT NULL,
  `gfy` text NOT NULL,
  `glv` text NOT NULL,
  `mid` int(11) NOT NULL,
  `gyid` int(11) NOT NULL,
  `gexp` text NOT NULL,
  `sid` text NOT NULL,
  `gmaxhp` varchar(255) NOT NULL,
  `gbj` int(11) NOT NULL,
  `gxx` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2315092 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `midguaiwu`
--

INSERT INTO `midguaiwu` (`id`, `gname`, `ghp`, `ggj`, `gfy`, `glv`, `mid`, `gyid`, `gexp`, `sid`, `gmaxhp`, `gbj`, `gxx`) VALUES
(2305732, 'Chuột gai', '880', '110', '90', '29', 256, 83, '218', '', '880', 0, 0),
(2280014, 'Yêu lôi la', '1474', '265', '238', '39', 266, 92, '254', '099f465c0c34dd5ef59f230a21447af4', '1960', 0, 0),
(2315087, 'Yêu hoa', '110', '15', '7', '3', 230, 58, '23', '', '110', 0, 0),
(2315086, 'Hổ', '70', '8', '6', '2', 229, 57, '15', '', '70', 0, 0),
(2313688, 'Sói man ma hóa', '700', '87', '71', '23', 251, 78, '150', '', '700', 0, 0),
(2313690, 'Sói man ma hóa', '700', '87', '71', '23', 251, 78, '150', '', '700', 0, 0),
(2313692, 'Đội trưởng quân phản loạn', '3510', '440', '405', '50', 270, 98, '375', '', '3510', 0, 0),
(2305736, 'Chuột gai', '880', '110', '90', '29', 256, 83, '218', '', '880', 0, 0),
(2305729, 'Thú xích lân', '850', '106', '87', '28', 255, 82, '238', '', '850', 0, 0),
(2253163, 'Lợn rừng', '40', '4', '4', '1', 228, 56, '8', '0e698c7ec2d718b658fa287c45929571', '40', 0, 0),
(2305764, 'Quân phản loạn tinh nhuệ', '2360', '320', '287', '47', 269, 97, '400', '', '2360', 0, 0),
(2313696, 'Đội trưởng quân phản loạn', '3510', '440', '405', '50', 270, 98, '375', '', '3510', 0, 0),
(2314933, 'Chiến sĩ man tộc nhập ma', '640', '80', '65', '21', 247, 76, '137', '', '640', 0, 0),
(2305761, 'Kẻ kiếp sát', '2260', '306', '275', '45', 269, 96, '293', '', '2260', 0, 0),
(2297445, 'Xà yêu phúc xích luyện', '1660', '224', '201', '33', 263, 87, '281', '', '1660', 0, 0),
(2297446, 'Xà yêu phúc xích luyện', '1660', '224', '201', '33', 263, 87, '281', '', '1660', 0, 0),
(2302424, 'Nhân quạ ma hóa', '610', '76', '62', '20', 244, 74, '170', '', '610', 0, 0),
(2314939, 'Miêu nữ nhũ trĩ ma hóa', '580', '72', '59', '19', 245, 73, '162', '', '580', 0, 0),
(2305762, 'Kẻ kiếp sát', '2260', '306', '275', '45', 269, 96, '293', '', '2260', 0, 0),
(2315075, 'Sói hoang hung bạo', '190', '23', '19', '6', 231, 62, '51', '', '190', 0, 0),
(2305728, 'Thú xích lân', '850', '106', '87', '28', 255, 82, '238', '', '850', 0, 0),
(2299847, 'Sói man ma hóa', '700', '87', '71', '23', 252, 78, '173', '', '700', 0, 0),
(2299850, 'Sư tử cuồng ma hóa', '730', '91', '74', '24', 252, 79, '180', '', '730', 0, 0),
(2299851, 'Sư tử cuồng ma hóa', '730', '91', '74', '24', 252, 79, '180', '', '730', 0, 0),
(2315082, 'Hổ', '70', '8', '6', '2', 229, 57, '15', '', '70', 0, 0),
(2313686, 'Sói man ma hóa', '700', '87', '71', '23', 251, 78, '150', '', '700', 0, 0),
(2313687, 'Sói man ma hóa', '700', '87', '71', '23', 251, 78, '150', '', '700', 0, 0),
(2305763, 'Quân phản loạn tinh nhuệ', '2360', '320', '287', '47', 269, 97, '400', '', '2360', 0, 0),
(2313645, 'Tê tê trăm năm', '2000', '150', '330', '34', 264, 88, '255', '', '2000', 0, 0),
(2314800, 'Vượn thông tý ma hóa', '490', '61', '50', '16', 242, 70, '120', '', '490', 0, 0),
(2302033, 'Nham ma', '1560', '211', '189', '31', 258, 85, '202', '', '1560', 0, 0),
(2305759, 'Kẻ kiếp sát', '2260', '306', '275', '45', 269, 96, '293', '', '2260', 0, 0),
(2305760, 'Kẻ kiếp sát', '2260', '306', '275', '45', 269, 96, '293', '', '2260', 0, 0),
(2315084, 'Hổ', '70', '8', '6', '2', 229, 57, '15', '', '70', 0, 0),
(2302037, 'Nham ma', '1560', '211', '189', '31', 258, 85, '202', '', '1560', 0, 0),
(2290134, 'Xà quái trăm năm', '820', '103', '84', '27', 254, 81, '176', '', '820', 0, 0),
(2314941, 'Miêu nữ nhũ trĩ ma hóa', '580', '72', '59', '19', 245, 73, '162', '', '580', 0, 0),
(2313693, 'Đội trưởng quân phản loạn', '3510', '440', '405', '50', 270, 98, '375', '', '3510', 0, 0),
(2305765, 'Quân phản loạn tinh nhuệ', '2360', '320', '287', '47', 269, 97, '400', '', '2360', 0, 0),
(2269220, 'Hổ thanh cổ', '1760', '238', '214', '35', 265, 89, '263', '', '1760', 0, 0),
(2290131, 'Xà quái trăm năm', '820', '103', '84', '27', 254, 81, '176', '', '820', 0, 0),
(2314938, 'Miêu nữ nhũ trĩ ma hóa', '580', '72', '59', '19', 245, 73, '162', '', '580', 0, 0),
(2314794, 'Kiếm ma ma hóa', '550', '68', '56', '18', 243, 72, '117', '', '550', 0, 0),
(2314793, 'Kiếm ma ma hóa', '550', '68', '56', '18', 243, 72, '117', '', '550', 0, 0),
(2305734, 'Chuột gai', '880', '110', '90', '29', 256, 83, '218', '', '880', 0, 0),
(2315078, 'Sói hoang thị huyết', '160', '22', '16', '5', 231, 61, '33', '', '160', 0, 0),
(2302474, 'Vượn thông tý ma hóa', '490', '61', '50', '16', 242, 70, '136', '781a121e409741ff53f5978578067146', '490', 0, 0),
(2249197, 'Sói man ma hóa', '700', '87', '71', '23', 251, 78, '173', 'e0e644a3727f0f1671e917f7b376c66f', '700', 0, 0),
(2313514, 'Sói hoang hung bạo', '144', '23', '19', '6', 231, 62, '45', 'bb2a45b7652a7900e7810128a329597e', '190', 0, 0),
(2280013, 'Yêu lôi la', '1960', '265', '238', '39', 266, 92, '254', '', '1960', 0, 0),
(2302427, 'Nhân quạ ma hóa', '610', '76', '62', '20', 244, 74, '170', '', '610', 0, 0),
(2313695, 'Đội trưởng quân phản loạn', '3510', '440', '405', '50', 270, 98, '375', '', '3510', 0, 0),
(2313641, 'Tê tê trăm năm', '2000', '150', '330', '34', 264, 88, '255', '', '2000', 0, 0),
(2314758, 'Ưng lôi', '310', '38', '31', '10', 235, 67, '85', '', '310', 0, 0),
(2290121, 'Khống thú sư ma đạo', '790', '99', '81', '26', 253, 80, '169', '', '790', 0, 0),
(2280015, 'Yêu lôi la', '1960', '265', '238', '39', 266, 92, '254', '', '1960', 0, 0),
(2313678, 'Chuột yêu thị linh', '1610', '218', '195', '32', 262, 86, '208', '', '1610', 0, 0),
(2305733, 'Chuột gai', '880', '110', '90', '29', 256, 83, '218', '', '880', 0, 0),
(2315090, 'Yêu hoa', '110', '15', '7', '3', 230, 58, '23', '', '110', 0, 0),
(2297451, 'Xà yêu phúc xích luyện', '1660', '224', '201', '33', 263, 87, '281', '', '1660', 0, 0),
(2313642, 'Tê tê trăm năm', '2000', '150', '330', '34', 264, 88, '255', '', '2000', 0, 0),
(2315079, 'Sói hoang thị huyết', '160', '22', '16', '5', 231, 61, '33', '', '160', 0, 0),
(2313679, 'Chuột yêu thị linh', '1610', '218', '195', '32', 262, 86, '208', '', '1610', 0, 0),
(2305727, 'Thú xích lân', '850', '106', '87', '28', 255, 82, '238', '', '850', 0, 0),
(2302426, 'Nhân quạ ma hóa', '610', '76', '62', '20', 244, 74, '170', '', '610', 0, 0),
(2302036, 'Nham ma', '1560', '211', '189', '31', 258, 85, '202', '', '1560', 0, 0),
(2308269, 'Vua yêu hắc diễm', '4530', '653', '454', '56', 267, 95, '420', '', '4530', 0, 0),
(2314802, 'Khỉ linh ma hóa', '520', '65', '53', '17', 242, 71, '111', '', '520', 0, 0),
(2314785, 'Tu sĩ ma đạo', '400', '49', '40', '13', 236, 69, '111', '', '400', 0, 0),
(2315088, 'Yêu hoa', '110', '15', '7', '3', 230, 58, '23', '', '110', 0, 0),
(2315085, 'Hổ', '70', '8', '6', '2', 229, 57, '15', '', '70', 0, 0),
(2314940, 'Miêu nữ nhũ trĩ ma hóa', '580', '72', '59', '19', 245, 73, '162', '', '580', 0, 0),
(2315089, 'Yêu hoa', '110', '15', '7', '3', 230, 58, '23', '', '110', 0, 0),
(2313710, 'Quạ huyết', '2010', '272', '244', '40', 268, 93, '260', '', '2010', 0, 0),
(2313709, 'Quạ huyết', '2010', '272', '244', '40', 268, 93, '260', '', '2010', 0, 0),
(2313691, 'Đội trưởng quân phản loạn', '3510', '440', '405', '50', 270, 98, '375', '', '3510', 0, 0),
(2314784, 'Tu sĩ ma đạo', '400', '49', '40', '13', 236, 69, '111', '', '400', 0, 0),
(2314719, 'Ma hoa sen', '280', '35', '28', '9', 233, 65, '68', '', '280', 0, 0),
(2314720, 'Ma hoa sen', '280', '35', '28', '9', 233, 65, '68', '', '280', 0, 0),
(2314721, 'Ma hoa sen', '280', '35', '28', '9', 233, 65, '68', '', '280', 0, 0),
(2314760, 'Ưng lôi', '310', '38', '31', '10', 235, 67, '85', '', '310', 0, 0),
(2315083, 'Hổ', '70', '8', '6', '2', 229, 57, '15', '', '70', 0, 0),
(2314231, 'Oán linh', '1510', '204', '183', '30', 257, 84, '225', '', '1510', 0, 0),
(2314782, 'Tu sĩ ma đạo', '400', '49', '40', '13', 236, 69, '111', '', '400', 0, 0),
(2315009, 'Ong cánh cứng', '40', '5', '3', '1', 228, 55, '8', '', '40', 0, 0),
(2314759, 'Ưng lôi', '310', '38', '31', '10', 235, 67, '85', '', '310', 0, 0),
(2315066, 'Long tước trăm tuổi', '250', '32', '25', '8', 232, 64, '60', '', '250', 0, 0),
(2315067, 'Long tước trăm tuổi', '250', '32', '25', '8', 232, 64, '60', '', '250', 0, 0),
(2315068, 'Long tước trăm tuổi', '250', '32', '25', '8', 232, 64, '60', '', '250', 0, 0),
(2315077, 'Sói hoang hung bạo', '190', '23', '19', '6', 231, 62, '51', '', '190', 0, 0),
(2315076, 'Sói hoang hung bạo', '190', '23', '19', '6', 231, 62, '51', '', '190', 0, 0),
(2315069, 'Long tước trăm tuổi', '250', '32', '25', '8', 232, 64, '60', '', '250', 0, 0),
(2314722, 'Ma hoa sen', '280', '35', '28', '9', 233, 65, '68', '', '280', 0, 0),
(2314723, 'Ma hoa sen', '280', '35', '28', '9', 233, 65, '68', '', '280', 0, 0),
(2314801, 'Khỉ linh ma hóa', '520', '65', '53', '17', 242, 71, '111', '', '520', 0, 0),
(2315081, 'Lợn rừng', '40', '4', '4', '1', 229, 56, '9', '', '40', 0, 0),
(2314792, 'Kiếm ma ma hóa', '550', '68', '56', '18', 243, 72, '117', '', '550', 0, 0),
(2315063, 'Long tước', '220', '27', '22', '7', 232, 63, '53', '', '220', 0, 0),
(2315064, 'Long tước', '220', '27', '22', '7', 232, 63, '53', '', '220', 0, 0),
(2315065, 'Long tước trăm tuổi', '250', '32', '25', '8', 232, 64, '60', '', '250', 0, 0),
(2314755, 'Ưng huyết lôi', '370', '46', '37', '12', 235, 66, '90', '', '370', 0, 0),
(2314756, 'Ưng huyết lôi', '370', '46', '37', '12', 235, 66, '90', '', '370', 0, 0),
(2314757, 'Ưng huyết lôi', '370', '46', '37', '12', 235, 66, '90', '', '370', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `npc`
--

CREATE TABLE IF NOT EXISTS `npc` (
  `id` int(11) unsigned NOT NULL,
  `nname` text CHARACTER SET utf8 NOT NULL,
  `nsex` varchar(255) NOT NULL,
  `ninfo` text CHARACTER SET utf8 NOT NULL,
  `muban` text NOT NULL,
  `taskid` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=gb2312;

--
-- Dữ liệu bảng `npc`
--

INSERT INTO `npc` (`id`, `nname`, `nsex`, `ninfo`, `muban`, `taskid`) VALUES
(11, 'Trưởng làng', 'Nam', 'Trưởng làng', '', '13,25,24,28'),
(13, 'Vua Lão Ngũ', 'Nam', 'Haizz... Ngày tháng một mình, thật sự khó quá.', '', '24'),
(14, 'Hách Bỉnh', 'Nam', 'Haizz, suốt ngày đứng ở đây thật vô liêu.', '', '28'),
(15, '周富贵[Thương nhân]', 'Nam', 'Lại đây lại đây   rẻ', 'Cửa hàng.php', ''),
(16, 'Thành Tụ Tiênchủ[phù lục]', 'Nam', 'Thành Tụ Tiênthànhchủ', 'Đổi kỹ năng.php', ''),
(18, 'vươngĐại mẫu', 'Nữ', 'vươngĐại mẫu', '', '24,29'),
(17, 'Tiên y du hành[trị liệu]', 'Nam', 'Tiên y du hành，Dường như ở đâu cũng thấy hắn', 'trị liệu.php', ''),
(19, 'Đại sư phù lục', 'Nam', 'Kỹ năng đại sư，Phụ trách đổi kỹ năng', 'Đổi kỹ năng.php', ''),
(20, 'Tiểu Man', 'Nữ', 'Tiểu Man sợ quá...', '', '20'),
(21, 'Trưởng lão man tộc', 'Nam', 'Trưởng lão man tộc', '', '19'),
(22, 'Thợ săn man tộc', 'Nam', 'già rồi,Làm không động nổi', '', '21'),
(23, 'Đại sứ đổi quà', 'Nam', 'Đại sứ đổi quà', '', '27'),
(24, 'Tiên y chính quy', 'Nam', 'Tiên y chính quy\r\nGiỏi hơn cả tiên y du hành', 'trị liệu_cấp bậc1.php', ''),
(25, 'Thành chủ Tuyết Cầm', 'Nữ', 'Thành chủ Thành Viêm Dương, Tuyết Cầm', '', ''),
(26, 'Quản lý viên môn phái', 'Nam', 'Quản lý môn phái', 'Quản lý viên môn phái.php', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng `playerchongwu`
--

CREATE TABLE IF NOT EXISTS `playerchongwu` (
  `cwid` int(11) NOT NULL,
  `cwname` varchar(255) NOT NULL,
  `cwhp` int(11) NOT NULL,
  `cwmaxhp` int(11) NOT NULL,
  `cwgj` int(11) NOT NULL,
  `cwfy` int(11) NOT NULL,
  `cwbj` int(11) NOT NULL,
  `cwxx` int(11) NOT NULL,
  `cwlv` int(11) NOT NULL,
  `cwexp` int(11) NOT NULL,
  `tool1` int(11) NOT NULL,
  `tool2` int(11) NOT NULL,
  `tool3` int(11) NOT NULL,
  `tool4` int(11) NOT NULL,
  `tool5` int(11) NOT NULL,
  `tool6` int(11) NOT NULL,
  `sid` varchar(255) NOT NULL,
  `uphp` int(11) NOT NULL,
  `upgj` int(11) NOT NULL,
  `upfy` int(11) NOT NULL,
  `cwpz` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3593 DEFAULT CHARSET=utf8mb4;

--
-- Dữ liệu bảng `playerchongwu`
--

INSERT INTO `playerchongwu` (`cwid`, `cwname`, `cwhp`, `cwmaxhp`, `cwgj`, `cwfy`, `cwbj`, `cwxx`, `cwlv`, `cwexp`, `tool1`, `tool2`, `tool3`, `tool4`, `tool5`, `tool6`, `sid`, `uphp`, `upgj`, `upfy`, `cwpz`) VALUES
(3562, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'c8268cce88c9be2636fd0c06e03bee40', 23, 5, 4, 0),
(3548, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '592857bc812f813ed52fa8b187582fc2', 20, 5, 7, 2),
(2861, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 4, 2),
(3547, 'Rồng ngầu ngầu', 276, 276, 50, 48, 0, 0, 12, 5055, 0, 0, 0, 0, 0, 0, '592857bc812f813ed52fa8b187582fc2', 12, 3, 3, 3),
(3546, 'Gà đản đản', 50, 110, 9, 10, 0, 0, 2, 104, 0, 0, 0, 0, 0, 0, '8bf2c38ba9d08fd609a3d40b35ea659c', 9, 3, 5, 1),
(3545, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '8bf2c38ba9d08fd609a3d40b35ea659c', 23, 3, 6, 0),
(3544, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '5f2f53403bda85d4fee078d944dd6d7e', 16, 3, 7, 0),
(3570, 'Rồng ngầu ngầu', 78, 122, 14, 10, 0, 0, 3, 197, 0, 0, 0, 0, 0, 0, '4e079b4084dcdd84cf4393a003a38283', 11, 4, 3, 0),
(3543, 'Rồng ngầu ngầu', -4, 100, 6, 4, 0, 0, 1, 120, 0, 0, 0, 0, 0, 0, '5f2f53403bda85d4fee078d944dd6d7e', 24, 3, 8, 3),
(2868, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 3, 8, 0),
(3541, 'Ngựa lưu lưu', 560, 560, 98, 165, 0, 0, 24, 1391, 0, 0, 0, 0, 0, 0, '775c0ff651b405a676fc9ee1729302f4', 18, 4, 6, 1),
(3536, 'Rồng ngầu ngầu', 227, 290, 26, 84, 0, 0, 11, 3511, 0, 0, 0, 0, 0, 0, 'c4339dfb63d53dbe95ff3f1297cd889d', 16, 2, 7, 2),
(2873, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 6, 8, 3),
(3535, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'a825614fde737c782675ea17eb88b206', 14, 5, 6, 2),
(3534, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'a825614fde737c782675ea17eb88b206', 9, 5, 5, 3),
(3533, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '68165aaec3d39dae1839882ac72de2b2', 12, 3, 7, 1),
(3532, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'cb3012bb47999fed316151ffd12a0da6', 13, 3, 5, 2),
(3531, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'cb3012bb47999fed316151ffd12a0da6', 8, 3, 4, 2),
(3530, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b93636fdca6a8e1edef742d667e18c8a', 9, 2, 8, 4),
(3529, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b93636fdca6a8e1edef742d667e18c8a', 10, 5, 3, 2),
(3528, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '91ec5e467841b175a85ca5ef02ef7aa9', 15, 5, 4, 0),
(3527, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '91ec5e467841b175a85ca5ef02ef7aa9', 9, 2, 5, 3),
(3526, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '0f16fd6082fd46fdeab5a5bb6be32dc4', 8, 5, 3, 0),
(3525, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '0f16fd6082fd46fdeab5a5bb6be32dc4', 24, 4, 8, 0),
(3524, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '684051aec8cc8472206087dc2658ae7c', 20, 4, 4, 2),
(2888, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 6, 6, 1),
(3523, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '684051aec8cc8472206087dc2658ae7c', 15, 3, 7, 1),
(2890, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 5, 6, 1),
(2892, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 8, 4, 1),
(3522, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af54af4a9b880d02dcd60fc1b0524dd7', 9, 3, 7, 0),
(3521, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af54af4a9b880d02dcd60fc1b0524dd7', 15, 4, 7, 2),
(3520, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '28f1763df68c4afdf505d27c70a8983b', 9, 2, 5, 2),
(2896, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 8, 7, 1),
(3519, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '28f1763df68c4afdf505d27c70a8983b', 20, 4, 3, 3),
(3518, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '2f6777e7be5fed1b94c413bf443efc5f', 16, 5, 5, 5),
(3516, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'ee1a9e463a83eeeaf317e9dc8a1c35a8', 19, 4, 8, 1),
(3515, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'ee1a9e463a83eeeaf317e9dc8a1c35a8', 18, 5, 4, 0),
(3514, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'ce9e08f15f3a59f355798b90bd0d3fb4', 13, 4, 8, 0),
(3513, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'ce9e08f15f3a59f355798b90bd0d3fb4', 18, 5, 4, 0),
(2904, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 4, 6, 1),
(3512, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b102ed029de6d7454172c3352b103110', 9, 3, 5, 3),
(3511, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b102ed029de6d7454172c3352b103110', 9, 4, 3, 1),
(2907, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 4, 2),
(3469, 'Trâu ngốc ngốc', 92, 100, 6, 4, 0, 0, 1, 34, 0, 0, 0, 0, 0, 0, 'ca0904a308346c194ff8ec780ccf6736', 8, 2, 3, 0),
(3468, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '4f49b5eb675277e6401832966f112262', 25, 5, 5, 0),
(2910, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 8, 4, 0),
(2912, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 5, 5, 1),
(2913, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 6, 5, 1),
(2914, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 8, 4, 1),
(3467, 'Ngựa lưu lưu', 91, 100, 6, 4, 0, 0, 1, 8, 0, 0, 0, 0, 0, 0, '4f49b5eb675277e6401832966f112262', 23, 2, 4, 0),
(2916, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 7, 6, 1),
(2917, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 5, 7, 2),
(3465, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'ea5a17b7f6c42320f7c242f2871a0f8d', 21, 5, 3, 0),
(2919, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 4, 8, 0),
(3466, 'Ngựa lưu lưu', 247, 262, 30, 64, 0, 0, 7, 287, 0, 0, 0, 0, 0, 0, 'ea5a17b7f6c42320f7c242f2871a0f8d', 21, 3, 8, 3),
(2922, 'Cừu mê mê', 100, 276, 182, 132, 0, 0, 17, 5205, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 8, 6, 4),
(2923, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 5, 6, 1),
(2924, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 8, 5, 0),
(2925, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 6, 6, 0),
(2926, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 4, 8, 0),
(2927, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 5, 7, 0),
(2928, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 4, 8, 3),
(2929, 'Cừu mê mê', 28, 352, 96, 58, 0, 0, 13, 5588, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 8, 4, 5),
(2930, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 4, 8, 3),
(2931, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 7, 6, 3),
(2932, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 4, 5, 1),
(2933, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 7, 6, 2),
(2934, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 4, 8, 1),
(2935, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 6, 8, 1),
(2936, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 6, 5, 0),
(2937, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 3, 4, 0),
(2938, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 8, 5, 0),
(2939, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 6, 8, 3),
(2940, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 5, 5, 5),
(2941, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 3, 6, 2),
(2942, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 8, 5, 1),
(2943, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 8, 3, 0),
(2944, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 8, 5, 1),
(2945, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 7, 7, 3),
(2946, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 4, 7, 0),
(2947, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 8, 7, 0),
(2948, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 5, 5, 0),
(2949, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 5, 0),
(2950, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 3, 6, 0),
(2951, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 7, 4, 1),
(2952, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 8, 5, 2),
(2953, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 4, 7, 3),
(2954, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 6, 3, 0),
(2955, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 4, 3),
(2956, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 7, 4, 0),
(2957, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 4, 7, 1),
(2958, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 8, 7, 1),
(2959, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 6, 8, 0),
(2960, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 5, 3, 4),
(2962, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 7, 5, 0),
(2963, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 8, 6, 0),
(2964, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 5, 5, 0),
(2965, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 8, 3, 0),
(2966, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 8, 5, 1),
(2967, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 3, 4, 2),
(2968, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 4, 4, 1),
(2969, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 7, 8, 0),
(2970, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 4, 3, 0),
(2971, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 6, 4, 1),
(2972, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 8, 8, 0),
(2973, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 6, 2),
(2974, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 8, 8, 2),
(2975, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 8, 3, 1),
(2976, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 4, 6, 4),
(2977, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 7, 7, 1),
(2978, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 6, 3, 2),
(2979, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 7, 4, 1),
(2980, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 3, 4, 0),
(2981, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 8, 6, 1),
(2982, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 5, 4, 0),
(2983, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 7, 3, 2),
(2984, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 8, 6, 0),
(2985, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 4, 7, 0),
(2986, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 5, 7, 2),
(2987, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 8, 4, 2),
(2988, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 7, 6, 1),
(2989, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 7, 5, 0),
(2990, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 3, 5, 2),
(2991, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 7, 4, 4),
(2992, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 4, 3, 0),
(2993, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 3, 7, 2),
(2994, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 5, 5, 1),
(2995, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 4, 3, 0),
(2996, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 3, 4, 1),
(2997, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 3, 8, 0),
(2998, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 5, 6, 1),
(2999, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 5, 8, 1),
(3000, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 3, 5, 4),
(3001, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 6, 6, 1),
(3002, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 8, 4, 1),
(3003, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 6, 8, 0),
(3004, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 3, 8, 0),
(3005, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 3, 4, 1),
(3006, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 7, 3, 0),
(3007, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 8, 1),
(3008, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 7, 7, 1),
(3009, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 3, 6, 1),
(3010, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 3, 4, 1),
(3011, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 5, 8, 1),
(3012, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 8, 4, 0),
(3013, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 3, 3, 0),
(3014, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 8, 8, 0),
(3015, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 3, 5, 0),
(3016, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 7, 7, 0),
(3017, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 6, 5, 2),
(3067, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 5, 3, 0),
(3018, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 8, 6, 1),
(3019, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 3, 0),
(3020, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 7, 3, 2),
(3021, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 7, 0),
(3022, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 5, 3, 1),
(3023, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 4, 4, 2),
(3024, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 6, 7, 0),
(3025, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 7, 0),
(3026, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 7, 6, 0),
(3027, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 4, 8, 1),
(3028, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 4, 5, 3),
(3029, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 8, 4, 0),
(3030, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 7, 8, 1),
(3031, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 5, 5, 1),
(3032, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 6, 6, 0),
(3033, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 8, 6, 1),
(3034, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 3, 7, 0),
(3035, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 6, 8, 2),
(3036, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 4, 7, 0),
(3037, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 8, 8, 3),
(3038, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 5, 3),
(3039, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 6, 5, 3),
(3040, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 5, 6, 2),
(3041, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 3, 8, 1),
(3042, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 4, 6, 1),
(3043, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 6, 5, 1),
(3044, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 8, 7, 1),
(3045, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 8, 5, 0),
(3046, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 7, 7, 2),
(3047, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 5, 4, 1),
(3048, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 5, 7, 1),
(3049, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 8, 8, 0),
(3050, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 5, 6, 0),
(3051, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 7, 7, 1),
(3052, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 6, 4, 0),
(3053, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 4, 3, 1),
(3054, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 3, 4, 0),
(3055, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 6, 6, 2),
(3056, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 4, 7, 0),
(3057, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 5, 4, 3),
(3058, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 3, 5, 1),
(3059, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 6, 5, 1),
(3060, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 3, 8, 1),
(3061, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 4, 3, 1),
(3062, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 8, 3, 3),
(3063, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 7, 7, 1),
(3064, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 6, 7, 2),
(3065, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 7, 4, 0),
(3066, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 4, 3, 1),
(3068, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 6, 3, 0),
(3069, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 4, 4, 3),
(3070, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 7, 6, 0),
(3071, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 3, 8, 3),
(3072, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 5, 8, 0),
(3073, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 5, 4, 0),
(3074, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 8, 5, 2),
(3075, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 5, 3, 2),
(3076, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 5, 4, 2),
(3077, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 7, 4, 2),
(3078, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 6, 4, 1),
(3079, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 5, 3, 0),
(3080, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 3, 5, 1),
(3081, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 3, 6, 1),
(3082, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 7, 8, 0),
(3083, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 3, 7, 2),
(3084, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 6, 3, 0),
(3085, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 8, 6, 0),
(3086, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 8, 8, 1),
(3087, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 4, 6, 4),
(3088, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 6, 6, 1),
(3089, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 5, 7, 3),
(3090, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 7, 6, 0),
(3091, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 7, 7, 0),
(3092, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 7, 7, 0),
(3093, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 3, 3, 0),
(3094, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 4, 5, 0),
(3095, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 6, 4, 1),
(3096, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 5, 4, 0),
(3097, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 8, 6, 1),
(3098, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 4, 5, 0),
(3099, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 8, 8, 1),
(3100, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 4, 6, 1),
(3101, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 6, 5, 1),
(3102, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 4, 8, 6, 0),
(3103, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 5, 5, 0),
(3104, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 5, 6, 2),
(3105, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 3, 3, 0),
(3106, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 4, 6, 0),
(3107, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 8, 8, 2),
(3108, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 6, 5, 1),
(3109, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 8, 7, 2),
(3110, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 4, 8, 0),
(3111, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 5, 3, 1),
(3112, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 3, 8, 4),
(3113, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 7, 4, 0),
(3114, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 4, 6, 0),
(3115, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 7, 8, 1),
(3116, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 3, 3, 0),
(3117, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 6, 3, 0),
(3118, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 4, 6, 2),
(3119, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 6, 3, 1),
(3120, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 6, 7, 0),
(3121, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 8, 3, 4),
(3122, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 5, 6, 0),
(3123, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 8, 4, 1),
(3124, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 6, 6, 1),
(3125, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 5, 5, 0),
(3126, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 5, 5, 1),
(3127, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 6, 6, 1),
(3128, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 5, 7, 1),
(3129, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 5, 5, 4),
(3130, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 8, 3, 3),
(3131, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 8, 8, 0),
(3132, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 4, 7, 2),
(3133, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 4, 4, 1),
(3134, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 3, 6, 4),
(3135, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 6, 4, 1),
(3136, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 7, 6, 0),
(3137, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 3, 3, 0),
(3138, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 6, 7, 3, 0),
(3139, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 5, 4, 1),
(3140, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 3, 1),
(3141, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 6, 7, 1),
(3142, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 4, 0),
(3143, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 4, 4, 0),
(3144, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 4, 4, 0),
(3145, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 6, 8, 1),
(3146, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 7, 4, 3),
(3147, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 7, 8, 1),
(3148, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 7, 6, 3),
(3149, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 5, 5, 0),
(3150, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 7, 7, 0),
(3151, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 6, 7, 0),
(3152, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 6, 3, 2),
(3153, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 6, 4, 1),
(3154, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 5, 4, 1),
(3155, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 7, 5, 1),
(3156, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 4, 3, 0),
(3157, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 6, 4, 4),
(3158, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 4, 8, 4),
(3159, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 5, 3, 6, 0),
(3160, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 3, 8, 0),
(3161, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 7, 8, 1),
(3162, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 6, 5, 7, 1),
(3163, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 3, 0),
(3164, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 6, 3, 0),
(3165, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 6, 6, 0),
(3166, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 3, 7, 0),
(3167, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 5, 8, 0),
(3168, 'Chuột lanh lợi', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 4, 8, 1),
(3169, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 3, 4, 1),
(3170, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 7, 4, 1),
(3171, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 7, 1),
(3172, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 5, 8, 3, 2),
(3173, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 3, 5, 6, 0),
(3174, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 3, 5, 0),
(3175, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 4, 8, 7, 0),
(3176, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 5, 8, 0),
(3177, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 7, 3, 3, 2),
(3178, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 4, 3, 1),
(3179, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 8, 6, 8, 3),
(3180, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 6, 7, 1),
(3181, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 7, 7, 4, 1),
(3182, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 3, 8, 3, 0),
(3183, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 8, 5, 6, 0),
(3360, 'Ngựa lưu lưu', 1024, 1040, 238, 352, 0, 0, 21, 6232, 0, 0, 0, 0, 0, 0, '36f30db66d6fe42f34a91d15b6097af0', 25, 5, 8, 5),
(3539, 'Trâu ngốc ngốc', 92, 100, 6, 4, 0, 0, 1, 5, 0, 0, 0, 0, 0, 0, '12b77bc3aa3cdf5b2283684271bc916c', 18, 4, 4, 1),
(3561, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '9b705d4e6713ac17822161af76f7c44f', 9, 2, 6, 0),
(3558, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b88aee7cafd66550817be8a5ea6e0aaf', 14, 3, 7, 0),
(3189, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 19, 3, 3, 0),
(3190, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 19, 4, 6, 0),
(3191, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '1fd446658a64b6b831a10b3136351e6d', 25, 5, 8, 0),
(3192, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '1fd446658a64b6b831a10b3136351e6d', 22, 4, 4, 0),
(3193, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '300a6f8086e83390efd5dbe046289410', 12, 4, 8, 1),
(3194, 'Trâu ngốc ngốc', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '300a6f8086e83390efd5dbe046289410', 18, 3, 8, 0),
(3538, 'Chuột lanh lợi', 203, 212, 18, 28, 0, 0, 5, 489, 0, 0, 0, 0, 0, 0, 'bb2a45b7652a7900e7810128a329597e', 25, 3, 5, 1),
(3540, 'Khỉ soái soái', 88, 100, 6, 4, 0, 0, 1, 17, 0, 0, 0, 0, 0, 0, '12b77bc3aa3cdf5b2283684271bc916c', 25, 4, 7, 1),
(3197, 'Lợn chiêu tài', 717, 721, 75, 234, 0, 0, 24, 18148, 0, 0, 0, 0, 0, 0, '43e4c5c6dda6740216e3bd54ff200c15', 21, 2, 8, 3),
(3499, 'Ngựa lưu lưu', 92, 100, 6, 4, 0, 0, 1, 59, 0, 0, 0, 0, 0, 0, 'aa0b823f483b02cc5a7516cab09c4f92', 17, 3, 7, 1),
(3500, 'Hổ uy uy', 123, 125, 8, 11, 0, 0, 2, 299, 0, 0, 0, 0, 0, 0, 'aa0b823f483b02cc5a7516cab09c4f92', 21, 2, 6, 2),
(3501, 'Rắn hoa hoa', 559, 580, 96, 154, 0, 0, 31, 56011, 0, 0, 0, 0, 0, 0, 'f58bb53a4bdd39d6d70b706d77fbc74f', 12, 2, 4, 3),
(3502, 'Lợn chiêu tài', 254, 254, 50, 114, 0, 0, 12, 1561, 0, 0, 0, 0, 0, 0, 'f58bb53a4bdd39d6d70b706d77fbc74f', 12, 3, 8, 2),
(3503, 'Khỉ soái soái', -9, 175, 15, 19, 0, 0, 4, 81, 0, 0, 0, 0, 0, 0, '1b10aad87b70a90c7514b3aa2feb52d1', 25, 3, 5, 0),
(3508, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'a15c17bb9370c276b121a0da1755395a', 16, 4, 8, 0),
(3205, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '630c9b2c30289031e4fc53da8537cd52', 22, 2, 8, 0),
(3206, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '630c9b2c30289031e4fc53da8537cd52', 14, 5, 5, 0),
(3207, 'Lợn chiêu tài', 0, 144, 10, 16, 0, 0, 3, 379, 0, 0, 0, 0, 0, 0, 'b4dd3b4ff25c3cdd67b858d5fed146fa', 18, 2, 5, 2),
(3209, 'Rồng ngầu ngầu', 563, 596, 161, 252, 0, 0, 32, 52120, 0, 0, 0, 0, 0, 0, '099f465c0c34dd5ef59f230a21447af4', 13, 4, 7, 2),
(3210, 'Rắn hoa hoa', 110, 113, 9, 10, 0, 0, 2, 44, 0, 0, 0, 0, 0, 0, 'a80e37407282b5feae841dd75b4dc7b7', 12, 3, 5, 1),
(3211, 'Cừu mê mê', 91, 100, 6, 4, 0, 0, 1, 28, 0, 0, 0, 0, 0, 0, 'ea5ea2d157d97045153a82e5a342ec8b', 13, 3, 4, 0),
(3212, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '61554becfc0543903e57c631693bf358', 16, 2, 7, 3),
(3213, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '61554becfc0543903e57c631693bf358', 12, 4, 3, 0),
(3214, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'be109289bb94f9bfa3bf306b453f92df', 19, 2, 5, 1),
(3215, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'be109289bb94f9bfa3bf306b453f92df', 16, 5, 8, 0),
(3559, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b88aee7cafd66550817be8a5ea6e0aaf', 15, 2, 6, 0),
(3510, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b692052b65088cc5c7f4f8438c55c5f9', 14, 2, 3, 1),
(3505, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'efdb10cc8c0441b8c1d53076baed3273', 10, 2, 6, 1),
(3506, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'efdb10cc8c0441b8c1d53076baed3273', 11, 2, 4, 1),
(3507, 'Hổ uy uy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'a15c17bb9370c276b121a0da1755395a', 13, 3, 4, 1),
(3497, 'Gà đản đản', -352, 228, 18, 28, 0, 0, 5, 106, 0, 0, 0, 0, 0, 0, '03a4c698ec11e112036183c308cfb94c', 21, 2, 4, 5),
(3244, 'Thỏ nhảy nhảy', 389, 550, 78, 166, 0, 0, 19, 11034, 0, 0, 0, 0, 0, 0, '6d07cdb650fc1fca94c0dd51a8ed971e', 23, 4, 8, 1),
(3509, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'b692052b65088cc5c7f4f8438c55c5f9', 14, 5, 8, 0),
(3261, 'Gà đản đản', 1831, 1834, 363, 565, 0, 0, 52, 167861, 0, 0, 0, 0, 0, 0, '9bb5f086e2f1efdbc8215e55f8a4a30f', 24, 5, 8, 4),
(3225, 'Thỏ nhảy nhảy', 1074, 1156, 237, 367, 0, 0, 34, 64797, 0, 0, 0, 0, 0, 0, '099f465c0c34dd5ef59f230a21447af4', 23, 5, 8, 4),
(3556, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6bf9af1dfe41b201dbd87d7c45d9ea29', 25, 3, 5, 2),
(3555, 'Khỉ soái soái', -4, 140, 16, 14, 0, 0, 3, 223, 0, 0, 0, 0, 0, 0, 'ad8f4d8e577f50deae4492bd03c96b56', 20, 5, 5, 0),
(3557, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '6bf9af1dfe41b201dbd87d7c45d9ea29', 16, 3, 3, 1),
(3551, 'Trâu ngốc ngốc', 112, 220, 66, 94, 0, 0, 11, 1618, 0, 0, 0, 0, 0, 0, 'eb61a0b08b9bfdfda961d64410eba5bc', 11, 5, 8, 1),
(3552, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '127260b5602737d7ca8a56f3ff47cfde', 9, 3, 3, 0),
(3553, 'Chuột lanh lợi', 153, 156, 14, 18, 0, 0, 3, 263, 0, 0, 0, 0, 0, 0, '127260b5602737d7ca8a56f3ff47cfde', 20, 3, 5, 4),
(3549, 'Lợn chiêu tài', 190, 190, 36, 22, 0, 0, 7, 1161, 0, 0, 0, 0, 0, 0, '781a121e409741ff53f5978578067146', 15, 5, 3, 0),
(3550, 'Thỏ nhảy nhảy', 64, 142, 16, 18, 0, 0, 3, 336, 0, 0, 0, 0, 0, 0, 'eb61a0b08b9bfdfda961d64410eba5bc', 21, 5, 7, 0),
(3234, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '099f465c0c34dd5ef59f230a21447af4', 20, 2, 6, 4),
(3560, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '9b705d4e6713ac17822161af76f7c44f', 15, 4, 3, 3),
(3563, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'c8268cce88c9be2636fd0c06e03bee40', 11, 5, 5, 1),
(3564, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '24cd04c703340be524c7c20721f692bc', 13, 2, 5, 2),
(3565, 'Ngựa lưu lưu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '24cd04c703340be524c7c20721f692bc', 25, 3, 4, 0),
(3566, 'Trâu ngốc ngốc', -5, 122, 11, 7, 0, 0, 2, 19, 0, 0, 0, 0, 0, 0, 'c9879e4c3738297c06b0b14d78dc39d6', 22, 5, 3, 0),
(3567, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'c9879e4c3738297c06b0b14d78dc39d6', 12, 4, 8, 0),
(3568, 'Rồng ngầu ngầu', -8, 200, 21, 19, 0, 0, 6, 338, 0, 0, 0, 0, 0, 0, 'ce13ba86e509d2fab5ed13c2cddf00c9', 20, 3, 3, 0),
(3569, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '06569f4ff7f633af6e060480a0431526', 17, 5, 7, 0),
(3572, 'Chó ngoan ngoan', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'aa588ffcf27da87551c01d7c88b24829', 12, 4, 6, 2),
(3573, 'Chó ngoan ngoan', -5, 100, 6, 4, 0, 0, 1, 96, 0, 0, 0, 0, 0, 0, 'aa588ffcf27da87551c01d7c88b24829', 9, 2, 7, 0),
(3574, 'Chuột lanh lợi', 94, 100, 6, 4, 0, 0, 1, 35, 0, 0, 0, 0, 0, 0, 'a71dfe5ae44c6f0d4c4be100a2e85748', 9, 2, 8, 1),
(3575, 'Rắn hoa hoa', -50, 256, 30, 28, 0, 0, 7, 615, 0, 0, 0, 0, 0, 0, 'a71dfe5ae44c6f0d4c4be100a2e85748', 22, 3, 3, 2),
(3576, 'Rắn hoa hoa', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '09fa9b0b46ac94b442588c98b6bed537', 9, 2, 5, 2),
(3577, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '09fa9b0b46ac94b442588c98b6bed537', 25, 2, 8, 1),
(3578, 'Cừu mê mê', 116, 118, 12, 13, 0, 0, 2, 164, 0, 0, 0, 0, 0, 0, '2007608a6942d33ec38e7c3d870fa674', 16, 5, 8, 1),
(3579, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '2007608a6942d33ec38e7c3d870fa674', 20, 4, 3, 0),
(3580, 'Chó ngoan ngoan', 115, 115, 8, 12, 0, 0, 2, 7, 0, 0, 0, 0, 0, 0, 'cc5cfc9a3fac118adae1bfb7f6dc6c3a', 15, 2, 8, 0),
(3581, 'Hổ uy uy', -2, 202, 30, 28, 0, 0, 7, 1265, 0, 0, 0, 0, 0, 0, 'dd58b4170ec8d6d20f876405b4b1265d', 12, 3, 3, 4),
(3583, 'Gà đản đản', 79, 123, 11, 9, 0, 0, 2, 171, 0, 0, 0, 0, 0, 0, 'e777555550491c15e506da8cafb60086', 18, 4, 4, 3),
(3584, 'Gà đản đản', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'e777555550491c15e506da8cafb60086', 20, 4, 8, 1),
(3585, 'Ngựa lưu lưu', -28, 117, 10, 13, 0, 0, 2, 159, 0, 0, 0, 0, 0, 0, '7159624dfdba178c848da03a6ffefec9', 15, 4, 8, 1),
(3586, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '7159624dfdba178c848da03a6ffefec9', 24, 5, 4, 0),
(3587, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '3c9d1d6c8f225e9e4139cccd830fdd00', 13, 4, 5, 0),
(3588, 'Rồng ngầu ngầu', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '9f98bca6ec1fa9e5b63f70012148b511', 21, 4, 4, 0),
(3589, 'Lợn chiêu tài', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '9f98bca6ec1fa9e5b63f70012148b511', 24, 2, 5, 1),
(3590, 'Cừu mê mê', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'f76c11b6601d3a6ce505c616b64ed478', 9, 5, 7, 1),
(3591, 'Thỏ nhảy nhảy', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'e14b6e0d27bea46402a112c75c170887', 10, 4, 7, 1),
(3592, 'Khỉ soái soái', 100, 100, 6, 4, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '3bfa14243cba16bb92e090b54cc5d544', 13, 5, 7, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `playerdaoju`
--

CREATE TABLE IF NOT EXISTS `playerdaoju` (
  `djname` varchar(255) NOT NULL,
  `djzl` int(255) NOT NULL,
  `djinfo` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `sid` text NOT NULL,
  `djsum` int(11) NOT NULL,
  `djid` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=467 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `playerdaoju`
--

INSERT INTO `playerdaoju` (`djname`, `djzl`, `djinfo`, `uid`, `sid`, `djsum`, `djid`) VALUES
('Mật ong Ong cánh cứng', 452, 'Ong cánh cứng mật ong', 425, '42352a5bb2acc1e76e8a2fa10ba7673b', 2, 8),
('Đá cường hóa', 2, 'Đạo cụ dùng để cường hóa trang bị', 424, 'f76c11b6601d3a6ce505c616b64ed478', 7, 1),
('Mật ong Ong cánh cứng', 453, 'Ong cánh cứng mật ong', 424, 'f76c11b6601d3a6ce505c616b64ed478', 4, 8),
('Mảnh phù lục-Sơ cấp linh', 454, 'Dùng để đổi phù lục', 424, 'f76c11b6601d3a6ce505c616b64ed478', 0, 6),
('Mảnh phù lục-Sơ cấp ma', 455, 'Đổi phù lục', 424, 'f76c11b6601d3a6ce505c616b64ed478', 8, 7),
('Mật ong Ong cánh cứng', 456, 'Ong cánh cứng mật ong', 426, '0ed4ce0a982475dad32cea331e8e50d7', 5, 8),
('Mảnh phù lục-Sơ cấp linh', 457, 'Dùng để đổi phù lục', 426, '0ed4ce0a982475dad32cea331e8e50d7', 100, 6),
('Mảnh phù lục-Sơ cấp ma', 458, 'Đổi phù lục', 426, '0ed4ce0a982475dad32cea331e8e50d7', 100, 7),
('Mật ong Ong cánh cứng', 459, 'Ong cánh cứng mật ong', 431, '3bfa14243cba16bb92e090b54cc5d544', 0, 8),
('Mảnh phù lục-Sơ cấp linh', 460, 'Dùng để đổi phù lục', 431, '3bfa14243cba16bb92e090b54cc5d544', 98, 6),
('Mảnh phù lục-Sơ cấp ma', 461, 'Đổi phù lục', 431, '3bfa14243cba16bb92e090b54cc5d544', 100, 7),
('Mật ong Ong cánh cứng', 462, 'Ong cánh cứng mật ong', 434, 'e14b6e0d27bea46402a112c75c170887', 11, 8),
('Mảnh phù lục-Sơ cấp linh', 463, 'Dùng để đổi phù lục', 434, 'e14b6e0d27bea46402a112c75c170887', 95, 6),
('Mảnh phù lục-Sơ cấp ma', 464, 'Đổi phù lục', 434, 'e14b6e0d27bea46402a112c75c170887', 100, 7),
('Mảnh phù lục-Sơ cấp linh', 465, 'Dùng để đổi phù lục', 422, '3c9d1d6c8f225e9e4139cccd830fdd00', 100, 6),
('Mảnh phù lục-Sơ cấp ma', 466, 'Đổi phù lục', 422, '3c9d1d6c8f225e9e4139cccd830fdd00', 100, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `playerjineng`
--

CREATE TABLE IF NOT EXISTS `playerjineng` (
  `jnname` varchar(255) NOT NULL,
  `jnid` int(11) NOT NULL,
  `jngj` int(11) NOT NULL,
  `jnfy` int(11) NOT NULL,
  `jnbj` int(11) NOT NULL,
  `jnxx` int(11) NOT NULL,
  `sid` text NOT NULL,
  `jncount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `playerjineng`
--

INSERT INTO `playerjineng` (`jnname`, `jnid`, `jngj`, `jnfy`, `jnbj`, `jnxx`, `sid`, `jncount`) VALUES
('Chém tụ linh', 4, 10, 0, 0, 2, '43e4c5c6dda6740216e3bd54ff200c15', 7),
('trâuB kỹ năng', 5, 0, 0, 100, 100, '43e4c5c6dda6740216e3bd54ff200c15', 3),
('trâuB kỹ năng', 5, 0, 0, 100, 100, 'af1d74362b935eb0ac845b7e4f7f707f', 1),
('Chém tụ linh', 4, 10, 0, 0, 2, '099f465c0c34dd5ef59f230a21447af4', 8),
('Chém tụ linh', 4, 10, 0, 0, 2, '9bb5f086e2f1efdbc8215e55f8a4a30f', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, '6d07cdb650fc1fca94c0dd51a8ed971e', 32),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, '6d07cdb650fc1fca94c0dd51a8ed971e', 0),
('Man lực phù thể', 6, 7, 7, 7, 7, '6d07cdb650fc1fca94c0dd51a8ed971e', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, '36f30db66d6fe42f34a91d15b6097af0', 0),
('Man lực phù thể', 6, 7, 7, 7, 7, '43e4c5c6dda6740216e3bd54ff200c15', 1),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, '9bb5f086e2f1efdbc8215e55f8a4a30f', 0),
('Man lực phù thể', 6, 7, 7, 7, 7, '9bb5f086e2f1efdbc8215e55f8a4a30f', 0),
('Nộ huyết bộc', 7, 12, 2, 20, 12, '9bb5f086e2f1efdbc8215e55f8a4a30f', 0),
('Nộ huyết bộc', 7, 12, 2, 20, 12, '36f30db66d6fe42f34a91d15b6097af0', 0),
('Man lực phù thể', 6, 7, 7, 7, 7, '36f30db66d6fe42f34a91d15b6097af0', 9),
('Nộ huyết bộc', 7, 12, 2, 20, 8, '43e4c5c6dda6740216e3bd54ff200c15', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, 'f58bb53a4bdd39d6d70b706d77fbc74f', 0),
('Man lực phù thể', 6, 7, 7, 7, 7, 'f58bb53a4bdd39d6d70b706d77fbc74f', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, 'c4339dfb63d53dbe95ff3f1297cd889d', 5),
('Nộ huyết bộc', 7, 12, 2, 20, 8, '6d07cdb650fc1fca94c0dd51a8ed971e', 0),
('Nộ huyết bộc', 7, 12, 2, 20, 8, 'f58bb53a4bdd39d6d70b706d77fbc74f', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, '592857bc812f813ed52fa8b187582fc2', 0),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, '592857bc812f813ed52fa8b187582fc2', 3),
('Chém tụ linh', 4, 10, 0, 0, 2, '781a121e409741ff53f5978578067146', 20),
('Chém tụ linh', 4, 10, 0, 0, 2, '775c0ff651b405a676fc9ee1729302f4', 20),
('Man lực phù thể', 6, 7, 7, 7, 7, '6b7b2713b1a52397c7282509906e8c5e', 1),
('Chém tụ linh', 4, 10, 0, 0, 2, 'c9879e4c3738297c06b0b14d78dc39d6', 15),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 'c9879e4c3738297c06b0b14d78dc39d6', 25),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, '781a121e409741ff53f5978578067146', 12),
('Chém tụ linh', 4, 10, 0, 0, 2, 'eb61a0b08b9bfdfda961d64410eba5bc', 3),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 'eb61a0b08b9bfdfda961d64410eba5bc', 2),
('Chém tụ linh', 4, 10, 0, 0, 2, '77099dca8f67b65ca91af53d0461ac2f', 0),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, '77099dca8f67b65ca91af53d0461ac2f', 0),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, '775c0ff651b405a676fc9ee1729302f4', 10),
('Man lực phù thể', 6, 7, 7, 7, 7, '775c0ff651b405a676fc9ee1729302f4', 23),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 'ad8f4d8e577f50deae4492bd03c96b56', 2),
('Chém tụ linh', 4, 10, 0, 0, 2, 'ad8f4d8e577f50deae4492bd03c96b56', 3),
('Chém tụ linh', 4, 10, 0, 0, 2, 'bb2a45b7652a7900e7810128a329597e', 2),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 'bb2a45b7652a7900e7810128a329597e', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, '4e079b4084dcdd84cf4393a003a38283', 2),
('Chém tụ linh', 4, 10, 0, 0, 2, 'ce13ba86e509d2fab5ed13c2cddf00c9', 2),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 'ce13ba86e509d2fab5ed13c2cddf00c9', 8),
('Chém tụ linh', 4, 10, 0, 0, 2, 'ea5a17b7f6c42320f7c242f2871a0f8d', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, 'dd58b4170ec8d6d20f876405b4b1265d', 0),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 'dd58b4170ec8d6d20f876405b4b1265d', 0),
('Chém tụ linh', 4, 10, 0, 0, 2, '7159624dfdba178c848da03a6ffefec9', 2),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, '7159624dfdba178c848da03a6ffefec9', 3),
('Chém tụ linh', 4, 10, 0, 0, 2, 'f76c11b6601d3a6ce505c616b64ed478', 0),
('Ma tâm bộc phát', 5, 5, 0, 10, 10, 'f76c11b6601d3a6ce505c616b64ed478', 10),
('Chém tụ linh', 4, 10, 0, 0, 2, 'e14b6e0d27bea46402a112c75c170887', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `playerrenwu`
--

CREATE TABLE IF NOT EXISTS `playerrenwu` (
  `rwname` varchar(255) NOT NULL,
  `rwzl` int(11) NOT NULL,
  `rwdj` varchar(255) NOT NULL,
  `rwzb` varchar(255) NOT NULL,
  `rwexp` varchar(255) NOT NULL,
  `rwyxb` varchar(255) NOT NULL,
  `sid` text NOT NULL,
  `rwzt` int(11) NOT NULL,
  `rwid` int(11) NOT NULL,
  `rwyq` int(11) NOT NULL,
  `rwcount` int(11) NOT NULL,
  `rwnowcount` int(11) NOT NULL,
  `rwlx` int(11) NOT NULL,
  `rwyp` text NOT NULL,
  `data` int(11) NOT NULL,
  `rwjineng` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `playerrenwu`
--

INSERT INTO `playerrenwu` (`rwname`, `rwzl`, `rwdj`, `rwzb`, `rwexp`, `rwyxb`, `sid`, `rwzt`, `rwid`, `rwyq`, `rwcount`, `rwnowcount`, `rwlx`, `rwyp`, `data`, `rwjineng`) VALUES
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '43e4c5c6dda6740216e3bd54ff200c15', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'c9879e4c3738297c06b0b14d78dc39d6', 3, 13, 56, 5, 0, 2, '', 21, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '43e4c5c6dda6740216e3bd54ff200c15', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'c9879e4c3738297c06b0b14d78dc39d6', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'fe770ad48c2efa7f70b271527359d0ed', 1, 13, 56, 5, 2, 2, '', 22, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'c9879e4c3738297c06b0b14d78dc39d6', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '43e4c5c6dda6740216e3bd54ff200c15', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'c9879e4c3738297c06b0b14d78dc39d6', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '43e4c5c6dda6740216e3bd54ff200c15', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'c9879e4c3738297c06b0b14d78dc39d6', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', '43e4c5c6dda6740216e3bd54ff200c15', 1, 19, 76, 50, 11, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', '43e4c5c6dda6740216e3bd54ff200c15', 1, 20, 77, 50, 7, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'dc00cd1d5392e16138e78f31a14653fc', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '6d07cdb650fc1fca94c0dd51a8ed971e', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '377b01fca16375319e1d921b89f66604', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '6d07cdb650fc1fca94c0dd51a8ed971e', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'bb2a45b7652a7900e7810128a329597e', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '6d07cdb650fc1fca94c0dd51a8ed971e', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '6d07cdb650fc1fca94c0dd51a8ed971e', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', '6d07cdb650fc1fca94c0dd51a8ed971e', 1, 19, 76, 50, 15, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', '6d07cdb650fc1fca94c0dd51a8ed971e', 1, 20, 77, 50, 8, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '6d07cdb650fc1fca94c0dd51a8ed971e', 1, 13, 56, 5, 0, 2, '', 23, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'eb61a0b08b9bfdfda961d64410eba5bc', 3, 13, 56, 5, 0, 2, '', 21, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'eb61a0b08b9bfdfda961d64410eba5bc', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'eb61a0b08b9bfdfda961d64410eba5bc', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'eb61a0b08b9bfdfda961d64410eba5bc', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '781a121e409741ff53f5978578067146', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '781a121e409741ff53f5978578067146', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '781a121e409741ff53f5978578067146', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '781a121e409741ff53f5978578067146', 3, 13, 56, 5, 0, 2, '', 21, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '781a121e409741ff53f5978578067146', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '781a121e409741ff53f5978578067146', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '77099dca8f67b65ca91af53d0461ac2f', 3, 13, 56, 5, 0, 2, '', 21, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', '775c0ff651b405a676fc9ee1729302f4', 3, 20, 77, 50, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', '775c0ff651b405a676fc9ee1729302f4', 3, 19, 76, 50, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '77099dca8f67b65ca91af53d0461ac2f', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '1de67183872072ed605030a8bf3059be', 3, 13, 56, 5, 0, 2, '', 21, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '1de67183872072ed605030a8bf3059be', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '1de67183872072ed605030a8bf3059be', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '77099dca8f67b65ca91af53d0461ac2f', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '77099dca8f67b65ca91af53d0461ac2f', 1, 29, 62, 10, 3, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '1de67183872072ed605030a8bf3059be', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '1de67183872072ed605030a8bf3059be', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '77099dca8f67b65ca91af53d0461ac2f', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'eb61a0b08b9bfdfda961d64410eba5bc', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'eb61a0b08b9bfdfda961d64410eba5bc', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '43e4c5c6dda6740216e3bd54ff200c15', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'bb2a45b7652a7900e7810128a329597e', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'bb2a45b7652a7900e7810128a329597e', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', '781a121e409741ff53f5978578067146', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', '781a121e409741ff53f5978578067146', 1, 19, 76, 50, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'eb61a0b08b9bfdfda961d64410eba5bc', 1, 19, 76, 50, 1, 1, '', 0, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', '781a121e409741ff53f5978578067146', 1, 21, 82, 30, 0, 2, '', 21, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'eb61a0b08b9bfdfda961d64410eba5bc', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', 'eb61a0b08b9bfdfda961d64410eba5bc', 1, 21, 82, 30, 0, 2, '', 21, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '592857bc812f813ed52fa8b187582fc2', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '592857bc812f813ed52fa8b187582fc2', 1, 13, 56, 5, 0, 2, '', 23, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '592857bc812f813ed52fa8b187582fc2', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '592857bc812f813ed52fa8b187582fc2', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '592857bc812f813ed52fa8b187582fc2', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '2f30be56d4505a584b454357bfcaa618', 1, 25, 55, 20, 3, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '592857bc812f813ed52fa8b187582fc2', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'ba5b232ca920fefa398ae123afcc87eb', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'ba5b232ca920fefa398ae123afcc87eb', 3, 13, 56, 5, 0, 2, '', 21, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'ba5b232ca920fefa398ae123afcc87eb', 1, 25, 55, 20, 15, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'ef0de555ed6bb051e1a18e2141be60a4', 1, 25, 55, 20, 10, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'ad8f4d8e577f50deae4492bd03c96b56', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'ad8f4d8e577f50deae4492bd03c96b56', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'ad8f4d8e577f50deae4492bd03c96b56', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'ad8f4d8e577f50deae4492bd03c96b56', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'ad8f4d8e577f50deae4492bd03c96b56', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'ad8f4d8e577f50deae4492bd03c96b56', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'ad8f4d8e577f50deae4492bd03c96b56', 1, 19, 76, 50, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'ad8f4d8e577f50deae4492bd03c96b56', 1, 13, 56, 5, 0, 2, '', 23, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '53b5753ac98d992ebb0e7c3ad6b7d2e4', 1, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '2de0f1d3eca04c1a8aff5354db0874ed', 2, 13, 56, 5, 5, 2, '', 21, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '2de0f1d3eca04c1a8aff5354db0874ed', 1, 25, 55, 20, 5, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '2de0f1d3eca04c1a8aff5354db0874ed', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '2de0f1d3eca04c1a8aff5354db0874ed', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '9bb5f086e2f1efdbc8215e55f8a4a30f', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '9bb5f086e2f1efdbc8215e55f8a4a30f', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '9bb5f086e2f1efdbc8215e55f8a4a30f', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '9bb5f086e2f1efdbc8215e55f8a4a30f', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '9bb5f086e2f1efdbc8215e55f8a4a30f', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'ce13ba86e509d2fab5ed13c2cddf00c9', 3, 13, 56, 5, 0, 2, '', 22, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'ce13ba86e509d2fab5ed13c2cddf00c9', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'ce13ba86e509d2fab5ed13c2cddf00c9', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'ce13ba86e509d2fab5ed13c2cddf00c9', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '2ff85222525dc6103813d8c61907572e', 1, 13, 56, 5, 0, 2, '', 21, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'ce13ba86e509d2fab5ed13c2cddf00c9', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '2ff85222525dc6103813d8c61907572e', 1, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '2ff85222525dc6103813d8c61907572e', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'bb2a45b7652a7900e7810128a329597e', 3, 13, 56, 5, 0, 2, '', 23, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'bb2a45b7652a7900e7810128a329597e', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'bb2a45b7652a7900e7810128a329597e', 1, 19, 76, 50, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'ef0de555ed6bb051e1a18e2141be60a4', 1, 13, 56, 5, 4, 2, '', 23, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', '9bb5f086e2f1efdbc8215e55f8a4a30f', 3, 19, 76, 50, 0, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', '9bb5f086e2f1efdbc8215e55f8a4a30f', 3, 20, 77, 50, 0, 1, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'bb2a45b7652a7900e7810128a329597e', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '06569f4ff7f633af6e060480a0431526', 1, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '06569f4ff7f633af6e060480a0431526', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '06569f4ff7f633af6e060480a0431526', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'fe770ad48c2efa7f70b271527359d0ed', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '4e079b4084dcdd84cf4393a003a38283', 3, 13, 56, 5, 0, 2, '', 22, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '4e079b4084dcdd84cf4393a003a38283', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '014f052e766dfebb8a3dff85c525f33d', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '4e079b4084dcdd84cf4393a003a38283', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '4e079b4084dcdd84cf4393a003a38283', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '775c0ff651b405a676fc9ee1729302f4', 1, 25, 55, 20, 0, 3, '', 0, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', '775c0ff651b405a676fc9ee1729302f4', 1, 21, 82, 30, 0, 2, '', 22, ''),
('Họa sói', 2, '1|100', '', '400', '300', '4e079b4084dcdd84cf4393a003a38283', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'ab427a3da6d74b88bcc13985a99f2fe3', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '4e079b4084dcdd84cf4393a003a38283', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', '4e079b4084dcdd84cf4393a003a38283', 1, 19, 76, 50, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'aa588ffcf27da87551c01d7c88b24829', 3, 13, 56, 5, 0, 2, '', 22, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'aa588ffcf27da87551c01d7c88b24829', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'aa588ffcf27da87551c01d7c88b24829', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '3efda130336e54b2ab0463e97020858d', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '44820855281001694b3ec98fb720b0b4', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '3efda130336e54b2ab0463e97020858d', 1, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '3efda130336e54b2ab0463e97020858d', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'aa588ffcf27da87551c01d7c88b24829', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'bb2a45b7652a7900e7810128a329597e', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'ce13ba86e509d2fab5ed13c2cddf00c9', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'ce13ba86e509d2fab5ed13c2cddf00c9', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'aa588ffcf27da87551c01d7c88b24829', 1, 29, 62, 10, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'a71dfe5ae44c6f0d4c4be100a2e85748', 3, 13, 56, 5, 0, 2, '', 22, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'a71dfe5ae44c6f0d4c4be100a2e85748', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'a71dfe5ae44c6f0d4c4be100a2e85748', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'ce13ba86e509d2fab5ed13c2cddf00c9', 1, 19, 76, 50, 0, 1, '', 0, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', 'ce13ba86e509d2fab5ed13c2cddf00c9', 1, 21, 82, 30, 0, 2, '', 22, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'a71dfe5ae44c6f0d4c4be100a2e85748', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'a71dfe5ae44c6f0d4c4be100a2e85748', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'a71dfe5ae44c6f0d4c4be100a2e85748', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '98c04e5c0946bf13d399e8577f181912', 1, 25, 55, 20, 9, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'ea5a17b7f6c42320f7c242f2871a0f8d', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '377b01fca16375319e1d921b89f66604', 3, 13, 56, 5, 0, 2, '', 22, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'ef0de555ed6bb051e1a18e2141be60a4', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '7159624dfdba178c848da03a6ffefec9', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '7159624dfdba178c848da03a6ffefec9', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '7159624dfdba178c848da03a6ffefec9', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'dbbec33ed7095aa0b5bc8b63e0ab9023', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', 'f58bb53a4bdd39d6d70b706d77fbc74f', 1, 21, 82, 30, 0, 2, '', 23, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'c75c050dc1b04f75f8211f68505097b1', 2, 13, 56, 5, 5, 2, '', 22, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'c75c050dc1b04f75f8211f68505097b1', 1, 25, 55, 20, 4, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'c75c050dc1b04f75f8211f68505097b1', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '181c4ae732e839b1b07425f056e83f51', 1, 13, 56, 5, 0, 2, '', 22, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '181c4ae732e839b1b07425f056e83f51', 1, 25, 55, 20, 2, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '181c4ae732e839b1b07425f056e83f51', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '014f052e766dfebb8a3dff85c525f33d', 1, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '014f052e766dfebb8a3dff85c525f33d', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '2007608a6942d33ec38e7c3d870fa674', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '2007608a6942d33ec38e7c3d870fa674', 1, 29, 62, 10, 0, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '2007608a6942d33ec38e7c3d870fa674', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '2007608a6942d33ec38e7c3d870fa674', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'cc5cfc9a3fac118adae1bfb7f6dc6c3a', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '2007608a6942d33ec38e7c3d870fa674', 3, 13, 56, 5, 0, 2, '', 23, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'cc5cfc9a3fac118adae1bfb7f6dc6c3a', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', '6d07cdb650fc1fca94c0dd51a8ed971e', 1, 21, 82, 30, 1, 2, '', 23, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'dd58b4170ec8d6d20f876405b4b1265d', 3, 13, 56, 5, 0, 2, '', 23, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'dd58b4170ec8d6d20f876405b4b1265d', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'dd58b4170ec8d6d20f876405b4b1265d', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'dd58b4170ec8d6d20f876405b4b1265d', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'dd58b4170ec8d6d20f876405b4b1265d', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', 'dd58b4170ec8d6d20f876405b4b1265d', 1, 21, 82, 30, 0, 2, '', 23, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'dd58b4170ec8d6d20f876405b4b1265d', 1, 19, 76, 50, 0, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'dd58b4170ec8d6d20f876405b4b1265d', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'dd58b4170ec8d6d20f876405b4b1265d', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'd4cd8bac31b76768226bd72adc430ab9', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'd4cd8bac31b76768226bd72adc430ab9', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '7159624dfdba178c848da03a6ffefec9', 3, 13, 56, 5, 0, 2, '', 24, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'd4cd8bac31b76768226bd72adc430ab9', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '97563ab1d73bbb1e071ec933b5b06e6c', 1, 25, 55, 20, 5, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '97563ab1d73bbb1e071ec933b5b06e6c', 3, 13, 56, 5, 0, 2, '', 23, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'f58bb53a4bdd39d6d70b706d77fbc74f', 1, 19, 76, 50, 4, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'f58bb53a4bdd39d6d70b706d77fbc74f', 1, 20, 77, 50, 1, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'e777555550491c15e506da8cafb60086', 3, 13, 56, 5, 0, 2, '', 24, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'e777555550491c15e506da8cafb60086', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'e777555550491c15e506da8cafb60086', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'e777555550491c15e506da8cafb60086', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'e777555550491c15e506da8cafb60086', 1, 29, 62, 10, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '7159624dfdba178c848da03a6ffefec9', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '7159624dfdba178c848da03a6ffefec9', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '087efeb819f49c1789df1f599ec15388', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '087efeb819f49c1789df1f599ec15388', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '087efeb819f49c1789df1f599ec15388', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '087efeb819f49c1789df1f599ec15388', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', '3c9d1d6c8f225e9e4139cccd830fdd00', 1, 19, 76, 50, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '3c9d1d6c8f225e9e4139cccd830fdd00', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '3c9d1d6c8f225e9e4139cccd830fdd00', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'f76c11b6601d3a6ce505c616b64ed478', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'f76c11b6601d3a6ce505c616b64ed478', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '42352a5bb2acc1e76e8a2fa10ba7673b', 1, 25, 55, 20, 3, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'f76c11b6601d3a6ce505c616b64ed478', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'f76c11b6601d3a6ce505c616b64ed478', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '0ed4ce0a982475dad32cea331e8e50d7', 3, 13, 56, 5, 0, 2, '', 2, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'bd2c1545c6284ceb5cd83c9cbe1f8ec7', 1, 13, 56, 5, 2, 2, '', 2, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '0ed4ce0a982475dad32cea331e8e50d7', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '0ed4ce0a982475dad32cea331e8e50d7', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '0ed4ce0a982475dad32cea331e8e50d7', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'f76c11b6601d3a6ce505c616b64ed478', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '0ed4ce0a982475dad32cea331e8e50d7', 1, 29, 62, 10, 2, 3, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '4cfb676f793c954980bab3c8ad2e2a5a', 1, 13, 56, 5, 1, 2, '', 5, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '9f98bca6ec1fa9e5b63f70012148b511', 1, 25, 55, 20, 1, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '9f98bca6ec1fa9e5b63f70012148b511', 2, 28, 11, 14, 0, 1, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', 'e14b6e0d27bea46402a112c75c170887', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'f76c11b6601d3a6ce505c616b64ed478', 1, 19, 76, 50, 12, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'f76c11b6601d3a6ce505c616b64ed478', 1, 20, 77, 50, 8, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', '4f51a51d5a72504387e6fd56da3464fe', 1, 13, 56, 5, 1, 2, '', 3, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', '3bfa14243cba16bb92e090b54cc5d544', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', '3bfa14243cba16bb92e090b54cc5d544', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '3bfa14243cba16bb92e090b54cc5d544', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '3bfa14243cba16bb92e090b54cc5d544', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', '3bfa14243cba16bb92e090b54cc5d544', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 'e14b6e0d27bea46402a112c75c170887', 3, 13, 56, 5, 0, 2, '', 3, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 'e14b6e0d27bea46402a112c75c170887', 3, 25, 55, 20, 0, 3, '', 0, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 'e14b6e0d27bea46402a112c75c170887', 3, 28, 11, 14, 0, 1, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 'e14b6e0d27bea46402a112c75c170887', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', '3c9d1d6c8f225e9e4139cccd830fdd00', 3, 24, 11, 18, 0, 3, '', 0, ''),
('Họa sói', 2, '1|100', '', '400', '300', '3c9d1d6c8f225e9e4139cccd830fdd00', 3, 29, 62, 10, 0, 3, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', '3c9d1d6c8f225e9e4139cccd830fdd00', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 'e14b6e0d27bea46402a112c75c170887', 1, 27, 12, 150, 0, 1, '', 0, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 'e14b6e0d27bea46402a112c75c170887', 1, 20, 77, 50, 0, 1, '', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 'e14b6e0d27bea46402a112c75c170887', 1, 19, 76, 50, 0, 1, '', 0, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng `playeryaopin`
--

CREATE TABLE IF NOT EXISTS `playeryaopin` (
  `ypname` varchar(255) NOT NULL,
  `ypid` int(11) NOT NULL,
  `yphp` int(11) NOT NULL,
  `ypgj` int(11) NOT NULL,
  `ypfy` int(11) NOT NULL,
  `ypxx` int(11) NOT NULL,
  `ypbj` int(11) NOT NULL,
  `sid` text NOT NULL,
  `ypsum` int(11) NOT NULL,
  `ypjg` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `playeryaopin`
--

INSERT INTO `playeryaopin` (`ypname`, `ypid`, `yphp`, `ypgj`, `ypfy`, `ypxx`, `ypbj`, `sid`, `ypsum`, `ypjg`) VALUES
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '43e4c5c6dda6740216e3bd54ff200c15', 69, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 11, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'b4dd3b4ff25c3cdd67b858d5fed146fa', 10, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '7e9ab9a48f33d0f31ce4cfc1512ba0b8', 7, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '099f465c0c34dd5ef59f230a21447af4', 11, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '0820a45ab816fb9c222a84c6546581b7', 3, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'a80e37407282b5feae841dd75b4dc7b7', 7, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'ea5ea2d157d97045153a82e5a342ec8b', 3, 10),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '9bb5f086e2f1efdbc8215e55f8a4a30f', 81, 15),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '099f465c0c34dd5ef59f230a21447af4', 118, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '6d07cdb650fc1fca94c0dd51a8ed971e', 0, 15),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, 'af1d74362b935eb0ac845b7e4f7f707f', 15, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '6d07cdb650fc1fca94c0dd51a8ed971e', 1, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '9bb5f086e2f1efdbc8215e55f8a4a30f', 705, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '43e4c5c6dda6740216e3bd54ff200c15', 2, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '36f30db66d6fe42f34a91d15b6097af0', 197, 15),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, '6d07cdb650fc1fca94c0dd51a8ed971e', 0, 55),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'e0e644a3727f0f1671e917f7b376c66f', 8, 15),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'c5cb7c746b98e872e69f0a5ef8e2d386', 8, 15),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '6b7b2713b1a52397c7282509906e8c5e', 26, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '36f30db66d6fe42f34a91d15b6097af0', 81, 30),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, '36f30db66d6fe42f34a91d15b6097af0', 115, 55),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '33619221f61feb039c524037c50aeb95', 3, 15),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '03a4c698ec11e112036183c308cfb94c', 15, 15),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'ea5a17b7f6c42320f7c242f2871a0f8d', 21, 15),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '4f49b5eb675277e6401832966f112262', 3, 15),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '1385c8e98187fabdc04a600693e0ae8f', 2, 15),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, '9bb5f086e2f1efdbc8215e55f8a4a30f', 869, 55),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'ca0904a308346c194ff8ec780ccf6736', 3, 15),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, '43e4c5c6dda6740216e3bd54ff200c15', 0, 55),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'aa0b823f483b02cc5a7516cab09c4f92', 7, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'f58bb53a4bdd39d6d70b706d77fbc74f', 0, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, 'f58bb53a4bdd39d6d70b706d77fbc74f', 1, 80),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '1b10aad87b70a90c7514b3aa2feb52d1', 6, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'ca083d233cbca174c1dec911b9c91e42', 3, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'c4339dfb63d53dbe95ff3f1297cd889d', 6, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'e2c3b13624da53a64bfd36596e04227b', 1, 30),
('Đan phục thương', 9, 1200, 0, 0, 0, 0, '099f465c0c34dd5ef59f230a21447af4', 2, 310),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '49a77fab810b41f76e378df436869254', 1, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '4ab5e4638b035213c341b7d4706ded4f', 7, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'bb2a45b7652a7900e7810128a329597e', 36, 30),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, 'bb2a45b7652a7900e7810128a329597e', 0, 155),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'a805c97cc13e0d4a7e07c7552cf101f9', 24, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '12b77bc3aa3cdf5b2283684271bc916c', 3, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '775c0ff651b405a676fc9ee1729302f4', 32, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '775c0ff651b405a676fc9ee1729302f4', 146, 80),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '5f2f53403bda85d4fee078d944dd6d7e', 24, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '8bf2c38ba9d08fd609a3d40b35ea659c', 4, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '781a121e409741ff53f5978578067146', 6, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '592857bc812f813ed52fa8b187582fc2', 0, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'eb61a0b08b9bfdfda961d64410eba5bc', 38, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'ad8f4d8e577f50deae4492bd03c96b56', 27, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '127260b5602737d7ca8a56f3ff47cfde', 10, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '1de67183872072ed605030a8bf3059be', 37, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '77099dca8f67b65ca91af53d0461ac2f', 31, 30),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, 'f58bb53a4bdd39d6d70b706d77fbc74f', 0, 155),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'c9879e4c3738297c06b0b14d78dc39d6', 33, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, '781a121e409741ff53f5978578067146', 10, 80),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'ba5b232ca920fefa398ae123afcc87eb', 15, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '2de0f1d3eca04c1a8aff5354db0874ed', 10, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'ce13ba86e509d2fab5ed13c2cddf00c9', 24, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '4e079b4084dcdd84cf4393a003a38283', 23, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'aa588ffcf27da87551c01d7c88b24829', 16, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'a71dfe5ae44c6f0d4c4be100a2e85748', 28, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '98c04e5c0946bf13d399e8577f181912', 2, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '377b01fca16375319e1d921b89f66604', 13, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '2007608a6942d33ec38e7c3d870fa674', 29, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'cc5cfc9a3fac118adae1bfb7f6dc6c3a', 15, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'dd58b4170ec8d6d20f876405b4b1265d', 22, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'd4cd8bac31b76768226bd72adc430ab9', 25, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '97563ab1d73bbb1e071ec933b5b06e6c', 3, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'e777555550491c15e506da8cafb60086', 29, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '7159624dfdba178c848da03a6ffefec9', 23, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '087efeb819f49c1789df1f599ec15388', 34, 30),
('Đan phục thương', 9, 1200, 0, 0, 0, 0, '087efeb819f49c1789df1f599ec15388', 100, 310),
('Đan phục thương', 9, 1200, 0, 0, 0, 0, '3c9d1d6c8f225e9e4139cccd830fdd00', 99, 310),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '3c9d1d6c8f225e9e4139cccd830fdd00', 30, 30),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, '3c9d1d6c8f225e9e4139cccd830fdd00', 8, 155),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '42352a5bb2acc1e76e8a2fa10ba7673b', 2, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'f76c11b6601d3a6ce505c616b64ed478', 0, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '0ed4ce0a982475dad32cea331e8e50d7', 23, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '9f98bca6ec1fa9e5b63f70012148b511', 4, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, 'f76c11b6601d3a6ce505c616b64ed478', 1, 80),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, '3bfa14243cba16bb92e090b54cc5d544', 25, 30),
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 'e14b6e0d27bea46402a112c75c170887', 26, 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `playerzhuangbei`
--

CREATE TABLE IF NOT EXISTS `playerzhuangbei` (
  `zbname` varchar(255) NOT NULL,
  `zbinfo` varchar(255) NOT NULL,
  `zbgj` varchar(255) NOT NULL,
  `zbfy` varchar(255) NOT NULL,
  `zbbj` varchar(255) NOT NULL,
  `zbxx` varchar(255) NOT NULL,
  `zbid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `zbnowid` int(11) NOT NULL,
  `sid` text NOT NULL,
  `zbhp` varchar(255) NOT NULL,
  `qianghua` int(11) NOT NULL,
  `zblv` int(11) NOT NULL,
  `zbtool` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=75753 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `playerzhuangbei`
--

INSERT INTO `playerzhuangbei` (`zbname`, `zbinfo`, `zbgj`, `zbfy`, `zbbj`, `zbxx`, `zbid`, `uid`, `zbnowid`, `sid`, `zbhp`, `qianghua`, `zblv`, `zbtool`) VALUES
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 422, 75742, '3c9d1d6c8f225e9e4139cccd830fdd00', '40', 0, 0, 3),
('Kiếm minh nguyệt', 'Minh nguyệt  Minh nguyệt', '3', '0', '0', '1', 25, 426, 75672, '0ed4ce0a982475dad32cea331e8e50d7', '0', 0, 0, 1),
('Kiếm thị huyết sơ cấp', 'Kiếm thị huyết sơ cấp', '3', '0', '1', '3', 29, 431, 75659, '3bfa14243cba16bb92e090b54cc5d544', '0', 1, 0, 1),
('Kiếm thị huyết sơ cấp', 'Kiếm thị huyết sơ cấp', '2', '0', '1', '3', 29, 422, 75683, '3c9d1d6c8f225e9e4139cccd830fdd00', '0', 0, 0, 1),
('Kiếm thị huyết sơ cấp', 'Kiếm thị huyết sơ cấp', '2', '0', '1', '3', 29, 427, 75674, '9f98bca6ec1fa9e5b63f70012148b511', '0', 0, 0, 1),
('Kiếm thị huyết sơ cấp', 'Kiếm thị huyết sơ cấp', '2', '0', '1', '3', 29, 426, 75666, '0ed4ce0a982475dad32cea331e8e50d7', '0', 0, 0, 1),
('Côn vũ vẫn thiết', 'Côn vũ vẫn thiết', '11', '3', '1', '1', 36, 422, 75715, '3c9d1d6c8f225e9e4139cccd830fdd00', '0', 3, 0, 0),
('Bố y tân thủ', 'Bố y dùng cho tân thủ', '0', '2', '0', '0', 24, 427, 75675, '9f98bca6ec1fa9e5b63f70012148b511', '10', 0, 0, 3),
('Hộ giáp thanh phong', 'Lấy từ thanh phong thường bạn', '0', '5', '1', '0', 26, 426, 75669, '0ed4ce0a982475dad32cea331e8e50d7', '25', 0, 0, 3),
('Bố y tân thủ', 'Bố y dùng cho tân thủ', '0', '2', '0', '0', 24, 427, 75676, '9f98bca6ec1fa9e5b63f70012148b511', '10', 0, 0, 3),
('Bố y tân thủ', 'Bố y dùng cho tân thủ', '0', '2', '0', '0', 24, 427, 75677, '9f98bca6ec1fa9e5b63f70012148b511', '10', 0, 0, 3),
('Mũ nhẹ nhàng', 'Mũ nhẹ nhàng', '1', '8', '1', '0', 30, 424, 75678, 'f76c11b6601d3a6ce505c616b64ed478', '50', 2, 0, 2),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 0, 75679, '', '40', 0, 0, 3),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 431, 75752, '3bfa14243cba16bb92e090b54cc5d544', '40', 0, 0, 3),
('Kiếm thanh cương bách luyện', 'Kiếm thanh cương bách luyện', '13', '3', '0', '2', 27, 424, 75682, 'f76c11b6601d3a6ce505c616b64ed478', '0', 11, 0, 1),
('Kiếm minh nguyệt', 'Minh nguyệt  Minh nguyệt', '3', '0', '0', '1', 25, 422, 75741, '3c9d1d6c8f225e9e4139cccd830fdd00', '0', 0, 0, 1),
('Hộ giáp thanh phong', 'Lấy từ thanh phong thường bạn', '0', '5', '1', '0', 26, 0, 75685, '', '25', 0, 0, 3),
('Kiếm thị huyết sơ cấp', 'Kiếm thị huyết sơ cấp', '2', '0', '1', '3', 29, 0, 75687, '', '0', 0, 0, 1),
('Côn vũ vẫn thiết', 'Côn vũ vẫn thiết', '8', '3', '1', '1', 36, 422, 75717, '3c9d1d6c8f225e9e4139cccd830fdd00', '0', 0, 0, 0),
('Dây chuyền ưng huyết', 'Dây chuyền ưng huyết', '0', '3', '3', '5', 32, 424, 75713, 'f76c11b6601d3a6ce505c616b64ed478', '22', 2, 0, 0),
('Ưng lôihộ giáp', 'Ưng lôihộ giáp', '0', '8', '1', '0', 31, 431, 75711, '3bfa14243cba16bb92e090b54cc5d544', '55', 0, 0, 3),
('Thương nguyệt luân', 'Thương nguyệt luân', '10', '0', '0', '2', 37, 424, 75718, 'f76c11b6601d3a6ce505c616b64ed478', '0', 0, 0, 0),
('Mũ nhẹ nhàng', 'Mũ nhẹ nhàng', '0', '7', '1', '0', 30, 422, 75709, '3c9d1d6c8f225e9e4139cccd830fdd00', '50', 0, 0, 2),
('Ưng lôihộ giáp', 'Ưng lôihộ giáp', '0', '8', '1', '0', 31, 424, 75708, 'f76c11b6601d3a6ce505c616b64ed478', '55', 0, 0, 3),
('Bố y tân thủ', 'Bố y dùng cho tân thủ', '0', '2', '0', '0', 24, 422, 75740, '3c9d1d6c8f225e9e4139cccd830fdd00', '10', 0, 0, 3),
('Thương nguyệt luân', 'Thương nguyệt luân', '10', '0', '0', '2', 37, 424, 75719, 'f76c11b6601d3a6ce505c616b64ed478', '0', 0, 0, 0),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 422, 75745, '3c9d1d6c8f225e9e4139cccd830fdd00', '40', 0, 0, 3),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 422, 75746, '3c9d1d6c8f225e9e4139cccd830fdd00', '40', 0, 0, 3),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 422, 75744, '3c9d1d6c8f225e9e4139cccd830fdd00', '40', 0, 0, 3),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 422, 75743, '3c9d1d6c8f225e9e4139cccd830fdd00', '40', 0, 0, 3),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 434, 75747, 'e14b6e0d27bea46402a112c75c170887', '40', 0, 0, 3),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 0, 75748, '', '40', 0, 0, 3),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, 0, 75749, '', '40', 0, 0, 3),
('Kiếm thị huyết sơ cấp', 'Kiếm thị huyết sơ cấp', '2', '0', '1', '3', 29, 434, 75750, 'e14b6e0d27bea46402a112c75c170887', '0', 0, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `qy`
--

CREATE TABLE IF NOT EXISTS `qy` (
  `qyid` int(10) unsigned NOT NULL,
  `qyname` varchar(255) NOT NULL,
  `mid` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `qy`
--

INSERT INTO `qy` (`qyid`, `qyname`, `mid`) VALUES
(14, 'Làng Tân Thủ', 225),
(16, 'Thành Tụ Tiên', 239),
(17, 'Khu vực ma hóa', 249),
(18, 'Vạn thiên sơn vực', 260),
(20, 'Điện Yêu Vương', 267),
(21, 'Thành Viêm Dương', 272);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `renwu`
--

CREATE TABLE IF NOT EXISTS `renwu` (
  `rwname` varchar(255) NOT NULL,
  `rwzl` int(11) NOT NULL,
  `rwdj` varchar(255) NOT NULL,
  `rwzb` varchar(255) NOT NULL,
  `rwexp` varchar(255) NOT NULL,
  `rwyxb` varchar(255) NOT NULL,
  `rwid` int(11) unsigned NOT NULL,
  `rwyq` int(11) NOT NULL,
  `rwinfo` varchar(255) NOT NULL,
  `rwcount` int(11) NOT NULL,
  `rwlx` int(255) NOT NULL,
  `rwyp` text NOT NULL,
  `lastrwid` int(11) NOT NULL,
  `rwjineng` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `renwu`
--

INSERT INTO `renwu` (`rwname`, `rwzl`, `rwdj`, `rwzb`, `rwexp`, `rwyxb`, `rwid`, `rwyq`, `rwinfo`, `rwcount`, `rwlx`, `rwyp`, `lastrwid`, `rwjineng`) VALUES
('Lợn rừnggây loạn', 2, '1|5', '24', '100', '120', 13, 56, 'Gần đâyLợn rừngxuống núi,làm xáo trộn cuộc sống của chúng tôi,hãy giúp chúng tôi đuổi chúng đi', 5, 2, '6|3', 0, ''),
('Thu thập mật ong', 1, '1|5', '23', '200', '100', 14, 8, 'Thu thậpOng cánh cứng mật ong', 10, 2, '6|3', 0, ''),
('Man!', 2, '1|30,9|50', '38', '500', '500', 19, 76, 'Ma đạo luôn không chịu từ bỏ vùng đất này, đã quyến rũ nhiều người trong tộc chúng tôi nhập ma, hy vọng bạn có thể giải cứu họ', 50, 1, '', -1, ''),
('Giết!', 2, '1|50,9|50', '39', '600', '400', 20, 77, 'Tôi sợ quá, giúp tôi giết chúng!!!', 50, 1, '', -1, ''),
('Thú xích lânda', 2, '1|10,10|50', '39', '800', '350', 21, 82, 'Bộ lạc hiện đang thiếu nhiều da thú để qua đông', 30, 2, '', -1, ''),
('Ong cánh cứngquấy rối', 2, '1|15,6|100,7|100', '', '200', '150', 25, 55, 'Ong cánh cứngquấy rối', 20, 3, '', -1, ''),
('Tìm Vương đại mẫu', 3, '1|20', '25', '200', '100', 24, 11, 'Tìm Vương đại mẫu', 18, 3, '6|10', 25, ''),
('Cố nhân', 3, '1|50', '29', '400', '200', 28, 11, 'Cố nhân', 14, 1, '6|10', -1, ''),
('Đồ tận yêu vương', 1, '', '45', '2000', '2000', 27, 12, 'Đồ tận yêu vương', 150, 1, '9|5', -1, ''),
('Họa sói', 2, '1|100', '', '400', '300', 29, 62, 'Họa sóithành tai họa，giúp chúng tôi', 10, 3, '', 24, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng `userinfo`
--

CREATE TABLE IF NOT EXISTS `userinfo` (
  `username` text DEFAULT NULL,
  `userpass` text DEFAULT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=gb2312;

--
-- Dữ liệu bảng `userinfo`
--

INSERT INTO `userinfo` (`username`, `userpass`, `token`) VALUES
('abc837932126', 'zzq229', '5e957390699be5a489b946a522480951'),
('YourMotherBOOM', 's819122s', '4b88bef282a4169c5f980719f6f324c0'),
('1271716477', '1271716477', '69e38acedaba6f4d9a0944e211e36f29'),
('1915498868', '1542236297', '87f8e87109d981f3f161c43ea7b42189'),
('12717164777', '1271716477', 'b6d21580c1c7811d68dd35d45600fd09'),
('yyy123456', 'yyy123', 'f1649d9584c004a44ba1350164d27edf'),
('16668888', '123456', '98b3f6fab6dde596afb2ae0c47b39531'),
('eto258159', 'zaw258159', '7c94757e2a45dacae0e888442da982b5'),
('1666888', '123456', 'c508c53d00f8fcd0f39e3d2f858d2383'),
('1250189', '123456', 'dccd00acbf6308d1eab462bcf9972ba1'),
('niubie', 'niubie', 'd5cff8630f39f71e7ec544249084b884'),
('710942034', '333ypc', 'd64870bce6d7d20e4a357e9618e67f6a'),
('xu464720', 'xu1234', 'ee2ab04d5e49a7d6c7e878f1e8eeb4e7'),
('111111', '111111', '0457f756ac8208d9da6fa2e4f432d7d0'),
('weeeee', 'qwertasdfg', '5a5248decb098173bbb8d3ea930cec57'),
('cjg199618', '254893', '9b7a95672ac9a1691085ef9e329dac2e'),
('xxxxxx', 'uuuuuu', 'a8fcf8584ee2947bd79649d6eb30104b'),
('huagui', '199618', '5b5dabca397f9ad206ae516f2a9e8d8c'),
('uuuuuu', 'xxxxxx', '7843e60906c6513f94bc9fc97236ea97'),
('eeeeee', '111111', '0f8572ed68430a1b6ac13d4ee2bf93f4'),
('2783599178', '233666', '7dda1d028412c6fcb9c2afb1510152b3'),
('1041604633', '61339557656', 'f2b2094a95d316f8d7a552f4cf3d75fe'),
('1209133343', '3331234435', 'f2351f790fadec16742d905e246bfa71'),
('13511643472', '233666', '2b755b4ea9f3cd34f5b80db286628764'),
('hahaha', '123456', '868ac3606d3fe0e98b748b17dd624fa9'),
('liu2521533', '111111', '392e801e88183e1001e949d870b2a6f3'),
('1265558010', 'yanan123', '29045222da73fb9782ba587872fabe46'),
('123456', '123456', '3e096ced657944ff66bbdfc30d059f2a'),
('asdfgh', '1234567', 'a38573d6bd430a396762778c2a57a3f5'),
('13777659292', '112233', '267ed415573736c86d3346f251b3e520'),
('abc123321', '1234567', '87c15964d286a26de34a6f4019ba6705'),
('1545445717', 'a1545445716', 'f554e88102cb7c51daa99fbfb00c3e9d'),
('zs3718140', '123456', '6d50828b4238b267d3a5bf44a5123dc6'),
('wangjie123456', '654321', '082e250dca21694791c00e681018bec4'),
('1054114709', '159357', 'e861f921ea384970fa7d8a631ad970b0'),
('a61124012', '123123', 'ae838e961d88c52fb24a2211cd8df9d3'),
('drrream', '201123', 'b321da01f057955f92a83371075f205b'),
('444444', '444444', '8eb877c767d0923e0864ceda7da22d53'),
('325ice', 'woailuo', '1a78ea55d84b740f42a3efce9ed5e007'),
('bbbaaa', 'aaaaaa', 'c02cb4450e03cd0e0c03e13c0bf00aab'),
('5w4t54te', '5w4t54te', 'f76ef3699652871251c89b5daa1567a4'),
('18915345067', 'wzywenziye724', '48da7c96f39f0138234030c804d33ff2'),
('cs3230524', 'cs2231808', '15c1bb95e92c5ba671b98701e2556304'),
('瞎逼逼', '352314693', '7688935d61a9f93e118148ef538c5cdf'),
('1455182178', '123456000', 'b99a2d628f747ce11cee67c0a778a313'),
('89283578', 'wszw5499', '08323357072c9f5d3f9daba4d9160ec9'),
('15218904755', '5201314', '93b2ceb1e895525d1700a1b7da60a711'),
('978675771', 'yyh978', '0d320ad25e1c29a8ce1223212582814f'),
('j5124343', '61339557656', '424c1ee752e07eae30db59eb93b0e793'),
('123456789', '61339557656', '67a5407f3bd067f3259a2a65bdd52113'),
('987654321', '61339557656', 'f991439686643ce5b1d0fc0a872e3660'),
('135781012', '61339557656', '79c7b27b535b0f172f9d0a6d2cb4ed38'),
('321654987', '61339557656', 'ceb90aa43625658e02b37e5262319a83'),
('asdfghjkl', '61339557656', '0e5f92407cd53a7187bb4a9dbc480cc5'),
('qwertyuiop', '61339557656', '9b0ae73594eee043ba27787e570dba38'),
('zxcvbnm', '61339557656', 'b53becb04649ff45ad85775bab3cc36b'),
('liangzhuonan', '61339557656', '16987553a705e9d2a1ed9a6e3b9900e1'),
('liangshi', '61339557656', 'cc72c71386871c352079e12210e7777b'),
('dianmiao', '61339557656', '42a85d9370a75a565b2b818eedd0633f'),
('nigebichi', '61339557656', 'e9e8704fefec8fd1d952051d1f555f98'),
('leidabudong', '61339557656', 'd83aae370b73004b9b76aba715c7acd9'),
('jipinlingshi', '61339557656', 'f34082a434aeb8ea871793819e141f43'),
('huajianzang', '61339557656', '5e43532d3bacb52519bffb544b84a3b9'),
('leijing', '61339557656', '788d14d8963f492e39a85bf8ecdd52e7'),
('yijianlian', '61339557656', '1f366fe6a264e9adf9bc76bfb33c8298'),
('85674688', '1999421', '9d7cd9a310d5970ab345abcb6c40137a'),
('86574688A', '1999421', '798951873896caab5c98b77d4f008862'),
('205273565', 'q3588563', '6edf5a4d7e3d380b8286e51d8695240c'),
('86574688', '1999421', 'f005c160bf7e515eb9967c2c74b9b10a'),
('linsoft', '123456', '8124fdc27f2a79e6f871ec6064920de8'),
('23333333333333', '123321', '3af46cc8e2d77585d2a76e62ee3fb7a4'),
('123321', '123321', '4db2ef7c070ce3be4bb5972ea261298f'),
('770325272', '770325272', '769ceaffc8b1dc661597da0282628340'),
('1928517106', '770019299eee', '92fe7382f72a6cc9a9c14e218a124c3d'),
('q123456', 'q123456', '165948a212eba800ba9be7f0a281916d'),
('半瓶神仙醋', 'wei760825311wei', '05423485f5c6b18c97b2e89e537c5cc2'),
('666666666', '666666', '75a37f21fbf987ac3023b0a3dd95eed8'),
('koow763614984', '123123', 'fc3c996aa3fc468745882e4d6bc55ac8'),
('819769328', '819769328', '9e258680fc52af4887b54b3e5efa8210'),
('qqwert', '1232123', '91f8ffbb263713f6969b489f3b1ee355'),
('宁宁', '13967810490', 'bd326fa3658ab87708b6ff4be9547407'),
('http://121.42.197.43/', 'http://121.42.197.43/', 'c164b9838f550c5bba49c3aba87df54f'),
('index.php', 'index.php', '70a033a1669b8b19707e9dc12cf699f9'),
('aaaaaaa', 'aaaaaaa', '89defce711c850804269f99337badd50'),
('1048548080', 'ggbggb', '25b7b362c176783d5365e30a37427bb8'),
('zhq19881022', 'z19881022', '97cf9304672b8c36bcd10a1cbe010c49'),
('fuheiyanjingshe', '1301303', '5a49329d0f4cee494e377ac11350b28b'),
('zitaoikcye', 'zitaoikcye', '8307b852839ff6be183ffa78a74920af'),
('abc8379', 'zzq229', '1208716e3a1ceabdba921d6b15511975'),
('yosemite', '123123', '1439529dbb71319409aff44f86bf08c5'),
('yang1234', '123456', '89f2b25387611c9b467d46ad851acf48'),
('md123456', 'md123456', '813e6e0358a0f30227e2acdc6ca9c2be'),
('1663433965', '6897632436', 'e6436241096aab70186936c60748d499'),
('wnh964', 'wnhwnhsds', '83cb0e966edf86a29cf5aaca02e07f9d'),
('204643441', 'yjmily21', 'dcc475aba47251e543a2ff6ce031643a'),
('hoodhopelin123', 'games@hood.com', '1a52dfaca0d02d88e9a5722bc55a1c54'),
('15811187781', '1928517106eee', 'aba5a4adc0e3bc7f94051bf1504468f5'),
('星辰', 'gudao15333', '7eff274ed167595dc8b8eb4097f2c2cf'),
('457482471', '666666', 'd9beb5748b38f405039a0fe6e924fe45'),
('glasseye', 'loveyou228', 'c589878e0b29e165452491a6b6aa3489'),
('kakb818', '3319247', 'de07e73c3c6d0486ae3c40425724f671'),
('qeqeqqqqqq', 'qqqqqq', 'c115d1b82d35c15478ba12a9871f8dfc'),
('453521', '453520', 'e37b4bd21958bfc226f7c7acbcaa59f0'),
('o123456789', '232356', '7a3f0a2c0aff973e011bdd9e416a735f'),
('1151223116', '1151223116', 'd59d1172c186816e44e2709501932f5c'),
('2875587647', '1234567', '77d27871c06d75e4083bb2802bade9a9'),
('2570368303', '123456', '34651c934e918b33fe3f9303bd23b0c5'),
('2977404260', '123456789', '4367784356b95082004c3d56bb4fd91a'),
('1097684180', 'wangs1234', '45ac67975b73923ba28eff5d0d037e88'),
('2803026965', '15850968690', 'aa291e5c1d6c56e564bed74b5a7baf65'),
('567890', '111111', 'dd72c5fb910fe1162cb8f92a17b3546b'),
('yi5752', 'yi5752162', '01fd1e0856a6635d955c31d0115606c1'),
('5678901', '1111111', '62d7eadcb644eb171aa9d39969465e4c'),
('56789012', '1111111', '1874e0b5e152820c0b67769648608afc'),
('1035226874', '87654321', 'd7fe1c3e19b0a7b9e57dd5be51acba52'),
('z5128442', '111111', '94665eb922234025ceea22db8b2d6fb9'),
('z51284421', '111111', '3a277f1eb3acfa1412936be55d881f54'),
('z51284422', '111111', '14ab2accfba8493fd9e966f65acd6924'),
('2729842103', '000000000', '8c3589673a9b455c75dfa8f84b73c1a7'),
('2250630365', '123456789', 'f8916af2a167370a15a9bdfb11e0c5c3'),
('129324501', '1984357986', 'f58ca5771082595f53819021e41534a7'),
('怪你入戏太深° ', 'yjxwoshiyindage', 'b17265ae61cecbc2734a953a8a5e91fb'),
('811986590', 'a1994123', 'f1e98eefae129018dc728e27560c3a8b'),
('abc2902153217', '123456', 'eb859a5144f1a9221c85ce2fed7cc296'),
('2902153217', '555555', '3bd8bda9ec9ae388ac6b8cf853a6b0fc'),
('2643521720', 'chen5201314.', 'e66aa48378e646e6f1e952eb1a6e36b1'),
('533521', '533521', '3a162b4cefc4ff3655e1830bda953576'),
('ia670470664', '8513771', '47d70ff24778d60dd1d528d355f18243'),
('gudaotian', 'EFGGGOOD', '198d61c1a7f639d7fb26bf498e4a7ff5'),
('辅导员', 'efgg15333', '82ab3cec35710e73cb57a4512cdd20c7'),
('古道', 'efgg15333', '5e6b36602ba713d6ff9e17e8702ae9d8'),
('774508', '774508', '37ac8b7cc8f71c6383f72538c0d33f53'),
('cdf999', '111111', 'af89fb352b7f7fc4ed4cd68a562c0573'),
('y461796452', 'f461796452', '1675b1c9a6394cc2f699ebae3db5ee7f'),
('87654321', '12345678', '3c0516fdc5c38119e9d3a64fe563e543'),
('qweqwe', 'qweqwe', 'a31e735487b64d02a070098dd52ed0dd'),
('bingshi', '210585', 'cef08e184be356c9a29c96227bfc5e82'),
('linbei003', 'linbei003', '7c74486aac07e72c73e40a4af553fdad'),
('test123', 'test123', '75cb838ed90b1d93c3a6b6a62e0cc5fb'),
('zjsmzhq', 'zjsmzhq', '5200d24260152a80fb6aecd14481f7fa'),
('binglong12', 'wangziquan', '055b559be237d5a8e6d901b927bea5ec'),
('1qweqwe', 'Aa123123', 'ae43278211f0185f3a8e5ee9a1a27ef9'),
('aiwenaidan', 'aiwenaidan999', '7e13f649642331458114e979170a00d1'),
('1234568', '222222', '72525ad2f4491207dda26ab5e7e5a062'),
('111222', '111222', 'ff51c8d135ed761190d7e912c3d2c11a'),
('孤岛', '1533396', 'c8f024d1496d77eda1f699d8cbca7792'),
('1337433463', '05060212M', 'ab80e91531272ff0997fa1c325760e2a'),
('123456789z', '654321', 'adafc2f53d3720e8995108d412c4fc35'),
('1969928633', '654321', '2fc7f1fe8bca86103e8b6d43adc05ae2'),
('1771206859', '124578', 'd0ac22f1cef09342c5fc9f042eadebe3'),
('zgymwcom', 'zgymw.com', 'ac3e5adf7d0e79be7896202e3dab78d3'),
('1234560', '1234560', '2a9a4fe21d1ad97cb9332db57046a141'),
('863756430', '123456', '42c1bd4a4cf2cd1c9b75f1e12716a5dd'),
('风遥', '1234567', '00a0c1920eb8864b355c3650bc0b699a'),
('a616909678', 'ch19950202', '2d307ab463aec2b6e8c809d8d8535107'),
('abc7777', 'zzq229', '4c33599a414dd95f7ef15bf525105cda'),
('红尘眷恋', 'long@123', '33928791763a66d71e7efe966aee2729'),
('as123456', 'as12345', '7fb690dc08d7791ee464cecad6e728d9'),
('李迩芦', '19840927', '0aec8176b7498322c9536b782fcd4a51'),
('白秋', 'qgjx1212', 'd847bc33ef1e39ede1eda873d704cb1a'),
('541420514', '2318768', '216c8e1940050708a9e88c217dec46bb'),
('shuyan', 'xht9109', 'ce87dcdacb921bdbbee6d27ccdd1a1d6'),
('hehehe', '9518520', 'c442c3f71609edbc97a16818ac7675d1'),
('1112223338', '123654789', '7fd66b9135614055df24d4fb4d95aead'),
('abctest', 'abctest', '12175fdd4a028538b06343b3e053e809'),
('道长', '123456', 'e8f07fd9dd9747eb7061440ea1f95577'),
('道长1', '123456', '634a3ef9c704b392f57961fe7f5b8dea'),
('xing030411', '030411kjk', '044ca22581d263964fd0158282fadb42'),
('123456799', '123456789', '849e353e7d5ea864cdaac5915801bc75'),
('123123', '123456', '3523574420f1cad4018e802180ae440c'),
('982162639', 'www456789', '6b95038f4e35e4c204cd63c4291f47dc'),
('1098933710', 'A123459', 'c911094e95590dda0b8a0813dca6f27f'),
('abcd123', 'abcd123', 'a3f9ecbb5e8f608ebbf0416a51004bc7'),
('whytdl', '919926256', 'b9066cad96a2d83cc94596bbb09e763c'),
('abcdefg', '123456789', '0bcbf80f605a7a4b32629e5080292a39'),
('黑猫', 'heimao', '5bcf6db33b57444bec34f05cf5fab6e8'),
('2331292718', '895207', 'a5318beda844395277cc8ca528f9cd16'),
('道长2', '123456', '0244846e79462dd7f89732301276bd56'),
('1234567', '7777777', 'db7d71820512cabea82d964fb062e143'),
('q76891828', 'q76891828', 'd9ffd17ec312dd7d906d3d0bd09e9c33'),
('juhuaguai', '123456', '567e3d19771392bddf87d647b1c79370'),
('a1314520', 'a1314520', 'abec8758f4bb1bf557b0189d4e0ab5c6');

-- --------------------------------------------------------

--
-- Cấu trúc bảng `yaopin`
--

CREATE TABLE IF NOT EXISTS `yaopin` (
  `ypname` varchar(255) NOT NULL,
  `ypid` int(11) unsigned NOT NULL,
  `yphp` int(11) NOT NULL,
  `ypgj` int(11) NOT NULL,
  `ypfy` int(11) NOT NULL,
  `ypxx` int(11) NOT NULL,
  `ypbj` int(11) NOT NULL,
  `ypjg` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `yaopin`
--

INSERT INTO `yaopin` (`ypname`, `ypid`, `yphp`, `ypgj`, `ypfy`, `ypxx`, `ypbj`, `ypjg`) VALUES
('Đan hoàn nguyên', 6, 100, 0, 0, 0, 0, 30),
('Tán hồi huyết', 7, 300, 0, 0, 0, 0, 80),
('Tang hồi xuân', 8, 600, 0, 0, 0, 0, 155),
('Đan phục thương', 9, 1200, 0, 0, 0, 0, 310);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `zhuangbei`
--

CREATE TABLE IF NOT EXISTS `zhuangbei` (
  `zbname` varchar(255) NOT NULL,
  `zbinfo` varchar(255) NOT NULL,
  `zbgj` varchar(255) NOT NULL,
  `zbfy` varchar(255) NOT NULL,
  `zbbj` varchar(255) NOT NULL,
  `zbxx` varchar(255) NOT NULL,
  `zbid` int(11) NOT NULL,
  `zbhp` varchar(255) NOT NULL,
  `zblv` int(11) NOT NULL,
  `zbtool` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dữ liệu bảng `zhuangbei`
--

INSERT INTO `zhuangbei` (`zbname`, `zbinfo`, `zbgj`, `zbfy`, `zbbj`, `zbxx`, `zbid`, `zbhp`, `zblv`, `zbtool`) VALUES
('Kiếm gỗ tân thủ', 'Kiếm gỗ dùng cho tân thủ', '1', '0', '0', '1', 23, '0', 0, 1),
('Bố y tân thủ', 'Bố y dùng cho tân thủ', '0', '2', '0', '0', 24, '10', 0, 3),
('Kiếm minh nguyệt', 'Minh nguyệt  Minh nguyệt', '3', '0', '0', '1', 25, '0', 0, 1),
('Hộ giáp thanh phong', 'Lấy từ thanh phong thường bạn', '0', '5', '1', '0', 26, '25', 0, 3),
('Kiếm thanh cương bách luyện', 'Kiếm thanh cương bách luyện', '5', '0', '0', '2', 27, '0', 0, 1),
('Giáp nhẹ nhàng bách luyện', 'Giáp nhẹ nhàng bách luyện', '0', '8', '0', '0', 28, '40', 0, 3),
('Kiếm thị huyết sơ cấp', 'Kiếm thị huyết sơ cấp', '2', '0', '1', '3', 29, '0', 0, 1),
('Mũ nhẹ nhàng', 'Mũ nhẹ nhàng', '0', '7', '1', '0', 30, '50', 0, 2),
('Ưng lôihộ giáp', 'Ưng lôihộ giáp', '0', '8', '1', '0', 31, '55', 0, 3),
('Dây chuyền ưng huyết', 'Dây chuyền ưng huyết', '0', '3', '3', '5', 32, '20', 0, 0),
('Dao găm hắc ma', 'Dao găm hắc ma', '14', '0', '3', '4', 33, '0', 0, 0),
('Kiếm thị huyết trung cấp', 'Kiếm thị huyết trung cấp', '15', '0', '0', '4', 34, '0', 0, 0),
('Giáp man thường', 'Giáp man thường', '0', '9', '2', '0', 35, '62', 0, 0),
('Côn vũ vẫn thiết', 'Côn vũ vẫn thiết', '8', '3', '1', '1', 36, '0', 0, 0),
('Thương nguyệt luân', 'Thương nguyệt luân', '10', '0', '0', '2', 37, '0', 0, 0),
('Giáp hậu thổ', 'Giáp hậu thổ', '0', '10', '1', '0', 38, '120', 0, 0),
('Cốt nhẫn thị hồn', 'Cốt nhẫn thị hồn', '17', '0', '5', '3', 39, '0', 0, 0),
('Thương cuồng lan bách trảm', 'Cuồng lan bách trảm', '20', '0', '0', '5', 40, '0', 0, 0),
('Duyên Phong - Y khưu lôi', 'Duyên Phong - Y khưu lôi', '0', '10', '0', '0', 41, '150', 0, 0),
('Duyên Phong - Hài mặc hồn', 'Duyên Phong - Hài mặc hồn', '0', '10', '3', '0', 42, '155', 0, 0),
('Duyên Phong - Đai yêu phá quân', 'Duyên Phong - Đai yêu phá quân', '0', '14', '0', '0', 43, '170', 0, 0),
('Duyên Phong - Dây chuyền thú hồn', 'Duyên Phong - Dây chuyền thú hồn', '18', '12', '4', '4', 44, '55', 0, 0),
('[Thần khí] Kiếm Yêu Vương', '[Thần khí] Kiếm Yêu Vương\r\nyêuvươngHợp thành từ mảnh kiếm', '45', '0', '13', '11', 45, '0', 0, 0),
('Dao kiếp', 'Dao kiếp', '25', '0', '4', '5', 46, '0', 0, 0),
('Giáp xích quân dụng', 'Giáp xích quân dụng', '5', '16', '5', '0', 47, '170', 0, 0),
('Đao mạc quan quân', 'Đao mạc quan quân', '30', '0', '5', '4', 48, '0', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng `zhurenwu`
--

CREATE TABLE IF NOT EXISTS `zhurenwu` (
  `zrwname` varchar(255) NOT NULL,
  `zrwid` int(11) NOT NULL,
  `zrwyq` varchar(255) NOT NULL,
  `yqcount` varchar(255) NOT NULL,
  `zrwjldj` varchar(255) NOT NULL,
  `zrwjlzb` varchar(255) NOT NULL,
  `zrwjlyp` varchar(255) NOT NULL,
  `zrwjljn` varchar(255) NOT NULL,
  `lastid` int(11) NOT NULL,
  `zrwexp` int(11) NOT NULL,
  `zrwyxb` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boss`
--
ALTER TABLE `boss`
  ADD PRIMARY KEY (`bossid`);

--
-- Indexes for table `bugcollect`
--
ALTER TABLE `bugcollect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`clubid`);

--
-- Indexes for table `clubplayer`
--
ALTER TABLE `clubplayer`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `daoju`
--
ALTER TABLE `daoju`
  ADD PRIMARY KEY (`djid`);

--
-- Indexes for table `duihuan`
--
ALTER TABLE `duihuan`
  ADD PRIMARY KEY (`dhid`,`dhm`);

--
-- Indexes for table `fangshi_dj`
--
ALTER TABLE `fangshi_dj`
  ADD PRIMARY KEY (`payid`);

--
-- Indexes for table `fangshi_zb`
--
ALTER TABLE `fangshi_zb`
  ADD UNIQUE KEY `payid` (`payid`),
  ADD UNIQUE KEY `zbnowid` (`zbnowid`);

--
-- Indexes for table `fb`
--
ALTER TABLE `fb`
  ADD PRIMARY KEY (`fbid`);

--
-- Indexes for table `game1`
--
ALTER TABLE `game1`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `ggliaotian`
--
ALTER TABLE `ggliaotian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guaiwu`
--
ALTER TABLE `guaiwu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `im`
--
ALTER TABLE `im`
  ADD PRIMARY KEY (`imuid`);

--
-- Indexes for table `imliaotian`
--
ALTER TABLE `imliaotian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jineng`
--
ALTER TABLE `jineng`
  ADD PRIMARY KEY (`jnid`);

--
-- Indexes for table `mid`
--
ALTER TABLE `mid`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `midguaiwu`
--
ALTER TABLE `midguaiwu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npc`
--
ALTER TABLE `npc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playerchongwu`
--
ALTER TABLE `playerchongwu`
  ADD PRIMARY KEY (`cwid`);

--
-- Indexes for table `playerdaoju`
--
ALTER TABLE `playerdaoju`
  ADD UNIQUE KEY `djzl` (`djzl`);

--
-- Indexes for table `playerzhuangbei`
--
ALTER TABLE `playerzhuangbei`
  ADD PRIMARY KEY (`zbnowid`);

--
-- Indexes for table `qy`
--
ALTER TABLE `qy`
  ADD PRIMARY KEY (`qyid`);

--
-- Indexes for table `renwu`
--
ALTER TABLE `renwu`
  ADD PRIMARY KEY (`rwid`);

--
-- Indexes for table `yaopin`
--
ALTER TABLE `yaopin`
  ADD PRIMARY KEY (`ypid`);

--
-- Indexes for table `zhuangbei`
--
ALTER TABLE `zhuangbei`
  ADD PRIMARY KEY (`zbid`);

--
-- Indexes for table `zhurenwu`
--
ALTER TABLE `zhurenwu`
  ADD PRIMARY KEY (`zrwid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boss`
--
ALTER TABLE `boss`
  MODIFY `bossid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bugcollect`
--
ALTER TABLE `bugcollect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `clubid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `daoju`
--
ALTER TABLE `daoju`
  MODIFY `djid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `duihuan`
--
ALTER TABLE `duihuan`
  MODIFY `dhid` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `fangshi_dj`
--
ALTER TABLE `fangshi_dj`
  MODIFY `payid` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fangshi_zb`
--
ALTER TABLE `fangshi_zb`
  MODIFY `payid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `game1`
--
ALTER TABLE `game1`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=438;
--
-- AUTO_INCREMENT for table `ggliaotian`
--
ALTER TABLE `ggliaotian`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4138;
--
-- AUTO_INCREMENT for table `guaiwu`
--
ALTER TABLE `guaiwu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `imliaotian`
--
ALTER TABLE `imliaotian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `jineng`
--
ALTER TABLE `jineng`
  MODIFY `jnid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mid`
--
ALTER TABLE `mid`
  MODIFY `mid` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=274;
--
-- AUTO_INCREMENT for table `midguaiwu`
--
ALTER TABLE `midguaiwu`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2315092;
--
-- AUTO_INCREMENT for table `npc`
--
ALTER TABLE `npc`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `playerchongwu`
--
ALTER TABLE `playerchongwu`
  MODIFY `cwid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3593;
--
-- AUTO_INCREMENT for table `playerdaoju`
--
ALTER TABLE `playerdaoju`
  MODIFY `djzl` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=467;
--
-- AUTO_INCREMENT for table `playerzhuangbei`
--
ALTER TABLE `playerzhuangbei`
  MODIFY `zbnowid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75753;
--
-- AUTO_INCREMENT for table `qy`
--
ALTER TABLE `qy`
  MODIFY `qyid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `renwu`
--
ALTER TABLE `renwu`
  MODIFY `rwid` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `yaopin`
--
ALTER TABLE `yaopin`
  MODIFY `ypid` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `zhuangbei`
--
ALTER TABLE `zhuangbei`
  MODIFY `zbid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
