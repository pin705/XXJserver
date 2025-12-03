<?php

namespace XXJ\Models;

class Player
{
    public $uname; // Biệt danh
    public $uid;
    public $sid; // sid 
    public $ulv; // Đẳng cấp
    public $uyxb; // Tiền trò chơi
    public $uczb; // Nạp tiền tệ
    public $uexp; // Kinh nghiệm
    public $umaxexp; // Kinh nghiệm hạn mức cao nhất
    public $uhp; // Sinh mệnh
    public $umaxhp; // Sinh mệnh
    public $ugj; // Công kích
    public $ufy; // Phòng ngự
    public $ubj; // Bạo kích
    public $uxx; // Hút máu
    public $uwx; // Ngũ Hành
    public $usex; // Giới tính
    public $vip; // vip
    public $nowmid; // Trước mắt địa đồ
    public $endtime;
    public $tool1;
    public $tool2;
    public $tool3;
    public $tool4;
    public $tool5;
    public $tool6;
    public $tool7;
    public $jingjie;
    public $sfxl;
    public $sfzx;
    public $xiuliantime;
    public $yp1;
    public $yp2;
    public $yp3;
    public $cw;
    public $jn1;
    public $jn2;
    public $jn3;
    public $ispvp;
    public $cengci;
    public $yd1;
    public $yd2;
    public $yd3;
    public $shenfen; // Thân phận
    public $dhvip; // Hối đoái vip Trang bị phán đoán
    public $dhvip1; // Hối đoái vip Trang bị phán đoán
    public $tf; // Thiên phú
    public $tfgj; // Thiên phú công kích
    public $tfxy; // Thiên phú nhỏ may mắn
    public $tfsb; // Né tránh
    public $tfxx; // Hút máu
    public $tfhp;
    public $tffy;
    public $tfbj;
    public $wugong;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
