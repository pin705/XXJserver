<?php

namespace XXJ\Models;

class Task
{
    public $id;
    public $rwname;
    public $rwzl; // Type
    public $rwdj; // Items required/reward
    public $rwzb; // Equipment
    public $rwexp;
    public $rwyxb;
    public $rwyq; // Requirement (NPC/Monster ID)
    public $rwcount;
    public $rwlx; // Daily/Main
    public $rwinfo;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
