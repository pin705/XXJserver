<?php

namespace XXJ\Models;

class Task
{
    public $rwid;
    public $rwname;
    public $rwzl; // Type: 1=Collect, 2=Kill, 3=Dialogue
    public $rwdj; // Items required/reward
    public $rwzb; // Equipment
    public $rwexp;
    public $rwyxb;
    public $rwyq; // Requirement (NPC/Monster ID/Item ID)
    public $rwcount; // Count or Target ID
    public $rwlx; // 1=Normal, 2=Daily, 3=Main
    public $rwinfo;
    public $rwqy; // Region/Map ID for teleport
    public $rwyp; // Potions reward

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
