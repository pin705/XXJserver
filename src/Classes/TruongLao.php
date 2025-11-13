<?php
/**
 * File chứa class TruongLao - Quản lý boss
 * 
 * Đây là phiên bản refactor của class boss cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class TruongLao - Đại diện cho boss trong game
 * 
 * Class này quản lý thông tin về trưởng lão/boss,
 * bao gồm chỉ số chiến đấu và vật phẩm rơi
 */
class TruongLao
{
    /** @var string Tên boss */
    public $tenBoss;
    
    /** @var int Cấp độ boss */
    public $capDoBoss;
    
    /** @var int ID boss */
    public $idBoss;
    
    /** @var string Thời gian làm mới boss */
    public $thoiGianLamMoi;
    
    /** @var int Trạng thái boss (0: Chết, 1: Sống) */
    public $trangThai;
    
    /** @var string Mô tả boss */
    public $moTaBoss;
    
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
    
    /** @var string Đạo cụ rơi */
    public $daoCuRoi;
    
    /** @var string Trang bị rơi */
    public $trangBiRoi;
    
    /** @var int Tỷ lệ rơi đạo cụ */
    public $tyLeRoiDaoCu;
    
    /** @var int Tỷ lệ rơi trang bị */
    public $tyLeRoiTrangBi;
    
    /** @var string Session ID người chơi đang đánh */
    public $idPhienNguoiChoi;
    
    /** @var int Tỷ lệ rơi dược phẩm */
    public $tyLeRoiDuocPham;
    
    /** @var string Dược phẩm rơi */
    public $duocPhamRoi;
    
    /**
     * Kiểm tra xem boss còn sống không
     * 
     * @return bool True nếu còn sống, False nếu đã chết
     */
    public function conSong()
    {
        return $this->sinhMenh > 0;
    }
    
    /**
     * Tính phần trăm sinh mệnh còn lại
     * 
     * @return float Phần trăm sinh mệnh (0-100)
     */
    public function tinhPhanTramSinhMenh()
    {
        if ($this->sinhMenhToiDa == 0) {
            return 0;
        }
        
        return ($this->sinhMenh / $this->sinhMenhToiDa) * 100;
    }
    
    /**
     * Nhận sát thương
     * 
     * @param int $satThuong Lượng sát thương nhận vào
     * @return int Sinh mệnh còn lại sau khi nhận sát thương
     */
    public function nhanSatThuong($satThuong)
    {
        $this->sinhMenh -= $satThuong;
        if ($this->sinhMenh < 0) {
            $this->sinhMenh = 0;
        }
        
        return $this->sinhMenh;
    }
    
    /**
     * Kiểm tra xem boss có đang bị đánh không
     * 
     * @return bool True nếu đang bị đánh, False nếu không
     */
    public function dangBiDanh()
    {
        return !empty($this->idPhienNguoiChoi);
    }
}
