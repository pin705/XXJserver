<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/24 0024
 * Time: 12:59
 */
$player = \player\getplayer($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$payhtml='';
$pdjcount = 0;
if (!isset($yeshu)){
    $yeshu = 0;
}
if (!isset($fangshi)){
    exit("<a href='?cmd=$gonowmid'>Trở về trò chơi</a>");
}
switch ($fangshi){
    case "daoju":
        
        if (isset($canshu)){
            if ($canshu == "buy"){
                $fsdj = \player\getfangshi_once("daoju",$payid,$dblj);
                try{
                    if (!$fsdj){
                        throw new PDOException("Đạo cụ đã bán sạch<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    }
                    $playerdj = \player\getplayerdaoju($sid,$fsdj->djid,$dblj);
                    if ($playerdj){
                        $pdjcount = $playerdj->djsum;
                    }
                    $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
                    $dblj->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
                    $dblj->beginTransaction();
                    $price = $buycount * $fsdj->pay;
                    $sql = "update `game1` set uyxb = uyxb - $price WHERE uyxb >= $price AND sid='$sid'";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows && $price>0)
                        throw new PDOException("Linh thạch không đủ<br/>");//Cái kia sai lầm ném ra ngoài dị thường

                    $sql = "update `fangshi_dj` set djcount = djcount - $buycount WHERE djcount >= $buycount and payid = $payid";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trong phường thị nên đạo cụ đếm không đủ<br/>");//Cái kia sai lầm ném ra ngoài dị thường

                    $sql = "update `game1` set uyxb = uyxb + {$price} WHERE uid = {$fsdj->uid}";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Treo lên nên đạo cụ tu sĩ chưa thu được linh thạch<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    $djsum = $pdjcount + $buycount;
                    $sql = "replace into `playerdaoju`(djname,djsum,uid,sid,djid,djinfo) VALUES('$fsdj->djname','$djsum','$player->uid','$sid',$fsdj->djid,'$fsdj->djinfo')";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Truyền tống trận tại truyền tống đạo cụ thời điểm truyền tống thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    echo "Giao dịch thành công！<br/>";
                    $dblj->commit();//Giao dịch thành công liền đưa ra

                }catch (PDOException $e){
                    echo $e->getMessage();
                    $dblj->rollBack();
                }
                $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);//Quan bế
                $sql="delete from `fangshi_dj` where djcount = 0";
                $dblj->exec($sql);
                \player\changerwyq1(1,$fsdj->djid,1,$sid,$dblj);
            }
        }
        $fsdjall = \player\getfangshi_all($fangshi,$dblj);
        foreach ($fsdjall as $fsdj){
            $djid = $fsdj['djid'];
            $djname = $fsdj['djname'];
            $djpay = $fsdj['pay'];
            $djcount = $fsdj['djcount'];
            $payid = $fsdj['payid'];
            $goumaidj1 = $encode->encode("cmd=fangshi&fangshi=daoju&canshu=buy&payid=$payid&buycount=1&sid=$sid");
            $goumaidj5 = $encode->encode("cmd=fangshi&fangshi=daoju&canshu=buy&payid=$payid&buycount=5&sid=$sid");
            $goumaidj10 = $encode->encode("cmd=fangshi&fangshi=daoju&canshu=buy&payid=$payid&buycount=10&sid=$sid");
            $djpaycmd = $encode->encode("cmd=djinfo&djid=$djid&sid=$sid");
            $payhtml .= "<a href='?cmd=$djpaycmd'>{$djname}x$djcount</a>Đơn giá:$djpay<a href='?cmd=$goumaidj1'>Mua 1</a><a href='?cmd=$goumaidj5'>Mua 5</a> <a href='?cmd=$goumaidj10'>Mua 10</a><br/>";
        }
        $zhuangbei = $encode->encode("cmd=fangshi&fangshi=zhuangbei&sid=$sid");
        $payhtml=<<<HTML
            【Đạo cụ|<a href="?cmd=$zhuangbei">Trang bị</a>】<br/>
            $payhtml
            <br/><a href='?cmd=$gonowmid'>Trở về trò chơi</a><br/>
HTML;
        break;
    
    
    case "zhuangbei":
        if (isset($canshu)){
            if ($canshu == "buy"){
                try{
                    $fszb = \player\getfangshi_once("zhuangbei",$payid,$dblj);

                    if (!$fszb){
                        echo "Trang bị đã bị bán ra<br/>";//Cái kia sai lầm ném ra ngoài dị thường
                        goto fszblist;
                    }
                    $pay = $fszb->pay;
                    $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
                    $dblj->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
                    $dblj->beginTransaction();
                    $sql = "update `game1` set uyxb = uyxb - $pay WHERE uyxb >= $pay AND sid='$sid'";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows && $pay>0)
                        throw new PDOException("Linh thạch không đủ<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "delete from `fangshi_zb` WHERE payid=$payid";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trang bị xuất hàng thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "update `game1` set uyxb = uyxb+ $pay WHERE uid=$fszb->uid";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows && $pay>0)
                        throw new PDOException("Treo lên nên trang bị tu sĩ chưa thu được linh thạch<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "update `playerzhuangbei` set sid = '$sid',uid=$player->uid WHERE zbnowid=$fszb->zbnowid";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trang bị truyền tống thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    echo "Giao dịch thành công！<br/>";
                    $dblj->commit();//Giao dịch thành công liền đưa ra
                }catch (PDOException $e){
                    echo $e->getMessage();
                    $dblj->rollBack();
                }
                $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);

            }
        }
        fszblist:
        $fsdjall = \player\getfangshi_all($fangshi,$dblj);
        foreach ($fsdjall as $fsdj){
            $zbnowid = $fsdj['zbnowid'];
            $zbname = $fsdj['zbname'];
            $zbqh = $fsdj['qianghua'];
            $zbpay = $fsdj['pay'];
            $payid = $fsdj['payid'];
            if ($zbqh){
                $zbqh = '+'.$zbqh;
            }else{
                $zbqh='';
            }
            $goumaizb = $encode->encode("cmd=fangshi&fangshi=zhuangbei&canshu=buy&payid=$payid&sid=$sid");
            $zbpaycmd = $encode->encode("cmd=zbinfo&zbnowid=$zbnowid&sid=$sid");
            $payhtml .= "<a href='?cmd=$zbpaycmd'>{$zbname}{$zbqh}</a>Giá cả:$zbpay<a href='?cmd=$goumaizb'>Mua</a><br/>";
        }
        $fangshi = $encode->encode("cmd=fangshi&fangshi=daoju&sid=$sid");
        $payhtml=<<<HTML
            【<a href="?cmd=$fangshi">Đạo cụ</a>|Trang bị】<br/>
            $payhtml
            <br/>
            <a href='?cmd=$gonowmid'>Trở về trò chơi</a><br/>
HTML;
        break;
}


echo $payhtml;