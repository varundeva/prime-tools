<?php
require_once __DIR__ . '/core/bootstrap.php';

$headers = getallheaders();
$params = $_GET;

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
    default:
        $data = [
            "error" => true,
            "message" => "Invalid tool specified"
        ];
        break;
}

Response::send($data);
