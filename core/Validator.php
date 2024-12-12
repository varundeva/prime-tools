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
        $validTools = ['whois', 'dns', 'ssl', 'email-security'];
        if (!isset($params['tool']) || !in_array($params['tool'], $validTools)) {
            return [
                "error" => true,
                "message" => "Invalid or missing 'tool' parameter. Valid tools: whois, dns, ssl, email-security."
            ];
        }

        return ["error" => false];
    }
}
