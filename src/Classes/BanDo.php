<?php
/**
 * File chứa class BanDo - Quản lý bản đồ
 * 
 * Đây là phiên bản refactor của class clmid cũ
 * 
 * @package TuTaTuTien\Classes
 */

namespace TuTaTuTien\Classes;

/**
 * Class BanDo - Đại diện cho bản đồ/khu vực trong game
 * 
 * Class này quản lý thông tin về bản đồ, khu vực,
 * bao gồm quái vật, NPC, kết nối giữa các bản đồ
 */
class BanDo
{
    /** @var string Tên bản đồ */
    public $tenBanDo;
    
    /** @var string Danh sách ID quái vật trong bản đồ */
    public $danhSachQuaiVat;
    
    /** @var int ID bản đồ */
    public $idBanDo;
    
    /** @var string Danh sách NPC trong bản đồ */
    public $danhSachNpc;
    
    /** @var int ID bản đồ phía trên */
    public $idBanDoPhiaLen;
    
    /** @var int ID bản đồ phía dưới */
    public $idBanDoPhiaXuong;
    
    /** @var int ID bản đồ bên trái */
    public $idBanDoPhiaTrai;
    
    /** @var int ID bản đồ bên phải */
    public $idBanDoPhiaPhai;
    
    /** @var string Thời gian làm mới quái vật */
    public $thoiGianLamMoiQuaiVat;
    
    /** @var int ID boss trong bản đồ */
    public $idBoss;
    
    /** @var int Trạng thái bản đồ */
    public $trangThai;
    
    /** @var string Mô tả bản đồ */
    public $moTaBanDo;
    
    /** @var int ID khu vực */
    public $idKhuVuc;
    
    /** @var string Thông tin người chơi trong bản đồ */
    public $thongTinNguoiChoi;
    
    /** @var int Có phải bản đồ PVP không (0: Không, 1: Có) */
    public $laBanDoPvp;
    
    /**
     * Kiểm tra xem bản đồ có quái vật không
     * 
     * @return bool True nếu có quái vật, False nếu không
     */
    public function coQuaiVat()
    {
        return !empty($this->danhSachQuaiVat);
    }
    
    /**
     * Kiểm tra xem bản đồ có NPC không
     * 
     * @return bool True nếu có NPC, False nếu không
     */
    public function coNpc()
    {
        return !empty($this->danhSachNpc);
    }
    
    /**
     * Kiểm tra xem bản đồ có boss không
     * 
     * @return bool True nếu có boss, False nếu không
     */
    public function coBoss()
    {
        return !empty($this->idBoss) && $this->idBoss > 0;
    }
    
    /**
     * Lấy danh sách ID của các bản đồ kết nối
     * 
     * @return array Mảng chứa ID các bản đồ kết nối
     */
    public function layDanhSachBanDoKetNoi()
    {
        $danhSach = [];
        
        if ($this->idBanDoPhiaLen > 0) {
            $danhSach['len'] = $this->idBanDoPhiaLen;
        }
        
        if ($this->idBanDoPhiaXuong > 0) {
            $danhSach['xuong'] = $this->idBanDoPhiaXuong;
        }
        
        if ($this->idBanDoPhiaTrai > 0) {
            $danhSach['trai'] = $this->idBanDoPhiaTrai;
        }
        
        if ($this->idBanDoPhiaPhai > 0) {
            $danhSach['phai'] = $this->idBanDoPhiaPhai;
        }
        
        return $danhSach;
    }
}
