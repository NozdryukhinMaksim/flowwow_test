<?php

use FlowwowTest\DTO\ExchangeRateDTO;
use FlowwowTest\Service\ExchangeRateService;
use PHPUnit\Framework\TestCase;

class ExchangeRateServiceTest extends TestCase {

	private ExchangeRateService $service;

	protected function setUp(): void {
		$this->service = new ExchangeRateService();
	}

	/**
	 * @throws Exception
	 */
	public function testGetLatestRatesReturnsValidDTO() {

		$dto = $this->service->getLatestRates();
		$this->printExchangeRates( $dto );

		$this->assertInstanceOf( ExchangeRateDTO::class, $dto );
		$this->assertEquals( 'USD', $dto->base );
		$this->assertNotEmpty( $dto->rates );
		$this->assertIsString( $dto->getFormattedTimestamp() );
		$this->assertArrayHasKey( 'GBP', $dto->rates );
		$this->assertArrayHasKey( 'EUR', $dto->rates );
	}

	private function printExchangeRates( ExchangeRateDTO $dto ): void {
		printf(
			"Base Currency: %s\n",
			$dto->base
		);

		foreach ( $dto->rates as $currency => $rate ) {
			printf(
				"1 %s equals %s %s\n",
				$dto->base,
				$rate,
				$currency
			);
		}

		printf(
			"Data as of: %s\n",
			date( 'H:i jS F, Y', $dto->timestamp )
		);
	}
}