<?php
/**
 * File chứa class QuaiVat - Quản lý thông tin quái vật
 * 
 * Đây là phiên bản refactor của class guaiwu cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

require_once __DIR__ . '/../../config/CauHinhGame.php';

use TuTaTuTien\Config\CauHinhGame;

/**
 * Class QuaiVat - Đại diện cho quái vật trong game
 * 
 * Class này quản lý thông tin và thuộc tính của quái vật
 * bao gồm chỉ số chiến đấu, vật phẩm rơi, v.v.
 */
class QuaiVat
{
    /** @var string Tên quái vật */
    public $tenQuai;
    
    /** @var string Mô tả quái vật */
    public $moTa;
    
    /** @var int Giới tính quái vật */
    public $gioiTinh;
    
    /** @var int ID trang bị rơi */
    public $idTrangBiRoi;
    
    /** @var float Tỷ lệ rơi trang bị (%) */
    public $tyLeRoiTrangBi;
    
    /** @var int ID đạo cụ rơi */
    public $idDaoCuRoi;
    
    /** @var float Tỷ lệ rơi đạo cụ (%) */
    public $tyLeRoiDaoCu;
    
    /** @var int ID dược phẩm rơi */
    public $idDuocPhamRoi;
    
    /** @var float Tỷ lệ rơi dược phẩm (%) */
    public $tyLeRoiDuocPham;
    
    /** @var int ID của quái vật trong game */
    public $idQuai;
    
    /** @var string Session ID của người chơi đang đánh */
    public $idPhienNguoiChoi;
    
    /** @var int Cấp độ quái vật */
    public $capDo;
    
    /** @var int Kinh nghiệm nhận được khi tiêu diệt */
    public $kinhNghiem;
    
    /** @var int Sinh mệnh hiện tại */
    public $sinhMenh;
    
    /** @var int Sinh mệnh tối đa */
    public $sinhMenhToiDa;
    
    /** @var int Công kích */
    public $congKich;
    
    /** @var int Phòng ngự */
    public $phongNgu;
    
    /** @var int Bạo kích */
    public $baoKich;
    
    /** @var int Hút máu */
    public $hutMau;
    
    /** @var int ID trong kho quái vật */
    public $idKhoQuai;
    
    /** @var string Cảnh giới quái vật */
    public $canhGioi;
    
    /**
     * Kiểm tra quái vật còn sống không
     * 
     * @return bool True nếu còn sống, false nếu đã chết
     */
    public function conSong()
    {
        return $this->sinhMenh > 0;
    }
    
    /**
     * Nhận sát thương từ người chơi
     * 
     * @param int $satThuong Lượng sát thương nhận vào
     * @return int Sát thương thực tế sau khi trừ phòng ngự
     */
    public function nhanSatThuong($satThuong)
    {
        $satThuongThucTe = max(1, $satThuong - $this->phongNgu);
        $this->sinhMenh = max(0, $this->sinhMenh - $satThuongThucTe);
        return $satThuongThucTe;
    }
    
    /**
     * Tấn công người chơi
     * 
     * @param NguoiChoi $nguoiChoi Đối tượng người chơi bị tấn công
     * @return int Sát thương gây ra
     */
    public function tanCong($nguoiChoi)
    {
        $satThuongCoBan = $this->congKich;
        
        // Tính bạo kích
        if (rand(1, 100) <= $this->baoKich) {
            $satThuongCoBan *= 2;
        }
        
        $satThuongThucTe = max(1, $satThuongCoBan - $nguoiChoi->phongNgu);
        return $satThuongThucTe;
    }
    
    /**
     * Lấy tên hiển thị đầy đủ với cảnh giới
     * 
     * @return string Tên đầy đủ (VD: "Yêu Hổ [Luyện Khí Một Giai]")
     */
    public function layTenDayDu()
    {
        return $this->tenQuai . ' [' . $this->canhGioi . ']';
    }
}
