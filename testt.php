<?php
$context = stream_context_create();
stream_context_set_option($context, 'ssl', 'allow_self_signed', false);
stream_context_set_option($context, 'ssl', 'verify_peer', false);
stream_context_set_option($context, 'ssl', 'verify_peer_name', false);
$fp = stream_socket_client("unix:///tmp/ssl.sock", $errno, $errstr, 30, STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_CONNECT, $context);

stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
