# Migration Guide - Hướng Dẫn Chuyển Đổi Code

## Tổng Quan

Document này hướng dẫn chi tiết cách chuyển đổi các file trong thư mục `game/` từ code cũ sang sử dụng các class mới đã được refactor.

## Tình Trạng Hiện Tại

### Files Đã Được Dọn Dẹp
- ✅ Đã xóa 12 files backup/test không sử dụng
- ✅ Đã xóa duplicate directories
- ✅ Đã xóa .idea khỏi git

### Files Cần Migrate (42 files)

#### Ưu Tiên Cao (10+ lần gọi old code)
| File | Lines | Old Calls | Complexity | Priority |
|------|-------|-----------|------------|----------|
| boss.php | 544 | 36 | Cao | 1 |
| pvp.php | 190 | 27 | Cao | 2 |
| pve.php | 491 | 26 | Cao | 3 |
| task.php | 175 | 19 | Trung bình | 4 |
| nowmid.php | 488 | 16 | Cao | 5 |
| xiulian.php | 101 | 13 | Thấp | 6 |
| playertaskinfo.php | 89 | 13 | Thấp | 7 |
| ydinfo.php | 222 | 12 | Trung bình | 8 |
| jninfo.php | 73 | 12 | Thấp | 9 |
| duihuan.php | 204 | 12 | Trung bình | 10 |
| wugong.php | 125 | 11 | Trung bình | 11 |
| chongwu.php | 207 | 11 | Trung bình | 12 |
| xxwg.php | 201 | 10 | Trung bình | 13 |

#### Ưu Tiên Trung Bình (5-9 lần gọi old code)
| File | Lines | Old Calls | Complexity | Priority |
|------|-------|-----------|------------|----------|
| tupo.php | 221 | 9 | Trung bình | 14 |
| fangshi.php | 275 | 9 | Trung bình | 15 |
| bagdj.php | 72 | 9 | Thấp | 16 |
| shangdian.php | 255 | 8 | Trung bình | 17 |
| club.php | 176 | 8 | Trung bình | 18 |
| bagzb.php | 201 | 7 | Trung bình | 19 |
| zbinfo.php | 186 | 6 | Trung bình | 20 |
| ypinfo.php | 81 | 6 | Thấp | 21 |
| qydt.php | 232 | 6 | Trung bình | 22 |
| djinfo.php | 77 | 6 | Thấp | 23 |
| otherzhuangtai.php | 165 | 5 | Trung bình | 24 |
| ginfo.php | 144 | 5 | Trung bình | 25 |
| bossinfo.php | 62 | 5 | Thấp | 26 |

#### Ưu Tiên Thấp (1-4 lần gọi old code)
| File | Lines | Old Calls | Complexity |
|------|-------|-----------|------------|
| zhuangtai.php | 306 | 3 | Trung bình |
| paihang.php | 42 | 3 | Thấp |
| zbinfo_sys.php | 24 | 2 | Thấp |
| liaotian.php | 81 | 2 | Thấp |
| clublist.php | 32 | 2 | Thấp |
| bagyd.php | 63 | 2 | Thấp |
| allmap.php | 44 | 2 | Thấp |
| playertask.php | 51 | 1 | Thấp |
| im.php | 42 | 1 | Thấp |
| bagjn.php | 36 | 1 | Thấp |

#### Không Cần Migrate (0 lần gọi old code)
| File | Lines | Status |
|------|-------|--------|
| tianfu.php | 217 | Đã sử dụng code mới hoặc không phụ thuộc |
| taozhuang.php | 285 | Đã sử dụng code mới hoặc không phụ thuộc |
| fy.php | 159 | Đã sử dụng code mới hoặc không phụ thuộc |
| cj.php | 33 | Đã sử dụng code mới hoặc không phụ thuộc |
| bagyp.php | 35 | Đã sử dụng code mới hoặc không phụ thuộc |

## Pattern Chuyển Đổi

### 1. Thay Thế Function Calls

#### Old Code (Cũ)
```php
<?php
$player = \player\getplayer($sid, $dblj);
$boss = \player\getboss($bossid, $dblj);
$guaiwu = \player\getguaiwu($gid, $dblj);
\player\changeexp($sid, $dblj, 100);
```

#### New Code (Mới)
```php
<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $ketNoiDB);
// Boss và QuaiVat helpers cần được tạo tương tự
$boss = Helpers\layThongTinBoss($bossid, $ketNoiDB);
$quaiVat = Helpers\layThongTinQuaiVat($gid, $ketNoiDB);
Helpers\themKinhNghiem($sid, 100, $ketNoiDB);
```

### 2. Mapping Functions Cũ → Mới

| Old Function | New Helper Function | File |
|--------------|---------------------|------|
| `\player\getplayer()` | `Helpers\layThongTinNguoiChoi()` | NguoiChoiHelper.php |
| `\player\changeexp()` | `Helpers\themKinhNghiem()` | NguoiChoiHelper.php |
| `\player\upplayerlv()` | `Helpers\nangCapChoNguoiChoi()` | NguoiChoiHelper.php |
| `\player\changeyxb()` | `Helpers\thayDoiTienTroChoi()` | NguoiChoiHelper.php |
| `\player\getboss()` | `Helpers\layThongTinBoss()` | ⚠️ Cần tạo |
| `\player\getguaiwu()` | `Helpers\layThongTinQuaiVat()` | ⚠️ Cần tạo |
| `\player\getmid()` | `Helpers\layThongTinBanDo()` | BanDoHelper.php |
| `\player\getdaoju()` | `Helpers\layThongTinDaoCu()` | DaoCuHelper.php |
| `\player\gettask()` | `Helpers\layThongTinNhiemVu()` | NhiemVuHelper.php |

⚠️ **Lưu ý:** Một số helper functions vẫn chưa được tạo và cần được implement trước khi migrate.

### 3. Variable Name Mapping

| Old Variable | New Variable |
|--------------|--------------|
| `$player->uname` | `$nguoiChoi->tenNhanVat` |
| `$player->ulv` | `$nguoiChoi->capDo` |
| `$player->uhp` | `$nguoiChoi->sinhMenh` |
| `$player->nowmid` | `$nguoiChoi->idBanDoHienTai` |
| `$dblj` | `$ketNoiDB` |

## Quy Trình Migration Từng Bước

### Bước 1: Chuẩn Bị
1. Backup database
2. Test code cũ để đảm bảo working baseline
3. Tạo branch mới cho migration

### Bước 2: Tạo Missing Helper Functions
Trước khi migrate, cần tạo các helper functions còn thiếu:
- [ ] BossHelper.php (TruongLaoHelper.php)
- [ ] QuaiVatHelper.php
- [ ] TrangBiHelper.php
- [ ] DuocPhamHelper.php
- [ ] KyNangHelper.php
- [ ] SungVatHelper.php

### Bước 3: Migration Từng File
Bắt đầu với các file ưu tiên thấp (ít dependencies):
1. Chọn file từ danh sách ưu tiên thấp
2. Backup file gốc
3. Thay thế function calls theo pattern
4. Test functionality
5. Commit nếu thành công

### Bước 4: Testing
- Test từng file sau khi migrate
- Test integration giữa các files
- Test toàn bộ game flow

### Bước 5: Cleanup
Sau khi tất cả files đã được migrate và test:
- Xóa class/player.php (giữ backup)
- Cập nhật game.php để không include class/player.php nữa
- Update documentation

## Helper Code Examples

### Ví dụ: Migrate bossinfo.php

**Before:**
```php
<?php
$boss = \player\getboss($bossid,$dblj);
$zbkzb = \player\getzbkzb($newstr,$dblj);
$dj = \player\getdaoju($newstr,$dblj);
$yp = \player\getyaopinonce($newstr,$dblj);
```

**After:**
```php
<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
use TuTaTuTien\Helpers as Helpers;

$boss = Helpers\layThongTinBoss($bossid, $ketNoiDB);
$zbkzb = Helpers\layThongTinTrangBi($newstr, $ketNoiDB);
$dj = Helpers\layThongTinDaoCu($newstr, $ketNoiDB);
$yp = Helpers\layThongTinDuocPham($newstr, $ketNoiDB);
```

## Lộ Trình Đề Xuất

### Phase 1: Tạo Missing Helpers (1-2 tuần)
- Tạo tất cả helper functions còn thiếu
- Test helpers với examples.php
- Document usage patterns

### Phase 2: Migrate Low-Priority Files (1 tuần)
- Migrate 10 files ưu tiên thấp
- Test từng file
- Document issues encountered

### Phase 3: Migrate Medium-Priority Files (2 tuần)
- Migrate 13 files ưu tiên trung bình
- Extensive testing
- Performance monitoring

### Phase 4: Migrate High-Priority Files (2-3 tuần)
- Migrate 13 files ưu tiên cao (phức tạp nhất)
- Full integration testing
- User acceptance testing

### Phase 5: Cleanup & Documentation (1 tuần)
- Remove old code
- Update all documentation
- Create migration completion report

**Tổng thời gian ước tính: 7-9 tuần**

## Rủi Ro và Giảm Thiểu

| Rủi Ro | Mức Độ | Giảm Thiểu |
|--------|--------|------------|
| Breaking game functionality | Cao | Extensive testing, backup, gradual rollout |
| Performance degradation | Trung bình | Performance benchmarking trước/sau |
| Database inconsistency | Cao | Database backup, transaction handling |
| Missing edge cases | Trung bình | Comprehensive test cases |

## Kết Luận

Migration là một dự án lớn đòi hỏi:
- **Thời gian:** 7-9 tuần với 1 developer full-time
- **Testing:** Extensive testing sau mỗi thay đổi
- **Patience:** Migrate từng file một, không rush
- **Backup:** Luôn có backup trước khi thay đổi

**Khuyến nghị:** Thực hiện migration dần dần, test kỹ từng bước, và có thể rollback nếu cần.

---
Generated: 2025-11-13
