# Hướng Dẫn Cài Đặt và Chạy Game - XXJserver

## 📋 Mục Lục

1. [Yêu Cầu Hệ Thống](#yêu-cầu-hệ-thống)
2. [Cài Đặt](#cài-đặt)
3. [Cấu Hình Database](#cấu-hình-database)
4. [Cấu Hình Web Server](#cấu-hình-web-server)
5. [Chạy Game](#chạy-game)
6. [Cấu Trúc Dự Án](#cấu-trúc-dự-án)
7. [Troubleshooting](#troubleshooting)

---

## 🖥️ Yêu Cầu Hệ Thống

### Phần Mềm Cần Thiết

- **PHP**: >= 7.4 (khuyến nghị PHP 8.0+)
- **MySQL/MariaDB**: >= 5.7 (khuyến nghị 8.0+)
- **Web Server**: 
  - Apache 2.4+ với mod_rewrite, hoặc
  - Nginx 1.18+, hoặc
  - PHP Built-in Server (chỉ dành cho development)

### PHP Extensions Cần Thiết

```bash
php -m | grep -E 'pdo|pdo_mysql|mbstring|json'
```

Các extension bắt buộc:
- `pdo`
- `pdo_mysql`
- `mbstring`
- `json`
- `session`

### Cài Đặt PHP Extensions (nếu thiếu)

**Ubuntu/Debian:**
```bash
sudo apt-get install php-pdo php-mysql php-mbstring php-json
```

**CentOS/RHEL:**
```bash
sudo yum install php-pdo php-mysqlnd php-mbstring php-json
```

**Windows (XAMPP/WAMP):**
- Mở file `php.ini`
- Bỏ comment (xóa dấu `;`) các dòng:
  ```ini
  extension=pdo_mysql
  extension=mbstring
  ```

---

## 📦 Cài Đặt

### Bước 1: Clone Repository

```bash
git clone https://github.com/pin705/XXJserver.git
cd XXJserver
```

### Bước 2: Thiết Lập Quyền Truy Cập

**Linux/macOS:**
```bash
# Cấp quyền đọc/ghi cho thư mục
chmod -R 755 .
chmod -R 777 images/
chmod -R 777 css/

# Nếu cần tạo thư mục logs
mkdir -p logs
chmod 777 logs
```

**Windows:**
- Đảm bảo user chạy web server có quyền đọc/ghi với thư mục dự án

---

## 🗄️ Cấu Hình Database

### Bước 1: Tạo Database

```bash
# Đăng nhập MySQL
mysql -u root -p

# Tạo database
CREATE DATABASE xxjserver CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Tạo user (tùy chọn, cho bảo mật)
CREATE USER 'xxjserver_user'@'localhost' IDENTIFIED BY 'password_mạnh_ở_đây';
GRANT ALL PRIVILEGES ON xxjserver.* TO 'xxjserver_user'@'localhost';
FLUSH PRIVILEGES;

EXIT;
```

### Bước 2: Import Database Schema

```bash
# Import file SQL
mysql -u root -p xxjserver < game.sql
```

### Bước 3: Cấu Hình Kết Nối Database

Mở file `pdo.php` và cập nhật thông tin kết nối:

```php
<?php
$host = 'localhost';        // Database host
$dbname = 'xxjserver';      // Tên database
$username = 'xxjserver_user'; // Username
$password = 'password_mạnh_ở_đây'; // Password

try {
    $dblj = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
```

---

## 🌐 Cấu Hình Web Server

### Option 1: Apache

#### Cấu Hình VirtualHost (khuyến nghị)

Tạo file `/etc/apache2/sites-available/xxjserver.conf`:

```apache
<VirtualHost *:80>
    ServerName xxjserver.local
    DocumentRoot /path/to/XXJserver
    
    <Directory /path/to/XXJserver>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/xxjserver_error.log
    CustomLog ${APACHE_LOG_DIR}/xxjserver_access.log combined
</VirtualHost>
```

Enable site và module:
```bash
sudo a2enmod rewrite
sudo a2ensite xxjserver
sudo systemctl restart apache2
```

Thêm vào `/etc/hosts`:
```
127.0.0.1   xxjserver.local
```

#### Sử dụng .htaccess (đã có sẵn)

File `.htaccess` đã được cấu hình sẵn trong dự án.

### Option 2: Nginx

Tạo file `/etc/nginx/sites-available/xxjserver`:

```nginx
server {
    listen 80;
    server_name xxjserver.local;
    root /path/to/XXJserver;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

Enable và restart:
```bash
sudo ln -s /etc/nginx/sites-available/xxjserver /etc/nginx/sites-enabled/
sudo systemctl restart nginx
sudo systemctl restart php8.0-fpm
```

### Option 3: PHP Built-in Server (Development Only)

```bash
cd /path/to/XXJserver
php -S localhost:8000
```

Truy cập: `http://localhost:8000`

---

## 🎮 Chạy Game

### Bước 1: Truy Cập Game

Mở trình duyệt và truy cập:

- **Apache/Nginx**: `http://xxjserver.local`
- **PHP Built-in**: `http://localhost:8000`

### Bước 2: Đăng Ký Tài Khoản

1. Truy cập trang chủ
2. Nhấn vào "Đăng ký" hoặc truy cập `reguser.php`
3. Điền thông tin đăng ký
4. Tạo nhân vật

### Bước 3: Đăng Nhập và Chơi

1. Đăng nhập với tài khoản đã tạo
2. Bắt đầu hành trình tu tiên!

---

## 📁 Cấu Trúc Dự Án

```
XXJserver/
├── bootstrap.php           # ⭐ File tự động load helpers/classes (MỚI)
├── game.php               # Entry point chính của game
├── index.php              # Trang chủ
├── pdo.php                # Cấu hình database
├── reguser.php            # Đăng ký người dùng
│
├── src/                   # Code hiện đại (PSR-compliant)
│   ├── Classes/           # Các class game chính
│   │   ├── NguoiChoi.php
│   │   ├── QuaiVat.php
│   │   ├── TrangBi.php
│   │   └── ... (10 classes)
│   │
│   ├── Core/              # ⭐ Core game logic (MỚI)
│   │   └── GameHandler.php
│   │
│   ├── Helpers/           # Helper functions
│   │   ├── NguoiChoiHelper.php
│   │   ├── TrangBiHelper.php
│   │   └── ... (11 helpers)
│   │
│   └── Game/              # Game logic files
│       ├── BanDoHienTai.php
│       ├── ChienDauQuaiVat.php
│       └── ... (41 files)
│
├── config/                # Cấu hình
│   └── CauHinhGame.php
│
├── class/                 # Code cũ (tương thích ngược)
│   └── player.php
│
├── game/                  # Game logic cũ (tương thích ngược)
│
├── css/                   # Stylesheets
├── js/                    # JavaScript files
├── images/                # Hình ảnh game
│
└── *.md                   # Documentation
```

---

## 🎯 Sử Dụng Code Mới

### Cách 1: Sử dụng Bootstrap (Khuyến nghị)

```php
<?php
// Chỉ cần require bootstrap một lần
require_once __DIR__ . '/bootstrap.php';

use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Core\GameHandler;

// Tất cả helpers và classes đã được load tự động
$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);

// Sử dụng GameHandler để giảm code lặp
$game = new GameHandler($dblj, $encode, $sid);
$player = $game->getNguoiChoi();
$linkQuayVe = $game->getLinkQuayVeBanDo();
```

### Cách 2: Require Thủ Công (Cách cũ)

```php
<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
// ... (nhiều require khác)

use TuTaTuTien\Helpers as Helpers;
```

---

## ⚙️ Cấu Hình Game

### File config/CauHinhGame.php

Chứa các hằng số cấu hình game:

```php
<?php
namespace TuTaTuTien\Config;

class CauHinhGame 
{
    const CAP_DO_TOI_DA = 999;
    const HE_SO_KINH_NGHIEM = 1.5;
    // ... các hằng số khác
}
```

### Bật Debug Mode (Development)

Trong `bootstrap.php`:

```php
define('DEBUG_MODE', true);  // Bật debug logging
define('PRODUCTION_MODE', false);  // Bật error reporting
```

---

## 🐛 Troubleshooting

### Lỗi: "Database connection failed"

**Nguyên nhân**: Không kết nối được database

**Giải pháp**:
1. Kiểm tra MySQL service đang chạy:
   ```bash
   sudo systemctl status mysql
   ```
2. Kiểm tra thông tin đăng nhập trong `pdo.php`
3. Kiểm tra database đã được tạo và import đúng

### Lỗi: "Class not found"

**Nguyên nhân**: Chưa require bootstrap hoặc helper files

**Giải pháp**:
```php
// Thêm vào đầu file
require_once __DIR__ . '/bootstrap.php';
```

### Lỗi: "Headers already sent"

**Nguyên nhân**: Output trước khi gọi `session_start()` hoặc `header()`

**Giải pháp**:
1. Đảm bảo không có khoảng trắng trước `<?php`
2. Kiểm tra file có BOM không (lưu dưới dạng UTF-8 without BOM)

### Lỗi 404 - Not Found

**Apache**: Bật mod_rewrite
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

**Nginx**: Kiểm tra cấu hình `try_files` trong nginx config

### Trang trắng / Blank Page

**Giải pháp**:
1. Bật error reporting:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```
2. Kiểm tra PHP error log:
   ```bash
   tail -f /var/log/apache2/error.log
   # hoặc
   tail -f /var/log/nginx/error.log
   ```

### Database charset issues

**Giải pháp**: Đảm bảo database sử dụng UTF-8:
```sql
ALTER DATABASE xxjserver CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 🔒 Bảo Mật

### Production Checklist

- [ ] Tắt error reporting trong production
- [ ] Đổi password database mặc định
- [ ] Cấu hình firewall chỉ cho phép port cần thiết
- [ ] Sử dụng HTTPS (SSL/TLS)
- [ ] Backup database định kỳ
- [ ] Giới hạn quyền truy cập thư mục
- [ ] Cập nhật PHP và MySQL thường xuyên

### File cần bảo vệ

Đảm bảo các file sau không thể truy cập trực tiếp từ web:

- `pdo.php` - Chứa thông tin database
- `config/` - Thư mục cấu hình
- `.git/` - Git repository
- `*.sql` - File database

Thêm vào `.htaccess`:
```apache
<Files "pdo.php">
    Require all denied
</Files>

<FilesMatch "\.(sql|md)$">
    Require all denied
</FilesMatch>
```

---

## 📚 Tài Liệu Thêm

- [README.md](README.md) - Tổng quan dự án
- [REFACTORING.md](REFACTORING.md) - Tài liệu refactoring
- [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) - Hướng dẫn migrate code
- [GAME_MIGRATION.md](GAME_MIGRATION.md) - Tài liệu di chuyển game files

---

## 💡 Tips

### Development

1. **Sử dụng PHP Built-in Server** cho development nhanh:
   ```bash
   php -S localhost:8000
   ```

2. **Bật debug mode** để dễ debug:
   ```php
   define('DEBUG_MODE', true);
   ```

3. **Sử dụng bootstrap.php** để giảm code lặp

### Production

1. **Tắt debug mode**:
   ```php
   define('DEBUG_MODE', false);
   define('PRODUCTION_MODE', true);
   ```

2. **Optimize PHP**:
   - Bật OPcache
   - Tăng memory_limit nếu cần
   - Optimize database queries

3. **Backup thường xuyên**:
   ```bash
   mysqldump -u root -p xxjserver > backup_$(date +%Y%m%d).sql
   ```

---

## 🆘 Hỗ Trợ

Nếu gặp vấn đề:

1. Kiểm tra [Troubleshooting](#troubleshooting) section
2. Kiểm tra logs: `debug.log`, Apache/Nginx error logs
3. Tạo issue trên GitHub repository

---

**Version**: 1.0.0  
**Cập nhật**: 2025-11-13  
**Tác giả**: XXJserver Development Team
