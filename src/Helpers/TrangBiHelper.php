<?php
/**
 * File helper functions cho trang bị
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng trang bị,
 * bao gồm truy vấn database, quản lý trang bị, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

require_once __DIR__ . '/../Classes/TrangBi.php';

use TuTaTuTien\Classes\TrangBi;

/**
 * Lấy thông tin trang bị của người chơi từ database
 * 
 * Lấy trang bị cụ thể mà người chơi đang sở hữu (từ bảng playerzhuangbei)
 * 
 * @param int $idTrangBi ID trang bị cụ thể (zbnowid)
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return TrangBi|null Đối tượng trang bị hoặc null nếu không tìm thấy
 */
function layTrangBiCuaNguoiChoi($idTrangBi, $ketNoiDB)
{
    $trangBi = new TrangBi();
    
    $sql = "SELECT * FROM playerzhuangbei WHERE zbnowid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idTrangBi]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('zbname', $trangBi->tenTrangBi);
    $stmt->bindColumn('zbinfo', $trangBi->moTa);
    $stmt->bindColumn('zbgj', $trangBi->congKich);
    $stmt->bindColumn('zbfy', $trangBi->phongNgu);
    $stmt->bindColumn('zbhp', $trangBi->sinhMenh);
    $stmt->bindColumn('zbbj', $trangBi->baoKich);
    $stmt->bindColumn('zbxx', $trangBi->hutMau);
    $stmt->bindColumn('zbid', $trangBi->idMauTrangBi);
    $stmt->bindColumn('uid', $trangBi->idNguoiSoHuu);
    $stmt->bindColumn('zbnowid', $trangBi->idTrangBi);
    $stmt->bindColumn('qianghua', $trangBi->capCuongHoa);
    $stmt->bindColumn('zblv', $trangBi->capDoYeuCau);
    $stmt->bindColumn('zbtool', $trangBi->viTri);
    $stmt->bindColumn('zbys', $trangBi->phamChat);
    
    $result = $stmt->fetch(\PDO::FETCH_BOUND);
    
    if (!$result) {
        return null;
    }
    
    return $trangBi;
}

/**
 * Lấy thông tin trang bị template từ database
 * 
 * Lấy thông tin mẫu của trang bị (từ bảng zhuangbei)
 * 
 * @param int $idMauTrangBi ID mẫu trang bị (zbid)
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return TrangBi|null Đối tượng trang bị hoặc null nếu không tìm thấy
 */
function layThongTinTrangBi($idMauTrangBi, $ketNoiDB)
{
    $trangBi = new TrangBi();
    
    $sql = "SELECT * FROM zhuangbei WHERE zbid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idMauTrangBi]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('zbname', $trangBi->tenTrangBi);
    $stmt->bindColumn('zbinfo', $trangBi->moTa);
    $stmt->bindColumn('zbgj', $trangBi->congKich);
    $stmt->bindColumn('zbfy', $trangBi->phongNgu);
    $stmt->bindColumn('zbhp', $trangBi->sinhMenh);
    $stmt->bindColumn('zbbj', $trangBi->baoKich);
    $stmt->bindColumn('zbxx', $trangBi->hutMau);
    $stmt->bindColumn('zbid', $trangBi->idMauTrangBi);
    $stmt->bindColumn('zbtool', $trangBi->viTri);
    $stmt->bindColumn('zbys', $trangBi->phamChat);
    $stmt->bindColumn('zblv', $trangBi->capDoYeuCau);
    
    $result = $stmt->fetch(\PDO::FETCH_BOUND);
    
    if (!$result) {
        return null;
    }
    
    return $trangBi;
}

/**
 * Thêm trang bị cho người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idMauTrangBi ID mẫu trang bị
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function themTrangBi($idPhien, $idMauTrangBi, $ketNoiDB)
{
    // Lấy thông tin template
    $mauTrangBi = layThongTinTrangBi($idMauTrangBi, $ketNoiDB);
    
    if (!$mauTrangBi) {
        return false;
    }
    
    // Insert trang bị mới cho người chơi
    $sql = "INSERT INTO playerzhuangbei (zbid, sid, zbname, zbinfo, zbgj, zbfy, zbhp, zbbj, zbxx, zbtool, zbys, zblv, qianghua) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
    
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([
        $idMauTrangBi,
        $idPhien,
        $mauTrangBi->tenTrangBi,
        $mauTrangBi->moTa,
        $mauTrangBi->congKich,
        $mauTrangBi->phongNgu,
        $mauTrangBi->sinhMenh,
        $mauTrangBi->baoKich,
        $mauTrangBi->hutMau,
        $mauTrangBi->viTri,
        $mauTrangBi->phamChat,
        $mauTrangBi->capDoYeuCau
    ]);
}

/**
 * Cập nhật chỉ số trang bị
 * 
 * @param int $idTrangBi ID trang bị cụ thể
 * @param string $tenChiSo Tên cột cần cập nhật (zbgj, zbfy, etc.)
 * @param int $giaTri Giá trị mới
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function capNhatChiSoTrangBi($idTrangBi, $tenChiSo, $giaTri, $ketNoiDB)
{
    $sql = "UPDATE playerzhuangbei SET $tenChiSo = ? WHERE zbnowid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$giaTri, $idTrangBi]);
}

/**
 * Cường hóa trang bị
 * 
 * @param int $idTrangBi ID trang bị cụ thể
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function cuongHoaTrangBi($idTrangBi, $idPhien, $ketNoiDB)
{
    $trangBi = layTrangBiCuaNguoiChoi($idTrangBi, $ketNoiDB);
    
    if (!$trangBi) {
        return false;
    }
    
    if ($trangBi->cuongHoa()) {
        $sql = "UPDATE playerzhuangbei SET qianghua = ? WHERE zbnowid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$trangBi->capCuongHoa, $idTrangBi]);
    }
    
    return false;
}

/**
 * Lấy danh sách trang bị của người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng các đối tượng trang bị
 */
function layDanhSachTrangBi($idPhien, $ketNoiDB)
{
    $sql = "SELECT * FROM playerzhuangbei WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien]);
    
    return $stmt->fetchAll(\PDO::FETCH_BOUND);
}
