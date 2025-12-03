<?php

namespace XXJ\Models;

class ClubMember
{
    public $clubid;
    public $uid;
    public $sid;
    public $uclv; // 1: Leader, 2: Vice, 3: Elder, 4: Deacon, 5: Elite, 6: Disciple

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getRankName()
    {
        $ranks = [
            1 => 'Chưởng môn',
            2 => 'Phó chưởng môn',
            3 => 'Trưởng lão',
            4 => 'Chấp sự',
            5 => 'Tinh anh',
            6 => 'Đệ tử'
        ];
        return $ranks[$this->uclv] ?? 'Đệ tử';
    }
}
