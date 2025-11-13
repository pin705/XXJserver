<?php
/**
 * File helper functions cho trưởng lão (boss)
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng boss/trưởng lão,
 * bao gồm truy vấn database, quản lý boss, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

use TuTaTuTien\Classes\TruongLao;

/**
 * Lấy thông tin boss từ database theo boss ID
 * 
 * Hàm này truy vấn database để lấy tất cả thông tin của boss
 * từ bảng boss (boss hiện tại trong game)
 * 
 * @param int $idBoss Boss ID
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return TruongLao|null Đối tượng boss hoặc null nếu không tìm thấy
 */
function layThongTinBoss($idBoss, $ketNoiDB)
{
    $boss = new TruongLao();
    
    $sql = "SELECT * FROM boss WHERE bossid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idBoss]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('bossname', $boss->tenBoss);
    $stmt->bindColumn('bossid', $boss->idBoss);
    $stmt->bindColumn('bosstime', $boss->thoiGianLamMoi);
    $stmt->bindColumn('bs', $boss->trangThai);
    $stmt->bindColumn('bossinfo', $boss->moTaBoss);
    $stmt->bindColumn('bosshp', $boss->sinhMenh);
    $stmt->bindColumn('bossmaxhp', $boss->sinhMenhToiDa);
    $stmt->bindColumn('bosslv', $boss->capDoBoss);
    $stmt->bindColumn('bossgj', $boss->congKich);
    $stmt->bindColumn('bossfy', $boss->phongNgu);
    $stmt->bindColumn('bossbj', $boss->baoKich);
    $stmt->bindColumn('bossxx', $boss->hutMau);
    $stmt->bindColumn('bossdj', $boss->daoCuRoi);
    $stmt->bindColumn('bosszb', $boss->trangBiRoi);
    $stmt->bindColumn('bossyp', $boss->duocPhamRoi);
    $stmt->bindColumn('ypjv', $boss->tyLeRoiDuocPham);
    $stmt->bindColumn('dljv', $boss->tyLeRoiTrangBi);
    $stmt->bindColumn('djjv', $boss->tyLeRoiDaoCu);
    $stmt->bindColumn('sid', $boss->idPhienNguoiChoi);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    return $boss;
}

/**
 * Lấy thông tin boss từ kho boss (bảng boss template)
 * 
 * Hàm này truy vấn database để lấy thông tin template của boss
 * từ bảng boss chính (không phải boss instance)
 * 
 * @param int $idBoss Boss ID từ bảng boss
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return TruongLao|null Đối tượng boss hoặc null nếu không tìm thấy
 */
function layThongTinBossTemplate($idBoss, $ketNoiDB)
{
    $boss = new TruongLao();
    
    $sql = "SELECT * FROM boss WHERE id = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idBoss]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('bossname', $boss->tenBoss);
    $stmt->bindColumn('bossinfo', $boss->moTaBoss);
    $stmt->bindColumn('bosslv', $boss->capDoBoss);
    $stmt->bindColumn('bosszb', $boss->trangBiRoi);
    $stmt->bindColumn('bossdj', $boss->daoCuRoi);
    $stmt->bindColumn('bosshp', $boss->sinhMenh);
    $stmt->bindColumn('bossgj', $boss->congKich);
    $stmt->bindColumn('bossfy', $boss->phongNgu);
    $stmt->bindColumn('bossbj', $boss->baoKich);
    $stmt->bindColumn('bossxx', $boss->hutMau);
    $stmt->bindColumn('sid', $boss->idPhienNguoiChoi);
    $stmt->bindColumn('bossyp', $boss->duocPhamRoi);
    $stmt->bindColumn('dljv', $boss->tyLeRoiTrangBi);
    $stmt->bindColumn('ypjv', $boss->tyLeRoiDuocPham);
    $stmt->bindColumn('djjv', $boss->tyLeRoiDaoCu);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    return $boss;
}

/**
 * Cập nhật sinh mệnh của boss
 * 
 * @param int $idBoss Boss ID
 * @param int $sinhMenh Sinh mệnh mới
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function capNhatSinhMenhBoss($idBoss, $sinhMenh, $ketNoiDB)
{
    $sql = "UPDATE boss SET bosshp = ? WHERE bossid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$sinhMenh, $idBoss]);
}

/**
 * Giảm sinh mệnh của boss
 * 
 * @param int $idBoss Boss ID
 * @param int $soSatThuong Lượng sát thương
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function giamSinhMenhBoss($idBoss, $soSatThuong, $ketNoiDB)
{
    $sql = "UPDATE boss SET bosshp = GREATEST(0, bosshp - ?) WHERE bossid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$soSatThuong, $idBoss]);
}

/**
 * Kiểm tra boss còn sống không
 * 
 * @param int $idBoss Boss ID
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu boss còn sống, false nếu đã chết
 */
function bossConSong($idBoss, $ketNoiDB)
{
    $boss = layThongTinBoss($idBoss, $ketNoiDB);
    return $boss && $boss->sinhMenh > 0;
}
