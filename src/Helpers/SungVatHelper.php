<?php
/**
 * File helper functions cho sủng vật
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng sủng vật,
 * bao gồm truy vấn database, quản lý sủng vật, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

use TuTaTuTien\Classes\SungVat;

/**
 * Lấy thông tin sủng vật từ database theo ID
 * 
 * @param int $idSungVat ID sủng vật
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return SungVat|null Đối tượng sủng vật hoặc null nếu không tìm thấy
 */
function layThongTinSungVat($idSungVat, $ketNoiDB)
{
    $sungVat = new SungVat();
    
    $sql = "SELECT * FROM chongwu WHERE cwid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idSungVat]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('cwname', $sungVat->tenSungVat);
    $stmt->bindColumn('cwlv', $sungVat->capDo);
    $stmt->bindColumn('cwexp', $sungVat->kinhNghiem);
    $stmt->bindColumn('cwmaxexp', $sungVat->kinhNghiemToiDa);
    $stmt->bindColumn('cwhp', $sungVat->sinhMenh);
    $stmt->bindColumn('cwmaxhp', $sungVat->sinhMenhToiDa);
    $stmt->bindColumn('cwgj', $sungVat->congKich);
    $stmt->bindColumn('cwfy', $sungVat->phongNgu);
    $stmt->bindColumn('cwbj', $sungVat->baoKich);
    $stmt->bindColumn('cwxx', $sungVat->hutMau);
    $stmt->bindColumn('cwhpup', $sungVat->sinhMenhTangCapDo);
    $stmt->bindColumn('cwgjup', $sungVat->congKichTangCapDo);
    $stmt->bindColumn('cwfyup', $sungVat->phongNguTangCapDo);
    $stmt->bindColumn('cwpc', $sungVat->phamChat);
    $stmt->bindColumn('tool1', $sungVat->trangBi1);
    $stmt->bindColumn('tool2', $sungVat->trangBi2);
    $stmt->bindColumn('tool3', $sungVat->trangBi3);
    $stmt->bindColumn('tool4', $sungVat->trangBi4);
    $stmt->bindColumn('tool5', $sungVat->trangBi5);
    $stmt->bindColumn('tool6', $sungVat->trangBi6);
    $stmt->bindColumn('tool7', $sungVat->trangBi7);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    return $sungVat;
}

/**
 * Lấy tất cả sủng vật của người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng các sủng vật
 */
function layTatCaSungVatCuaNguoiChoi($idPhien, $ketNoiDB)
{
    $sql = "SELECT * FROM chongwu WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien]);
    
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Thêm sủng vật mới cho người chơi
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function themSungVat($idPhien, $ketNoiDB)
{
    // Tạo sủng vật mới với các chỉ số ngẫu nhiên
    $tenSungVat = "Sủng vật";
    $capDo = 1;
    $kinhNghiem = 0;
    $kinhNghiemToiDa = 100;
    
    // Chỉ số cơ bản ngẫu nhiên
    $sinhMenh = rand(100, 200);
    $sinhMenhToiDa = $sinhMenh;
    $congKich = rand(10, 30);
    $phongNgu = rand(10, 30);
    $baoKich = rand(5, 15);
    $hutMau = rand(1, 10);
    
    // Chỉ số tăng khi lên cấp
    $sinhMenhTangCapDo = rand(10, 20);
    $congKichTangCapDo = rand(2, 5);
    $phongNguTangCapDo = rand(2, 5);
    
    // Phẩm chất ngẫu nhiên
    $phamChat = rand(1, 5);
    
    $sql = "INSERT INTO chongwu (sid, cwname, cwlv, cwexp, cwmaxexp, cwhp, cwmaxhp, cwgj, cwfy, cwbj, cwxx, cwhpup, cwgjup, cwfyup, cwpc) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([
        $idPhien, $tenSungVat, $capDo, $kinhNghiem, $kinhNghiemToiDa,
        $sinhMenh, $sinhMenhToiDa, $congKich, $phongNgu, $baoKich, $hutMau,
        $sinhMenhTangCapDo, $congKichTangCapDo, $phongNguTangCapDo, $phamChat
    ]);
}

/**
 * Xóa sủng vật
 * 
 * @param int $idSungVat ID sủng vật
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function xoaSungVat($idSungVat, $idPhien, $ketNoiDB)
{
    $sql = "DELETE FROM chongwu WHERE cwid = ? AND sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$idSungVat, $idPhien]);
}

/**
 * Thêm kinh nghiệm cho sủng vật
 * 
 * @param int $idSungVat ID sủng vật
 * @param int $kinhNghiem Lượng kinh nghiệm thêm vào
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function themKinhNghiemSungVat($idSungVat, $kinhNghiem, $ketNoiDB)
{
    $sql = "UPDATE chongwu SET cwexp = cwexp + ? WHERE cwid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$kinhNghiem, $idSungVat]);
}

/**
 * Cập nhật chỉ số sủng vật
 * 
 * @param string $tenChiSo Tên cột cần cập nhật (cwgj, cwfy, etc.)
 * @param int $giaTri Giá trị thay đổi (có thể âm)
 * @param int $idSungVat ID sủng vật
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function capNhatChiSoSungVat($tenChiSo, $giaTri, $idSungVat, $ketNoiDB)
{
    $sql = "UPDATE chongwu SET $tenChiSo = $tenChiSo + ? WHERE cwid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$giaTri, $idSungVat]);
}

/**
 * Thêm chỉ số cho sủng vật
 * 
 * @param string $tenChiSo Tên cột cần cập nhật (cwgj, cwfy, etc.)
 * @param int $giaTri Giá trị thêm vào
 * @param int $idSungVat ID sủng vật
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function themChiSoSungVat($tenChiSo, $giaTri, $idSungVat, $ketNoiDB)
{
    return capNhatChiSoSungVat($tenChiSo, $giaTri, $idSungVat, $ketNoiDB);
}
