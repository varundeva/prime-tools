<?php
class ReverseDnsTool extends BaseTool {
    public static function getData($params) {
        // Check if ip is provided directly
        if (isset($params['ip'])) {
            $ip = $params['ip'];
            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                return [
                    "error" => true,
                    "message" => "Invalid IP address."
                ];
            }
            return self::performReverseDns($ip);

        } elseif (isset($params['domain'])) {
            $domain = $params['domain'];

            // Resolve domain to IP
            $ip = gethostbyname($domain);
            if ($ip === $domain) {
                return [
                    "error" => true,
                    "message" => "Unable to resolve domain to IP."
                ];
            }
            return self::performReverseDns($ip);
        } else {
            return [
                "error" => true,
                "message" => "No 'domain' or 'ip' parameter found."
            ];
        }
    }

    private static function performReverseDns($ip) {
        $hostname = gethostbyaddr($ip);
        if ($hostname === $ip) {
            // No PTR record or reverse DNS entry found
            return [
                "error" => false,
                "ip" => $ip,
                "reverseDns" => null,
                "message" => "No reverse DNS record found."
            ];
        } else {
            return [
                "error" => false,
                "ip" => $ip,
                "reverseDns" => $hostname
            ];
        }
    }
}
