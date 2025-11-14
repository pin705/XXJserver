<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$ydaoju = \player\getdaoju($djid,$dblj);
$daoju = \player\getdaoju($djid,$dblj);
$chushou = $encode->encode("cmd=djinfo&canshu=chushou&djid=$djid&sid=$sid");
$daoju = \player\getplayerdaoju($sid,$djid,$dblj);
$player = \player\getplayer($sid,$dblj);
$djhtml = '';
if ($daoju){
    $self = $_SERVER['PHP_SELF'];
    $djhtml =<<<HTML
    
    <form action="$self">
    <input type="hidden" name="cmd" value="djinfo">
    <input type="hidden" name="canshu" value="chushou">
    <input type="hidden" name="sid" value='$sid'>
    <input type="hidden" name="djid" value="$djid">
    Đấu giá số lượng：<br/>
    <input type="number" name="djcount"><br/>
    Đấu giá đơn giá：<br/>
    <input type="number" name="pay"> 
    <input type="submit" value="Đấu giá">
    </form>
HTML;

}
if(isset($canshu))
    if ($canshu == "chushou"){
        try{
            $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            $dblj->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
            $dblj->beginTransaction();
            $sql = "update `playerdaoju` set djsum= djsum - $djcount WHERE djid = $djid AND djsum >= $djcount AND uid = $player->uid AND sid='$sid'";
            $affected_rows=$dblj->exec($sql);
            if (!$affected_rows){
                throw new PDOException("Trên người ngươi đạo cụ không đủ<br/>");//Cái kia sai lầm ném ra ngoài dị thường
            }
            $sql = "insert into `fangshi_dj`(djid,djcount,uid,pay,djname,djinfo) VALUES ($djid,$djcount,$player->uid,$pay,'$daoju->djname','$daoju->djinfo')";
            $affected_rows=$dblj->exec($sql);
            if (!$affected_rows){
                throw new PDOException("Bán ra thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
            }
            echo "Bán ra thành công！<br/>";
            $dblj->commit();//Giao dịch thành công liền đưa ra
        }catch (PDOException $e){
            echo $e->getMessage();
            $dblj->rollBack();
        }
        $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);//Quan bế
        $daoju = \player\getplayerdaoju($sid,$djid,$dblj);
        \player\changerwyq1(1,$djid,1,$sid,$dblj);
    }
    $gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$player->sid");
$fh =<<<HTML
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> <br/>
HTML;

?>

Đạo cụ tên：<?php echo $ydaoju->djname; ?><br/>
<?php
    if ($daoju) {
        echo "Đạo cụ số lượng:$daoju->djsum<br/>";
    }
?>
Đạo cụ giá cả：<?php echo $ydaoju->djyxb;?>Linh thạch<br/>
Đạo cụ nói rõ：
<?php echo $ydaoju->djinfo; ?>
<hr>
<?php echo $djhtml; ?>
<br/>
<?php 
echo $fh;

?>

