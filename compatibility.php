<?php
/**
 * Compatibility Layer - Lớp tương thích ngược
 * 
 * File này cung cấp các wrapper functions để code cũ có thể
 * gọi code mới mà không cần thay đổi
 * 
 * @package TuTaTuTien
 */

// Include các file mới
require_once __DIR__ . '/src/Classes/NguoiChoi.php';
require_once __DIR__ . '/src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/config/CauHinhGame.php';

use TuTaTuTien\Helpers as Helpers;

/**
 * Wrapper cho hàm getplayer cũ
 * Gọi hàm mới layThongTinNguoiChoi
 * 
 * @param string $sid Session ID
 * @param \PDO $dblj Kết nối database
 * @return object Đối tượng player (tương thích với code cũ)
 * @deprecated Sử dụng Helpers\layThongTinNguoiChoi() thay thế
 */
function getplayer_new($sid, $dblj)
{
    $nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
    
    if (!$nguoiChoi) {
        return null;
    }
    
    // Chuyển đổi sang format cũ để tương thích
    $player = new \stdClass();
    $player->uname = $nguoiChoi->tenNhanVat;
    $player->sid = $nguoiChoi->idPhien;
    $player->uid = $nguoiChoi->idNguoiDung;
    $player->ulv = $nguoiChoi->capDo;
    $player->uyxb = $nguoiChoi->tienTroChoi;
    $player->uczb = $nguoiChoi->tienNap;
    $player->uexp = $nguoiChoi->kinhNghiem;
    $player->umaxexp = $nguoiChoi->kinhNghiemToiDa;
    $player->uhp = $nguoiChoi->sinhMenh;
    $player->umaxhp = $nguoiChoi->sinhMenhToiDa;
    $player->ugj = $nguoiChoi->congKich;
    $player->ufy = $nguoiChoi->phongNgu;
    $player->ubj = $nguoiChoi->baoKich;
    $player->uxx = $nguoiChoi->hutMau;
    $player->uwx = $nguoiChoi->nguHanh;
    $player->usex = $nguoiChoi->gioiTinh;
    $player->vip = $nguoiChoi->vip;
    $player->nowmid = $nguoiChoi->idBanDoHienTai;
    $player->endtime = $nguoiChoi->thoiGianKetThuc;
    $player->jingjie = $nguoiChoi->canhGioi;
    $player->cengci = $nguoiChoi->tangCanhGioi;
    $player->ispvp = $nguoiChoi->trangThaiPvp;
    $player->sfzx = $nguoiChoi->trangThaiOnline;
    
    return $player;
}

/**
 * Wrapper cho hàm changeexp cũ
 * Gọi hàm mới themKinhNghiem
 * 
 * @param string $sid Session ID
 * @param \PDO $dblj Kết nối database
 * @param int $exp Số kinh nghiệm cần thêm
 * @return bool Kết quả thực hiện
 * @deprecated Sử dụng Helpers\themKinhNghiem() thay thế
 */
function changeexp_new($sid, $dblj, $exp)
{
    return Helpers\themKinhNghiem($sid, $exp, $dblj);
}

/**
 * Wrapper cho hàm upplayerlv cũ
 * Gọi hàm mới nangCapChoNguoiChoi
 * 
 * @param string $sid Session ID
 * @param \PDO $dblj Kết nối database
 * @return bool Kết quả thực hiện
 * @deprecated Sử dụng Helpers\nangCapChoNguoiChoi() thay thế
 */
function upplayerlv_new($sid, $dblj)
{
    return Helpers\nangCapChoNguoiChoi($sid, $dblj);
}

/**
 * Helper để chuyển đổi từ đối tượng cũ sang mới
 * 
 * @param object $playerCu Đối tượng player cũ
 * @return \TuTaTuTien\Classes\NguoiChoi Đối tượng NguoiChoi mới
 */
function chuyenDoiSangNguoiChoiMoi($playerCu)
{
    $nguoiChoi = new \TuTaTuTien\Classes\NguoiChoi();
    $nguoiChoi->tenNhanVat = $playerCu->uname ?? '';
    $nguoiChoi->idPhien = $playerCu->sid ?? '';
    $nguoiChoi->idNguoiDung = $playerCu->uid ?? 0;
    $nguoiChoi->capDo = $playerCu->ulv ?? 1;
    $nguoiChoi->tienTroChoi = $playerCu->uyxb ?? 0;
    $nguoiChoi->tienNap = $playerCu->uczb ?? 0;
    $nguoiChoi->kinhNghiem = $playerCu->uexp ?? 0;
    $nguoiChoi->kinhNghiemToiDa = $playerCu->umaxexp ?? 100;
    $nguoiChoi->sinhMenh = $playerCu->uhp ?? 100;
    $nguoiChoi->sinhMenhToiDa = $playerCu->umaxhp ?? 100;
    $nguoiChoi->congKich = $playerCu->ugj ?? 10;
    $nguoiChoi->phongNgu = $playerCu->ufy ?? 5;
    $nguoiChoi->baoKich = $playerCu->ubj ?? 0;
    $nguoiChoi->hutMau = $playerCu->uxx ?? 0;
    $nguoiChoi->nguHanh = $playerCu->uwx ?? 0;
    $nguoiChoi->gioiTinh = $playerCu->usex ?? 0;
    $nguoiChoi->vip = $playerCu->vip ?? 0;
    $nguoiChoi->idBanDoHienTai = $playerCu->nowmid ?? '';
    $nguoiChoi->thoiGianKetThuc = $playerCu->endtime ?? '';
    $nguoiChoi->canhGioi = $playerCu->jingjie ?? '';
    $nguoiChoi->tangCanhGioi = $playerCu->cengci ?? '';
    
    return $nguoiChoi;
}

/**
 * Helper để chuyển đổi từ đối tượng mới sang cũ
 * 
 * @param \TuTaTuTien\Classes\NguoiChoi $nguoiChoi Đối tượng NguoiChoi mới
 * @return object Đối tượng player cũ
 */
function chuyenDoiSangPlayerCu($nguoiChoi)
{
    $player = new \stdClass();
    $player->uname = $nguoiChoi->tenNhanVat;
    $player->sid = $nguoiChoi->idPhien;
    $player->uid = $nguoiChoi->idNguoiDung;
    $player->ulv = $nguoiChoi->capDo;
    $player->uyxb = $nguoiChoi->tienTroChoi;
    $player->uczb = $nguoiChoi->tienNap;
    $player->uexp = $nguoiChoi->kinhNghiem;
    $player->umaxexp = $nguoiChoi->kinhNghiemToiDa;
    $player->uhp = $nguoiChoi->sinhMenh;
    $player->umaxhp = $nguoiChoi->sinhMenhToiDa;
    $player->ugj = $nguoiChoi->congKich;
    $player->ufy = $nguoiChoi->phongNgu;
    $player->ubj = $nguoiChoi->baoKich;
    $player->uxx = $nguoiChoi->hutMau;
    $player->uwx = $nguoiChoi->nguHanh;
    $player->usex = $nguoiChoi->gioiTinh;
    $player->vip = $nguoiChoi->vip;
    $player->nowmid = $nguoiChoi->idBanDoHienTai;
    $player->endtime = $nguoiChoi->thoiGianKetThuc;
    $player->jingjie = $nguoiChoi->canhGioi;
    $player->cengci = $nguoiChoi->tangCanhGioi;
    
    return $player;
}
