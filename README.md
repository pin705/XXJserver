# XXJserver

Game Text-Based PHP - Tự Ta Tu Tiên (修仙)

## 📋 Tổng Quan

Dự án game tu tiên text-based được viết bằng PHP. Đã được refactor để tuân thủ các chuẩn mực lập trình hiện đại.

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

**Đang chờ:**
- ⏳ Migration nội dung 41 files trong src/Game/ sang code mới (xem [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md))

Xem chi tiết trong [REFACTORING.md](REFACTORING.md) và [SUMMARY.md](SUMMARY.md)

## 📁 Cấu Trúc Mới

```
XXJserver/
├── src/                    # Code refactored mới
│   ├── Classes/           # NguoiChoi, QuaiVat, TrangBi
│   ├── Helpers/           # Helper functions
│   └── Game/              # Game logic files (41 files) ✨ MỚI
├── config/                # CauHinhGame - Constants
├── data/                  # Game data (sẽ thêm)
├── public/                # Entry points (sẽ di chuyển)
├── class/                 # Code cũ (giữ tương thích)
├── game/                  # Logic game cũ (giữ tương thích ngược)
├── compatibility.php      # Backward compatibility
├── examples.php           # Ví dụ sử dụng
├── REFACTORING.md        # Tài liệu chi tiết
└── GAME_MIGRATION.md     # Tài liệu di chuyển game/ ✨ MỚI

```

## 🚀 Bắt Đầu

### Xem ví dụ code mới:
```bash
php examples.php
```

### Sử dụng trong code:
```php
<?php
use TuTaTuTien\Helpers;

// Lấy thông tin người chơi
$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $pdo);

// Thêm kinh nghiệm
Helpers\themKinhNghiem($sid, 1000, $pdo);
```

## 📖 Documentation

- [README.md](README.md) - Tổng quan dự án
- [REFACTORING.md](REFACTORING.md) - Hướng dẫn refactoring đầy đủ
- [SUMMARY.md](SUMMARY.md) - Tổng kết refactoring
- [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) - Hướng dẫn migrate game/ files
- [GAME_MIGRATION.md](GAME_MIGRATION.md) - **MỚI**: Tài liệu di chuyển và đổi tên game files
- [examples.php](examples.php) - Ví dụ sử dụng code mới

## 🔄 Tương Thích

Code cũ vẫn hoạt động bình thường. Code mới được thêm vào song song để chuyển đổi dần.

## 👥 Contributors

Refactoring by GitHub Copilot Agent