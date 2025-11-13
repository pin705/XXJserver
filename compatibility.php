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

// ============================================================
// Compatibility wrappers cho các class mới được refactor
// ============================================================

// Include các file mới
require_once __DIR__ . '/src/Classes/BanDo.php';
require_once __DIR__ . '/src/Classes/DaoCu.php';
require_once __DIR__ . '/src/Classes/NhiemVu.php';
require_once __DIR__ . '/src/Helpers/BanDoHelper.php';
require_once __DIR__ . '/src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/src/Helpers/NhiemVuHelper.php';

use TuTaTuTien\Helpers\BanDoHelper;
use TuTaTuTien\Helpers\DaoCuHelper;
use TuTaTuTien\Helpers\NhiemVuHelper;

/**
 * Wrapper cho hàm getmid cũ (lấy thông tin bản đồ)
 * Gọi hàm mới layThongTinBanDo
 * 
 * @param int $mid ID bản đồ
 * @param \PDO $dblj Kết nối database
 * @return object Đối tượng clmid (tương thích với code cũ)
 * @deprecated Sử dụng BanDoHelper\layThongTinBanDo() thay thế
 */
function getmid_new($mid, $dblj)
{
    $banDo = BanDoHelper\layThongTinBanDo($mid, $dblj);
    
    if (!$banDo) {
        return null;
    }
    
    // Chuyển đổi sang format cũ để tương thích
    $clmid = new \stdClass();
    $clmid->mname = $banDo->tenBanDo;
    $clmid->mgid = $banDo->danhSachQuaiVat;
    $clmid->mid = $banDo->idBanDo;
    $clmid->mnpc = $banDo->danhSachNpc;
    $clmid->upmid = $banDo->idBanDoPhiaLen;
    $clmid->downmid = $banDo->idBanDoPhiaXuong;
    $clmid->leftmid = $banDo->idBanDoPhiaTrai;
    $clmid->rightmid = $banDo->idBanDoPhiaPhai;
    $clmid->mgtime = $banDo->thoiGianLamMoiQuaiVat;
    $clmid->midboss = $banDo->idBoss;
    $clmid->ms = $banDo->trangThai;
    $clmid->midinfo = $banDo->moTaBanDo;
    $clmid->mqy = $banDo->idKhuVuc;
    $clmid->playerinfo = $banDo->thongTinNguoiChoi;
    $clmid->ispvp = $banDo->laBanDoPvp;
    
    return $clmid;
}

/**
 * Wrapper cho hàm getplayerdaoju cũ
 * Gọi hàm mới layDaoCuCuaNguoiChoi
 * 
 * @param string $sid Session ID
 * @param int $djid ID đạo cụ
 * @param \PDO $dblj Kết nối database
 * @return object Đối tượng daoju (tương thích với code cũ)
 * @deprecated Sử dụng DaoCuHelper\layDaoCuCuaNguoiChoi() thay thế
 */
function getplayerdaoju_new($sid, $djid, $dblj)
{
    $daoCu = DaoCuHelper\layDaoCuCuaNguoiChoi($sid, $djid, $dblj);
    
    if (!$daoCu) {
        return null;
    }
    
    // Chuyển đổi sang format cũ
    $daoju = new \stdClass();
    $daoju->djname = $daoCu->tenDaoCu;
    $daoju->djzl = $daoCu->idDaoCuNguoiChoi;
    $daoju->djinfo = $daoCu->moTaDaoCu;
    $daoju->djid = $daoCu->idDaoCu;
    $daoju->djsum = $daoCu->soLuong;
    
    return $daoju;
}

/**
 * Wrapper cho hàm gettask cũ
 * Gọi hàm mới layThongTinNhiemVu
 * 
 * @param int $rwid ID nhiệm vụ
 * @param \PDO $dblj Kết nối database
 * @return object Đối tượng task (tương thích với code cũ)
 * @deprecated Sử dụng NhiemVuHelper\layThongTinNhiemVu() thay thế
 */
function gettask_new($rwid, $dblj)
{
    $nhiemVu = NhiemVuHelper\layThongTinNhiemVu($rwid, $dblj);
    
    if (!$nhiemVu) {
        return null;
    }
    
    // Chuyển đổi sang format cũ
    $task = new \stdClass();
    $task->rwname = $nhiemVu->tenNhiemVu;
    $task->rwinfo = $nhiemVu->moTaNhiemVu;
    $task->rwid = $nhiemVu->idNhiemVu;
    $task->rwzl = $nhiemVu->loaiNhiemVu;
    $task->rwyq = $nhiemVu->yeuCauNhiemVu;
    $task->rwdj = $nhiemVu->daoCuThuong;
    $task->rwzb = $nhiemVu->trangBiThuong;
    $task->rwexp = $nhiemVu->kinhNghiemThuong;
    $task->rwyxb = $nhiemVu->tienTroChoiThuong;
    $task->rwcount = $nhiemVu->soLuongYeuCau;
    $task->rwlx = $nhiemVu->loaiThuong;
    $task->rwyp = $nhiemVu->duocPhamThuong;
    $task->lastrwid = $nhiemVu->idNhiemVuTruoc;
    $task->rwqy = $nhiemVu->idKhuVucNhiemVu;
    
    return $task;
}

