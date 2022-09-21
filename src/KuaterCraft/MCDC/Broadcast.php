<?php
namespace KuaterCraft\MCDC;

use pocketmine\scheduler\Task;

class Broadcast extends Task {

    private $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onRun(): void {
        if($this->main->getEnabled() && $this->main->attachment != null) {
            $stream = $this->main->attachment->clearStream();
            $this->sendToDiscord($stream, $this->main->discordWebHookOptions);
        }
    }

    public function sendToDiscord(string $msg = "", array $options = []) {
        $curlopts = [
            "content"    => $msg,
            "username"	=> $this->main->getDiscordWebHookName()
        ];
        $this->main->getServer()->getAsyncPool()->submitTask(new SendAsync($this->main->getDiscordWebHookURL(), serialize($curlopts)));
    }
}
