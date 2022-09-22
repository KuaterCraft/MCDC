<?php
declare(strict_types=1);

namespace KuaterCraft\MCDC;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\scheduler\TaskHandler;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;


class Main extends PluginBase implements Listener {

	public $attachment				= null;
	private $enabled				= true;
	private $discordWebHookURL		= "";
	private $discordWebHookName		= "";
	public $discordWebHookOptions	= array();
  private $task    = null;

	public function onLoad(): void {

	}

	public function onEnable(): void {
		$this->saveDefaultConfig();
		$this->reloadConfig();

		if($this->getConfig()->get("enabled")) {
			$this->initTasks();
		}
		
		if($this->enabled) {
			$this->sendToDiscord("-------MCDC enabled-------");
		}
	}
	
	
	public function onDisable(): void {
		$this->endTasks();
		$this->enabled = false;
	}
	

    public function onPlayerCommandPreprocess(PlayerCommandPreprocessEvent $event) {
        $player = $event->getPlayer();
        $message = $event->getMessage();

        $this->sendToDiscord("<".$player->getName()."> ".$message);
    }
	
	
    public function onJoin(PlayerJoinEvent $event)
    {
        if($this->getConfig()->get("show_player_events") !== false) {
            $player = $event->getPlayer();
            $this->sendToDiscord("<".$player->getName()."> joined the server");
        }
    }

    public function onQuit(PlayerQuitEvent $event)
    {
        if($this->getConfig()->get("show_player_events") !== false) {
            $player = $event->getPlayer();
            $this->sendToDiscord("<".$player->getName()."> left the server");
        }
    }


    public function initTasks() {
		$url = $this->getConfig()->get("discord_webhook_url", "");
		
    $prefixMatch = $this->getConfig()->get("discord_webhook_override", false);
    
    if(!$prefixMatch) {
      $prefix = "https://discordapp.com/api/webhooks/";
  		$prefixLength = strlen($prefix);
      if(substr($url, 0, $prefixLength) == $prefix && strlen($url) > $prefixLength) {
        $prefixMatch = true;
      }
    }
    
    if(!$prefixMatch) {
      $prefix = "https://discord.com/api/webhooks/";
  		$prefixLength = strlen($prefix);
      if(substr($url, 0, $prefixLength) == $prefix && strlen($url) > $prefixLength) {
        $prefixMatch = true;
      }
    }
    
		if($prefixMatch) {
			$this->discordWebHookURL = $url;
			$this->discordWebHookName = $this->getConfig()->get("discord_webhook_name", "MCDC");
      
      $this->discordWebHookOptions["enable_pings"] = ($this->getConfig()->get("enable_pings", true) === true);

			if($this->attachment == null) {
				$this->attachment = new Attachment();

				if($this->getConfig()->get("send_console") !== true) {
					$this->attachment->enable(false);
				}

				$this->getServer()->getLogger()->addAttachment($this->attachment);

                $mtime = intval($this->getConfig()->get("discord_webhook_refresh", 10)) * 20;
                $this->task = $this->getScheduler()->scheduleRepeatingTask(new Broadcast($this), $mtime);

                $this->getServer()->getPluginManager()->registerEvents($this, $this);

				$this->enabled = true;
				return true;
			}		
		} else {
			$this->getLogger()->error(TextFormat::WHITE . "Webhook URL doesn't look right in config.yml. Disabling plugin. Use discord_webhook_override=true in config.yml to override");
		}
		
		$this->endTasks();
		return false;
	}
	
	
	public function endTasks() {
		if($this->task != null) {
			$this->task->remove();
			$this->task = null;
		}

		if($this->attachment != null) {
			$this->getServer()->getLogger()->removeAttachment($this->attachment);
			$this->attachment = null;
		}
	}


	public function sendToDiscord(string $msg) {
		if($this->enabled && $this->attachment != null) {
			$this->attachment->appendStream($msg);
		}
	}


	public function getDiscordWebHookURL() {
		return $this->discordWebHookURL;
	}


	public function getDiscordWebHookName() {
		return $this->discordWebHookName;
	}

	public function getEnabled() {
        return $this->enabled;
    }

	public function backFromAsync($player, $result) {

	}
}
