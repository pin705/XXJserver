<?php

namespace XXJ\Models;

class Map
{
    public $mid;
    public $mname;
    public $mgid;
    public $midboss;
    public $mqy;
    public $upmid;
    public $downmid;
    public $leftmid;
    public $rightmid;
    public $playerinfo;
    public $ispvp;
    public $midinfo;
    public $mgtime;
    public $ms;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
