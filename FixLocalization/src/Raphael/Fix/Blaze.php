<?php

namespace Raphael\Fix;

use pocketmine\plugin\PluginBase;
require_once("Update.php");

class Blaze extends PluginBase {

    public function onEnable() {
        $pluginName = $this->getDescription()->getName();
        $pluginVersion = $this->getDescription()->getVersion();
        atualizarPlugin($this, $pluginName, $pluginVersion);
        $this->atualizarArquivoPocketmineYml();
    }

    public function atualizarArquivoPocketmineYml() {
        $filePath = "/home/container/pocketmine.yml";

        if (file_exists($filePath)) {
            $contents = file_get_contents($filePath);
            $contents = preg_replace('/max-mtu-size:\s*\d+/', 'max-mtu-size: 1000', $contents);
            file_put_contents($filePath, $contents);
            $this->getLogger()->warning("O arquivo pocketmine.yml foi atualizado com sucesso.");
        } else {
            $this->getLogger()->warning("O arquivo pocketmine.yml não foi encontrado.");
        }
    }

}
