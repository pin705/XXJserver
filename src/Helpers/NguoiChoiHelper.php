<?php
/**
 * File helper functions cho người chơi
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng người chơi,
 * bao gồm truy vấn database, tính toán chỉ số, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

use TuTaTuTien\Classes\NguoiChoi;
use TuTaTuTien\Config\CauHinhGame;

/**
 * Lấy thông tin người chơi từ database theo session ID
 * 
 * Hàm này truy vấn database để lấy tất cả thông tin của người chơi,
 * bao gồm cả việc tính toán chỉ số từ trang bị và thiên phú
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return NguoiChoi|null Đối tượng người chơi hoặc null nếu không tìm thấy
 */
function layThongTinNguoiChoi($idPhien, $ketNoiDB)
{
    $nguoiChoi = new NguoiChoi();
    
    // Truy vấn thông tin cơ bản từ database
    $sql = "SELECT * FROM game1 WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien]);
    
    // Bind các cột vào thuộc tính của đối tượng
    $stmt->bindColumn('uname', $nguoiChoi->tenNhanVat);
    $stmt->bindColumn('sid', $nguoiChoi->idPhien);
    $stmt->bindColumn('uid', $nguoiChoi->idNguoiDung);
    $stmt->bindColumn('ulv', $nguoiChoi->capDo);
    $stmt->bindColumn('uyxb', $nguoiChoi->tienTroChoi);
    $stmt->bindColumn('uczb', $nguoiChoi->tienNap);
    $stmt->bindColumn('uexp', $nguoiChoi->kinhNghiem);
    $stmt->bindColumn('uhp', $nguoiChoi->sinhMenh);
    $stmt->bindColumn('umaxhp', $nguoiChoi->sinhMenhToiDa);
    $stmt->bindColumn('ugj', $nguoiChoi->congKich);
    $stmt->bindColumn('ufy', $nguoiChoi->phongNgu);
    $stmt->bindColumn('ubj', $nguoiChoi->baoKich);
    $stmt->bindColumn('uxx', $nguoiChoi->hutMau);
    $stmt->bindColumn('uwx', $nguoiChoi->nguHanh);
    $stmt->bindColumn('usex', $nguoiChoi->gioiTinh);
    $stmt->bindColumn('vip', $nguoiChoi->vip);
    $stmt->bindColumn('nowmid', $nguoiChoi->idBanDoHienTai);
    $stmt->bindColumn('endtime', $nguoiChoi->thoiGianKetThuc);
    $stmt->bindColumn('tool1', $nguoiChoi->trangBi1);
    $stmt->bindColumn('tool2', $nguoiChoi->trangBi2);
    $stmt->bindColumn('tool3', $nguoiChoi->trangBi3);
    $stmt->bindColumn('tool4', $nguoiChoi->trangBi4);
    $stmt->bindColumn('tool5', $nguoiChoi->trangBi5);
    $stmt->bindColumn('tool6', $nguoiChoi->trangBi6);
    $stmt->bindColumn('tool7', $nguoiChoi->trangBi7);
    $stmt->bindColumn('sfxl', $nguoiChoi->trangThaiTuLuyen);
    $stmt->bindColumn('xiuliantime', $nguoiChoi->thoiGianTuLuyen);
    $stmt->bindColumn('yp1', $nguoiChoi->duocPham1);
    $stmt->bindColumn('yp2', $nguoiChoi->duocPham2);
    $stmt->bindColumn('yp3', $nguoiChoi->duocPham3);
    $stmt->bindColumn('jn1', $nguoiChoi->kyNang1);
    $stmt->bindColumn('jn2', $nguoiChoi->kyNang2);
    $stmt->bindColumn('jn3', $nguoiChoi->kyNang3);
    $stmt->bindColumn('cw', $nguoiChoi->sungVat);
    $stmt->bindColumn('sfzx', $nguoiChoi->trangThaiOnline);
    $stmt->bindColumn('ispvp', $nguoiChoi->trangThaiPvp);
    $stmt->bindColumn('dhvip', $nguoiChoi->daDoiVipTrangBi);
    $stmt->bindColumn('dhvip1', $nguoiChoi->daDoiVipTrangBi1);
    $stmt->bindColumn('tf', $nguoiChoi->diemThienPhu);
    $stmt->bindColumn('tfgj', $nguoiChoi->thienPhuCongKich);
    $stmt->bindColumn('tfxy', $nguoiChoi->thienPhuMayMan);
    $stmt->bindColumn('tfsb', $nguoiChoi->thienPhuNeTranh);
    $stmt->bindColumn('tfxx', $nguoiChoi->thienPhuHutMau);
    $stmt->bindColumn('tfhp', $nguoiChoi->thienPhuSinhMenh);
    $stmt->bindColumn('tffy', $nguoiChoi->thienPhuPhongNgu);
    $stmt->bindColumn('tfbj', $nguoiChoi->thienPhuBaoKich);
    $stmt->bindColumn('wugong', $nguoiChoi->voCong);
    $stmt->bindColumn('shenfen', $nguoiChoi->thanPhan);
    $stmt->bindColumn('yd1', $nguoiChoi->duocDan1);
    $stmt->bindColumn('yd2', $nguoiChoi->duocDan2);
    $stmt->bindColumn('yd3', $nguoiChoi->duocDan3);
    
    // Lấy dữ liệu
    $ketQua = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$ketQua) {
        return null;
    }
    
    // Tính toán chỉ số từ trang bị
    $nguoiChoi = tinhChiSoTuTrangBi($nguoiChoi, $ketNoiDB);
    
    // Tính toán chỉ số từ thiên phú
    $nguoiChoi = tinhChiSoTuThienPhu($nguoiChoi);
    
    // Tính toán cảnh giới và kinh nghiệm tối đa
    $nguoiChoi = tinhToanCanhGioiVaKinhNghiem($nguoiChoi);
    
    return $nguoiChoi;
}

/**
 * Lấy thông tin người chơi từ database theo user ID
 * 
 * Hàm này truy vấn database để lấy thông tin người chơi theo uid
 * 
 * @param int $idNguoiDung User ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return NguoiChoi|null Đối tượng người chơi hoặc null nếu không tìm thấy
 */
function layThongTinNguoiChoiTheoUid($idNguoiDung, $ketNoiDB)
{
    // Lấy sid từ uid
    $sql = "SELECT sid FROM game1 WHERE uid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idNguoiDung]);
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result || !isset($result['sid'])) {
        return null;
    }
    
    // Dùng sid để lấy đầy đủ thông tin
    return layThongTinNguoiChoi($result['sid'], $ketNoiDB);
}

/**
 * Tính toán chỉ số bổ sung từ trang bị
 * 
 * @param NguoiChoi $nguoiChoi Đối tượng người chơi
 * @param \PDO $ketNoiDB Kết nối database
 * @return NguoiChoi Đối tượng người chơi đã cập nhật
 */
function tinhChiSoTuTrangBi($nguoiChoi, $ketNoiDB)
{
    // Duyệt qua 7 slot trang bị
    for ($i = 1; $i <= 7; $i++) {
        $tenThuocTinh = 'trangBi' . $i;
        $idTrangBi = $nguoiChoi->$tenThuocTinh;
        
        if ($idTrangBi != 0) {
            $trangBi = layThongTinTrangBi($idTrangBi, $ketNoiDB);
            
            if ($trangBi) {
                $nguoiChoi->congKich += $trangBi->congKich;
                $nguoiChoi->phongNgu += $trangBi->phongNgu;
                $nguoiChoi->baoKich += $trangBi->baoKich;
                $nguoiChoi->hutMau += $trangBi->hutMau;
                $nguoiChoi->sinhMenhToiDa += $trangBi->sinhMenh;
            }
        }
    }
    
    return $nguoiChoi;
}

/**
 * Tính toán chỉ số bổ sung từ thiên phú
 * 
 * @param NguoiChoi $nguoiChoi Đối tượng người chơi
 * @return NguoiChoi Đối tượng người chơi đã cập nhật
 */
function tinhChiSoTuThienPhu($nguoiChoi)
{
    // Thiên phú công kích
    if ($nguoiChoi->thienPhuCongKich > 0) {
        $nguoiChoi->congKich += $nguoiChoi->thienPhuCongKich * CauHinhGame::HE_SO_THIEN_PHU_CONG_KICH;
    }
    
    // Thiên phú bạo kích
    if ($nguoiChoi->thienPhuBaoKich > 0) {
        $nguoiChoi->baoKich += $nguoiChoi->thienPhuBaoKich * CauHinhGame::HE_SO_THIEN_PHU_BAO_KICH;
    }
    
    // Thiên phú hút máu
    if ($nguoiChoi->thienPhuHutMau > 0) {
        $nguoiChoi->hutMau += $nguoiChoi->thienPhuHutMau * CauHinhGame::HE_SO_THIEN_PHU_HUT_MAU;
    }
    
    // Thiên phú sinh mệnh
    if ($nguoiChoi->thienPhuSinhMenh > 0) {
        $nguoiChoi->sinhMenhToiDa += $nguoiChoi->thienPhuSinhMenh * CauHinhGame::HE_SO_THIEN_PHU_SINH_MENH;
    }
    
    // Thiên phú phòng ngự
    if ($nguoiChoi->thienPhuPhongNgu > 0) {
        $nguoiChoi->phongNgu += $nguoiChoi->thienPhuPhongNgu * CauHinhGame::HE_SO_THIEN_PHU_PHONG_NGU;
    }
    
    return $nguoiChoi;
}

/**
 * Tính toán cảnh giới và kinh nghiệm tối đa dựa trên cấp độ
 * 
 * @param NguoiChoi $nguoiChoi Đối tượng người chơi
 * @return NguoiChoi Đối tượng người chơi đã cập nhật
 */
function tinhToanCanhGioiVaKinhNghiem($nguoiChoi)
{
    $ngưỡngCapDo = CauHinhGame::NGUONG_CAP_DO_CANH_GIOI;
    $hesoKinhNghiem = CauHinhGame::HE_SO_KINH_NGHIEM;
    $tenCanhGioi = CauHinhGame::TEN_CANH_GIOI;
    $capDoTiepTheo = $nguoiChoi->capDo + 1;
    
    // Tên các tầng cảnh giới với màu sắc
    $tenTangCanhGioi = array(
        '<font color=#C7C7C7>Một</font><font color=#D7D7D7>Giai</font>',
        '<font color=#78CAC6>Hai</font><font color=#75C7C3>Giai</font>',
        '<font color=#A78104>Ba</font><font color=#A36208>Giai</font>',
        '<font color=#A78104>Bốn</font><font color=#A36208>Giai</font>',
        '<font color=#F49477>Năm</font><font color=#F19174>Giai</font>',
        '<font color=#F49477>Sáu</font><font color=#F19174>Giai</font>',
        '<font color=#EB1A21>Bảy</font><font color=#E8171E>Giai</font>',
        '<font color=#9D0F36>Tám</font><font color=#4C0148>Giai</font>',
        '<font color=#9D0F36>Chín</font><font color=#4C0148>Giai</font>',
        '<font color=#770035>Mười</font><font color=#740044>Toàn</font>'
    );
    
    // Xác định cảnh giới hiện tại
    for ($i = 0; $i < count($ngưỡngCapDo) - 1; $i++) {
        if ($nguoiChoi->capDo >= $ngưỡngCapDo[$i] && $nguoiChoi->capDo < $ngưỡngCapDo[$i + 1]) {
            // Tính tầng trong cảnh giới
            $chenhLech = $nguoiChoi->capDo - $ngưỡngCapDo[$i];
            $buocTang = ($ngưỡngCapDo[$i + 1] - $ngưỡngCapDo[$i]) / 10;
            $viTriTang = floor($chenhLech / $buocTang);
            
            // Gán cảnh giới và tầng
            $nguoiChoi->canhGioi = $tenCanhGioi[$i];
            $nguoiChoi->tangCanhGioi = $tenTangCanhGioi[$viTriTang];
            
            // Tính kinh nghiệm tối đa
            $nguoiChoi->kinhNghiemToiDa = $capDoTiepTheo * ($capDoTiepTheo + round($capDoTiepTheo / 2)) * 10 * $hesoKinhNghiem[$i] + $capDoTiepTheo;
            
            break;
        }
    }
    
    return $nguoiChoi;
}

/**
 * Lấy thông tin trang bị từ database
 * 
 * @param int $idTrangBi ID của trang bị
 * @param \PDO $ketNoiDB Kết nối database
 * @return object|null Thông tin trang bị hoặc null nếu không tìm thấy
 */
function layThongTinTrangBi($idTrangBi, $ketNoiDB)
{
    $sql = "SELECT zbgj, zbfy, zbbj, zbxx, zbhp FROM playerzhuangbei WHERE zbnowid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idTrangBi]);
    
    $trangBi = new \stdClass();
    $stmt->bindColumn('zbgj', $trangBi->congKich);
    $stmt->bindColumn('zbfy', $trangBi->phongNgu);
    $stmt->bindColumn('zbbj', $trangBi->baoKich);
    $stmt->bindColumn('zbxx', $trangBi->hutMau);
    $stmt->bindColumn('zbhp', $trangBi->sinhMenh);
    
    $ketQua = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    return $ketQua ? $trangBi : null;
}

/**
 * Cập nhật kinh nghiệm cho người chơi
 * 
 * @param string $idPhien Session ID người chơi
 * @param int $soKinhNghiem Số kinh nghiệm cần thêm
 * @param \PDO $ketNoiDB Kết nối database
 * @return bool True nếu cập nhật thành công
 */
function themKinhNghiem($idPhien, $soKinhNghiem, $ketNoiDB)
{
    // Kiểm tra xem có thể nhận thêm kinh nghiệm không
    if (!coTheNhanKinhNghiem($idPhien, $ketNoiDB)) {
        return false;
    }
    
    $sql = "UPDATE game1 SET uexp = uexp + ? WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $ketQua = $stmt->execute([$soKinhNghiem, $idPhien]);
    
    // Kiểm tra và tự động lên cấp nếu đủ kinh nghiệm
    kiemTraVaLenCap($idPhien, $ketNoiDB);
    
    return $ketQua;
}

/**
 * Kiểm tra xem người chơi có thể nhận thêm kinh nghiệm không
 * 
 * @param string $idPhien Session ID người chơi
 * @param \PDO $ketNoiDB Kết nối database
 * @return bool True nếu có thể nhận, false nếu đã đạt giới hạn
 */
function coTheNhanKinhNghiem($idPhien, $ketNoiDB)
{
    $nguoiChoi = layThongTinNguoiChoi($idPhien, $ketNoiDB);
    
    if (!$nguoiChoi) {
        return false;
    }
    
    // Nếu đã đạt kinh nghiệm tối đa và cần đột phá
    return !($nguoiChoi->kinhNghiem >= $nguoiChoi->kinhNghiemToiDa);
}

/**
 * Kiểm tra và tự động lên cấp cho người chơi nếu đủ điều kiện
 * 
 * @param string $idPhien Session ID người chơi  
 * @param \PDO $ketNoiDB Kết nối database
 * @return bool True nếu đã lên cấp
 */
function kiemTraVaLenCap($idPhien, $ketNoiDB)
{
    $nguoiChoi = layThongTinNguoiChoi($idPhien, $ketNoiDB);
    
    if (!$nguoiChoi || !$nguoiChoi->coTheLenCap()) {
        return false;
    }
    
    return nangCapChoNguoiChoi($idPhien, $ketNoiDB);
}

/**
 * Nâng cấp cho người chơi
 * 
 * @param string $idPhien Session ID người chơi
 * @param \PDO $ketNoiDB Kết nối database
 * @return bool True nếu nâng cấp thành công
 */
function nangCapChoNguoiChoi($idPhien, $ketNoiDB)
{
    $nguoiChoi = layThongTinNguoiChoi($idPhien, $ketNoiDB);
    
    if (!$nguoiChoi) {
        return false;
    }
    
    // Trừ kinh nghiệm
    $sql = "UPDATE game1 SET uexp = uexp - ? WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$nguoiChoi->kinhNghiemToiDa, $idPhien]);
    
    // Tính chỉ số tăng thêm theo cảnh giới
    $ngưỡngCapDo = CauHinhGame::NGUONG_CAP_DO_CANH_GIOI;
    $hesoCongKich = CauHinhGame::HE_SO_CONG_KICH;
    $hesoPhongNgu = CauHinhGame::HE_SO_PHONG_NGU;
    $hesoSinhMenh = CauHinhGame::HE_SO_SINH_MENH;
    $hesoNguHanh = CauHinhGame::HE_SO_NGU_HANH;
    
    $capDoMoi = $nguoiChoi->capDo + 1;
    
    // Tính chỉ số tăng thêm dựa trên thân phận
    $bonusBaoKich = 0;
    $bonusHutMau = 0;
    $bonusMayMan = 0;
    $bonusSinhMenh = 0;
    $bonusPhongNgu = 0;
    $bonusCongKich = 0;
    
    if ($nguoiChoi->thanPhan == 1) { // Chiến sĩ
        $bonusBaoKich = 1;
        $bonusCongKich = 1;
    } elseif ($nguoiChoi->thanPhan == 2) { // Pháp sư
        $bonusHutMau = 1;
        $bonusPhongNgu = 1;
    } elseif ($nguoiChoi->thanPhan == 3) { // Dược sư
        $bonusMayMan = 1;
        $bonusSinhMenh = 2;
    }
    
    // Tìm cảnh giới để áp dụng hệ số
    for ($i = 0; $i < count($ngưỡngCapDo) - 1; $i++) {
        if ($capDoMoi >= $ngưỡngCapDo[$i] && $capDoMoi < $ngưỡngCapDo[$i + 1]) {
            // Điều chỉnh bonus theo cảnh giới cao
            if ($capDoMoi >= 90) {
                $bonusBaoKich *= 2;
                $bonusHutMau *= 1.5;
                $bonusMayMan *= 1.5;
            }
            
            // Cập nhật thuộc tính
            $sql = "UPDATE game1 SET 
                    ulv = ulv + 1,
                    umaxhp = umaxhp + ?,
                    ugj = ugj + ?,
                    ufy = ufy + ?,
                    tfbj = tfbj + ?,
                    tfxx = tfxx + ?,
                    tfxy = tfxy + ?,
                    tfhp = tfhp + ?,
                    tffy = tffy + ?,
                    tfgj = tfgj + ?,
                    uwx = uwx + ?
                    WHERE sid = ?";
            
            $stmt = $ketNoiDB->prepare($sql);
            $stmt->execute([
                $hesoSinhMenh[$i],
                $hesoCongKich[$i],
                $hesoPhongNgu[$i],
                $bonusBaoKich,
                $bonusHutMau,
                $bonusMayMan,
                $bonusSinhMenh,
                $bonusPhongNgu,
                $bonusCongKich,
                $hesoNguHanh[$i],
                $idPhien
            ]);
            
            return true;
        }
    }
    
    return false;
}

/**
 * Thay đổi chỉ số người chơi
 * 
 * Hàm này thay đổi một chỉ số cụ thể của người chơi thành giá trị mới
 * 
 * @param string $tenChiSo Tên cột cần thay đổi (uhp, ugj, ufy, etc.)
 * @param mixed $giaTriMoi Giá trị mới
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function thayDoiChiSoNguoiChoi($tenChiSo, $giaTriMoi, $idPhien, $ketNoiDB)
{
    $sql = "UPDATE game1 SET $tenChiSo = ? WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$giaTriMoi, $idPhien]);
}

/**
 * Thêm/trừ chỉ số người chơi
 * 
 * Hàm này cộng hoặc trừ một giá trị vào chỉ số hiện tại của người chơi
 * 
 * @param string $tenChiSo Tên cột cần thay đổi (uhp, ugj, ufy, etc.)
 * @param int $giaTriThayDoi Giá trị thay đổi (dương để cộng, âm để trừ)
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại
 */
function themChiSoNguoiChoi($tenChiSo, $giaTriThayDoi, $idPhien, $ketNoiDB)
{
    $sql = "UPDATE game1 SET $tenChiSo = $tenChiSo + ? WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    return $stmt->execute([$giaTriThayDoi, $idPhien]);
}

/**
 * Thay đổi tiền trò chơi của người chơi
 * 
 * @param int $loaiThaoTac 1 = thêm tiền, 2 = trừ tiền
 * @param int $soTien Số tiền thay đổi
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại (không đủ tiền khi trừ)
 */
function thayDoiTienTroChoi($loaiThaoTac, $soTien, $idPhien, $ketNoiDB)
{
    if ($loaiThaoTac == 1) {
        // Thêm tiền
        $sql = "UPDATE game1 SET uyxb = uyxb + ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$soTien, $idPhien]);
    } elseif ($loaiThaoTac == 2) {
        // Trừ tiền - kiểm tra đủ tiền không
        $nguoiChoi = layThongTinNguoiChoi($idPhien, $ketNoiDB);
        
        if (!$nguoiChoi || $nguoiChoi->tienTroChoi < $soTien) {
            return false;
        }
        
        $sql = "UPDATE game1 SET uyxb = uyxb - ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$soTien, $idPhien]);
    }
    
    return false;
}

/**
 * Thay đổi tiền nạp của người chơi
 * 
 * @param int $loaiThaoTac 1 = thêm tiền, 2 = trừ tiền
 * @param int $soTien Số tiền thay đổi
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return bool True nếu thành công, false nếu thất bại (không đủ tiền khi trừ)
 */
function thayDoiTienNap($loaiThaoTac, $soTien, $idPhien, $ketNoiDB)
{
    if ($loaiThaoTac == 1) {
        // Thêm tiền
        $sql = "UPDATE game1 SET uczb = uczb + ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$soTien, $idPhien]);
    } elseif ($loaiThaoTac == 2) {
        // Trừ tiền - kiểm tra đủ tiền không
        $nguoiChoi = layThongTinNguoiChoi($idPhien, $ketNoiDB);
        
        if (!$nguoiChoi || $nguoiChoi->tienNap < $soTien) {
            return false;
        }
        
        $sql = "UPDATE game1 SET uczb = uczb - ? WHERE sid = ?";
        $stmt = $ketNoiDB->prepare($sql);
        return $stmt->execute([$soTien, $idPhien]);
    }
    
    return false;
}
