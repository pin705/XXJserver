<?php

namespace XXJ\Models;

class Club
{
    public $clubid;
    public $clubname;
    public $clublv;
    public $clubexp;
    public $clubno1; // Leader UID
    public $clubinfo;
    public $clubyxb;
    public $clubczb;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
