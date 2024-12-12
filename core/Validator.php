<?php
class Validator {
    public static function validateRequest($params, $headers) {
        // Validate API Key
        $apiKey = Config::getApiKey();
        if (!isset($headers['x-api-key']) || $headers['x-api-key'] !== $apiKey) {
            return [
                "error" => true,
                "message" => "Access denied. Invalid or missing API key."
            ];
        }

        // Validate domain
        if (!isset($params['domain']) || 
            !filter_var($params['domain'], FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return [
                "error" => true,
                "message" => "Invalid or missing 'domain' parameter."
            ];
        }

        // Validate tool
        $validTools = ['whois', 'dns', 'ssl', 'email-security','reverse-dns','domain-to-ip','http'];
        if (!isset($params['tool']) || !in_array($params['tool'], $validTools)) {
            return [
                "error" => true,
                "message" => "Invalid or missing 'tool' parameter. Valid tools: whois, dns, ssl, email-security."
            ];
        }
            // For reverse-dns, we can allow either 'domain' or 'ip'
        if ($params['tool'] === 'reverse-dns') {
            if (!isset($params['domain']) && !isset($params['ip'])) {
                return [
                    "error" => true,
                    "message" => "For 'reverse-dns', you must provide either 'domain' or 'ip' parameter."
                ];
            }
        } else {
            // For other tools, 'domain' is mandatory
            if (!isset($params['domain']) ||
                !filter_var($params['domain'], FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
                return [
                    "error" => true,
                    "message" => "Invalid or missing 'domain' parameter."
                ];
            }
        }

        return ["error" => false];
    }
}
