<?php

namespace XXJ\Models;

class Item
{
    public $zbnowid;
    public $zbname;
    public $zbinfo;
    public $zblv;
    public $zbgj;
    public $zbfy;
    public $zbbj;
    public $zbxx;
    public $zbhp;
    public $zbys;
    public $qianghua;
    public $uid;
    public $sid;
    public $tool;
    public $zbid;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
