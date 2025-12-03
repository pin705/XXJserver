<?php

namespace XXJ\Models;

class Monster
{
    public $id;
    public $gname;
    public $ginfo;
    public $gsex;
    public $glv;
    public $gexp;
    public $ghp;
    public $gmaxhp;
    public $ggj;
    public $gfy;
    public $gbj;
    public $gxx;
    public $gyid;
    public $sid; // Session ID of player attacking it
    public $mid; // Map ID

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
