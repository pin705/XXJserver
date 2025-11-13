<?php
/**
 * File helper functions cho club (bang hội)
 * 
 * Chứa các hàm tiện ích để làm việc với đối tượng club,
 * bao gồm truy vấn database, quản lý club, v.v.
 * 
 * @package TuTaTuTien\Helpers
 */

namespace TuTaTuTien\Helpers;

/**
 * Lấy thông tin club từ database theo ID
 * 
 * @param int $idClub ID club
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return \stdClass|null Đối tượng club hoặc null nếu không tìm thấy
 */
function layThongTinClub($idClub, $ketNoiDB)
{
    $sql = "SELECT * FROM `club` WHERE clubid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idClub]);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    $club = new \stdClass();
    $club->clubname = $result['clubname'] ?? '';
    $club->clubinfo = $result['clubinfo'] ?? '';
    $club->clublv = $result['clublv'] ?? 0;
    $club->clubexp = $result['clubexp'] ?? 0;
    $club->clubid = $result['clubid'] ?? 0;
    $club->clubno1 = $result['clubno1'] ?? 0;
    $club->clubyxb = $result['clubyxb'] ?? 0;
    $club->clubczb = $result['clubczb'] ?? 0;
    
    return $club;
}

/**
 * Lấy tất cả club
 * 
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return array Mảng các club
 */
function layTatCaClub($ketNoiDB)
{
    $sql = "SELECT * FROM `club`";
    $stmt = $ketNoiDB->query($sql);
    
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Lấy thông tin club player (thành viên club)
 * 
 * @param string $idPhien Session ID của người chơi
 * @param \PDO $ketNoiDB Đối tượng kết nối PDO database
 * @return \stdClass|null Đối tượng clubplayer hoặc null nếu không tìm thấy
 */
function layThongTinClubPlayer($idPhien, $ketNoiDB)
{
    $sql = "SELECT * FROM `clubplayer` WHERE sid = ?";
    $stmt = $ketNoiDB->prepare($sql);
    $stmt->execute([$idPhien]);
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$result) {
        return null;
    }
    
    $clubPlayer = new \stdClass();
    $clubPlayer->clubid = $result['clubid'] ?? 0;
    $clubPlayer->uid = $result['uid'] ?? 0;
    $clubPlayer->sid = $result['sid'] ?? '';
    $clubPlayer->uclv = $result['uclv'] ?? 0;
    
    return $clubPlayer;
}
