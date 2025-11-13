# Quick Reference - Hướng Dẫn Nhanh

## Cách Sử Dụng Bootstrap và GameHandler

### 1️⃣ Thay Thế Requires (Bước đầu tiên)

**❌ TRƯỚC (Code cũ - lặp lại 11 dòng):**
```php
<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/QuaiVatHelper.php';
require_once __DIR__ . '/../src/Helpers/TruongLaoHelper.php';
require_once __DIR__ . '/../src/Helpers/NhiemVuHelper.php';
require_once __DIR__ . '/../src/Helpers/BanDoHelper.php';
require_once __DIR__ . '/../src/Helpers/SungVatHelper.php';
require_once __DIR__ . '/../src/Helpers/KyNangHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;
```

**✅ SAU (Code mới - chỉ 1 dòng):**
```php
<?php
require_once __DIR__ . '/../bootstrap.php';
use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Core\GameHandler;
```

---

### 2️⃣ Validation Bản Đồ

**❌ TRƯỚC:**
```php
$player = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$player->sid");

if ($nowmid != $player->idBanDoHienTai) {
    $html = <<<HTML
        Mời bình thường chơi đùa！<br/>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
    echo $html;
    exit();
}
```

**✅ SAU:**
```php
$game = new GameHandler($dblj, $encode, $sid);
$validation = $game->validateBanDo($nowmid);

if (!$validation['valid']) {
    exit($validation['message']);
}

$player = $game->getNguoiChoi();
```

---

### 3️⃣ Validation PVP

**❌ TRƯỚC (~25 dòng):**
```php
$cxmid = Helpers\layThongTinBanDo($player->idBanDoHienTai, $dblj);
$pvper = Helpers\layThongTinNguoiChoiTheoUid($uid, $dblj);

if ($cxmid->ispvp == 0) {
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp", 0, $sid, $dblj);
    $tishihtml = 'Trước mắt địa đồ không cho phép PK<br/><br/>';
    $tishihtml .= '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}

if ($pvper->sfzx == 0) {
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp", 0, $sid, $dblj);
    $tishihtml = 'Nên người chơi không có online<br/><br/>';
    $tishihtml .= '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}

if ($pvper->idBanDoHienTai != $player->idBanDoHienTai) {
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp", 0, $sid, $dblj);
    $tishihtml = 'Nên người chơi không có ở nơi đó đồ<br/><br/>';
    $tishihtml .= '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
// ... nhiều checks khác
```

**✅ SAU (5 dòng):**
```php
$game = new GameHandler($dblj, $encode, $sid);
$pvpValidation = $game->validatePVP($uid);

if (!$pvpValidation['valid']) {
    exit($pvpValidation['message']);
}

$target = $pvpValidation['target'];
```

---

### 4️⃣ Tạo Links

**❌ TRƯỚC:**
```php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$player->sid");
$pvecmd = $encode->encode("cmd=pve&gid=$gid&sid=$sid&nowmid=$nowmid");
```

**✅ SAU:**
```php
$game = new GameHandler($dblj, $encode, $sid);

$gonowmid = $game->getLinkQuayVeBanDo();
$pvecmd = $game->createLink('pve', ['gid' => $gid, 'nowmid' => $nowmid]);
```

---

### 5️⃣ Error Messages

**❌ TRƯỚC:**
```php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$player->sid");
$html = 'Lỗi xảy ra!<br/><br/>';
$html .= '<a href="?cmd='.$gonowmid.'">Trở về</a>';
echo $html;
exit;
```

**✅ SAU:**
```php
$game = new GameHandler($dblj, $encode, $sid);
exit($game->createErrorMessage('Lỗi xảy ra!'));
```

---

## GameHandler Methods Reference

### Khởi Tạo
```php
$game = new GameHandler($dblj, $encode, $sid);
```

### Quản Lý Người Chơi
```php
$player = $game->getNguoiChoi();           // Lấy người chơi hiện tại
$player = $game->reloadNguoiChoi();        // Reload từ DB
```

### Tạo Links
```php
$link = $game->createLink($cmd, $params);         // Tạo link với params tùy chỉnh
$link = $game->getLinkQuayVeBanDo();             // Link về bản đồ hiện tại
$link = $game->getLinkQuayVeKhuVuc();            // Link về khu vực
```

### Validation
```php
$result = $game->validateBanDo($nowmid);         // Validate bản đồ
// Returns: ['valid' => bool, 'message' => string]

$result = $game->validatePVP($targetUid);        // Validate PVP
// Returns: ['valid' => bool, 'message' => string, 'target' => NguoiChoi|null]

$alive = $game->nguoiChoiConSong();              // Kiểm tra còn sống
$online = $game->nguoiChoiDangOnline();          // Kiểm tra online
```

### Utilities
```php
$msg = $game->createErrorMessage($message);      // Tạo error message với link back
$msg = $game->createErrorMessage($msg, $link);   // Với custom link

$duocPham = $game->getThongTinDuocPhamTrangBi(); // Info 3 dược phẩm
$kyNang = $game->getThongTinKyNangTrangBi();     // Info 3 kỹ năng
```

---

## Migration Checklist

Khi update một file game:

- [ ] Thay 11 requires bằng `require_once __DIR__ . '/../bootstrap.php'`
- [ ] Add `use TuTaTuTien\Core\GameHandler;`
- [ ] Tạo GameHandler: `$game = new GameHandler($dblj, $encode, $sid);`
- [ ] Thay validation bản đồ bằng `$game->validateBanDo($nowmid)`
- [ ] Thay PVP checks bằng `$game->validatePVP($uid)` (nếu có)
- [ ] Thay link generation bằng GameHandler methods
- [ ] Thay error messages bằng `$game->createErrorMessage()`
- [ ] Test file hoạt động đúng

---

## Lợi Ích

✅ **Giảm 70-80% code lặp**  
✅ **Dễ maintain hơn**  
✅ **Ít bug hơn** (logic tập trung một chỗ)  
✅ **Dễ mở rộng** (thêm method vào GameHandler)  
✅ **Tuân thủ PSR** standards  
✅ **Type-safe** với PHPDoc  

---

## Files Tham Khảo

- `bootstrap.php` - Bootstrap source
- `src/Core/GameHandler.php` - GameHandler source  
- `examples-bootstrap.php` - Ví dụ đầy đủ
- `SETUP.md` - Setup guide
- `game/ginfo.php` - File đã migrate làm mẫu
- `game/bossinfo.php` - File đã migrate đơn giản

---

**Happy Coding!** 🚀
