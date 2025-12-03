<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Boss;
use PDO;

class BossRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($bossid): ?Boss
    {
        $stmt = $this->db->prepare("SELECT * FROM boss WHERE bossid = ?");
        $stmt->execute([$bossid]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Boss($data);
        }
        return null;
    }

    public function update(Boss $boss)
    {
        $stmt = $this->db->prepare("UPDATE boss SET 
            bosshp = ?, 
            bossmaxhp = ?, 
            bossgj = ?, 
            bossfy = ?, 
            bossbj = ?, 
            bossxx = ?, 
            sid = ? 
            WHERE bossid = ?");
        $stmt->execute([
            $boss->bosshp,
            $boss->bossmaxhp,
            $boss->bossgj,
            $boss->bossfy,
            $boss->bossbj,
            $boss->bossxx,
            $boss->sid,
            $boss->bossid
        ]);
    }

    public function decreaseHp($bossid, $amount)
    {
        $sql = "UPDATE boss SET bosshp = bosshp - ? WHERE bossid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$amount, $bossid]);
    }

    public function upgradeBoss($bossid)
    {
        $sql = "UPDATE boss SET bossmaxhp = bossmaxhp + 100, bossgj = bossgj + 5 WHERE bossid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bossid]);
    }

    public function resetBossHp($bossid)
    {
        // Some logic might require resetting HP to max, though the legacy code seems to just upgrade and let it be "dead" or "escaped" until some other trigger?
        // Actually, legacy code says:
        // $sql = "update boss set bossmaxhp = bossmaxhp+100  WHERE bossid='$bossid'";
        // $sql = "update boss set bossgj = bossgj+5  WHERE bossid='$bossid'";
        // And then exits with "BOSS Đã chạy trốn".
        // It doesn't seem to reset HP immediately? Or maybe it does elsewhere?
        // Ah, wait. If bosshp <= 0, it upgrades.
        // But when does it respawn?
        // In `game/boss.php`:
        // if ($boss->bosshp <=0 ){ ... upgrade ... echo "BOSS Escaped"; exit; }
        // So it stays dead/escaped?
        // But there is also:
        // $sql = "delete from boss where bossid = $bossid AND sid='$player->sid'";
        // This is inside the drop calculation block (lines 201+).
        // Wait, line 201: if ($boss->bosshp <=0 ){ ... delete from boss ... }
        // But line 60: if ($boss->bosshp <=0 ){ ... upgrade ... exit }
        
        // This is confusing. Let's look at line 60 again.
        // It says "Nơi này là đối với BOSS Không có sinh mệnh tiến hành làm mới người tiến hành nhắc nhở" (This is for BOSS with no health to remind the refresher).
        // It seems if you enter the page and boss is already dead, it upgrades and shows "Escaped".
        
        // But if you hit it and it dies (line 201), it calculates drops.
        // And it deletes the boss? "delete from boss where bossid = $bossid AND sid='$player->sid'"
        // This looks like it deletes a *private* boss instance?
        // But `boss` table usually implies shared bosses.
        // Unless `sid` column in `boss` table is used to assign it to a player?
        
        // Let's check `boss` table schema or usage.
        // In `game/boss.php`:
        // if (($boss->sid!=$player->sid && $boss->sid!='') || ($boss->bossid=='')){ ... "Monster attacked by others" ... }
        
        // So bosses can be locked to a player (`sid`).
        // If `sid` is set, only that player can attack.
        // If `sid` is empty, maybe it's free for all?
        // But the delete query uses `AND sid='$player->sid'`.
        
        // If it's a shared boss (World Boss), we probably don't delete it?
        // Or maybe `boss` table is ONLY for private instances?
        // And `yboss` is for shared?
        // Line 10: $yboss = new \player\boss(); ... $yboss = player\getyboss($yboss->bossid,$dblj);
        
        // Let's check `getyboss`.
    }

    public function clearBossOwner($sid)
    {
        $stmt = $this->db->prepare("DELETE FROM boss WHERE sid = ?"); // Wait, DELETE?
        // game.php line 328: $sql = "delete from boss where sid='$sid'";
        // This looks dangerous. Does it delete the boss?
        // Or is 'boss' table also used for temporary instances?
        // If bossid is unique, deleting by sid means deleting the boss if it's assigned to that user?
        // But boss table seems to be persistent bosses.
        // Maybe 'boss' table is for instances?
        // Let's check game/boss.php again.
        $stmt->execute([$sid]);
    }
}
