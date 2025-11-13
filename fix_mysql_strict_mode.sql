-- Fix MySQL Strict Mode Issues
-- Chạy file này để tắt strict mode cho session hiện tại

-- Kiểm tra sql_mode hiện tại
SELECT @@sql_mode;

-- Tắt strict mode (chỉ cho session hiện tại)
SET SESSION sql_mode = '';

-- Hoặc tắt một số mode cụ thể (recommended)
SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';

-- Để tắt vĩnh viễn, thêm vào file my.cnf hoặc my.ini:
-- [mysqld]
-- sql_mode = "NO_ENGINE_SUBSTITUTION"

-- Sau khi chạy lệnh trên, kiểm tra lại:
SELECT @@sql_mode;
