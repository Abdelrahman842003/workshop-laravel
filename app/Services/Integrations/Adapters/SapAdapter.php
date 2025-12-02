<?php

namespace App\Services\Integrations\Adapters;

use App\Services\Integrations\Contracts\IntegrationAdapterInterface;
use App\Services\Integrations\DTOs\ExportPayloadDTO;
use App\Services\Integrations\DTOs\IntegrationConfigDTO;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class SapAdapter implements IntegrationAdapterInterface
{
    public function send(ExportPayloadDTO $payload, IntegrationConfigDTO $config): array
    {
        // 1. Convert Data to XML
        $xml = new SimpleXMLElement('<Request/>');
        $body = $xml->addChild('Body');
        $items = $body->addChild('Items');

        foreach ($payload->data as $row) {
            $item = $items->addChild('Item');
            foreach ($row as $key => $value) {
                $item->addChild($key, htmlspecialchars((string)$value));
            }
        }

        $xmlString = $xml->asXML();

        // 2. Simulate SOAP Request
        Log::info("SapAdapter: Sending XML to {$config->settings['url']}", ['xml_snippet' => substr($xmlString, 0, 200) . '...']);

        // In real world: use SoapClient or Http::post with XML body
        // $response = Http::withBody($xmlString, 'text/xml')->post($url);

        return [
            'status' => 'success',
            'message' => 'XML Data received by SAP',
            'transaction_id' => 'SAP-' . uniqid(),
        ];
    }

    public function testConnection(IntegrationConfigDTO $config): bool
    {
        return !empty($config->settings['url']);
    }
}
