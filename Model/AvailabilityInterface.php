<?php

namespace Kamwoz\WubookAPIBundle\Model;


interface AvailabilityInterface {

	public function isClosedArrival(): bool;

	public function setClosedArrival( bool $closedArrival ): Availability;

	public function isBooked(): bool;

	public function setBooked( bool $booked ): Availability;

	public function getMaxStay(): int;

	public function setMaxStay( int $maxStay ): Availability;

	public function getPrice(): float;

	public function setPrice( float $price ): Availability;

	public function getMinStay(): int;

	public function setMinStay( int $minStay ): Availability;

	public function isClosedDeparture(): bool;

	public function setClosedDeparture( bool $closedDeparture ): Availability;

	public function getAvail(): int;

	public function setAvail( int $avail ): Availability;

	public function isClosed(): bool;

	public function setClosed( bool $closed ): Availability;

	public function getMinStayArrival(): int;

	public function setMinStayArrival( int $minStayArrival ): Availability;

	public function isNoOta(): bool;

	public function setNoOta( bool $noOta ): Availability;
}