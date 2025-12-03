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

    public function upgradeBoss($bossid)
    {
        // Logic from game/boss.php: bossmaxhp+100, bossgj+5
        $stmt = $this->db->prepare("UPDATE boss SET bossmaxhp = bossmaxhp + 100, bossgj = bossgj + 5, bosshp = bossmaxhp + 100 WHERE bossid = ?");
        $stmt->execute([$bossid]);
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
