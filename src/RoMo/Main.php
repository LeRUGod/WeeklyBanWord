<?php

/*
██████╗░░█████╗░███╗░░░███╗░█████╗░░█████╗░███████╗███████╗██╗░█████╗░██╗░█████╗░██╗░░░░░
██╔══██╗██╔══██╗████╗░████║██╔══██╗██╔══██╗██╔════╝██╔════╝██║██╔══██╗██║██╔══██╗██║░░░░░
██████╔╝██║░░██║██╔████╔██║██║░░██║██║░░██║█████╗░░█████╗░░██║██║░░╚═╝██║███████║██║░░░░░
██╔══██╗██║░░██║██║╚██╔╝██║██║░░██║██║░░██║██╔══╝░░██╔══╝░░██║██║░░██╗██║██╔══██║██║░░░░░
██║░░██║╚█████╔╝██║░╚═╝░██║╚█████╔╝╚█████╔╝██║░░░░░██║░░░░░██║╚█████╔╝██║██║░░██║███████╗
╚═╝░░╚═╝░╚════╝░╚═╝░░░░░╚═╝░╚════╝░░╚════╝░╚═╝░░░░░╚═╝░░░░░╚═╝░╚════╝░╚═╝╚═╝░░╚═╝╚══════╝
Made by RoMo_Official
My github : https://github.com/bluefirewolf534
My music : https://www.youtube.com/channel/UC68NMSCaZLD2xd6gK1-IYFA
*/

namespace RoMo;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener{
	public function onEnable(){
		@mkdir($this->getDataFolder());
		$this->con = new Config($this->getDataFolder(). "config.yml", Config::YAML, ["word" => ["로모"]]);
		$this->conall = $this->con->getAll();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
		if($command->getName() == "금지어변경"){
			if(empty($args[0])){
				$sender->sendMessage("똑바로 입력해주세요");
				return true;
			}

			else{
			$this->conall["word"][0] = $args[0];
			$this->saveConfig();
			$sender->sendMessage("금지어를 $args[0]로 변경했습니다");
			return true;
			}
		}
		return false;
	}


	public function chat(PlayerChatEvent $event){
		$chat = $event->getMessage();
		$player = $event->getPlayer();
		$name = $player->getName();
		if($this->conall["word"][0] === $chat){
			$event->setCancelled();
			$player->kick("이번주 금지어에 걸리셨습니다! 금지어 : " . $this->conall["word"][0]);
			$this->getServer()->broadcastMessage($name . "님이 이번주 §c금지어§f에 §6걸리셨습니다!");
		}
	}
}
