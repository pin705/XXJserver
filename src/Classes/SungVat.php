<?php
/**
 * File chứa class SungVat - Quản lý sủng vật (thú cưng)
 * 
 * Đây là phiên bản refactor của class chongwu cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class SungVat - Đại diện cho sủng vật (pet) trong game
 * 
 * Class này quản lý thông tin về sủng vật của người chơi,
 * bao gồm chỉ số chiến đấu và trang bị của sủng vật
 */
class SungVat
{
    /** @var string Tên sủng vật */
    public $tenSungVat;
    
    /** @var int Cấp độ sủng vật */
    public $capDo;
    
    /** @var int Kinh nghiệm hiện tại */
    public $kinhNghiem;
    
    /** @var int Kinh nghiệm tối đa cần để lên cấp */
    public $kinhNghiemToiDa;
    
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
    
    /** @var int Sinh mệnh tăng thêm khi lên cấp */
    public $sinhMenhTangCapDo;
    
    /** @var int Công kích tăng thêm khi lên cấp */
    public $congKichTangCapDo;
    
    /** @var int Phòng ngự tăng thêm khi lên cấp */
    public $phongNguTangCapDo;
    
    /** @var int Phẩm chất sủng vật */
    public $phamChat;
    
    /** @var int ID trang bị vị trí 1 */
    public $trangBi1;
    
    /** @var int ID trang bị vị trí 2 */
    public $trangBi2;
    
    /** @var int ID trang bị vị trí 3 */
    public $trangBi3;
    
    /** @var int ID trang bị vị trí 4 */
    public $trangBi4;
    
    /** @var int ID trang bị vị trí 5 */
    public $trangBi5;
    
    /** @var int ID trang bị vị trí 6 */
    public $trangBi6;
    
    /** @var int ID trang bị vị trí 7 */
    public $trangBi7;
    
    /**
     * Kiểm tra xem sủng vật còn sống không
     * 
     * @return bool True nếu còn sống, False nếu đã chết
     */
    public function conSong()
    {
        return $this->sinhMenh > 0;
    }
    
    /**
     * Kiểm tra xem có thể lên cấp không
     * 
     * @return bool True nếu có thể lên cấp, False nếu không
     */
    public function coTheLenCap()
    {
        return $this->kinhNghiem >= $this->kinhNghiemToiDa;
    }
    
    /**
     * Tính phần trăm kinh nghiệm hiện tại
     * 
     * @return float Phần trăm kinh nghiệm (0-100)
     */
    public function tinhPhanTramKinhNghiem()
    {
        if ($this->kinhNghiemToiDa == 0) {
            return 0;
        }
        
        return ($this->kinhNghiem / $this->kinhNghiemToiDa) * 100;
    }
    
    /**
     * Tính tổng chỉ số công kích bao gồm trang bị
     * 
     * @return int Tổng công kích
     */
    public function tinhTongCongKich()
    {
        // Chỉ số cơ bản, trang bị sẽ được tính thêm trong helper function
        return $this->congKich;
    }
    
    /**
     * Kiểm tra xem sủng vật có đang mặc trang bị không
     * 
     * @return bool True nếu có trang bị, False nếu không
     */
    public function coTrangBi()
    {
        return $this->trangBi1 > 0 || $this->trangBi2 > 0 || $this->trangBi3 > 0
            || $this->trangBi4 > 0 || $this->trangBi5 > 0 || $this->trangBi6 > 0
            || $this->trangBi7 > 0;
    }
}
