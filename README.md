# Prime Tools API

The Prime Tools API provides a suite of utilities to gather essential information about a domain. It's designed as a single endpoint that can deliver a comprehensive set of data points—ranging from basic WHOIS records to DNS configurations and server metadata—without requiring separate services or complicated setups.

## Features

- **WHOIS**: Retrieve registration details, registrar info, and key dates (creation, expiration, update) for any given domain.
- **DNS**: Fetch a variety of DNS records (A, AAAA, MX, NS, TXT, and more) to understand the domain’s configuration and infrastructure.
- **SSL**: Inspect the domain’s SSL/TLS certificate, including issuer, subject details, validity period, and security-related extensions.
- **Email Security**: Check the domain’s DNS entries for email authentication mechanisms (SPF, DKIM, DMARC) to gauge email sending reputation and security.
- **Reverse DNS**: Given a domain or IP, determine its PTR record, revealing the hostnames associated with an IP and aiding in network and security diagnostics.
- **Domain to IP**: Quickly resolve a domain to its corresponding IPv4 address, useful for network troubleshooting or further IP-based lookups.
- **HTTP Headers & Content**: Retrieve HTTP response headers and the root page’s HTML content from the domain’s server, providing insights into server types, caching policies, and initial content served.

These tools work together to offer a holistic view of a domain’s technical landscape, catering to developers, sysadmins, security analysts, and researchers who need quick and reliable domain intelligence.

## File and Folder Structure
tools-crowd/
├── .gitignore
├── README.md
├── config/
│   └── Config.php
├── core/
│   ├── Response.php
│   ├── Validator.php
│   └── bootstrap.php
├── index.php
└── tools/
    ├── BaseTool.php
    ├── DnsTool.php
    ├── DomainToIpTool.php
    ├── EmailSecurityTool.php
    ├── HttpTool.php
    ├── ReverseDnsTool.php
    ├── SslTool.php
    └── WhoisTool.php

## Postman Collection

To streamline integration and testing, we’ve provided a ready-to-import Postman collection. This collection contains all API endpoints preconfigured with request parameters and placeholders for your API key.

**Collection URL:** [View on Postman]([https://www.postman.com/collections/your-postman-collection-link](https://bold-equinox-5091.postman.co/workspace/Team-Workspace~acc3498d-ab72-4823-846c-36164d8d5263/collection/6224175-ad2b330b-21e8-42df-aeea-3e125eb20e7a?action=share&creator=6224175))

By importing the collection into Postman, you can quickly explore each tool’s output, understand response structures, and integrate domain intelligence into your workflows.
