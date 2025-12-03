# Hướng dẫn cài đặt và chạy XXJServer (Võ Hiệp Game)

Dưới đây là hướng dẫn chi tiết để cài đặt và chạy game server trên môi trường local.

## 1. Yêu cầu hệ thống

*   **PHP**: Phiên bản 7.4 trở lên.
*   **MySQL** (hoặc MariaDB): Phiên bản 5.6 trở lên.
*   **Composer**: Để quản lý thư viện PHP.
*   **Web Server**: Nginx, Apache, hoặc PHP Built-in Server (cho development).

## 2. Cài đặt

### Bước 1: Cài đặt các thư viện phụ thuộc
Mở terminal tại thư mục gốc của dự án và chạy lệnh:

```bash
composer install
```

Lệnh này sẽ tạo thư mục `vendor/` và tải các thư viện cần thiết cũng như thiết lập autoloading cho chuẩn MVC mới.

### Bước 2: Cấu hình Database

1.  Mở file `pdo.php` ở thư mục gốc.
2.  Chỉnh sửa các thông tin kết nối cho phù hợp với máy của bạn:

```php
<?php
$sqlname='root';      // Tên đăng nhập MySQL
$sqlpass='password';  // Mật khẩu MySQL
$dbhost='localhost';  // Host
$dbname='game';       // Tên database
// ...
?>
```

### Bước 3: Import Database

Bạn cần import cấu trúc database vào MySQL.
1.  Tạo database tên là `game` (hoặc tên bạn đã cấu hình ở trên).
2.  Import file SQL gốc của game vào database này.
    *   *Lưu ý: Nếu bạn không có file SQL gốc, game sẽ báo lỗi khi chạy vì thiếu các bảng `game1`, `mid`, `npc`, v.v.*

## 3. Chạy Game

### Cách 1: Sử dụng PHP Built-in Server (Nhanh nhất)

Đây là cách đơn giản nhất để chạy thử game mà không cần cài đặt Nginx hay Apache phức tạp.

Tại terminal thư mục gốc, chạy lệnh:

```bash
php -S localhost:8000
```

Sau đó mở trình duyệt và truy cập: [http://localhost:8000](http://localhost:8000)

### Cách 2: Sử dụng Nginx/Apache

Nếu dùng Nginx hoặc Apache, hãy trỏ **Document Root** vào thư mục gốc của dự án.
Đảm bảo server hỗ trợ PHP và đã bật module PDO MySQL.

## 4. Cấu trúc dự án mới (MVC)

Dự án đã được refactor từ code thuần sang mô hình MVC:

*   **`game.php`**: Router chính, điều hướng mọi request của game.
*   **`src/Controllers/`**: Chứa logic xử lý (Game, Player, Combat, NPC...).
*   **`src/Models/`**: Chứa các class đại diện cho dữ liệu (Player, Map, Item...).
*   **`src/Repositories/`**: Xử lý truy vấn Database.
*   **`views/`**: Chứa giao diện (HTML/PHP templates).
*   **`pdo.php`**: Cấu hình kết nối Database.

## 5. Các tài khoản test (Nếu có trong DB cũ)

Thường game sẽ có sẵn tài khoản admin hoặc bạn có thể đăng ký mới tại trang chủ.

---
**Lưu ý**:
*   Nếu gặp lỗi "Class not found", hãy chắc chắn bạn đã chạy `composer install`.
*   Nếu gặp lỗi kết nối Database, kiểm tra lại `pdo.php`.
