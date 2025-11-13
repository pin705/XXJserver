<?php
/**
 * File chứa class NguoiChoi - Quản lý thông tin người chơi
 * 
 * Đây là phiên bản refactor của class player cũ, tuân thủ chuẩn PSR-1/PSR-12
 * với tên gọi tiếng Việt không dấu và PHPDoc đầy đủ bằng tiếng Việt có dấu
 * 
 * @package TuTaTuTien\Classes
 * @author Refactored Team
 * @version 2.0
 */

namespace TuTaTuTien\Classes;

use TuTaTuTien\Config\CauHinhGame;

/**
 * Class NguoiChoi - Đại diện cho người chơi trong game
 * 
 * Class này quản lý tất cả thông tin và thuộc tính của người chơi
 * bao gồm thông tin cơ bản, chỉ số chiến đấu, trang bị, tu luyện, v.v.
 */
class NguoiChoi
{
    /** @var string Tên nhân vật */
    public $tenNhanVat;
    
    /** @var int ID người dùng */
    public $idNguoiDung;
    
    /** @var string Session ID */
    public $idPhien;
    
    /** @var int Cấp độ */
    public $capDo;
    
    /** @var int Tiền trò chơi (yxb - game currency) */
    public $tienTroChoi;
    
    /** @var int Tiền nạp (czb - cash) */
    public $tienNap;
    
    /** @var int Kinh nghiệm hiện tại */
    public $kinhNghiem;
    
    /** @var int Kinh nghiệm tối đa cần để lên cấp */
    public $kinhNghiemToiDa;
    
    /** @var int Sinh mệnh hiện tại (HP) */
    public $sinhMenh;
    
    /** @var int Sinh mệnh tối đa (Max HP) */
    public $sinhMenhToiDa;
    
    /** @var int Công kích (Attack) */
    public $congKich;
    
    /** @var int Phòng ngự (Defense) */
    public $phongNgu;
    
    /** @var int Bạo kích (Critical) */
    public $baoKich;
    
    /** @var int Hút máu (Life Steal) */
    public $hutMau;
    
    /** @var int Ngũ hành */
    public $nguHanh;
    
    /** @var int Giới tính (0: Nam, 1: Nữ) */
    public $gioiTinh;
    
    /** @var int Cấp độ VIP */
    public $vip;
    
    /** @var string ID bản đồ hiện tại */
    public $idBanDoHienTai;
    
    /** @var string Thời gian kết thúc phiên */
    public $thoiGianKetThuc;
    
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
    
    /** @var string Cảnh giới tu luyện */
    public $canhGioi;
    
    /** @var int Trạng thái tu luyện */
    public $trangThaiTuLuyen;
    
    /** @var int Trạng thái online */
    public $trangThaiOnline;
    
    /** @var string Thời gian tu luyện */
    public $thoiGianTuLuyen;
    
    /** @var int ID dược phẩm slot 1 */
    public $duocPham1;
    
    /** @var int ID dược phẩm slot 2 */
    public $duocPham2;
    
    /** @var int ID dược phẩm slot 3 */
    public $duocPham3;
    
    /** @var int ID sủng vật */
    public $sungVat;
    
    /** @var int ID kỹ năng slot 1 */
    public $kyNang1;
    
    /** @var int ID kỹ năng slot 2 */
    public $kyNang2;
    
    /** @var int ID kỹ năng slot 3 */
    public $kyNang3;
    
    /** @var int Trạng thái PVP (ID người đánh) */
    public $trangThaiPvp;
    
    /** @var string Tầng cảnh giới (Một Giai, Hai Giai, ...) */
    public $tangCanhGioi;
    
    /** @var int ID dược đan slot 1 */
    public $duocDan1;
    
    /** @var int ID dược đan slot 2 */
    public $duocDan2;
    
    /** @var int ID dược đan slot 3 */
    public $duocDan3;
    
    /** @var int Thân phận (1: Chiến sĩ, 2: Pháp sư, 3: Dược sư) */
    public $thanPhan;
    
    /** @var int Trạng thái đổi VIP trang bị */
    public $daDoiVipTrangBi;
    
    /** @var int Trạng thái đổi VIP trang bị 1 */
    public $daDoiVipTrangBi1;
    
    /** @var int Điểm thiên phú */
    public $diemThienPhu;
    
    /** @var int Điểm thiên phú công kích */
    public $thienPhuCongKich;
    
    /** @var int Điểm thiên phú may mắn */
    public $thienPhuMayMan;
    
    /** @var int Điểm thiên phú né tránh */
    public $thienPhuNeTranh;
    
    /** @var int Điểm thiên phú hút máu */
    public $thienPhuHutMau;
    
    /** @var int Điểm thiên phú sinh mệnh */
    public $thienPhuSinhMenh;
    
    /** @var int Điểm thiên phú phòng ngự */
    public $thienPhuPhongNgu;
    
    /** @var int Điểm thiên phú bạo kích */
    public $thienPhuBaoKich;
    
    /** @var string Võ công đang sử dụng */
    public $voCong;
    
    /**
     * Constructor - Khởi tạo đối tượng người chơi
     */
    public function __construct()
    {
        // Khởi tạo các giá trị mặc định nếu cần
    }
    
    /**
     * Tính toán tổng công kích bao gồm từ trang bị và thiên phú
     * 
     * @return int Tổng công kích
     */
    public function tinhTongCongKich()
    {
        $tongCongKich = $this->congKich;
        
        // Cộng thêm từ thiên phú công kích
        if ($this->thienPhuCongKich > 0) {
            $tongCongKich += $this->thienPhuCongKich * CauHinhGame::HE_SO_THIEN_PHU_CONG_KICH;
        }
        
        return $tongCongKich;
    }
    
    /**
     * Tính toán tổng phòng ngự bao gồm từ trang bị và thiên phú
     * 
     * @return int Tổng phòng ngự
     */
    public function tinhTongPhongNgu()
    {
        $tongPhongNgu = $this->phongNgu;
        
        // Cộng thêm từ thiên phú phòng ngự
        if ($this->thienPhuPhongNgu > 0) {
            $tongPhongNgu += $this->thienPhuPhongNgu * CauHinhGame::HE_SO_THIEN_PHU_PHONG_NGU;
        }
        
        return $tongPhongNgu;
    }
    
    /**
     * Kiểm tra xem người chơi có đủ kinh nghiệm để lên cấp không
     * 
     * @return bool True nếu đủ kinh nghiệm, false nếu không
     */
    public function coTheLenCap()
    {
        return $this->kinhNghiem >= $this->kinhNghiemToiDa;
    }
    
    /**
     * Kiểm tra xem người chơi có còn sống không
     * 
     * @return bool True nếu còn sống, false nếu đã chết
     */
    public function conSong()
    {
        return $this->sinhMenh > 0;
    }
    
    /**
     * Lấy tên hiển thị cảnh giới đầy đủ
     * 
     * @return string Tên cảnh giới đầy đủ (VD: "Luyện Khí Một Giai")
     */
    public function layTenCanhGioiDayDu()
    {
        return $this->canhGioi . ' ' . $this->tangCanhGioi;
    }
}
