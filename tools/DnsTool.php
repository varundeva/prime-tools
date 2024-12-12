<?php
class DnsTool extends BaseTool {
    public static function getData($domain) {
        $recordTypes = ['A', 'AAAA', 'CNAME', 'MX', 'NS', 'PTR', 'SOA', 'TXT', 'SRV', 'NAPTR'];
        $dnsInfo = [];
        foreach ($recordTypes as $type) {
            $records = dns_get_record($domain, constant("DNS_$type"));
            if (!empty($records)) {
                $dnsInfo[$type] = $records;
            }
        }

        return [
            "error" => false,
            "domain" => $domain,
            "data" => $dnsInfo
        ];
    }
}
