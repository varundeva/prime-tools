<?php
class HttpTool extends BaseTool {
    public static function getData($domain) {
        // Construct URL (Assuming we want to fetch from http/https. Let's default to https)
        $url = "https://{$domain}/";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);     // Include headers in output
        curl_setopt($ch, CURLOPT_NOBODY, false);    // Set to false to get content as well
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($error) {
            return [
                "error" => true,
                "domain" => $domain,
                "message" => "Error fetching data: $error"
            ];
        }

        // Separate headers and body
        $headerSize = $info['header_size'];
        $headersRaw = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        // Parse headers into associative array
        $headers = self::parseHeaders($headersRaw);

        return [
            "error" => false,
            "domain" => $domain,
            "headers" => $headers
        ];
    }

    private static function parseHeaders($rawHeaders) {
        $headers = [];
        $lines = explode("\r\n", trim($rawHeaders));
        // The first line is the HTTP status line
        // Example: HTTP/1.1 200 OK
        if (isset($lines[0]) && preg_match('#HTTP/\d\.\d\s+(\d+)\s+(.*)#', $lines[0], $matches)) {
            $headers['http_version'] = substr($lines[0], 5, 3);
            $headers['status_code'] = $matches[1];
            $headers['status_text'] = $matches[2];
        }

        // Remove the status line from array
        array_shift($lines);

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                $headers[$key] = $value;
            }
        }

        return $headers;
    }
}
