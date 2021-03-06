<?php

  namespace WhitelistReason;

  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerJoinEvent;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\command\ComamndExecutor;

  class Main extends PluginBase implements Listener {

    public function onEnable() {

      $this->getServer()->getPluginManager()->registerEvents($this, $this);

      if(!(file_exists("WhitelistReason/"))) {

        @mkdir("WhitelistReason/", 0777, true);

        if(!(file_exists("WhitelistReason/players.txt"))) {

          touch("WhitelistReason/players.txt");
          file_put_contents("WhitelistReason/players.txt", "players, ");

        }

        if(!(file_exists("WhitelistReason/reason.txt"))) {

          touch("WhitelistReason/reason.txt");

        }

        if(!(file_exists("WhitelistReason/whitelist.txt"))) {

          touch("WhitelistReason/whitelist.txt");

        }

      }

    }

    public function onJoin(PlayerJoinEvent $event) {

      $player = $event->getPlayer();
      $player_name = $player->getName();
      $whitelist = file_get_contents("WhitelistReason/whitelist.txt");
      $players = file_get_contents("WhitelistReason/players.txt");
      $reason = file_get_contents("WhitelistReason/reason.txt");

      if($whitelist == "true") {

        $player_isWhitelisted = strpos($players, $player_name);

        if($player_isWhitelisted === false) {

          $player->kick($reason);

        }

      }

    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {

      if($cmd->getName() === "reason") {

        if(!(isset($args[0]))) {

          $sender->sendMessage(TF::RED . "Error: not enough args.");

        } else {

          $reason = implode(" ", $args);
          $replace = str_replace(file_get_contents("WhitelistReason/reason.txt"), $reason, file_get_contents("WhitelistReason/reason.txt"));
          $sender->sendMessage(TF::GREEN . "Successfully updated reason!");
          file_put_contents("WhitelistReason/reason.txt", $replace);

        }

      }

      if($cmd->getName() === "wr") {

        if(!(isset($args[0]))) {

          $sender->sendMessage(TF::RED . "Error: not enough args.");

        } else {

          if(strtolower($args[0]) == "true") {

           $replace = str_replace(file_get_contents("WhitelistReason/whitelist.txt"), "true", file_get_contents("WhitelistReason/whitelist.txt"));
            $sender->sendMessage(TF::GREEN . "Successfully updated whitelist, please restart server.");
            file_put_contents("WhitelistReason/whitelist.txt", $replace);

          } else if(strtolower($args[0]) == "false") {

            $replace = str_replace(file_get_contents("WhitelistReason/whitelist.txt"), "false", file_get_contents("WhitelistReason/whitelist.txt"));
            $sender->sendMessage(TF::GREEN . "Successfully updated whitelist, please restart server.");
            file_put_contents("WhitelistReason/whitelist.txt", $replace);

          }

        }

      }

      if($cmd->getName() == "add") {

        if(!(isset($args[0]))) {

          $sender->sendMessage(TF::RED . "Error: not enough args.");

        } else {

          $file = file_get_contents("WhitelistReason/players.txt");
          $player = args[0];
          file_put_contents($file, $player . ", ", FILE_APPEND);
          $sender->sendMessage(TF::GREEN . "Successfully added new player!");

        }

      }

    }

  }

?>
