<?php
/**
 * GameHandler - Class xử lý logic game chung
 * 
 * Class này chứa các phương thức chung được sử dụng xuyên suốt game
 * để tránh lặp code và tăng khả năng mở rộng
 * 
 * @package TuTaTuTien\Core
 */

namespace TuTaTuTien\Core;

require_once __DIR__ . '/../Classes/NguoiChoi.php';
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/BanDoHelper.php';

use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Classes\NguoiChoi;

class GameHandler
{
    /**
     * @var \PDO Kết nối database
     */
    protected $db;
    
    /**
     * @var \encode\encode Đối tượng encode
     */
    protected $encode;
    
    /**
     * @var NguoiChoi Người chơi hiện tại
     */
    protected $nguoiChoi;
    
    /**
     * @var string Session ID
     */
    protected $sid;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Kết nối database
     * @param \encode\encode $encode Đối tượng encode
     * @param string $sid Session ID
     */
    public function __construct($db, $encode, $sid = null)
    {
        $this->db = $db;
        $this->encode = $encode;
        $this->sid = $sid;
        
        if ($sid) {
            $this->nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $db);
        }
    }
    
    /**
     * Lấy thông tin người chơi hiện tại
     * 
     * @return NguoiChoi|null
     */
    public function getNguoiChoi()
    {
        return $this->nguoiChoi;
    }
    
    /**
     * Tải lại thông tin người chơi từ database
     * 
     * @return NguoiChoi|null
     */
    public function reloadNguoiChoi()
    {
        if ($this->sid) {
            $this->nguoiChoi = Helpers\layThongTinNguoiChoi($this->sid, $this->db);
        }
        return $this->nguoiChoi;
    }
    
    /**
     * Tạo link encode với các tham số
     * 
     * @param string $cmd Command
     * @param array $params Các tham số bổ sung
     * @return string Chuỗi đã encode
     */
    public function createLink($cmd, array $params = [])
    {
        $queryParams = ['cmd' => $cmd];
        
        // Tự động thêm sid nếu có
        if ($this->sid) {
            $queryParams['sid'] = $this->sid;
        }
        
        // Merge với params bổ sung
        $queryParams = array_merge($queryParams, $params);
        
        // Tạo query string
        $queryString = http_build_query($queryParams);
        
        return $this->encode->encode($queryString);
    }
    
    /**
     * Lấy link quay về bản đồ hiện tại
     * 
     * @return string Link đã encode
     */
    public function getLinkQuayVeBanDo()
    {
        if (!$this->nguoiChoi) {
            return '';
        }
        
        return $this->createLink('gomid', [
            'newmid' => $this->nguoiChoi->idBanDoHienTai
        ]);
    }
    
    /**
     * Lấy link quay về khu vực chính
     * 
     * @return string Link đã encode
     */
    public function getLinkQuayVeKhuVuc()
    {
        if (!$this->nguoiChoi) {
            return '';
        }
        
        $banDo = Helpers\layThongTinBanDo($this->nguoiChoi->idBanDoHienTai, $this->db);
        $khuVuc = Helpers\layThongTinKhuVuc($banDo->mqy, $this->db);
        
        return $this->createLink('gomid', [
            'newmid' => $khuVuc->mid
        ]);
    }
    
    /**
     * Kiểm tra người chơi có còn sống không
     * 
     * @return bool
     */
    public function nguoiChoiConSong()
    {
        return $this->nguoiChoi && $this->nguoiChoi->sinhMenh > 0;
    }
    
    /**
     * Kiểm tra người chơi có đang online không
     * 
     * @return bool
     */
    public function nguoiChoiDangOnline()
    {
        return $this->nguoiChoi && $this->nguoiChoi->sfzx == 1;
    }
    
    /**
     * Tạo thông báo lỗi với link quay về
     * 
     * @param string $message Thông báo lỗi
     * @param string $linkBack Link quay về (mặc định là bản đồ hiện tại)
     * @return string HTML thông báo
     */
    public function createErrorMessage($message, $linkBack = null)
    {
        if ($linkBack === null) {
            $linkBack = $this->getLinkQuayVeBanDo();
        }
        
        return $message . '<br/><br/><a href="?' . $linkBack . '">Trở về</a>';
    }
    
    /**
     * Kiểm tra và xử lý điều kiện bản đồ
     * 
     * @param int $nowmid Bản đồ hiện tại từ request
     * @return array ['valid' => bool, 'message' => string]
     */
    public function validateBanDo($nowmid)
    {
        if (!$this->nguoiChoi) {
            return [
                'valid' => false,
                'message' => $this->createErrorMessage('Không tìm thấy thông tin người chơi')
            ];
        }
        
        if ($nowmid != $this->nguoiChoi->idBanDoHienTai) {
            return [
                'valid' => false,
                'message' => $this->createErrorMessage('Mời bình thường chơi đùa!')
            ];
        }
        
        return ['valid' => true, 'message' => ''];
    }
    
    /**
     * Kiểm tra điều kiện PVP
     * 
     * @param int $targetUid UID của mục tiêu
     * @return array ['valid' => bool, 'message' => string, 'target' => NguoiChoi|null]
     */
    public function validatePVP($targetUid)
    {
        $banDo = Helpers\layThongTinBanDo($this->nguoiChoi->idBanDoHienTai, $this->db);
        $target = Helpers\layThongTinNguoiChoiTheoUid($targetUid, $this->db);
        
        if ($banDo->ispvp == 0) {
            return [
                'valid' => false,
                'message' => $this->createErrorMessage('Trước mắt địa đồ không cho phép PK'),
                'target' => null
            ];
        }
        
        if (!$target || $target->sfzx == 0) {
            return [
                'valid' => false,
                'message' => $this->createErrorMessage('Nên người chơi không có online'),
                'target' => null
            ];
        }
        
        if ($target->idBanDoHienTai != $this->nguoiChoi->idBanDoHienTai) {
            return [
                'valid' => false,
                'message' => $this->createErrorMessage('Nên người chơi không có ở nơi đó đồ'),
                'target' => null
            ];
        }
        
        if ($this->nguoiChoi->sinhMenh <= 0) {
            return [
                'valid' => false,
                'message' => $this->createErrorMessage('Bạn đã chết, không thể PK'),
                'target' => null
            ];
        }
        
        return [
            'valid' => true,
            'message' => '',
            'target' => $target
        ];
    }
    
    /**
     * Lấy thông tin dược phẩm trang bị
     * 
     * @return array Mảng chứa thông tin 3 dược phẩm
     */
    public function getThongTinDuocPhamTrangBi()
    {
        $result = [
            'yp1' => ['id' => null, 'name' => 'Dược phẩm 1', 'link' => ''],
            'yp2' => ['id' => null, 'name' => 'Dược phẩm 2', 'link' => ''],
            'yp3' => ['id' => null, 'name' => 'Dược phẩm 3', 'link' => ''],
        ];
        
        if (!$this->nguoiChoi) {
            return $result;
        }
        
        // Xử lý dược phẩm 1
        if ($this->nguoiChoi->yp1) {
            $yp1 = Helpers\layThongTinDuocPham($this->nguoiChoi->yp1, $this->db);
            if ($yp1) {
                $result['yp1']['id'] = $yp1->id;
                $result['yp1']['name'] = isset($yp1->yname) ? $yp1->yname : 'Dược phẩm 1';
            }
        }
        
        // Xử lý dược phẩm 2
        if ($this->nguoiChoi->yp2) {
            $yp2 = Helpers\layThongTinDuocPham($this->nguoiChoi->yp2, $this->db);
            if ($yp2) {
                $result['yp2']['id'] = $yp2->id;
                $result['yp2']['name'] = isset($yp2->yname) ? $yp2->yname : 'Dược phẩm 2';
            }
        }
        
        // Xử lý dược phẩm 3
        if ($this->nguoiChoi->yp3) {
            $yp3 = Helpers\layThongTinDuocPham($this->nguoiChoi->yp3, $this->db);
            if ($yp3) {
                $result['yp3']['id'] = $yp3->id;
                $result['yp3']['name'] = isset($yp3->yname) ? $yp3->yname : 'Dược phẩm 3';
            }
        }
        
        return $result;
    }
    
    /**
     * Lấy thông tin kỹ năng trang bị
     * 
     * @return array Mảng chứa thông tin 3 kỹ năng
     */
    public function getThongTinKyNangTrangBi()
    {
        $result = [
            'jn1' => ['id' => null, 'name' => 'Phù lục 1', 'link' => ''],
            'jn2' => ['id' => null, 'name' => 'Phù lục 2', 'link' => ''],
            'jn3' => ['id' => null, 'name' => 'Phù lục 3', 'link' => ''],
        ];
        
        if (!$this->nguoiChoi) {
            return $result;
        }
        
        // Xử lý kỹ năng 1
        if ($this->nguoiChoi->jn1) {
            $jn1 = Helpers\layThongTinKyNang($this->nguoiChoi->jn1, $this->db);
            if ($jn1) {
                $result['jn1']['id'] = $jn1->jid;
                $result['jn1']['name'] = $jn1->jname ?? 'Phù lục 1';
            }
        }
        
        // Xử lý kỹ năng 2
        if ($this->nguoiChoi->jn2) {
            $jn2 = Helpers\layThongTinKyNang($this->nguoiChoi->jn2, $this->db);
            if ($jn2) {
                $result['jn2']['id'] = $jn2->jid;
                $result['jn2']['name'] = $jn2->jname ?? 'Phù lục 2';
            }
        }
        
        // Xử lý kỹ năng 3
        if ($this->nguoiChoi->jn3) {
            $jn3 = Helpers\layThongTinKyNang($this->nguoiChoi->jn3, $this->db);
            if ($jn3) {
                $result['jn3']['id'] = $jn3->jid;
                $result['jn3']['name'] = $jn3->jname ?? 'Phù lục 3';
            }
        }
        
        return $result;
    }
}
