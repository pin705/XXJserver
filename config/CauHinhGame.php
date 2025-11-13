<?php
/**
 * File cấu hình các hằng số của game
 * 
 * File này chứa tất cả các hằng số được sử dụng trong game
 * như tỷ lệ kinh nghiệm, giới hạn cấp độ, v.v.
 */

namespace TuTaTuTien\Config;

/**
 * Class CauHinhGame - Quản lý các hằng số cấu hình game
 */
class CauHinhGame
{
    // Cấu hình cấp độ
    /** @var int Cấp độ tối đa */
    const CAP_DO_TOI_DA = 110;
    
    /** @var int Cấp độ mở khóa thiên phú */
    const CAP_DO_MO_KHOA_THIEN_PHU = 30;
    
    // Ngưỡng cấp độ cho các cảnh giới
    /** @var array Ngưỡng cấp độ của các cảnh giới tu luyện */
    const NGUONG_CAP_DO_CANH_GIOI = [0, 30, 50, 70, 80, 90, 100, 110];
    
    // Hệ số kinh nghiệm
    /** @var array Hệ số kinh nghiệm cho mỗi cảnh giới */
    const HE_SO_KINH_NGHIEM = [2.5, 5, 7.5, 10, 12.5, 15, 17.5];
    
    // Hệ số tăng trưởng công kích
    /** @var array Hệ số công kích tăng theo cảnh giới */
    const HE_SO_CONG_KICH = [2.5, 5, 7.5, 10, 12.5, 15, 17.5];
    
    // Hệ số tăng trưởng phòng ngự
    /** @var array Hệ số phòng ngự tăng theo cảnh giới */
    const HE_SO_PHONG_NGU = [2.5, 5, 7.5, 10, 12.5, 15, 17.5];
    
    // Hệ số tăng trưởng sinh mệnh
    /** @var array Hệ số sinh mệnh tăng theo cảnh giới */
    const HE_SO_SINH_MENH = [30, 50, 70, 90, 110, 130, 170];
    
    // Hệ số tăng trưởng ngũ hành
    /** @var array Hệ số ngũ hành tăng theo cảnh giới */
    const HE_SO_NGU_HANH = [2, 4, 6, 8, 10, 12, 14];
    
    // Tên các cảnh giới
    /** @var array Tên hiển thị của các cảnh giới */
    const TEN_CANH_GIOI = [
        'Luyện Khí',
        'Trúc Cơ', 
        'Kim Đan',
        'Nguyên Anh',
        'Hóa Thần',
        'Luyện Hư',
        'Hợp Thể',
        'Đại Thừa'
    ];
    
    // Cấu hình thiên phú
    /** @var int Hệ số nhân thiên phú công kích */
    const HE_SO_THIEN_PHU_CONG_KICH = 5;
    
    /** @var float Hệ số nhân thiên phú bạo kích */
    const HE_SO_THIEN_PHU_BAO_KICH = 1.5;
    
    /** @var int Hệ số nhân thiên phú hút máu */
    const HE_SO_THIEN_PHU_HUT_MAU = 2;
    
    /** @var int Hệ số nhân thiên phú sinh mệnh */
    const HE_SO_THIEN_PHU_SINH_MENH = 10;
    
    /** @var int Hệ số nhân thiên phú phòng ngự */
    const HE_SO_THIEN_PHU_PHONG_NGU = 5;
    
    // Cấu hình thời gian
    /** @var int Thời gian offline tối đa (giây) */
    const THOI_GIAN_OFFLINE_TOI_DA = 900;
    
    /** @var int Khoảng cách giữa các lần click (milliseconds) */
    const KHOANG_CACH_CLICK = 220;
    
    // Cấu hình cường hóa
    /** @var float Tỷ lệ tăng thuộc tính khi cường hóa */
    const TY_LE_CUONG_HOA = 0.08;
}
