-- Fix: Add default value for nowguaiwu column
-- Date: 2025-11-13
-- Purpose: Fix "Field 'nowguaiwu' doesn't have a default value" error

-- Thêm default value cho cột nowguaiwu
ALTER TABLE game1 MODIFY COLUMN nowguaiwu INT DEFAULT 0 COMMENT 'ID quái vật đang đánh';

-- Hoặc nếu cột chưa tồn tại, tạo mới:
-- ALTER TABLE game1 ADD COLUMN nowguaiwu INT DEFAULT 0 COMMENT 'ID quái vật đang đánh';
