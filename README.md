# XXJserver

Game Text-Based PHP - Tự Ta Tu Tiên (修仙)

## 📋 Tổng Quan

Dự án game tu tiên text-based được viết bằng PHP. Đã được refactor để tuân thủ các chuẩn mực lập trình hiện đại và giảm thiểu code lặp.

## 🎯 Recent Improvements (Mới nhất)

**✨ Code Quality & Extensibility (2025-11-13):**
- ✅ Bootstrap file tự động load tất cả helpers/classes
- ✅ GameHandler class tập trung logic game chung
- ✅ Giảm 70-80% code lặp trong mỗi file game
- ✅ Tăng khả năng mở rộng và bảo trì
- ✅ Hướng dẫn setup và chạy game chi tiết (SETUP.md)

## 🎯 Refactoring Status

**Đã hoàn thành:**
- ✅ Tổ chức lại cấu trúc thư mục (src/, public/, config/, data/)
- ✅ Refactor các class chính: NguoiChoi, QuaiVat, TrangBi, BanDo, DaoCu, DuocPham, NhiemVu, TruongLao, KyNang, SungVat (10 classes)
- ✅ Đặt tên theo PSR-1/PSR-12 standards
- ✅ Thêm PHPDoc comments tiếng Việt đầy đủ
- ✅ Tạo helper functions với tên rõ ràng
- ✅ Tạo file config cho constants
- ✅ Compatibility layer với code cũ
- ✅ Examples và documentation
- ✅ Xóa 22+ files/directories không sử dụng
- ✅ **Di chuyển 41 files từ game/ sang src/Game/ với tên có ý nghĩa** (xem [GAME_MIGRATION.md](GAME_MIGRATION.md))
- ✅ **Hoàn tất migration: Xóa thư mục game/ cũ - tất cả files giờ đều dùng tên chuẩn trong src/Game/**

**Đang chờ:**
- ⏳ Migration nội dung 41 files trong src/Game/ sang code mới (xem [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md))

Xem chi tiết trong [REFACTORING.md](REFACTORING.md) và [SUMMARY.md](SUMMARY.md)

## 📁 Cấu Trúc Mới

```
XXJserver/
├── bootstrap.php           # ⭐ Auto-load helpers/classes (MỚI)
├── src/                    # Code refactored mới
│   ├── Classes/           # NguoiChoi, QuaiVat, TrangBi (10 classes)
│   ├── Core/              # ⭐ GameHandler - Logic chung (MỚI)
│   ├── Helpers/           # Helper functions (11 helpers)
│   └── Game/              # ⭐ Game logic files - TÊN CHUẨN (41 files) ✨
├── config/                # CauHinhGame - Constants
├── data/                  # Game data (sẽ thêm)
├── public/                # Entry points (sẽ di chuyển)
├── class/                 # Code cũ (giữ tương thích)
├── SETUP.md              # ⭐ Hướng dẫn cài đặt & chạy (MỚI)
├── examples-bootstrap.php # ⭐ Ví dụ sử dụng mới (MỚI)
├── compatibility.php      # Backward compatibility
├── examples.php           # Ví dụ sử dụng
├── REFACTORING.md        # Tài liệu chi tiết
└── GAME_MIGRATION.md     # Tài liệu di chuyển game/ ✨

```

## 🚀 Bắt Đầu

### Cài đặt và chạy game:
Xem hướng dẫn chi tiết trong [SETUP.md](SETUP.md)

### Sử dụng code mới (khuyến nghị):
```php
<?php
// Chỉ cần 1 dòng require thay vì 11 dòng!
require_once __DIR__ . '/bootstrap.php';

use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Core\GameHandler;

// Sử dụng GameHandler để giảm code lặp
$game = new GameHandler($dblj, $encode, $sid);
$nguoiChoi = $game->getNguoiChoi();

// Validation tự động
$validation = $game->validateBanDo($nowmid);
if (!$validation['valid']) {
    exit($validation['message']);
}
```

### Xem ví dụ:
```bash
# Ví dụ code cũ
php examples.php

# Ví dụ code mới với bootstrap & GameHandler
php examples-bootstrap.php
```

## 📖 Documentation

- [SETUP.md](SETUP.md) - **⭐ MỚI**: Hướng dẫn cài đặt và chạy game chi tiết
- [README.md](README.md) - Tổng quan dự án
- [REFACTORING.md](REFACTORING.md) - Hướng dẫn refactoring đầy đủ
- [SUMMARY.md](SUMMARY.md) - Tổng kết refactoring
- [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) - Hướng dẫn migrate game/ files
- [GAME_MIGRATION.md](GAME_MIGRATION.md) - Tài liệu di chuyển và đổi tên game files
- [examples.php](examples.php) - Ví dụ sử dụng code mới
- [examples-bootstrap.php](examples-bootstrap.php) - **⭐ MỚI**: Ví dụ bootstrap & GameHandler

## 🔄 Tương Thích

Code cũ vẫn hoạt động bình thường. Code mới được thêm vào song song để chuyển đổi dần.

## 👥 Contributors

Refactoring by GitHub Copilot Agent