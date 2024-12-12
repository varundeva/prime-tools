<?php
class WhoisTool extends BaseTool {
    public static function getData($domain) {
        $whoisServer = self::getWhoisServer($domain);
        $connection = @fsockopen($whoisServer, 43, $errno, $errstr, 10);

        if (!$connection) {
            return [
                "error" => true,
                "message" => "Unable to connect to WHOIS server ($whoisServer)"
            ];
        }

        fwrite($connection, $domain . "\r\n");
        $response = stream_get_contents($connection);
        fclose($connection);

        $parsed = self::parseWhoisData($response);

        return [
            "error" => false,
            "domain" => $domain,
            "whoisServer" => $whoisServer,
            "data" => $parsed['parsedData'],
            "rawData" => $parsed['rawData']
        ];
    }

    private static function getWhoisServer($domain) {
        $tld = substr(strrchr($domain, "."), 1);
        $whoisServers = [
            "com" => "whois.verisign-grs.com",
            "net" => "whois.verisign-grs.com",
            "org" => "whois.pir.org",
            "info" => "whois.afilias.net",
            "biz" => "whois.neulevel.biz",
            "io" => "whois.nic.io",
            "uk" => "whois.nic.uk",
            "de" => "whois.denic.de",
            "fr" => "whois.nic.fr",
            "eu" => "whois.eu",
            "in" => "whois.registry.in",
            "us" => "whois.nic.us",
            "ca" => "whois.cira.ca",
            "au" => "whois.auda.org.au",
            "jp" => "whois.jprs.jp",
            "cn" => "whois.cnnic.cn",
            "ru" => "whois.tcinet.ru",
            "br" => "whois.registro.br",
            "za" => "whois.registry.net.za",
        ];
        return isset($whoisServers[$tld]) ? $whoisServers[$tld] : "whois.iana.org";
    }

    private static function parseWhoisData($data) {
        $parsedData = [];
        $lines = explode("\n", $data);
    
        foreach ($lines as $line) {
            if (trim($line) === "") continue;
    
            $parts = explode(":", $line, 2);
            if (count($parts) == 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
    
                if (isset($parsedData[$key])) {
                    if (is_array($parsedData[$key])) {
                        $parsedData[$key][] = $value;
                    } else {
                        $parsedData[$key] = [$parsedData[$key], $value];
                    }
                } else {
                    $parsedData[$key] = $value;
                }
            }
        }
    
        return [
            "parsedData"=>$parsedData,
            "rawData"=>$data];
    }
}
