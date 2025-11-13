# Tài Liệu Refactoring - Dự Án Game Tự Ta Tu Tiên

## Tổng Quan

Dự án này đã được refactor để tuân thủ các chuẩn mực lập trình hiện đại (PSR-1/PSR-12) với mục tiêu tăng tính dễ đọc, dễ bảo trì và mở rộng.

## Cấu Trúc Thư Mục Mới

```
XXJserver/
├── src/                    # Mã nguồn chính
│   ├── Classes/           # Các class chính của game
│   │   └── NguoiChoi.php # Class quản lý người chơi (refactored)
│   └── Helpers/           # Các hàm tiện ích
│       └── NguoiChoiHelper.php # Helper functions cho người chơi
├── public/                # Điểm vào ứng dụng (sẽ di chuyển index.php vào đây)
├── config/                # File cấu hình
│   └── CauHinhGame.php   # Các hằng số cấu hình game
├── data/                  # Dữ liệu game (mô tả vật phẩm, quái vật, v.v.)
├── class/                 # Thư mục cũ (giữ lại để tương thích ngược)
│   └── player.php        # Class người chơi phiên bản cũ
├── game/                  # Các file logic game
└── index.php             # File entry point chính
```

## Quy Tắc Đặt Tên

### 1. Class Names (PascalCase)
- **Cũ**: `player`, `guaiwu`, `clmid`
- **Mới**: `NguoiChoi`, `QuaiVat`, `BanDo`

### 2. Function Names (camelCase)
- **Cũ**: `getplayer()`, `changeexp()`, `upplayerlv()`
- **Mới**: `layThongTinNguoiChoi()`, `themKinhNghiem()`, `nangCapChoNguoiChoi()`

### 3. Variable Names (camelCase)
- **Cũ**: `$player`, `$dblj`, `$cxjg`
- **Mới**: `$nguoiChoi`, `$ketNoiDB`, `$ketQua`

### 4. Constants (SCREAMING_SNAKE_CASE)
- **Mới**: `CAP_DO_TOI_DA`, `HE_SO_KINH_NGHIEM`, `THOI_GIAN_OFFLINE_TOI_DA`

## Bảng Mapping Tên Cũ - Mới

### Classes

| Tên Cũ | Tên Mới | Mô Tả |
|---------|---------|-------|
| `player` | `NguoiChoi` | Class quản lý người chơi |
| `guaiwu` | `QuaiVat` | Class quản lý quái vật |
| `clmid` | `BanDo` | Class quản lý bản đồ |
| `zhuangbei` | `TrangBi` | Class quản lý trang bị |
| `yaopin` | `DuocPham` | Class quản lý dược phẩm |
| `daoju` | `DaoCu` | Class quản lý đạo cụ |
| `task` | `NhiemVu` | Class quản lý nhiệm vụ |
| `boss` | `TruongLao` | Class quản lý boss |
| `chongwu` | `SungVat` | Class quản lý sủng vật |
| `jineng` | `KyNang` | Class quản lý kỹ năng |

### Functions

| Tên Cũ | Tên Mới | Mô Tả |
|---------|---------|-------|
| `getplayer()` | `layThongTinNguoiChoi()` | Lấy thông tin người chơi |
| `changeexp()` | `themKinhNghiem()` | Thay đổi kinh nghiệm |
| `upplayerlv()` | `nangCapChoNguoiChoi()` | Nâng cấp người chơi |
| `changeyxb()` | `thayDoiTienTroChoi()` | Thay đổi tiền game |
| `getzb()` | `layThongTinTrangBi()` | Lấy thông tin trang bị |
| `addzb()` | `themTrangBi()` | Thêm trang bị |
| `useyaopin()` | `suDungDuocPham()` | Sử dụng dược phẩm |

### Properties (Thuộc tính)

| Tên Cũ | Tên Mới | Mô Tả |
|---------|---------|-------|
| `$uname` | `$tenNhanVat` | Tên nhân vật |
| `$uid` | `$idNguoiDung` | ID người dùng |
| `$sid` | `$idPhien` | Session ID |
| `$ulv` | `$capDo` | Cấp độ |
| `$uyxb` | `$tienTroChoi` | Tiền game |
| `$uczb` | `$tienNap` | Tiền nạp |
| `$uexp` | `$kinhNghiem` | Kinh nghiệm |
| `$umaxexp` | `$kinhNghiemToiDa` | Kinh nghiệm tối đa |
| `$uhp` | `$sinhMenh` | Sinh mệnh (HP) |
| `$umaxhp` | `$sinhMenhToiDa` | Sinh mệnh tối đa |
| `$ugj` | `$congKich` | Công kích |
| `$ufy` | `$phongNgu` | Phòng ngự |
| `$ubj` | `$baoKich` | Bạo kích |
| `$uxx` | `$hutMau` | Hút máu |
| `$uwx` | `$nguHanh` | Ngũ hành |
| `$usex` | `$gioiTinh` | Giới tính |
| `$nowmid` | `$idBanDoHienTai` | ID bản đồ hiện tại |
| `$jingjie` | `$canhGioi` | Cảnh giới |
| `$cengci` | `$tangCanhGioi` | Tầng cảnh giới |
| `$tfgj` | `$thienPhuCongKich` | Thiên phú công kích |
| `$tfxy` | `$thienPhuMayMan` | Thiên phú may mắn |
| `$tfsb` | `$thienPhuNeTranh` | Thiên phú né tránh |
| `$tfxx` | `$thienPhuHutMau` | Thiên phú hút máu |
| `$tfhp` | `$thienPhuSinhMenh` | Thiên phú sinh mệnh |
| `$tffy` | `$thienPhuPhongNgu` | Thiên phú phòng ngự |
| `$tfbj` | `$thienPhuBaoKich` | Thiên phú bạo kích |
| `$shenfen` | `$thanPhan` | Thân phận (class) |
| `$wugong` | `$voCong` | Võ công |

## PHPDoc Comments

Tất cả các class, function và method mới đều được bổ sung PHPDoc comments đầy đủ bằng tiếng Việt có dấu, bao gồm:

- Mô tả mục đích
- `@param` - Mô tả các tham số
- `@return` - Mô tả giá trị trả về
- `@var` - Mô tả các thuộc tính

### Ví dụ:

```php
/**
 * Lấy thông tin người chơi từ database theo session ID
 * 
 * Hàm này truy vấn database để lấy tất cả thông tin của người chơi,
 * bao gồm cả việc tính toán chỉ số từ trang bị và thiên phú
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return NguoiChoi|null Đối tượng người chơi hoặc null nếu không tìm thấy
 */
function layThongTinNguoiChoi($idPhien, $ketNoiDB)
{
    // Implementation
}
```

## File Cấu Hình

### config/CauHinhGame.php

File này chứa tất cả các hằng số cấu hình của game:

- Cấp độ và giới hạn
- Hệ số kinh nghiệm, công kích, phòng ngự
- Tên các cảnh giới tu luyện
- Hệ số thiên phú
- Thời gian và giới hạn

## Tương Thích Ngược

- Các file cũ vẫn được giữ nguyên trong thư mục `class/`
- Code mới được đặt trong `src/` để dễ phân biệt
- Có thể sử dụng song song cả hai phiên bản trong quá trình chuyển đổi

## Hướng Dẫn Sử Dụng

### Cài đặt và chạy ví dụ

```bash
# Chạy file ví dụ để xem code mới hoạt động
php examples.php
```

### Sử dụng class và function mới:

```php
<?php
// Include autoloader hoặc require file
require_once 'src/Classes/NguoiChoi.php';
require_once 'src/Helpers/NguoiChoiHelper.php';
require_once 'config/CauHinhGame.php';

use TuTaTuTien\Helpers;
use TuTaTuTien\Classes\NguoiChoi;

// Lấy thông tin người chơi
$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $pdo);

// Thêm kinh nghiệm
Helpers\themKinhNghiem($sid, 100, $pdo);

// Kiểm tra còn sống
if ($nguoiChoi->conSong()) {
    // Logic game
}
```

## Các Bước Tiếp Theo

1. ✅ Tạo cấu trúc thư mục mới
2. ✅ Refactor class NguoiChoi
3. ✅ Tạo file cấu hình
4. ✅ Tạo helper functions
5. ✅ Tạo class QuaiVat và TrangBi
6. ✅ Tạo compatibility layer
7. ✅ Tạo file examples.php với ví dụ sử dụng
8. ✅ Refactor các class còn lại (BanDo, DaoCu, DuocPham, NhiemVu, TruongLao, KyNang, SungVat)
9. ✅ Xóa các file backup không sử dụng (boss - *.php, test files)
10. ✅ Xóa các thư mục và file duplicate (chajian/tishikuang/chajian/, dialog.old.css, dialog.less)
11. ✅ Xóa .idea khỏi git tracking
12. ⏳ Di chuyển index.php vào public/
13. ⏳ Cập nhật các file game/ để sử dụng class mới (26 files còn lại)
14. ⏳ Kiểm tra và test toàn bộ hệ thống
15. ⏳ Loại bỏ code cũ sau khi đã chuyển đổi hoàn toàn

## Files Đã Tạo

### Cấu trúc (Structure)
- `.gitignore` - File ignore cho Git
- `REFACTORING.md` - Tài liệu hướng dẫn refactoring (file này)

### Classes  
- `src/Classes/NguoiChoi.php` - Class người chơi refactored
- `src/Classes/QuaiVat.php` - Class quái vật refactored
- `src/Classes/TrangBi.php` - Class trang bị refactored
- `src/Classes/BanDo.php` - Class bản đồ refactored
- `src/Classes/DaoCu.php` - Class đạo cụ refactored
- `src/Classes/DuocPham.php` - Class dược phẩm refactored
- `src/Classes/NhiemVu.php` - Class nhiệm vụ refactored
- `src/Classes/TruongLao.php` - Class boss refactored
- `src/Classes/KyNang.php` - Class kỹ năng refactored
- `src/Classes/SungVat.php` - Class sủng vật refactored

### Helpers
- `src/Helpers/NguoiChoiHelper.php` - Helper functions cho người chơi
- `src/Helpers/BanDoHelper.php` - Helper functions cho bản đồ

### Config
- `config/CauHinhGame.php` - Game constants và cấu hình

### Utilities
- `compatibility.php` - Layer tương thích ngược với code cũ
- `examples.php` - File ví dụ sử dụng code refactored

## Mapping Database Fields sang Properties Mới

### Bản Đồ (BanDo / clmid)
| Database Field | Old Property | New Property | Mô Tả |
|----------------|--------------|--------------|-------|
| `mname` | `$mname` | `$tenBanDo` | Tên bản đồ |
| `mgid` | `$mgid` | `$danhSachQuaiVat` | Danh sách quái vật |
| `mid` | `$mid` | `$idBanDo` | ID bản đồ |
| `mnpc` | `$mnpc` | `$danhSachNpc` | Danh sách NPC |
| `mup` | `$upmid` | `$idBanDoPhiaLen` | ID bản đồ phía trên |
| `mdown` | `$downmid` | `$idBanDoPhiaXuong` | ID bản đồ phía dưới |
| `mleft` | `$leftmid` | `$idBanDoPhiaTrai` | ID bản đồ bên trái |
| `mright` | `$rightmid` | `$idBanDoPhiaPhai` | ID bản đồ bên phải |
| `mgtime` | `$mgtime` | `$thoiGianLamMoiQuaiVat` | Thời gian làm mới |
| `midboss` | `$midboss` | `$idBoss` | ID boss |
| `ms` | `$ms` | `$trangThai` | Trạng thái |
| `midinfo` | `$midinfo` | `$moTaBanDo` | Mô tả |
| `mqy` | `$mqy` | `$idKhuVuc` | ID khu vực |
| `playerinfo` | `$playerinfo` | `$thongTinNguoiChoi` | Thông tin người chơi |
| `ispvp` | `$ispvp` | `$laBanDoPvp` | Bản đồ PVP |
| **game1.nowmid** | `$nowmid` | `$idBanDoHienTai` | **ID bản đồ hiện tại của người chơi** |

## Công Việc Dọn Dẹp (Cleanup Work)

### Files đã xóa (2025-11-13)

**Backup files trong game/ (6 files):**
- `game/boss - 0.php` - File backup cũ
- `game/boss - 12251230.php` - File backup cũ
- `game/boss - 1225副本.php` - File backup cũ
- `game/boss - 2022-2-12-.php` - File backup cũ
- `game/boss -20211223.php` - File backup cũ
- `game/20211225ceshi.php` - File test cũ

**Unused files trong game/ (6 files):**
- `game/ditu.php` - Không được sử dụng
- `game/fangshi2.php` - Không được sử dụng
- `game/ltmsg.php` - Không được sử dụng
- `game/php.php` - Không được sử dụng
- `game/pk.php` - Không được sử dụng
- `game/qiandao.php` - Không được sử dụng

**Duplicate/Old files:**
- `chajian/tishikuang/chajian/` - Thư mục duplicate nested
- `chajian/tishikuang/style/dialog.old.css` - CSS cũ không dùng
- `chajian/tishikuang/style/dialog.less` - LESS source không dùng
- `.idea/` - IDE configuration files (removed from git tracking)

**Tổng cộng:** Đã xóa 22+ files/directories không sử dụng

## Lưu Ý

- **Không xóa code cũ** cho đến khi đã test kỹ code mới
- **Thực hiện từng bước nhỏ** và test sau mỗi thay đổi
- **Backup database** trước khi chạy với code mới
- **Giữ nguyên logic game** - chỉ refactor cấu trúc và tên gọi

## Tác Giả

Refactoring được thực hiện theo yêu cầu modernization và chuẩn hóa codebase.

Ngày cập nhật: 2025-11-13
