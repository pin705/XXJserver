<?php
// Legacy template support
// Variables available: $npc, $tasks, $canshu, $dblj, $player, $sid, $encode (from Controller render)

// Include the template
$templatePath = __DIR__ . '/../../npc/muban/' . $npc->muban . '.php';
if (file_exists($templatePath)) {
    include $templatePath;
} else {
    echo "NPC Template not found: " . $npc->muban;
}
?>
<br/>
<a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
