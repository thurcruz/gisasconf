<?php
function log_acesso_arquivo($user_id, $action) {
    $file = 'acessos.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = sprintf("[%s] User ID: %d - Action: %s\n", $timestamp, $user_id, $action);
    file_put_contents($file, $log_entry, FILE_APPEND | LOCK_EX);
}

function log_acesso_db($conn, $user_id, $action) {
    // Captura o IP real
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    $sql = "INSERT INTO logs_acessos (usuario_id, acao, timestamp_acesso, ip_acesso)
            VALUES (?, ?, NOW(), ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $action, $ip);
    $stmt->execute();
}
?>
