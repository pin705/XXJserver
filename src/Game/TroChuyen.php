<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$_SERVER['PHP_SELF'];
$gonowmid = $encode->encode("cmd=goto_map&newmid=$nguoiChoi->idBanDoHienTai&sid=$nguoiChoi->idPhien");
if ($ltlx == "all"){
    $sql = 'SELECT * FROM ggliaotian ORDER BY id DESC LIMIT 10';//Nói chuyện phiếm danh sách thu hoạch 10
    $ltcxjg = $dblj->query($sql);
    $lthtml='';

    if ($ltcxjg){
        $ret = $ltcxjg->fetchAll(PDO::FETCH_BOUND);
        $goliaotian = $encode->encode("cmd=chat&ltlx=all&sid=$sid");
        $imliaotian = $encode->encode("cmd=chat&ltlx=im&sid=$sid");
        $lthtml = "【Công cộng|<a href='?cmd=$imliaotian'>Nói chuyện riêng</a>】<div style='border: #dcd4a1; border-style: dashed; border-top-width: 1px;
border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px'>";
        for ($i=0;$i < count($ret);$i++){
            $uname = $ret[count($ret) - $i-1]['name'];
            $umsg = $ret[count($ret) - $i-1]['msg'];
            $uid = $ret[count($ret) - $i-1]['uid'];
            $ucmd = $encode->encode("cmd=get_player_info&uid=$uid&sid=$nguoiChoi->idPhien");
            if ($uid){
                $lthtml .="<font color=#F4911A></font><font color=#F18E17></font><font color=#EE8B14></font><font color=#EB8811></font><a href='?cmd=$ucmd'>$uname</a>：$umsg<br/>";//Sửa chữa công cộng nói chuyện phiếm trước【Công cộng】
            }else{
                $lthtml .="<font color=#F4911A></font><font color=#F18E17></font><font color=#EE8B14></font><font color=#EB8811></font><div class='hpys' style='display: inline'>$uname</div>：$umsg<br/>";
            }

        }
        $lthtml.=<<<HTML
</div>
<form>
<input type="hidden" name="cmd" value="sendliaotian">
<input type="hidden" name="ltlx" value="all">
<input type="hidden" name="sid" value="$sid">
<!--<input type="text" name="ltmsg">-->
<input type="text" name="ltmsg" maxlength="50">
<input type="submit" value="Gửi đi"><font size="2" ><a href='?cmd=$goliaotian' style="    padding: 0px 2px;">làm mới</a></font>

</form>
HTML;
    }
}
if ($ltlx == 'im'){

    $sql = "SELECT * FROM imliaotian WHERE uid= {$nguoiChoi->idNguoiDung} or imuid = {$nguoiChoi->idNguoiDung} ORDER BY id DESC LIMIT 10";//Nói chuyện phiếm danh sách thu hoạch 10
    $ltcxjg = $dblj->query($sql);
    
    $lthtml='';

    if ($ltcxjg){
        $ret = $ltcxjg->fetchAll(PDO::FETCH_BOUND);
        $goliaotian = $encode->encode("cmd=chat&ltlx=all&sid=$sid");
        $imliaotian = $encode->encode("cmd=chat&ltlx=im&sid=$sid");
        $lthtml = "【<a href='?cmd=$goliaotian'>Công cộng</a>|Nói chuyện riêng】<br/>";
        for ($i=0;$i < count($ret);$i++){
            $uname = $ret[count($ret) - $i-1]['name'];
            $umsg = $ret[count($ret) - $i-1]['msg'];
            $uid = $ret[count($ret) - $i-1]['uid'];
            $imuid = $ret[count($ret) - $i-1]['imuid'];
            $nguoiChoiKhac = Helpers\layThongTinNguoiChoiTheoUid($imuid, $dblj);
            $ucmd = $encode->encode("cmd=get_player_info&uid=$uid&sid=$nguoiChoi->idPhien");
            $imucmd = $encode->encode("cmd=get_player_info&uid=$imuid&sid=$nguoiChoi->idPhien");
            if ($uid){
                $lthtml .="[Nói chuyện riêng]<a href='?cmd=$ucmd'>$uname</a>-->><a href='?cmd=$imucmd'>$nguoiChoiKhac->tenNhanVat</a>:$umsg<br/>";
            }
        }
    }
}

$html = <<<HTML
$lthtml
<br/>
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> 
HTML;
echo $html;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13
 * Time: 21:49
 */?>