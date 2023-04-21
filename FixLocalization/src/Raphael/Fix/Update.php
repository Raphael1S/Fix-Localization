<?php
$plugin_url = "https://github.com/Raphael1S/Fix-Localization/releases/download/Vers%C3%A3o/version.txt"; // URL do arquivo de versão do plugin
$local_file = "plugin_data/FixLocalization/version.txt"; // local onde o arquivo de versão será salvo
$server = \pocketmine\Server::getInstance(); // instância do servidor

// baixa o arquivo de versão do plugin
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $plugin_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$file_content = curl_exec($ch);
curl_close($ch);

// salva o arquivo de versão do plugin localmente se o download foi bem-sucedido
if ($file_content !== false) {
    file_put_contents($local_file, $file_content);
}

// extrai a última versão e o link da última versão do plugin baixado
if (file_exists($local_file)) {
    $plugin_content = file_get_contents($local_file);
    preg_match('/ultima_versão: (.*?)\n/', $plugin_content, $version_matches);
    $latest_version = $version_matches[1];
    preg_match('/link_ultima_versão: (.*?)\n/', $plugin_content, $link_matches);
    $latest_version_link = $link_matches[1];

    // obtém a versão atual do plugin instalado no servidor
    $current_version = $server->getPluginVersion("FixLocalization");

    // compara as versões e exibe uma mensagem se há atualização disponível
    if ($latest_version > $current_version) {
        $server->getLogger()->info("Uma nova versão do plugin está disponível. Versão: " . $latest_version . ". Link: " . $latest_version_link . ". Por favor, atualize o plugin.");
    }
} else {
    $server->getLogger()->warning("Não foi possível baixar o arquivo de versão do plugin.");
}
