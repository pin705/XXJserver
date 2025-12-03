<?php

namespace XXJ\Core;

use XXJ\Repositories\PlayerRepository;
use XXJ\Utils\Encoder;

class Controller
{
    protected $player;
    protected $sid;
    protected $encoder;
    protected $playerRepo;

    public function __construct()
    {
        $this->encoder = new Encoder();
        $this->playerRepo = new PlayerRepository();
        
        // Auto-load player if sid is present
        if (isset($_GET['sid'])) {
            $this->sid = $_GET['sid'];
            $this->player = $this->playerRepo->findBySid($this->sid);
        }
    }

    protected function render($view, $data = [])
    {
        // Inject common variables
        if (!isset($data['player']) && $this->player) {
            $data['player'] = $this->player;
        }
        if (!isset($data['sid']) && $this->sid) {
            $data['sid'] = $this->sid;
        }
        if (!isset($data['encoder'])) {
            $data['encoder'] = $this->encoder;
            $data['encode'] = $this->encoder; // Alias for legacy templates
        }

        View::render($view, $data);
    }

    protected function redirect($cmd, $params = [])
    {
        $queryString = "cmd=$cmd";
        if ($this->sid) {
            $queryString .= "&sid={$this->sid}";
        }
        foreach ($params as $key => $value) {
            $queryString .= "&$key=$value";
        }
        
        $encoded = $this->encoder->encode($queryString);
        header("Location: ?cmd=$encoded");
        exit;
    }
}
