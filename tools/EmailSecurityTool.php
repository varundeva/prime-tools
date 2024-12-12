<?php
class EmailSecurityTool extends BaseTool {
    public static function getData($domain) {
        $records = [
            "SPF" => dns_get_record($domain, DNS_TXT),
            "DMARC" => dns_get_record("_dmarc." . $domain, DNS_TXT),
            "DKIM" => dns_get_record("default._domainkey." . $domain, DNS_TXT)
        ];

        return [
            "error" => false,
            "domain" => $domain,
            "data" => $records
        ];
    }
}
