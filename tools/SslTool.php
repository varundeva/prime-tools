<?php
class SslTool extends BaseTool {
    public static function getData($domain, $port = 443) {
        $streamContext = stream_context_create([
            "ssl" => [
                "capture_peer_cert" => true,
                "verify_peer" => false,
                "verify_peer_name" => false
            ]
        ]);

        $client = @stream_socket_client("ssl://{$domain}:{$port}", $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $streamContext);
        if (!$client) {
            return [
                "error" => true,
                "message" => "Unable to connect to {$domain} on port {$port}: {$errstr}"
            ];
        }

        $options = stream_context_get_options($streamContext);
        if (!isset($options["ssl"]["peer_certificate"])) {
            return [
                "error" => true,
                "message" => "No certificate found for {$domain}"
            ];
        }

        $certificate = openssl_x509_parse($options["ssl"]["peer_certificate"]);
        if ($certificate === false) {
            return [
                "error" => true,
                "message" => "Unable to parse certificate for {$domain}"
            ];
        }

        return [
            "error" => false,
            "domain" => $domain,
            "data" => [
                "issuer" => $certificate["issuer"] ?? [],
                "subject" => $certificate["subject"] ?? [],
                "validFrom" => date("Y-m-d H:i:s", $certificate["validFrom_time_t"] ?? 0),
                "validTo" => date("Y-m-d H:i:s", $certificate["validTo_time_t"] ?? 0),
                "serialNumber" => $certificate["serialNumber"] ?? "",
                "signatureAlgorithm" => $certificate["signatureTypeSN"] ?? "",
                "extensions" => $certificate["extensions"] ?? []
            ]
        ];
    }
}
