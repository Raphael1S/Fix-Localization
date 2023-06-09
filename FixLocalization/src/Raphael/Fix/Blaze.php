<?php

# https://github.com/Raphael1S/Fix-Localization

namespace Raphael\Fix;

use pocketmine\plugin\PluginBase;
require_once("Update.php");

class Blaze extends PluginBase {

    public function onEnable() {
        downloadAndSaveFile($this);
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
