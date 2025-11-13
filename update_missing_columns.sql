-- Migration: Add missing columns to game1 table
-- Date: 2025-11-13
-- Purpose: Fix "Did not find column name" warnings

-- Add missing equipment column
ALTER TABLE game1 ADD COLUMN tool7 VARCHAR(255) DEFAULT NULL COMMENT 'Trang bị slot 7';

-- Add VIP exchange tracking columns
ALTER TABLE game1 ADD COLUMN dhvip INT DEFAULT 0 COMMENT 'Đã đổi VIP trang bị';
ALTER TABLE game1 ADD COLUMN dhvip1 INT DEFAULT 0 COMMENT 'Đã đổi VIP trang bị 1';

-- Add talent/attribute point columns (Thiên phú)
ALTER TABLE game1 ADD COLUMN tf INT DEFAULT 0 COMMENT 'Điểm thiên phú';
ALTER TABLE game1 ADD COLUMN tfgj INT DEFAULT 0 COMMENT 'Thiên phú - Công kích';
ALTER TABLE game1 ADD COLUMN tfxy INT DEFAULT 0 COMMENT 'Thiên phú - May mắn';
ALTER TABLE game1 ADD COLUMN tfsb INT DEFAULT 0 COMMENT 'Thiên phú - Né tránh';
ALTER TABLE game1 ADD COLUMN tfxx INT DEFAULT 0 COMMENT 'Thiên phú - Hút máu';
ALTER TABLE game1 ADD COLUMN tfhp INT DEFAULT 0 COMMENT 'Thiên phú - Sinh mệnh';
ALTER TABLE game1 ADD COLUMN tffy INT DEFAULT 0 COMMENT 'Thiên phú - Phòng ngự';
ALTER TABLE game1 ADD COLUMN tfbj INT DEFAULT 0 COMMENT 'Thiên phú - Bạo kích';

-- Add martial arts column
ALTER TABLE game1 ADD COLUMN wugong VARCHAR(255) DEFAULT NULL COMMENT 'Võ công';

-- Add pill/elixir columns (Dược đan)
ALTER TABLE game1 ADD COLUMN yd1 VARCHAR(255) DEFAULT NULL COMMENT 'Dược đan 1';
ALTER TABLE game1 ADD COLUMN yd2 VARCHAR(255) DEFAULT NULL COMMENT 'Dược đan 2';
ALTER TABLE game1 ADD COLUMN yd3 VARCHAR(255) DEFAULT NULL COMMENT 'Dược đan 3';
