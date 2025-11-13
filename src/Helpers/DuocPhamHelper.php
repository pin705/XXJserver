<?php
/**
 * File helper functions cho dược phẩm
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng dược phẩm,
 * bao gồm truy vấn database, quản lý dược phẩm, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

require_once __DIR__ . '/../Classes/DuocPham.php';

use TuTaTuTien\Classes\DuocPham;

/**
 * Lấy thông tin dược phẩm từ database theo ID
 * 
 * @param int $idDuocPham ID dược phẩm
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return DuocPham|null Đối tượng dược phẩm hoặc null nếu không tìm thấy
 */
function layThongTinDuocPham($idDuocPham, $ketNoiDB)
{
    $duocPham = new DuocPham();
    
    $sql = "SELECT * FROM yaopin WHERE ypid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idDuocPham]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('ypname', $duocPham->tenDuocPham);
    $stmt->bindColumn('yphp', $duocPham->sinhMenhHoiPhuc);
    $stmt->bindColumn('ypgj', $duocPham->congKichTangThem);
    $stmt->bindColumn('ypfy', $duocPham->phongNguTangThem);
    $stmt->bindColumn('ypjg', $duocPham->giaBan);
    $stmt->bindColumn('ypbj', $duocPham->baoKichTangThem);
    $stmt->bindColumn('ypid', $duocPham->idDuocPham);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    return $duocPham;
}

/**
 * Lấy thông tin dược phẩm của người chơi
 * 
 * @param int $idDuocPham ID dược phẩm
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array|null Mảng thông tin dược phẩm hoặc null nếu không tìm thấy
 */
function layDuocPhamCuaNguoiChoi($idDuocPham, $idPhien, $ketNoiDB)
{
    $sql = "SELECT * FROM playeryaopin WHERE ypid = ? AND sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idDuocPham, $idPhien]);
    
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

/**
 * Lấy tất cả dược phẩm của người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng các dược phẩm
 */
function layTatCaDuocPhamCuaNguoiChoi($idPhien, $ketNoiDB)
{
    $sql = "SELECT * FROM playeryaopin WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien]);
    
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Thêm dược phẩm cho người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idDuocPham ID dược phẩm
 * @param int $soLuong Số lượng thêm vào
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function themDuocPham($idPhien, $idDuocPham, $soLuong, $ketNoiDB)
{
    // Kiểm tra xem người chơi đã có dược phẩm này chưa
    $duocPhamHienTai = layDuocPhamCuaNguoiChoi($idDuocPham, $idPhien, $ketNoiDB);
    
    if ($duocPhamHienTai) {
        // Nếu đã có, tăng số lượng
        $sql = "UPDATE playeryaopin SET ypsum = ypsum + ? WHERE ypid = ? AND sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$soLuong, $idDuocPham, $idPhien]);
    } else {
        // Nếu chưa có, thêm mới
        $sql = "INSERT INTO playeryaopin (sid, ypid, ypsum) VALUES (?, ?, ?)";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$idPhien, $idDuocPham, $soLuong]);
    }
}

/**
 * Xóa/giảm dược phẩm của người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idDuocPham ID dược phẩm
 * @param int $soLuong Số lượng xóa
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function xoaDuocPham($idPhien, $idDuocPham, $soLuong, $ketNoiDB)
{
    // Giảm số lượng
    $sql = "UPDATE playeryaopin SET ypsum = GREATEST(0, ypsum - ?) WHERE ypid = ? AND sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$soLuong, $idDuocPham, $idPhien]);
}

/**
 * Sử dụng dược phẩm
 * 
 * @param int $idDuocPham ID dược phẩm
 * @param int $soLuong Số lượng sử dụng
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function suDungDuocPham($idDuocPham, $soLuong, $idPhien, $ketNoiDB)
{
    // Lấy thông tin người chơi
    $nguoiChoi = layThongTinNguoiChoi($idPhien, $ketNoiDB);
    
    if (!$nguoiChoi || $nguoiChoi->sinhMenh <= 0) {
        return false;
    }
    
    // Kiểm tra và giảm số lượng dược phẩm
    $ret = xoaDuocPham($idPhien, $idDuocPham, $soLuong, $ketNoiDB);
    
    if (!$ret) {
        return false;
    }
    
    // Lấy thông tin dược phẩm
    $duocPham = layThongTinDuocPham($idDuocPham, $ketNoiDB);
    
    if (!$duocPham) {
        return false;
    }
    
    // Tính toán sinh mệnh hồi phục
    $sinhMenhCanHoi = $nguoiChoi->sinhMenhToiDa - $nguoiChoi->sinhMenh;
    $sinhMenhHoiPhuc = $duocPham->sinhMenhHoiPhuc;
    
    if ($sinhMenhHoiPhuc >= $sinhMenhCanHoi) {
        // Hồi đầy sinh mệnh
        $sql = "UPDATE game1 SET uhp = umaxhp WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        $stmt->execute([$idPhien]);
    } else {
        // Hồi một phần sinh mệnh
        $sql = "UPDATE game1 SET uhp = uhp + ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        $stmt->execute([$sinhMenhHoiPhuc, $idPhien]);
    }
    
    // Cập nhật các chỉ số tăng thêm
    if ($duocPham->congKichTangThem > 0) {
        $sql = "UPDATE game1 SET ugj = ugj + ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        $stmt->execute([$duocPham->congKichTangThem, $idPhien]);
    }
    
    if ($duocPham->phongNguTangThem > 0) {
        $sql = "UPDATE game1 SET ufy = ufy + ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        $stmt->execute([$duocPham->phongNguTangThem, $idPhien]);
    }
    
    if ($duocPham->baoKichTangThem > 0) {
        $sql = "UPDATE game1 SET ubj = ubj + ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        $stmt->execute([$duocPham->baoKichTangThem, $idPhien]);
    }
    
    return true;
}

/**
 * Lấy tất cả dược phẩm có sẵn trong hệ thống
 * 
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng các dược phẩm
 */
function layTatCaDuocPham($ketNoiDB)
{
    $sql = "SELECT * FROM yaopin";
    $stmt = $ketNoiDB->query($sql);
    
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
