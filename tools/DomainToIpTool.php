<?php
class DomainToIpTool extends BaseTool {
    public static function getData($domain) {
        // Resolve the domain to its IP address
        $ip = gethostbyname($domain);

        if ($ip === $domain) {
            // Resolution failed
            return [
                "error" => true,
                "domain" => $domain,
                "message" => "Unable to resolve domain to an IP address."
            ];
        } else {
            // Successfully resolved to IP
            return [
                "error" => false,
                "domain" => $domain,
                "ip" => $ip
            ];
        }
    }
}
