
$(document).ready(function() {
    var name = ['1000', '2000', '3000', '4000', '5000', 'Ngọc Nữ Tâm Kinh', 'Quỳ Hoa Bảo Điển', 'Tạ ơn tham dự', 'Ba năm mô phỏng hai năm thi đại học']
   //var name = [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ']
	var shu = ['1', '2', '3', '4', '5', '6', '7', '8', '9']
	$iii= i ;
    for (var i = 1; i <= name.length; i++) {
        $(".content").append('<div id="' + i + '" class="kuai">' + name[i - 1] + ' </div>');
		$ii = ' + shu[i - 1] + ';
    }
    $('.choujiang').on('click', function() {
        $(this).attr("disabled", true); //Nhấn cái nút sau, nút bấm tiến vào không thể biên tập trạng thái
        var sum = name.length;
        var le = 3 //Thiết trí nhấp nhô nhiều vòng
        var hh = sum * le;
        var y = 1;
        var x = hh;
        var times = 12; //Điều tiết nhấp nhô tốc độ
        var rand = parseInt(Math.random() * (x - y + 1) + y); //Thu hoạch ngẫu nhiên số
        var i = Math.ceil(rand / sum); //Hướng lên lấy cả
		
        for (var i = i; i < le; i++) {
            rand = rand + sum
        }
		
        time(1, rand, times, sum, times) //Nhấn cái nút sau phát động time Sự kiện
    })
});


function time(shu, sums, tie, sum, tis) { //Đếm ngược
    var tie = tie + tis //Nhấp nhô tốc độ
    setTimeout(function() {
        if (shu <= sums) {
            $('.kuai').css({
                'background-color': '',
                'color': ''
            }) //Thanh trừ css Thân-Đo nguyên-Mã-Lưới-w-w-w-.-q-c-y-m-w-.c-o-m-
            $('#' + shu + '').css({
                'background-color': 'aqua',
                'color': '#fff'
            }) //Tăng thêm css Kiểu dáng
            if (shu == sum) {
                sums = sums - shu
                shu = 0;
            }
            shu++
            text(shu, sums, tie, sum, tis)
        } else {
            $('.choujiang').attr("disabled", false); //Rút thưởng hoàn tất, nút bấm lần nữa tiến vào nhưng biên tập trạng thái
        }
    }, tie);
}

function text(shu, sums, tie, sum, tis) {
    time(shu, sums, tie, sum, tis) //Chấp hành time Sự kiện
}
