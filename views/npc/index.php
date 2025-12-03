<?php
$npc = $data['npc'];
$taskHtml = $data['taskHtml'];
$templateOutput = $data['templateOutput'];
$gonowmid = $data['gonowmid'];
?>
<div class="npc-container">
    <h3><?= $npc->nname ?></h3>
    <p><?= $npc->ninfo ?></p>
    
    <div class="npc-tasks">
        <?= $taskHtml ?>
    </div>
    
    <div class="npc-interaction">
        <?= $templateOutput ?>
    </div>
    
    <div class="npc-actions">
        <a href="?cmd=<?= $gonowmid ?>">Return to Map</a>
    </div>
</div>
