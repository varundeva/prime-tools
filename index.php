<?php
// Enable CORS for all domains (adjust as needed)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept");

require_once __DIR__ . '/core/bootstrap.php';

$headers = getallheaders();
$params = $_GET;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$validation = Validator::validateRequest($params, $headers);
if ($validation['error']) {
    Response::send($validation, 403);
}

$tool = $params['tool'];
$domain = $params['domain'];

switch ($tool) {
    case 'whois':
        $data = WhoisTool::getData($domain);
        break;
    case 'dns':
        $data = DnsTool::getData($domain);
        break;
    case 'ssl':
        $data = SslTool::getData($domain);
        break;
    case 'email-security':
        $data = EmailSecurityTool::getData($domain);
        break;
    case 'reverse-dns':
        $data = ReverseDnsTool::getData($params);
        break;
    case 'domain-to-ip':
        $data = DomainToIpTool::getData($params['domain']);
        break;
    case 'http':
        $data = HttpTool::getData($params['domain']);
        break;
    default:
        $data = [
            "error" => true,
            "message" => "Invalid tool specified"
        ];
        break;
}

Response::send($data);
