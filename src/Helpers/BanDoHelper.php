<?php
/**
 * File helper functions cho bản đồ
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng bản đồ,
 * bao gồm truy vấn database, điều hướng giữa các bản đồ, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

require_once __DIR__ . '/../Classes/BanDo.php';

use TuTaTuTien\Classes\BanDo;

/**
 * Lấy thông tin bản đồ từ database theo ID bản đồ
 * 
 * Hàm này truy vấn database để lấy tất cả thông tin của bản đồ,
 * bao gồm quái vật, NPC, và các bản đồ kết nối
 * 
 * @param int $idBanDo ID của bản đồ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return BanDo|null Đối tượng bản đồ hoặc null nếu không tìm thấy
 */
function layThongTinBanDo($idBanDo, $ketNoiDB)
{
    $banDo = new BanDo();
    
    // Truy vấn thông tin bản đồ từ database
    $sql = "SELECT * FROM mid WHERE mid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idBanDo]);
    
    // Bind các cột từ database vào thuộc tính của đối tượng
    // Lưu ý: Tên cột database (tên cũ) -> Tên thuộc tính mới (camelCase)
    $stmt->bindColumn('mname', $banDo->tenBanDo);
    $stmt->bindColumn('mgid', $banDo->danhSachQuaiVat);
    $stmt->bindColumn('mid', $banDo->idBanDo);
    $stmt->bindColumn('mup', $banDo->idBanDoPhiaLen);
    $stmt->bindColumn('mdown', $banDo->idBanDoPhiaXuong);
    $stmt->bindColumn('mleft', $banDo->idBanDoPhiaTrai);
    $stmt->bindColumn('mright', $banDo->idBanDoPhiaPhai);
    $stmt->bindColumn('mnpc', $banDo->danhSachNpc);
    $stmt->bindColumn('mgtime', $banDo->thoiGianLamMoiQuaiVat);
    $stmt->bindColumn('midboss', $banDo->idBoss);
    $stmt->bindColumn('ms', $banDo->trangThai);
    $stmt->bindColumn('midinfo', $banDo->moTaBanDo);
    $stmt->bindColumn('mqy', $banDo->idKhuVuc);
    $stmt->bindColumn('playerinfo', $banDo->thongTinNguoiChoi);
    $stmt->bindColumn('ispvp', $banDo->laBanDoPvp);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    return $banDo;
}

/**
 * Kiểm tra xem người chơi có thể di chuyển đến bản đồ mới không
 * 
 * @param int $idBanDoHienTai ID bản đồ hiện tại
 * @param int $idBanDoMoi ID bản đồ muốn di chuyển đến
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu có thể di chuyển, False nếu không
 */
function coTheDiChuyenDenBanDo($idBanDoHienTai, $idBanDoMoi, $ketNoiDB)
{
    $banDoHienTai = layThongTinBanDo($idBanDoHienTai, $ketNoiDB);
    
    if (!$banDoHienTai) {
        return false;
    }
    
    $danhSachKetNoi = $banDoHienTai->layDanhSachBanDoKetNoi();
    
    return in_array($idBanDoMoi, $danhSachKetNoi);
}

/**
 * Cập nhật vị trí bản đồ hiện tại của người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idBanDoMoi ID bản đồ mới
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu cập nhật thành công, False nếu thất bại
 */
function capNhatViTriBanDo($idPhien, $idBanDoMoi, $ketNoiDB)
{
    $sql = "UPDATE game1 SET nowmid = ? WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    
    return $stmt->execute([$idBanDoMoi, $idPhien]);
}

/**
 * Lấy danh sách quái vật trong bản đồ
 * 
 * @param int $idBanDo ID của bản đồ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng chứa danh sách ID quái vật
 */
function layDanhSachQuaiVatTrongBanDo($idBanDo, $ketNoiDB)
{
    $banDo = layThongTinBanDo($idBanDo, $ketNoiDB);
    
    if (!$banDo || empty($banDo->danhSachQuaiVat)) {
        return [];
    }
    
    // Tách chuỗi ID quái vật thành mảng
    return explode(',', $banDo->danhSachQuaiVat);
}

/**
 * Lấy danh sách NPC trong bản đồ
 * 
 * @param int $idBanDo ID của bản đồ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng chứa danh sách ID NPC
 */
function layDanhSachNpcTrongBanDo($idBanDo, $ketNoiDB)
{
    $banDo = layThongTinBanDo($idBanDo, $ketNoiDB);
    
    if (!$banDo || empty($banDo->danhSachNpc)) {
        return [];
    }
    
    // Tách chuỗi ID NPC thành mảng
    return explode(',', $banDo->danhSachNpc);
}

/**
 * Kiểm tra xem bản đồ có phải là bản đồ PVP không
 * 
 * @param int $idBanDo ID của bản đồ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu là bản đồ PVP, False nếu không
 */
function laBanDoPvp($idBanDo, $ketNoiDB)
{
    $banDo = layThongTinBanDo($idBanDo, $ketNoiDB);
    
    return $banDo && $banDo->laBanDoPvp == 1;
}
