<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Mạch đương manh mối<zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Think;

class PageAjax{
    public $firstRow; // Mở đầu đi số
    public $listRows; // danh sách mỗi trang biểu hiện đi số
    public $parameter; // Phân trang nhảy chuyển lúc muốn dẫn tham số
    public $totalRows; // Được số
    public $totalPages; // Phân trang tổng giao diện số
    public $rollPage   = 11;// Phân trang cột mỗi trang biểu hiện số trang
	public $lastSuffix = true; // Một trang cuối cùng phải chăng biểu hiện tổng số trang

    private $p       = 'p'; //Phân trang tham số tên
    private $url     = ''; //Trước mắt kết nối URL
    private $nowPage = 1;

	// Phân trang biểu hiện định chế
    private $config  = array(
        'header' => '<span class="rows">Chung%TOTAL_ROW% Đầu ghi chép</span>',
        'prev'   => '<<',
        'next'   => '>>',
        'first'  => '1...',
        'last'   => '...%TOTAL_PAGE%',
        'theme'  => '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
		'addClass' => '',
    );

    /**
     * Cơ cấu hàm số
     * @param array $totalRows  Tổng ghi chép số
     * @param array $listRows  Mỗi trang biểu hiện ghi chép số
     * @param array $parameter  Phân trang nhảy chuyển tham số
     */
    public function __construct($totalRows, $listRows=20, $parameter = array()) {
        C('VAR_PAGE') && $this->p = C('VAR_PAGE'); //Thiết trí phân trang tham số tên
        /* Cơ sở thiết trí*/
        $this->totalRows  = $totalRows; //Thiết trí tổng ghi chép số
        $this->listRows   = $listRows;  //Thiết trí mỗi trang biểu hiện đi số
        $this->parameter  = empty($parameter) ? $_GET : $parameter;
        $this->nowPage    = empty($_GET[$this->p]) ? 1 : intval($_GET[$this->p]);
        $this->nowPage    = $this->nowPage>0 ? $this->nowPage : 1;
        $this->firstRow   = $this->listRows * ($this->nowPage - 1);
    }

    /**
     * Định chế phân trang kết nối thiết trí
     * @param string $name  Thiết trí tên
     * @param string $value Thiết trí giá trị
     */
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * Tạo ra kết nối URL
     * @param  integer $page Số trang
     * @return string
     */
    private function url($page){
        return str_replace(urlencode('[PAGE]'), $page, $this->url);
    }

    /**
     * Lắp ráp phân trang kết nối
     * @return string
     */
    public function show() {
        if(0 == $this->totalRows) return '';

        /* Tạo ra URL*/
        $this->parameter[$this->p] = '[PAGE]';
        $this->url = U(ACTION_NAME, $this->parameter);
        /* Tính toán phân trang tin tức*/
        $this->totalPages = ceil($this->totalRows / $this->listRows); //Tổng số trang
		
		//Như tổng số trang chỉ có một tờ, thì lùi ra không phân trang cột
		if($this->totalPages == 1) {
			$this->totalRows  = $totalRows; //Thiết trí tổng ghi chép số
			$this->listRows   = $listRows;  //Thiết trí mỗi trang biểu hiện đi số
			$this->parameter  = empty($parameter) ? $_GET : $parameter;
			$this->nowPage    = empty($_GET[$this->p]) ? 1 : intval($_GET[$this->p]);
			$this->nowPage    = $this->nowPage>0 ? $this->nowPage : 1;
			$this->firstRow   = 0;
			return "";
		}
		
		
		if(!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

        /* Tính toán phân trang lúc không giờ lượng biến đổi*/
        $now_cool_page      = $this->rollPage/2;
		$now_cool_page_ceil = ceil($now_cool_page);
		$this->lastSuffix && $this->config['last'] = $this->totalPages;

        //Trang trước
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<li><a class="prev" href="javascript:" data-p="' . $up_row . '" data-url="' . $this->url($up_row) . '">' . $this->config['prev'] . '</a></li>' : '';

        //Trang kế tiếp
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<li><a class="next" href="javascript:" data-p="' . $down_row . '" data-url="' . $this->url($down_row) . '">' . $this->config['next'] . '</a></li>' : '';

        //Tờ thứ nhất
        $the_first = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1){
            $the_first = '<li><a class="first" href="javascript:" data-url="' . $this->url(1) . '">' . $this->config['first'] . '</a></li>';
        }

        //Một trang cuối cùng
        $the_end = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages){
            $the_end = '<li><a class="end" href="javascript:" data-p="' . $this->config['last'] . '" data-url="' . $this->url($this->totalPages) . '">' . $this->config['last'] . '</a></li>';
        }

        //Số lượng kết nối
        $link_page = "";
        for($i = 1; $i <= $this->rollPage; $i++){
			if(($this->nowPage - $now_cool_page) <= 0 ){
				$page = $i;
			}elseif(($this->nowPage + $now_cool_page - 1) >= $this->totalPages){
				$page = $this->totalPages - $this->rollPage + $i;
			}else{
				$page = $this->nowPage - $now_cool_page_ceil + $i;
			}
            if($page > 0 && $page != $this->nowPage){

                if($page <= $this->totalPages){
                    $link_page .= '<li><a class="num" href="javascript:" data-p="' . $page . '" data-url="' . $this->url($page) . '">' . $page . '</a></li>';
                }else{
                    break;
                }
            }else{
                if($page > 0 && $this->totalPages != 1){
                    $link_page .= '<li class="active"><span class="current">' . $page . '</span></li>';
                }
            }
        }

        //Thay thế phân trang nội dung
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'),
            array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages),
            $this->config['theme']);
        return "<ul class='pagination " . $this->config['addClass'] . "'>{$page_str}</ul>";
    }
}
