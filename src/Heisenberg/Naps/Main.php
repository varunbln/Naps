<?php

declare(strict_types=1);

namespace Heisenberg\Naps;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerBedEnterEvent;
use pocketmine\event\player\PlayerBedLeaveEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    /* @var Config*/
    public $config;

    public function onLoad(){
        @mkdir($this->getDataFolder());
    }

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML, ["Sleep" => "{player} has gone to bed", "Awake" => "{player} has woken up"]);
	}

	public function onSleep(PlayerBedEnterEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if(!$player->hasPermission("naps.silence")) {
            $message = $this->config->get("Sleep");
            $msg = str_replace("{player}", $name, $message);
            $this->getServer()->broadcastMessage($msg);
        }
    }

    public function onAwake(PlayerBedLeaveEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if(!$player->hasPermission("naps.silence")) {
            $message = $this->config->get("Awake");
            $msg = str_replace("{player}", $name, $message);
            $this->getServer()->broadcastMessage($msg);
        }
    }

}
