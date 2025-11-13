<?php
/**
 * File helper functions cho quái vật
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng quái vật,
 * bao gồm truy vấn database, quản lý quái vật, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

require_once __DIR__ . '/../Classes/QuaiVat.php';

use TuTaTuTien\Classes\QuaiVat;

/**
 * Lấy thông tin quái vật từ database (instance trong bản đồ)
 * 
 * @param int $idQuai ID quái vật trong bản đồ
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return QuaiVat|null Đối tượng quái vật hoặc null nếu không tìm thấy
 */
function layThongTinQuaiVat($idQuai, $ketNoiDB)
{
    $quaiVat = new QuaiVat();
    
    $sql = "SELECT * FROM midguaiwu WHERE id = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idQuai]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('gname', $quaiVat->tenQuai);
    $stmt->bindColumn('id', $quaiVat->idQuai);
    $stmt->bindColumn('sid', $quaiVat->idPhienNguoiChoi);
    $stmt->bindColumn('glv', $quaiVat->capDo);
    $stmt->bindColumn('gexp', $quaiVat->kinhNghiem);
    $stmt->bindColumn('ghp', $quaiVat->sinhMenh);
    $stmt->bindColumn('gmaxhp', $quaiVat->sinhMenhToiDa);
    $stmt->bindColumn('ggj', $quaiVat->congKich);
    $stmt->bindColumn('gfy', $quaiVat->phongNgu);
    $stmt->bindColumn('gbj', $quaiVat->baoKich);
    $stmt->bindColumn('gxx', $quaiVat->hutMau);
    $stmt->bindColumn('gyid', $quaiVat->idKhoQuai);
    
    $result = $stmt->fetch(\PDO::FETCH_BOUND);
    
    if (!$result) {
        return null;
    }
    
    // Tính cảnh giới
    $rangeslv = array(0, 30, 50, 70, 80, 90, 100, 110);
    $rangesjj = array('Luyện khí', 'Trúc cơ', 'Kim Đan', 'Nguyên Anh', 'Hóa Thần', 'Luyện Hư', 'Hợp thể', 'Đại Thừa');
    
    for ($i = 0; $i < count($rangeslv); $i++) {
        if ($quaiVat->capDo >= $rangeslv[$i] && $quaiVat->capDo < $rangeslv[$i+1]) {
            $rangesjd = array('Một','Hai','Ba','Bốn','Năm','Sáu','Bảy','Tám','Chín','Mười');
            $djc = $quaiVat->capDo - $rangeslv[$i];
            $jds = ($rangeslv[$i+1] - $rangeslv[$i]) / 10;
            $jieduan = floor($djc / $jds);
            $jd = $rangesjd[$jieduan];
            $quaiVat->canhGioi = $rangesjj[$i] . $jd . 'Tầng';
            break;
        }
    }
    
    return $quaiVat;
}

/**
 * Lấy thông tin quái vật template từ kho
 * 
 * @param int $idKhoQuai ID quái vật trong kho template
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return QuaiVat|null Đối tượng quái vật hoặc null nếu không tìm thấy
 */
function layThongTinQuaiVatTemplate($idKhoQuai, $ketNoiDB)
{
    $quaiVat = new QuaiVat();
    
    $sql = "SELECT * FROM guaiwu WHERE id = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idKhoQuai]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('gname', $quaiVat->tenQuai);
    $stmt->bindColumn('ginfo', $quaiVat->moTa);
    $stmt->bindColumn('gsex', $quaiVat->gioiTinh);
    $stmt->bindColumn('glv', $quaiVat->capDo);
    $stmt->bindColumn('gzb', $quaiVat->idTrangBiRoi);
    $stmt->bindColumn('gdj', $quaiVat->idDaoCuRoi);
    $stmt->bindColumn('ghp', $quaiVat->sinhMenh);
    $stmt->bindColumn('ggj', $quaiVat->congKich);
    $stmt->bindColumn('gfy', $quaiVat->phongNgu);
    $stmt->bindColumn('gbj', $quaiVat->baoKich);
    $stmt->bindColumn('gxx', $quaiVat->hutMau);
    $stmt->bindColumn('gyp', $quaiVat->idDuocPhamRoi);
    $stmt->bindColumn('dljv', $quaiVat->tyLeRoiTrangBi);
    $stmt->bindColumn('ypjv', $quaiVat->tyLeRoiDuocPham);
    $stmt->bindColumn('djjv', $quaiVat->tyLeRoiDaoCu);
    
    $result = $stmt->fetch(\PDO::FETCH_BOUND);
    
    if (!$result) {
        return null;
    }
    
    return $quaiVat;
}

/**
 * Cập nhật sinh mệnh quái vật
 * 
 * @param int $idQuai ID quái vật
 * @param int $sinhMenh Sinh mệnh mới
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function capNhatSinhMenhQuaiVat($idQuai, $sinhMenh, $ketNoiDB)
{
    $sql = "UPDATE midguaiwu SET ghp = ? WHERE id = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$sinhMenh, $idQuai]);
}

/**
 * Giảm sinh mệnh quái vật
 * 
 * @param int $idQuai ID quái vật
 * @param int $soSatThuong Lượng sát thương
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function giamSinhMenhQuaiVat($idQuai, $soSatThuong, $ketNoiDB)
{
    $sql = "UPDATE midguaiwu SET ghp = GREATEST(0, ghp - ?) WHERE id = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$soSatThuong, $idQuai]);
}

/**
 * Kiểm tra quái vật còn sống không
 * 
 * @param int $idQuai ID quái vật
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu quái vật còn sống, false nếu đã chết
 */
function quaiVatConSong($idQuai, $ketNoiDB)
{
    $quaiVat = layThongTinQuaiVat($idQuai, $ketNoiDB);
    return $quaiVat && $quaiVat->sinhMenh > 0;
}
