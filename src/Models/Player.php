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

    public function getJingjie()
    {
        $rangeslv = array(0, 30, 50, 70, 80, 90, 100, 110);
        $rangesjj = array(
            '<font color=#C7C7C7>Luyện</font><font color=#D7D7D7>Khí</font>', 
            '<font color=#78CAC6>Trúc</font><font color=#75C7C3>Cơ</font>', 
            '<font color=#A78104>Kim</font><font color=#A36208>Đan</font>', 
            '<font color=#FAC389>Nguyên</font><font color=#F7C086>Anh</font>', 
            '<font color=#F49477>Hóa</font><font color=#F19174>Thần</font>', 
            '<font color=#EB1A21>Luyện</font><font color=#E8171E>Hư</font>', 
            '<font color=#9D0F36>Hợp</font><font color=#4C0148>Thể</font>', 
            '<font color=#770035>Lớn</font><font color=#740044>Thừa</font>'
        );
        
        for ($i = 0; $i < count($rangeslv); $i++) {
            if ($this->ulv >= $rangeslv[$i] && $this->ulv < ($rangeslv[$i+1] ?? 9999)) {
                return $rangesjj[$i];
            }
        }
        return "Phàm Nhân";
    }
}
