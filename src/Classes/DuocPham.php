<?php
/**
 * File chứa class DuocPham - Quản lý dược phẩm
 * 
 * Đây là phiên bản refactor của class yaopin cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class DuocPham - Đại diện cho dược phẩm trong game
 * 
 * Class này quản lý thông tin về dược phẩm (thuốc, bổ dược)
 * mà người chơi có thể sử dụng để hồi phục hoặc tăng chỉ số
 */
class DuocPham
{
    /** @var string Tên dược phẩm */
    public $tenDuocPham;
    
    /** @var int ID dược phẩm */
    public $idDuocPham;
    
    /** @var int Sinh mệnh hồi phục */
    public $sinhMenhHoiPhuc;
    
    /** @var int Công kích tăng thêm */
    public $congKichTangThem;
    
    /** @var int Phòng ngự tăng thêm */
    public $phongNguTangThem;
    
    /** @var int Giá bán */
    public $giaBan;
    
    /** @var int Bạo kích tăng thêm */
    public $baoKichTangThem;
    
    /** @var int Hút máu tăng thêm */
    public $hutMauTangThem;
    
    /** @var int Số lượng hiện có */
    public $soLuong;
    
    /**
     * Kiểm tra xem có thể sử dụng dược phẩm không
     * 
     * @return bool True nếu có thể sử dụng, False nếu không
     */
    public function coTheSuDung()
    {
        return $this->soLuong > 0;
    }
    
    /**
     * Tính hiệu quả hồi phục sinh mệnh cho số lượng nhất định
     * 
     * @param int $soLuongSuDung Số lượng dược phẩm sử dụng
     * @return int Tổng sinh mệnh hồi phục
     */
    public function tinhHieuQuaHoiPhuc($soLuongSuDung = 1)
    {
        return $this->sinhMenhHoiPhuc * $soLuongSuDung;
    }
    
    /**
     * Kiểm tra xem dược phẩm có tác dụng tăng chỉ số chiến đấu không
     * 
     * @return bool True nếu có tác dụng tăng chỉ số, False nếu không
     */
    public function coTacDungTangChiSo()
    {
        return $this->congKichTangThem > 0 
            || $this->phongNguTangThem > 0 
            || $this->baoKichTangThem > 0 
            || $this->hutMauTangThem > 0;
    }
}
