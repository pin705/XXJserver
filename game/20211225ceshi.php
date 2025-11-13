<?php
$player = player\getplayer($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");

$zhuangbei1 = player\getzb($player->tool1,$dblj);
$zhuangbei2 = player\getzb($player->tool2,$dblj);
$zhuangbei3 = player\getzb($player->tool3,$dblj);
$zhuangbei4 = player\getzb($player->tool4,$dblj);
$zhuangbei5 = player\getzb($player->tool5,$dblj);
$zhuangbei6 = player\getzb($player->tool6,$dblj);
$zhuangbei7 = player\getzb($player->tool7,$dblj);
if($zhuangbei1->tz=$zhuangbei2->tz){$tz=1;
}if($zhuangbei1->tz=$zhuangbei3->tz){$tz=1;
}if($zhuangbei1->tz=$zhuangbei4->tz){$tz=1;
}if($zhuangbei1->tz=$zhuangbei5->tz){$tz=1;
}if($zhuangbei1->tz=$zhuangbei6->tz){$tz=1;
}if($zhuangbei1->tz=$zhuangbei7->tz){$tz=1;
}
if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz){$tz=2;
}if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei4->tz){$tz=2;
}if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei5->tz){$tz=2;
}if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei6->tz){$tz=2;
}if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei7->tz){$tz=2;
}
if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei4->tz){$tz=3;
}if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei5->tz){$tz=3;
}if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei6->tz){$tz=3;
}if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei7->tz){$tz=3;
}
if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei4->tz&&$zhuangbei1->tz=$zhuangbei5->tz){$tz=4;
}
if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei4->tz&&$zhuangbei1->tz=$zhuangbei6->tz){$tz=4;
}
if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei4->tz&&$zhuangbei1->tz=$zhuangbei7->tz){$tz=4;
}

if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei4->tz&&$zhuangbei1->tz=$zhuangbei5->tz&&$zhuangbei1->tz=$zhuangbei6->tz){$tz=5;
}
if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei4->tz&&$zhuangbei1->tz=$zhuangbei5->tz&&$zhuangbei1->tz=$zhuangbei7->tz){$tz=5;
}
if($zhuangbei1->tz=$zhuangbei2->tz&&$zhuangbei1->tz=$zhuangbei3->tz&&$zhuangbei1->tz=$zhuangbei4->tz&&$zhuangbei1->tz=$zhuangbei5->tz&&$zhuangbei1->tz=$zhuangbei6->tz&&$zhuangbei1->tz=$zhuangbei7->tz){$tz=10;
}


if($tz=10){
	$gj = $ugj*2
}





?>