<?php
// Manually require all necessary files since we are not using Composer
require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/Response.php';
require_once __DIR__ . '/../tools/BaseTool.php';
require_once __DIR__ . '/../tools/WhoisTool.php';
require_once __DIR__ . '/../tools/DnsTool.php';
require_once __DIR__ . '/../tools/SslTool.php';
require_once __DIR__ . '/../tools/EmailSecurityTool.php';
require_once __DIR__ . '/../tools/ReverseDnsTool.php';
require_once __DIR__ . '/../tools/DomainToIpTool.php';
require_once __DIR__ . '/../tools/HttpTool.php';