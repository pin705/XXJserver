<?php
/**
 * File chứa class TrangBi - Quản lý trang bị
 * 
 * Đây là phiên bản refactor của class zhuangbei cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class TrangBi - Đại diện cho trang bị trong game
 * 
 * Class này quản lý thông tin và thuộc tính của trang bị
 * bao gồm các chỉ số, cường hóa, v.v.
 */
class TrangBi
{
    /** @var string Tên trang bị */
    public $tenTrangBi;
    
    /** @var string Mô tả trang bị */
    public $moTa;
    
    /** @var int Công kích cộng thêm */
    public $congKich;
    
    /** @var int Phòng ngự cộng thêm */
    public $phongNgu;
    
    /** @var int Bạo kích cộng thêm */
    public $baoKich;
    
    /** @var int Hút máu cộng thêm */
    public $hutMau;
    
    /** @var int ID trang bị trong database template */
    public $idMauTrangBi;
    
    /** @var int ID người sở hữu */
    public $idNguoiSoHuu;
    
    /** @var int ID trang bị cụ thể (instance) */
    public $idTrangBi;
    
    /** @var int Cấp độ cường hóa */
    public $capCuongHoa;
    
    /** @var int Sinh mệnh cộng thêm */
    public $sinhMenh;
    
    /** @var int Cấp độ yêu cầu để trang bị */
    public $capDoYeuCau;
    
    /** @var int Vị trí trang bị (1-7) */
    public $viTri;
    
    /** @var string Màu sắc/phẩm chất trang bị */
    public $phamChat;
    
    /** @var int ID bộ trang bị (nếu thuộc bộ) */
    public $idBoTrangBi;
    
    /**
     * Tính tổng công kích bao gồm cường hóa
     * 
     * @return int Tổng công kích
     */
    public function tinhTongCongKich()
    {
        return $this->congKich + ($this->congKich * $this->capCuongHoa * 0.08);
    }
    
    /**
     * Tính tổng phòng ngự bao gồm cường hóa
     * 
     * @return int Tổng phòng ngự
     */
    public function tinhTongPhongNgu()
    {
        return $this->phongNgu + ($this->phongNgu * $this->capCuongHoa * 0.08);
    }
    
    /**
     * Kiểm tra có thể cường hóa không
     * 
     * @param int $capCuongHoaToiDa Cấp cường hóa tối đa cho phép
     * @return bool True nếu có thể cường hóa
     */
    public function coTheCuongHoa($capCuongHoaToiDa = 15)
    {
        return $this->capCuongHoa < $capCuongHoaToiDa;
    }
    
    /**
     * Tính tỷ lệ thành công cường hóa
     * 
     * @return float Tỷ lệ thành công (0-100)
     */
    public function tinhTyLeCuongHoa()
    {
        $tyLeCoBan = 100;
        $giamTheoCap = $this->capCuongHoa * 3;
        return max(10, $tyLeCoBan - $giamTheoCap);
    }
    
    /**
     * Cường hóa trang bị
     * 
     * @return bool True nếu cường hóa thành công
     */
    public function cuongHoa()
    {
        $tyLeThanhCong = $this->tinhTyLeCuongHoa();
        $ngauNhien = rand(1, 100);
        
        if ($ngauNhien <= $tyLeThanhCong) {
            $this->capCuongHoa++;
            return true;
        }
        
        return false;
    }
    
    /**
     * Lấy tên hiển thị với cấp cường hóa
     * 
     * @return string Tên trang bị (VD: "Kiếm Trường +5")
     */
    public function layTenDayDu()
    {
        $ten = $this->tenTrangBi;
        if ($this->capCuongHoa > 0) {
            $ten .= ' +' . $this->capCuongHoa;
        }
        return $ten;
    }
    
    /**
     * Lấy màu hiển thị theo phẩm chất
     * 
     * @return string Mã màu HTML
     */
    public function layMauPhamChat()
    {
        $bangMau = [
            'trang' => '#FFFFFF',   // Trắng - Thường
            'xanh' => '#00FF00',    // Xanh lá - Xuất sắc
            'tim' => '#9966FF',     // Tím - Hiếm
            'vang' => '#FFFF00',    // Vàng - Sử thi
            'do' => '#FF0000',      // Đỏ - Huyền thoại
        ];
        
        return $bangMau[$this->phamChat] ?? $bangMau['trang'];
    }
}
