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

    public function getAllSkills($sid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerwugong WHERE sid = ?");
        $stmt->execute([$sid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSkill($sid, $skillId)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerwugong WHERE wgid = ? AND sid = ?");
        $stmt->execute([$skillId, $sid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getSkillTemplate($skillId)
    {
        $stmt = $this->db->prepare("SELECT * FROM wugong WHERE wgid = ?");
        $stmt->execute([$skillId]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function drawSkill($sid, $uid, $isVip)
    {
        // Logic from cqwg in player.php
        // Random skill ID. 1-3 for normal, 1-10 for VIP.
        $maxId = $isVip ? 10 : 3;
        $skillId = mt_rand(1, $maxId);

        $existingSkill = $this->getSkill($sid, $skillId);

        if ($existingSkill) {
            $stmt = $this->db->prepare("UPDATE playerwugong SET wgsum = wgsum + 1 WHERE wgid = ? AND sid = ?");
            $stmt->execute([$skillId, $sid]);
            return ['type' => 'duplicate', 'skill' => $existingSkill];
        } else {
            $template = $this->getSkillTemplate($skillId);
            if ($template) {
                $stmt = $this->db->prepare("
                    INSERT INTO playerwugong (wgname, wgid, wginfo, wgys, sid, uid, wglx, wgsum, wgdj, wgxl, wgxlmax, xlzt, xlsj) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 1, 0, 0, 100, 0, 0)
                ");
                
                $stmt->execute([
                    $template->wgname,
                    $template->wgid,
                    $template->wginfo,
                    $template->wgys,
                    $sid,
                    $uid,
                    $template->wglx
                ]);
                return ['type' => 'new', 'skill' => $template];
            }
        }
        return false;
    }

    public function deleteSkill($sid, $skillId)
    {
        $skill = $this->getSkill($sid, $skillId);
        if (!$skill) return false;

        if ($skill->wgsum > 1) {
            $stmt = $this->db->prepare("UPDATE playerwugong SET wgsum = wgsum - 1 WHERE wgid = ? AND sid = ?");
            $stmt->execute([$skillId, $sid]);
        } else {
            $stmt = $this->db->prepare("DELETE FROM playerwugong WHERE wgid = ? AND sid = ?");
            $stmt->execute([$skillId, $sid]);
        }
        return true;
    }

    public function learnSkill($sid, $skillId)
    {
        $stmt = $this->db->prepare("UPDATE game1 SET wugong = ? WHERE sid = ?");
        $stmt->execute([$skillId, $sid]);
    }

    public function unlearnSkill($sid)
    {
        $stmt = $this->db->prepare("UPDATE game1 SET wugong = 0 WHERE sid = ?");
        $stmt->execute([$sid]);
    }

    public function startTraining($sid, $skillId)
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("UPDATE playerwugong SET xlzt = 1, xlsjc = ? WHERE wgid = ? AND sid = ?");
        $stmt->execute([$now, $skillId, $sid]);
    }

    public function endTraining($sid, $skillId, $minutes, $consumedBooks)
    {
        $skill = $this->getSkill($sid, $skillId);
        if (!$skill || $skill->xlzt != 1) return false;

        $expGain = round($minutes * 0.8);
        if ($expGain < 1) $expGain = 1;

        $newExp = $skill->wgxl + $expGain;
        $maxExp = $skill->wgxlmax;
        $level = $skill->wgdj;

        if ($newExp >= $maxExp) {
            // Level up
            $stmt = $this->db->prepare("
                UPDATE playerwugong 
                SET wgdj = wgdj + 1, 
                    wgxl = 0, 
                    wgxlmax = wgxlmax * 2, 
                    xlzt = 0,
                    wgsum = wgsum - ?
                WHERE wgid = ? AND sid = ?
            ");
            $stmt->execute([$consumedBooks, $skillId, $sid]);
            return ['leveled_up' => true, 'exp_gain' => $expGain, 'new_level' => $level + 1];
        } else {
            // Just add exp
            $stmt = $this->db->prepare("
                UPDATE playerwugong 
                SET wgxl = wgxl + ?, 
                    xlzt = 0,
                    wgsum = wgsum - ?
                WHERE wgid = ? AND sid = ?
            ");
            $stmt->execute([$expGain, $consumedBooks, $skillId, $sid]);
            return ['leveled_up' => false, 'exp_gain' => $expGain];
        }
    }
}
