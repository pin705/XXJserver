<?php
/**
 * File helper functions cho nhiệm vụ
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng nhiệm vụ
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

require_once __DIR__ . '/../Classes/NhiemVu.php';

use TuTaTuTien\Classes\NhiemVu;

/**
 * Lấy thông tin nhiệm vụ từ database theo ID nhiệm vụ
 * 
 * @param int $idNhiemVu ID của nhiệm vụ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return NhiemVu|null Đối tượng nhiệm vụ hoặc null nếu không tìm thấy
 */
function layThongTinNhiemVu($idNhiemVu, $ketNoiDB)
{
    $nhiemVu = new NhiemVu();
    
    $sql = "SELECT * FROM renwu WHERE rwid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idNhiemVu]);
    
    $stmt->bindColumn('rwname', $nhiemVu->tenNhiemVu);
    $stmt->bindColumn('rwinfo', $nhiemVu->moTaNhiemVu);
    $stmt->bindColumn('rwzl', $nhiemVu->loaiNhiemVu);
    $stmt->bindColumn('rwid', $nhiemVu->idNhiemVu);
    $stmt->bindColumn('rwyq', $nhiemVu->yeuCauNhiemVu);
    $stmt->bindColumn('rwdj', $nhiemVu->daoCuThuong);
    $stmt->bindColumn('rwzb', $nhiemVu->trangBiThuong);
    $stmt->bindColumn('rwexp', $nhiemVu->kinhNghiemThuong);
    $stmt->bindColumn('rwyxb', $nhiemVu->tienTroChoiThuong);
    $stmt->bindColumn('rwcount', $nhiemVu->soLuongYeuCau);
    $stmt->bindColumn('rwlx', $nhiemVu->loaiThuong);
    $stmt->bindColumn('rwyp', $nhiemVu->duocPhamThuong);
    $stmt->bindColumn('lastrwid', $nhiemVu->idNhiemVuTruoc);
    $stmt->bindColumn('rwqy', $nhiemVu->idKhuVucNhiemVu);
    
    $result = $stmt->fetch(\PDO::FETCH_BOUND);
    
    if (!$result) {
        return null;
    }
    
    return $nhiemVu;
}

/**
 * Lấy nhiệm vụ của người chơi từ database
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idNhiemVu ID của nhiệm vụ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return NhiemVu|null Đối tượng nhiệm vụ hoặc null nếu không tìm thấy
 */
function layNhiemVuCuaNguoiChoi($idPhien, $idNhiemVu, $ketNoiDB)
{
    $nhiemVu = new NhiemVu();
    
    $sql = "SELECT * FROM playerrenwu WHERE sid = ? AND rwid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien, $idNhiemVu]);
    
    $stmt->bindColumn('rwname', $nhiemVu->tenNhiemVu);
    $stmt->bindColumn('rwid', $nhiemVu->idNhiemVu);
    $stmt->bindColumn('rwzl', $nhiemVu->loaiNhiemVu);
    $stmt->bindColumn('rwyq', $nhiemVu->yeuCauNhiemVu);
    $stmt->bindColumn('rwdj', $nhiemVu->daoCuThuong);
    $stmt->bindColumn('rwzb', $nhiemVu->trangBiThuong);
    $stmt->bindColumn('rwexp', $nhiemVu->kinhNghiemThuong);
    $stmt->bindColumn('rwyxb', $nhiemVu->tienTroChoiThuong);
    $stmt->bindColumn('rwzt', $nhiemVu->trangThaiNhiemVu);
    $stmt->bindColumn('rwcount', $nhiemVu->soLuongYeuCau);
    $stmt->bindColumn('rwnowcount', $nhiemVu->soLuongHienTai);
    $stmt->bindColumn('rwlx', $nhiemVu->loaiThuong);
    $stmt->bindColumn('rwyp', $nhiemVu->duocPhamThuong);
    
    $result = $stmt->fetch(\PDO::FETCH_BOUND);
    
    if (!$result) {
        return null;
    }
    
    $nhiemVu->idPhienNguoiChoi = $idPhien;
    
    return $nhiemVu;
}

/**
 * Lấy tất cả nhiệm vụ của người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng chứa các nhiệm vụ
 */
function layTatCaNhiemVuCuaNguoiChoi($idPhien, $ketNoiDB)
{
    $sql = "SELECT * FROM playerrenwu WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien]);
    
    return $stmt->fetchAll(\PDO::FETCH_BOUND);
}

/**
 * Cập nhật tiến độ nhiệm vụ
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idNhiemVu ID của nhiệm vụ
 * @param int $soLuongTangThem Số lượng tăng thêm
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, False nếu thất bại
 */
function capNhatTienDoNhiemVu($idPhien, $idNhiemVu, $soLuongTangThem, $ketNoiDB)
{
    $sql = "UPDATE playerrenwu SET rwnowcount = rwnowcount + ? WHERE sid = ? AND rwid = ? AND rwzt = 1";
    $stmt = $ketNoiDB->prepare($sql);
    $result = $stmt->execute([$soLuongTangThem, $idPhien, $idNhiemVu]);
    
    // Kiểm tra xem nhiệm vụ đã hoàn thành chưa
    if ($result) {
        $sql = "UPDATE playerrenwu SET rwzt = 2 
                WHERE sid = ? AND rwid = ? AND rwnowcount >= rwcount AND rwzt = 1";
        $stmt = $ketNoiDB->prepare($sql);
        $stmt->execute([$idPhien, $idNhiemVu]);
    }
    
    return $result;
}

/**
 * Nhận thưởng nhiệm vụ
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idNhiemVu ID của nhiệm vụ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, False nếu thất bại
 */
function nhanThuongNhiemVu($idPhien, $idNhiemVu, $ketNoiDB)
{
    $nhiemVu = layNhiemVuCuaNguoiChoi($idPhien, $idNhiemVu, $ketNoiDB);
    
    if (!$nhiemVu || !$nhiemVu->coTheNhanThuong()) {
        return false;
    }
    
    // Cập nhật trạng thái nhiệm vụ
    $sql = "UPDATE playerrenwu SET rwzt = 3 WHERE sid = ? AND rwid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    
    return $stmt->execute([$idPhien, $idNhiemVu]);
}
