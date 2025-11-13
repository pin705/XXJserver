<?php
/**
 * File helper functions cho đạo cụ
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng đạo cụ
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

use TuTaTuTien\Classes\DaoCu;

/**
 * Lấy thông tin đạo cụ của người chơi từ database
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idDaoCu ID của đạo cụ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return DaoCu|null Đối tượng đạo cụ hoặc null nếu không tìm thấy
 */
function layDaoCuCuaNguoiChoi($idPhien, $idDaoCu, $ketNoiDB)
{
    $daoCu = new DaoCu();
    
    $sql = "SELECT * FROM playerdaoju WHERE djid = ? AND sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idDaoCu, $idPhien]);
    
    $stmt->bindColumn('djname', $daoCu->tenDaoCu);
    $stmt->bindColumn('djzl', $daoCu->idDaoCuNguoiChoi);
    $stmt->bindColumn('djinfo', $daoCu->moTaDaoCu);
    $stmt->bindColumn('djid', $daoCu->idDaoCu);
    $stmt->bindColumn('djsum', $daoCu->soLuong);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    return $daoCu;
}

/**
 * Lấy thông tin đạo cụ từ template
 * 
 * @param int $idDaoCu ID của đạo cụ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return DaoCu|null Đối tượng đạo cụ hoặc null nếu không tìm thấy
 */
function layThongTinDaoCu($idDaoCu, $ketNoiDB)
{
    $daoCu = new DaoCu();
    
    $sql = "SELECT * FROM daoju WHERE djid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idDaoCu]);
    
    $stmt->bindColumn('djname', $daoCu->tenDaoCu);
    $stmt->bindColumn('djzl', $daoCu->idDaoCuNguoiChoi);
    $stmt->bindColumn('djinfo', $daoCu->moTaDaoCu);
    $stmt->bindColumn('djid', $daoCu->idDaoCu);
    $stmt->bindColumn('djyxb', $daoCu->giaTienTroChoi);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    return $daoCu;
}

/**
 * Thêm đạo cụ vào kho người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idDaoCu ID của đạo cụ
 * @param int $soLuong Số lượng đạo cụ thêm vào
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, False nếu thất bại
 */
function themDaoCu($idPhien, $idDaoCu, $soLuong, $ketNoiDB)
{
    // Lấy thông tin người chơi
    $sqlPlayer = "SELECT uid FROM game1 WHERE sid = ?";
    $stmtPlayer = $ketNoiDB->prepare($sqlPlayer);
    $stmtPlayer->execute([$idPhien]);
    $player = $stmtPlayer->fetch(\PDO::FETCH_ASSOC);
    
    if (!$player) {
        return false;
    }
    
    // Kiểm tra xem đạo cụ đã tồn tại chưa
    $daoCuHienCo = layDaoCuCuaNguoiChoi($idPhien, $idDaoCu, $ketNoiDB);
    
    if ($daoCuHienCo) {
        // Cập nhật số lượng
        $sql = "UPDATE playerdaoju SET djsum = djsum + ? WHERE sid = ? AND djid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$soLuong, $idPhien, $idDaoCu]);
    } else {
        // Thêm mới
        $daoCuTemplate = layThongTinDaoCu($idDaoCu, $ketNoiDB);
        
        if (!$daoCuTemplate) {
            return false;
        }
        
        $sql = "INSERT INTO playerdaoju (djname, djinfo, djzl, djid, djsum, sid, uid) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([
            $daoCuTemplate->tenDaoCu,
            $daoCuTemplate->moTaDaoCu,
            $daoCuTemplate->idDaoCuNguoiChoi,
            $daoCuTemplate->idDaoCu,
            $soLuong,
            $idPhien,
            $player['uid']
        ]);
    }
}

/**
 * Xóa/giảm đạo cụ từ kho người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param int $idDaoCu ID của đạo cụ
 * @param int $soLuong Số lượng đạo cụ cần xóa
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, False nếu thất bại
 */
function xoaDaoCu($idPhien, $idDaoCu, $soLuong, $ketNoiDB)
{
    $daoCu = layDaoCuCuaNguoiChoi($idPhien, $idDaoCu, $ketNoiDB);
    
    if (!$daoCu || !$daoCu->duSoLuong($soLuong)) {
        return false;
    }
    
    if ($daoCu->soLuong == $soLuong) {
        // Xóa hoàn toàn
        $sql = "DELETE FROM playerdaoju WHERE sid = ? AND djid = ?";
    } else {
        // Giảm số lượng
        $sql = "UPDATE playerdaoju SET djsum = djsum - ? WHERE sid = ? AND djid = ?";
    }
    
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$soLuong, $idPhien, $idDaoCu]);
}
