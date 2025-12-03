<?php
// Header and CSS/JS
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" />
<link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
<script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
<script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>

<?php if ($messageType === 'success'): ?>
    <font id="success"></font>
    <script type="text/javascript">
        setTimeout(function() {
            if(document.all) { document.getElementById("success").click(); }
            else {
                var e = document.createEvent("MouseEvents");
                e.initEvent("click", true, true);
                document.getElementById("success").dispatchEvent(e);
            }
        }, 500);
        $('#success').click(function(){
            popup({type:'success',msg:"<?php echo $message; ?>",delay:1000,callBack:function(){
                console.log('callBack~~~');
            }});
        })
    </script>
<?php elseif ($messageType === 'error'): ?>
    <font id="error"></font>
    <script type="text/javascript">
        setTimeout(function() {
            if(document.all) { document.getElementById("error").click(); }
            else {
                var e = document.createEvent("MouseEvents");
                e.initEvent("click", true, true);
                document.getElementById("error").dispatchEvent(e);
            }
        }, 500);
        $('#error').click(function(){
            popup({type:'error',msg:"<?php echo $message; ?>",delay:2000,bg:true,clickDomCancel:true});
        })
    </script>
<?php endif; ?>

<IMG width='280' height='140' src='./images/shangdian.png' style="border-radius: 8px;">
<div class="menu">
    <a href="?cmd=<?php echo $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid"); ?>">Linh thạch đan dược</a>
    <a href="?cmd=<?php echo $encode->encode("cmd=shangdian&canshu1=gogoumai1&sid=$sid"); ?>"><font color="#9c27b0">Ma thạch đan dược</font></a>
    <a href="?cmd=<?php echo $encode->encode("cmd=getbagyd&sid=$sid"); ?>">Hiệu thuốc</a>
</div>
<br/>
<hr>
Đang có <br/>
Linh thạch: <?php echo $player->uyxb; ?><br/>Ma thạch: <?php echo $player->uczb; ?><hr>

<?php if ($canshu === 'gogoumai' || $canshu1 === 'gogoumai1'): ?>
    <?php foreach ($items as $item): ?>
        <?php
            $ydname = $item['ydname'];
            $ydid = $item['ydid'];
            $ydjg = ($canshu === 'gogoumai') ? $item['ydjg'] : $item['ydjgm'];
            $ydys = $item['ydys'];
            $currencyName = ($canshu === 'gogoumai') ? 'Linh thạch' : 'Ma thạch';
            
            $ydcmd = $encode->encode("cmd=ydinfo&ydid=$ydid&sid=$sid");
            
            $buyParams = ($canshu === 'gogoumai') 
                ? "cmd=shangdian&canshu=gogoumai&ydcount=1&ydid=$ydid&sid=$sid"
                : "cmd=shangdian&canshu1=gogoumai1&ydcount=1&ydid=$ydid&sid=$sid";
            $gm1yd = $encode->encode($buyParams);
            
            $buyParams10 = ($canshu === 'gogoumai')
                ? "cmd=shangdian&canshu=gogoumai&ydcount=10&ydid=$ydid&sid=$sid"
                : "cmd=shangdian&canshu1=gogoumai1&ydcount=10&ydid=$ydid&sid=$sid";
            $gm10yd = $encode->encode($buyParams10);
        ?>
        <br/><div class='menu'>
            <div style="text-align: left;">
                <a style="min-width: 200px" href="?cmd=<?php echo $ydcmd; ?>">
                    <font color='<?php echo $ydys; ?>'>[<?php echo $ydname; ?>]</font><br/>
                    Giá: <?php echo $ydjg; ?> <?php echo $currencyName; ?>
                </a>
            </div>
            <div style="width: 80px;">
                <a id="load" href="?cmd=<?php echo $gm1yd; ?>">Mua 1</a>
                <a href="?cmd=<?php echo $gm10yd; ?>">Mua 10</a>
            </div>
        </div>
    <?php endforeach; ?>
    <br/>
<?php else: ?>
    <br/>
    <a href="?cmd=<?php echo $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid"); ?>"><font color="#ffc100">Linh thạch mua</font></a><br/>
    <a href="?cmd=<?php echo $encode->encode("cmd=shangdian&canshu1=gogoumai1&sid=$sid"); ?>"><font color="#ffc100">Ma thạch mua</font></a>
    <br/>
<?php endif; ?>

<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="game.php?cmd=<?php echo $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid"); ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>

<script type="text/javascript">
    $('#load').click(function(){
        popup({type:'load',msg:"Xin chờ đợi",delay:1500,callBack:function(){
            popup({type:"success",msg:"Tăng thêm thành công",delay:1000});
        }});
    })
    $('#tip').click(function(){
        popup({type:'tip',msg:"Nhắc nhở tin tức",delay:null,bg:true,clickDomCancel:true});
    })
</script>
