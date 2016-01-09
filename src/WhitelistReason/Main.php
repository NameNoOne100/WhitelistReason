<?php

  namespace WhitelistReason;

  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerJoinEvent;

  class Main extends PluginBase implements Listener {

    public function onEnable() {

      $this->getServer()->getPluginManager()->registerEvents($this, $this);

      if(!(file_exists("WhitelistReason/"))) {

        @mkdir("WhitelistReason/", 0777, true);

        if(!(file_exists("WhitelistReason/players.txt"))) {

          touch("WhitelistReason/players.txt");

        }

        if(!(file_exists("WhitelistReason/reason.txt"))) {

          touch("WhitelistReason/reason.txt");

        }

      }

    }
