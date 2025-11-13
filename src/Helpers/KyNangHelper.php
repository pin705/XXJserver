<?php
/**
 * File helper functions cho kỹ năng
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng kỹ năng,
 * bao gồm truy vấn database, quản lý kỹ năng, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

require_once __DIR__ . '/../Classes/KyNang.php';

use TuTaTuTien\Classes\KyNang;

/**
 * Lấy thông tin kỹ năng từ database theo ID
 * 
 * @param int $idKyNang ID kỹ năng
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return KyNang|null Đối tượng kỹ năng hoặc null nếu không tìm thấy
 */
function layThongTinKyNang($idKyNang, $ketNoiDB)
{
    $kyNang = new KyNang();
    
    $sql = "SELECT * FROM jineng WHERE jnid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idKyNang]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('jnname', $kyNang->tenKyNang);
    $stmt->bindColumn('jnid', $kyNang->idKyNang);
    $stmt->bindColumn('jngj', $kyNang->congKichTangThem);
    $stmt->bindColumn('jnfy', $kyNang->phongNguTangThem);
    $stmt->bindColumn('jnbj', $kyNang->baoKichTangThem);
    $stmt->bindColumn('jnxx', $kyNang->hutMauTangThem);
    $stmt->bindColumn('jndj', $kyNang->soDaoCuCanHoc);
    $stmt->bindColumn('djsum', $kyNang->soLuongDaoCu);
    
    $result = $stmt->fetch(\PDO::FETCH_BOUND);
    
    if (!$result) {
        return null;
    }
    
    return $kyNang;
}

/**
 * Lấy kỹ năng của người chơi
 * 
 * @param int $idKyNang ID kỹ năng
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array|null Mảng thông tin kỹ năng hoặc null nếu không tìm thấy
 */
function layKyNangCuaNguoiChoi($idKyNang, $idPhien, $ketNoiDB)
{
    $sql = "SELECT * FROM playerjineng WHERE jnid = ? AND sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idKyNang, $idPhien]);
    
    return $stmt->fetch(\PDO::FETCH_BOUND);
}

/**
 * Lấy tất cả kỹ năng của người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng các kỹ năng
 */
function layTatCaKyNangCuaNguoiChoi($idPhien, $ketNoiDB)
{
    $sql = "SELECT pj.*, j.jnname, j.jngj, j.jnfy, j.jnbj, j.jnxx 
            FROM playerjineng pj 
            LEFT JOIN jineng j ON pj.jnid = j.jnid 
            WHERE pj.sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien]);
    
    return $stmt->fetchAll(\PDO::FETCH_BOUND);
}

/**
 * Thêm kỹ năng cho người chơi
 * 
 * @param int $idKyNang ID kỹ năng
 * @param int $soLuong Số lượng (số lần sử dụng)
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function themKyNang($idKyNang, $soLuong, $idPhien, $ketNoiDB)
{
    // Kiểm tra xem người chơi đã có kỹ năng này chưa
    $kyNangHienTai = layKyNangCuaNguoiChoi($idKyNang, $idPhien, $ketNoiDB);
    
    if ($kyNangHienTai) {
        // Nếu đã có, tăng số lượng
        $sql = "UPDATE playerjineng SET jncount = jncount + ? WHERE jnid = ? AND sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$soLuong, $idKyNang, $idPhien]);
    } else {
        // Nếu chưa có, thêm mới
        $sql = "INSERT INTO playerjineng (sid, jnid, jncount) VALUES (?, ?, ?)";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$idPhien, $idKyNang, $soLuong]);
    }
}

/**
 * Xóa/giảm kỹ năng của người chơi
 * 
 * @param int $idKyNang ID kỹ năng
 * @param int $soLuong Số lượng xóa
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function xoaKyNang($idKyNang, $soLuong, $idPhien, $ketNoiDB)
{
    // Giảm số lượng
    $sql = "UPDATE playerjineng SET jncount = GREATEST(0, jncount - ?) WHERE jnid = ? AND sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$soLuong, $idKyNang, $idPhien]);
}

/**
 * Lấy tất cả kỹ năng có sẵn trong hệ thống
 * 
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng các kỹ năng
 */
function layTatCaKyNang($ketNoiDB)
{
    $sql = "SELECT * FROM jineng";
    $stmt = $ketNoiDB->query($sql);
    
    return $stmt->fetchAll(\PDO::FETCH_BOUND);
}
