<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\MonsterRepository;
use XXJ\Repositories\ItemRepository;

class MonsterController extends Controller
{
    private MonsterRepository $monsterRepo;
    private ItemRepository $itemRepo;

    public function __construct()
    {
        parent::__construct();
        $this->monsterRepo = new MonsterRepository();
        $this->itemRepo = new ItemRepository();
    }

    public function info()
    {
        $gid = $_GET['gid'] ?? 0;
        $gyid = $_GET['gyid'] ?? 0;
        $nowmid = $_GET['nowmid'] ?? 0;

        if ($nowmid != $this->player->nowmid) {
            $this->render('monster_info', [
                'error' => 'Mời bình thường chơi đùa！',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        $monster = $this->monsterRepo->findById($gid);
        $template = $this->monsterRepo->getTemplate($gyid);

        if (!$monster || !$template) {
             $this->render('monster_info', [
                'error' => 'Quái vật không tồn tại',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        if ($template->ginfo == '') {
            $template->ginfo = 'Không có bất kỳ cái gì danh khí';
        }

        if ($monster->sid != '' || $monster->gname == '') {
             $this->render('monster_info', [
                'error' => 'Quái vật đã bị những người khác công kích！<br/>Mời thiếu hiệp luyện tập một chút tốc độ tay a',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        // Process drops for display
        $drops = [];
        if ($template->gzb) {
            $ids = explode(',', $template->gzb);
            foreach ($ids as $id) {
                $item = $this->itemRepo->getEquipmentTemplate($id);
                if ($item) {
                    $drops[] = [
                        'type' => 'equip',
                        'name' => $item->zbname,
                        'color' => $item->zbys,
                        'cmd' => 'zbinfo_sys&zbid=' . $item->zbid . '&sid=' . $this->sid
                    ];
                }
            }
        }
        
        if ($template->gdj) {
             $ids = explode(',', $template->gdj);
             foreach ($ids as $id) {
                 $item = $this->itemRepo->getItemTemplate($id);
                 if ($item) {
                     $drops[] = [
                         'type' => 'item',
                         'name' => $item->djname,
                         'cmd' => 'djinfo&djid=' . $item->djid . '&sid=' . $this->sid
                     ];
                 }
             }
        }

        if ($template->gyp) {
             $ids = explode(',', $template->gyp);
             foreach ($ids as $id) {
                 $item = $this->itemRepo->getPotionTemplate($id);
                 if ($item) {
                     $drops[] = [
                         'type' => 'potion',
                         'name' => $item->ypname,
                         'cmd' => 'ypinfo&ypid=' . $item->ypid . '&sid=' . $this->sid
                     ];
                 }
             }
        }

        $this->render('monster_info', [
            'monster' => $monster,
            'template' => $template,
            'drops' => $drops,
            'pve_cmd' => 'pve&gid=' . $gid . '&sid=' . $this->sid . '&nowmid=' . $nowmid,
            'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
        ]);
    }
}
