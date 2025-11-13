<?php
/**
 * File chứa class KyNang - Quản lý kỹ năng
 * 
 * Đây là phiên bản refactor của class jineng cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class KyNang - Đại diện cho kỹ năng trong game
 * 
 * Class này quản lý thông tin về kỹ năng võ công
 * mà người chơi có thể học và sử dụng
 */
class KyNang
{
    /** @var string Tên kỹ năng */
    public $tenKyNang;
    
    /** @var int ID kỹ năng */
    public $idKyNang;
    
    /** @var int Công kích tăng thêm */
    public $congKichTangThem;
    
    /** @var int Phòng ngự tăng thêm */
    public $phongNguTangThem;
    
    /** @var int Bạo kích tăng thêm */
    public $baoKichTangThem;
    
    /** @var int Hút máu tăng thêm */
    public $hutMauTangThem;
    
    /** @var int Số đạo cụ cần để học */
    public $soDaoCuCanHoc;
    
    /** @var int Số lượng đạo cụ cần */
    public $soLuongDaoCu;
    
    /** @var int Số lần đã sử dụng */
    public $soLanSuDung;
    
    /**
     * Kiểm tra xem có đủ điều kiện học kỹ năng không
     * 
     * @param int $soLuongDaoCuHienCo Số lượng đạo cụ hiện có
     * @return bool True nếu đủ điều kiện, False nếu không
     */
    public function duDieuKienHoc($soLuongDaoCuHienCo)
    {
        return $soLuongDaoCuHienCo >= $this->soLuongDaoCu;
    }
    
    /**
     * Tính tổng sát thương của kỹ năng
     * 
     * @param int $congKichCoSo Công kích cơ sở của người chơi
     * @return int Tổng sát thương
     */
    public function tinhTongSatThuong($congKichCoSo)
    {
        return $congKichCoSo + $this->congKichTangThem;
    }
    
    /**
     * Kiểm tra xem kỹ năng có hiệu ứng đặc biệt không
     * 
     * @return bool True nếu có hiệu ứng đặc biệt, False nếu không
     */
    public function coHieuUngDacBiet()
    {
        return $this->baoKichTangThem > 0 || $this->hutMauTangThem > 0;
    }
}
