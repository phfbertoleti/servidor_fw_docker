<?php
// Verifica se os parâmetros foram passados na URL
if (isset($_GET['projeto']) && isset($_GET['target']) && isset($_GET['versao'])) {
    
    // Recupera os valores dos parâmetros passados no PHP
    $projeto = htmlspecialchars($_GET['projeto']);
    $target = htmlspecialchars($_GET['target']);
    $versao = htmlspecialchars($_GET['versao']);
    
    // Monta o caminho completo para o arquivo solicitado
    $caminho_arquivo = "/var/www/html/arquivos_firmware/" . $projeto . "/" . $target . "/" . $versao;
    
    // Verifica se o diretório existe e contém arquivos
    if (is_dir($caminho_arquivo) && ($arquivos = scandir($caminho_arquivo)) !== false) {
        
        // Remover os itens '.' e '..' da lista de arquivos
        $arquivos = array_diff($arquivos, array('.', '..'));

        // Se houver arquivos no diretório, retorna o primeiro arquivo encontrado
        if (count($arquivos) > 0) {
            $arquivo = reset($arquivos); // Pega o primeiro arquivo da lista
            $caminho_completo = $caminho_arquivo . "/" . $arquivo;
            
            // Retorna o arquivo para download
            if (file_exists($caminho_completo)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($caminho_completo).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($caminho_completo));
                readfile($caminho_completo);
                exit;
            }
        }
    }

    // Se não houver arquivos, ou o diretório não existir, retorna "FW_NOT_FOUND"
    echo "FW_NOT_FOUND";
    
} else {
    echo "Parâmetros insuficientes na URL";
}
?>
