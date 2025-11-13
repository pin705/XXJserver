-- Thêm cột shenfen (thân phận) vào bảng game1
-- Chạy file này để update database nếu lỗi khi tạo nhân vật

ALTER TABLE `game1` ADD `shenfen` INT(11) NOT NULL DEFAULT '1' AFTER `sfzx`;

-- Mô tả giá trị:
-- 1: Chiến sĩ
-- 2: Hiệp sĩ  
-- 3: Ẩn sĩ
