<?php
/**
 * File chứa class NhiemVu - Quản lý nhiệm vụ
 * 
 * Đây là phiên bản refactor của class task cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class NhiemVu - Đại diện cho nhiệm vụ trong game
 * 
 * Class này quản lý thông tin về nhiệm vụ mà người chơi nhận và thực hiện
 */
class NhiemVu
{
    /** @var string Tên nhiệm vụ */
    public $tenNhiemVu;
    
    /** @var string Mô tả nhiệm vụ */
    public $moTaNhiemVu;
    
    /** @var int ID nhiệm vụ */
    public $idNhiemVu;
    
    /** @var int Loại nhiệm vụ (1: Thu thập đạo cụ, 2: Tiêu diệt quái vật, 3: Tìm NPC) */
    public $loaiNhiemVu;
    
    /** @var int Yêu cầu nhiệm vụ (ID quái vật hoặc đạo cụ) */
    public $yeuCauNhiemVu;
    
    /** @var string Đạo cụ thưởng */
    public $daoCuThuong;
    
    /** @var string Trang bị thưởng */
    public $trangBiThuong;
    
    /** @var int Kinh nghiệm thưởng */
    public $kinhNghiemThuong;
    
    /** @var int Tiền trò chơi thưởng */
    public $tienTroChoiThuong;
    
    /** @var string Session ID người chơi */
    public $idPhienNguoiChoi;
    
    /** @var int Trạng thái nhiệm vụ (0: Chưa nhận, 1: Đang thực hiện, 2: Hoàn thành, 3: Đã nhận thưởng) */
    public $trangThaiNhiemVu;
    
    /** @var int Số lượng yêu cầu */
    public $soLuongYeuCau;
    
    /** @var string Dược phẩm thưởng */
    public $duocPhamThuong;
    
    /** @var int Loại thưởng */
    public $loaiThuong;
    
    /** @var int Số lượng hiện tại đã hoàn thành */
    public $soLuongHienTai;
    
    /** @var int ID nhiệm vụ trước */
    public $idNhiemVuTruoc;
    
    /** @var int ID khu vực nhiệm vụ */
    public $idKhuVucNhiemVu;
    
    /**
     * Kiểm tra xem nhiệm vụ đã hoàn thành chưa
     * 
     * @return bool True nếu đã hoàn thành, False nếu chưa
     */
    public function daHoanThanh()
    {
        return $this->soLuongHienTai >= $this->soLuongYeuCau;
    }
    
    /**
     * Tính phần trăm hoàn thành nhiệm vụ
     * 
     * @return float Phần trăm hoàn thành (0-100)
     */
    public function tinhPhanTramHoanThanh()
    {
        if ($this->soLuongYeuCau == 0) {
            return 0;
        }
        
        return min(100, ($this->soLuongHienTai / $this->soLuongYeuCau) * 100);
    }
    
    /**
     * Kiểm tra xem nhiệm vụ có đang được thực hiện không
     * 
     * @return bool True nếu đang thực hiện, False nếu không
     */
    public function dangThucHien()
    {
        return $this->trangThaiNhiemVu == 1;
    }
    
    /**
     * Kiểm tra xem có thể nhận thưởng không
     * 
     * @return bool True nếu có thể nhận thưởng, False nếu không
     */
    public function coTheNhanThuong()
    {
        return $this->trangThaiNhiemVu == 2;
    }
}
