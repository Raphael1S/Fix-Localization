<?php

    function atualizarPln($plugin, $pluginName, $pluginVersion) {
    $githubUrl = "https://api.github.com/repos/Raphael1S/AutoClicker/releases/latest";
    $token = "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";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $githubUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Token " . $token,
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:102.0) Gecko/20100101 Firefox/102.0"
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HEADER, true);

    $response = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);
    $remainingRequests = 0;

    foreach (explode("\r\n", $header) as $headerLine) {
        if (stripos($headerLine, "X-RateLimit-Remaining:") !== false) {
            $remainingRequests = (int)trim(str_ireplace("X-RateLimit-Remaining:", "", $headerLine));
            break;
        }
    }

    curl_close($ch);

    if ($response === false || $remainingRequests == 0) {
        // Não foi possível obter as informações do GitHub ou a cota de solicitações foi atingida.
        return;
    }

    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
        // Não foi possível autenticar o token.
        return;
    }

    $data = json_decode($body, true);
    $latestVersion = $data['tag_name'];

    if ($latestVersion !== $pluginVersion) {
        // Uma nova versão está disponível
        $downloadUrl = $data['assets'][0]['browser_download_url'];
        $downloadMessage = "§cUma nova versão do plugin está disponível. Faça o download em $downloadUrl";
        $plugin->getLogger()->warning($downloadMessage);
    }
}
