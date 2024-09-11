<?php

namespace FlowwowTest\Service;

use Exception;
use FlowwowTest\DTO\ExchangeRateDTO;

require_once __DIR__ . '/../_env.php';

class ExchangeRateService {
	private string $appId;
	private string $apiUrl;

	public function __construct() {
		$this->appId = $_ENV['API_KEY'] ?? null;
		$this->apiUrl = "https://openexchangerates.org/api/latest.json?app_id=" . $this->appId;
	}

	/**
	 * @throws Exception
	 */
	public function getLatestRates(): ExchangeRateDTO {
		$ch = curl_init( $this->apiUrl );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$json = curl_exec( $ch );

		if ( $json === false ) {
			throw new Exception( 'Curl error: ' . curl_error( $ch ) );
		}

		curl_close( $ch );

		$data = json_decode( $json, true );

		if ( ! isset( $data['rates'], $data['base'], $data['timestamp'] ) ) {
			throw new Exception( 'Invalid response from API: ' . $json );
		}

		return new ExchangeRateDTO( $data['base'], $data['rates'], $data['timestamp'] );
	}
}