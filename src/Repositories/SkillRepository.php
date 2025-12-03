<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use PDO;

class SkillRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getSkill($sid, $wgid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerwugong WHERE wgid = ? AND sid = ?");
        $stmt->execute([$wgid, $sid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function startCultivation($sid, $wgid, $cost, $currencyType)
    {
        try {
            $this->db->beginTransaction();

            // Deduct cost
            if ($currencyType === 1) {
                $stmt = $this->db->prepare("UPDATE game1 SET uyxb = uyxb - ? WHERE sid = ? AND uyxb >= ?");
            } else {
                $stmt = $this->db->prepare("UPDATE game1 SET uczb = uczb - ? WHERE sid = ? AND uczb >= ?");
            }
            $stmt->execute([$cost, $sid, $cost]);
            
            if ($stmt->rowCount() === 0) {
                $this->db->rollBack();
                return false;
            }

            // Update skill status
            $now = date('Y-m-d H:i:s');
            $stmt = $this->db->prepare("UPDATE playerwugong SET xlzt = 1, xlsj = ? WHERE wgid = ? AND sid = ?");
            $stmt->execute([$now, $wgid, $sid]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function endCultivation($sid, $wgid, $exp, $isLevelUp, $levelUpData = [])
    {
        try {
            $this->db->beginTransaction();

            // Reset status
            $stmt = $this->db->prepare("UPDATE playerwugong SET xlzt = 0 WHERE wgid = ? AND sid = ?");
            $stmt->execute([$wgid, $sid]);

            if ($isLevelUp) {
                // Level up logic
                $stmt = $this->db->prepare("
                    UPDATE playerwugong SET 
                        wgxl = ?, 
                        wgdj = wgdj + 1, 
                        wgxlmax = wgxlmax + ?, 
                        wgsum = wgsum - 1 
                    WHERE wgid = ? AND sid = ?
                ");
                $stmt->execute([$levelUpData['new_exp'], $levelUpData['max_exp_increase'], $wgid, $sid]);
            } else {
                // Normal exp gain
                $stmt = $this->db->prepare("
                    UPDATE playerwugong SET 
                        wgxl = wgxl + ?, 
                        wgsum = wgsum - 1 
                    WHERE wgid = ? AND sid = ?
                ");
                $stmt->execute([$exp, $wgid, $sid]);
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getPlayerSkills($sid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerwugong WHERE sid = ?");
        $stmt->execute([$sid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
