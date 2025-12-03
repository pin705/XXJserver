<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Club;
use XXJ\Models\ClubMember;
use PDO;

class ClubRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findClubById($clubid): ?Club
    {
        $stmt = $this->db->prepare("SELECT * FROM club WHERE clubid = ?");
        $stmt->execute([$clubid]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Club($data);
        }
        return null;
    }

    public function findMemberBySid($sid): ?ClubMember
    {
        $stmt = $this->db->prepare("SELECT * FROM clubplayer WHERE sid = ?");
        $stmt->execute([$sid]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new ClubMember($data);
        }
        return null;
    }

    public function getAllClubs(): array
    {
        $stmt = $this->db->query("SELECT * FROM club ORDER BY clublv DESC, clubexp DESC");
        $clubs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clubs[] = new Club($row);
        }
        return $clubs;
    }

    public function getMembers($clubid): array
    {
        // Join with game1 to get player names
        $sql = "SELECT cp.*, g.uname, g.ulv, g.ugj, g.ufy 
                FROM clubplayer cp 
                JOIN game1 g ON cp.uid = g.uid 
                WHERE cp.clubid = ? 
                ORDER BY cp.uclv ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$clubid]);
        
        $members = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // We can return an array or a richer object. 
            // For now, let's return an array with extra player info
            $member = new ClubMember($row);
            // Attach extra info dynamically
            $member->uname = $row['uname'];
            $member->ulv = $row['ulv'];
            $member->ugj = $row['ugj'];
            $member->ufy = $row['ufy'];
            $members[] = $member;
        }
        return $members;
    }

    public function createClub($clubname, $leaderUid, $leaderSid)
    {
        // Start transaction
        $this->db->beginTransaction();
        try {
            // Insert Club
            $stmt = $this->db->prepare("INSERT INTO club (clubname, clublv, clubexp, clubno1, clubinfo, clubyxb, clubczb) VALUES (?, 1, 0, ?, 'Chưa có thông báo', 0, 0)");
            $stmt->execute([$clubname, $leaderUid]);
            $clubid = $this->db->lastInsertId();

            // Insert Leader as Member (Rank 1)
            $stmt = $this->db->prepare("INSERT INTO clubplayer (clubid, uid, sid, uclv) VALUES (?, ?, ?, 1)");
            $stmt->execute([$clubid, $leaderUid, $leaderSid]);

            $this->db->commit();
            return $clubid;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function joinClub($clubid, $uid, $sid)
    {
        $stmt = $this->db->prepare("INSERT INTO clubplayer (clubid, uid, sid, uclv) VALUES (?, ?, ?, 6)");
        return $stmt->execute([$clubid, $uid, $sid]);
    }

    public function leaveClub($sid)
    {
        $stmt = $this->db->prepare("DELETE FROM clubplayer WHERE sid = ?");
        return $stmt->execute([$sid]);
    }

    public function deleteClub($clubid)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("DELETE FROM club WHERE clubid = ?");
            $stmt->execute([$clubid]);

            $stmt = $this->db->prepare("DELETE FROM clubplayer WHERE clubid = ?");
            $stmt->execute([$clubid]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updateMemberRank($clubid, $uid, $newRank)
    {
        $stmt = $this->db->prepare("UPDATE clubplayer SET uclv = ? WHERE clubid = ? AND uid = ?");
        return $stmt->execute([$newRank, $clubid, $uid]);
    }
    
    public function updateClubInfo($clubid, $info)
    {
        $stmt = $this->db->prepare("UPDATE club SET clubinfo = ? WHERE clubid = ?");
        return $stmt->execute([$info, $clubid]);
    }
}
