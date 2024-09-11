<?php

namespace FlowwowTest\DTO;

class ExchangeRateDTO {
	public string $base;
	public array $rates;
	public int $timestamp;

	public function __construct( string $base, array $rates, int $timestamp ) {
		$this->base      = $base;
		$this->rates     = $rates;
		$this->timestamp = $timestamp;
	}

	public function getRate( string $currency ): ?float {
		return $this->rates[ $currency ] ?? null;
	}

	public function getFormattedTimestamp( string $format = 'H:i jS F, Y' ): string {
		return date( $format, $this->timestamp );
	}
}