<?php

namespace XXJ\Models;

class Pet
{
    public $cwid;
    public $cwname;
    public $cwlv;
    public $cwexp;
    public $cwmaxexp;
    public $cwhp;
    public $cwmaxhp;
    public $cwgj;
    public $cwfy;
    public $cwbj;
    public $cwxx;
    public $uphp;
    public $upgj;
    public $upfy;
    public $cwpz;
    public $sid;
    public $tool1;
    public $tool2;
    public $tool3;
    public $tool4;
    public $tool5;
    public $tool6;
    public $tool7;

    // Calculated stats
    public $total_gj;
    public $total_fy;
    public $total_hp;
    public $total_bj;
    public $total_xx;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        
        // Initialize calculated stats with base stats
        $this->total_gj = $this->cwgj;
        $this->total_fy = $this->cwfy;
        $this->total_hp = $this->cwmaxhp;
        $this->total_bj = $this->cwbj;
        $this->total_xx = $this->cwxx;
        
        $this->calculateMaxExp();
    }

    public function calculateMaxExp()
    {
        $rangeslv = array(0, 30, 50, 70, 80, 90, 100, 110);
        $rangesexp = array(2, 4, 6, 9, 12.5, 15, 17.5);
        
        for ($i = 0; $i < count($rangeslv) - 1; $i++) {
            if ($this->cwlv >= $rangeslv[$i] && $this->cwlv < $rangeslv[$i+1]) {
                $cwnextlv = $this->cwlv + 1;
                $this->cwmaxexp = $cwnextlv * ($cwnextlv + round($cwnextlv/2)) * 50 * $rangesexp[$i] + $cwnextlv;
                break;
            }
        }
        // Fallback if not set (e.g. level > 110 or < 0)
        if (!$this->cwmaxexp) {
            $this->cwmaxexp = 999999999;
        }
    }
    
    public function getQualityName()
    {
        $pz = array('Phổ thông', 'Ưu tú', 'Trác tuyệt', 'Phi phàm', 'Hoàn mỹ', 'Nghịch thiên');
        return $pz[$this->cwpz] ?? 'Không xác định';
    }
    
    public function getQualityColor()
    {
        $sc = array('#00C000', '#1a80da', '#a08f0a', '#14b8b9', '#f16613', '#ec0909');
        return $sc[$this->cwpz] ?? '#000000';
    }
}
