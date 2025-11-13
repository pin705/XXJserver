<?php
/**
 * File chứa class DaoCu - Quản lý đạo cụ/vật phẩm
 * 
 * Đây là phiên bản refactor của class daoju cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class DaoCu - Đại diện cho đạo cụ/vật phẩm trong game
 * 
 * Class này quản lý thông tin về các đạo cụ, vật phẩm đặc biệt
 * mà người chơi có thể sử dụng hoặc trao đổi
 */
class DaoCu
{
    /** @var string Tên đạo cụ */
    public $tenDaoCu;
    
    /** @var int ID đạo cụ trong kho người chơi */
    public $idDaoCuNguoiChoi;
    
    /** @var string Mô tả đạo cụ */
    public $moTaDaoCu;
    
    /** @var int ID template đạo cụ */
    public $idDaoCu;
    
    /** @var int Số lượng đạo cụ */
    public $soLuong;
    
    /** @var int Giá bán bằng tiền trò chơi */
    public $giaTienTroChoi;
    
    /**
     * Kiểm tra xem có đủ số lượng đạo cụ không
     * 
     * @param int $soLuongCanKiem Số lượng cần kiểm tra
     * @return bool True nếu đủ, False nếu không đủ
     */
    public function duSoLuong($soLuongCanKiem)
    {
        return $this->soLuong >= $soLuongCanKiem;
    }
    
    /**
     * Tính tổng giá trị của đạo cụ hiện có
     * 
     * @return int Tổng giá trị
     */
    public function tinhTongGiaTri()
    {
        return $this->giaTienTroChoi * $this->soLuong;
    }
}
