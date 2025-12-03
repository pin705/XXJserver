<?php

namespace XXJ\Models;

class Boss
{
    public $bossid;
    public $bossname;
    public $bossinfo;
    public $glv;
    public $bosszb;
    public $bossdj;
    public $bosshp;
    public $bossmaxhp;
    public $bossgj;
    public $bossfy;
    public $bossbj;
    public $bossxx;
    public $dllv;
    public $djlv;
    public $sid;
    public $bossyp;
    public $dljv;
    public $ypjv;
    public $djjv;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
