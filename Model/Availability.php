<?php

namespace Kamwoz\WubookAPIBundle\Model;


class Availability implements AvailabilityInterface {

	/** @var  bool */
	private $closedArrival;

	/** @var  bool */
	private $booked;

	/** @var  int */
	private $maxStay;

	/** @var  float */
	private $price;

	/** @var  int */
	private $minStay;

	/** @var  bool */
	private $closedDeparture;

	/** @var  int */
	private $avail;

	/** @var  bool */
	private $closed;

	/** @var  int */
	private $minStayArrival;

	/** @var  bool */
	private $noOta;

	public static function createFromData(array $data) : AvailabilityInterface {
		$availability = new self();

		$availability
			->setClosedArrival($data['closed_arrival'])
			->setBooked($data['booked'])
			->setMaxStay($data['max_stay'])
			->setPrice($data['price'])
			->setMinStay($data['min_stay'])
			->setClosedDeparture($data['closed_departure'])
			->setAvail($data['avail'])
			->setClosed($data['closed'])
			->setMinStayArrival($data['min_stay_arrival'])
			->setNoOta(!!$data['no_ota']);

		return $availability;
	}

	public function isClosedArrival(): bool {
		return $this->closedArrival;
	}

	public function setClosedArrival( bool $closedArrival ): Availability {
		$this->closedArrival = $closedArrival;

		return $this;
	}

	public function isBooked(): bool {
		return $this->booked;
	}

	public function setBooked( bool $booked ): Availability {
		$this->booked = $booked;

		return $this;
	}

	public function getMaxStay(): int {
		return $this->maxStay;
	}

	public function setMaxStay( int $maxStay ): Availability {
		$this->maxStay = $maxStay;

		return $this;
	}

	public function getPrice(): float {
		return $this->price;
	}

	public function setPrice( float $price ): Availability {
		$this->price = $price;

		return $this;
	}

	public function getMinStay(): int {
		return $this->minStay;
	}

	public function setMinStay( int $minStay ): Availability {
		$this->minStay = $minStay;

		return $this;
	}

	public function isClosedDeparture(): bool {
		return $this->closedDeparture;
	}

	public function setClosedDeparture( bool $closedDeparture ): Availability {
		$this->closedDeparture = $closedDeparture;

		return $this;
	}

	public function getAvail(): int {
		return $this->avail;
	}

	public function setAvail( int $avail ): Availability {
		$this->avail = $avail;

		return $this;
	}

	public function isClosed(): bool {
		return $this->closed;
	}

	public function setClosed( bool $closed ): Availability {
		$this->closed = $closed;

		return $this;
	}

	public function getMinStayArrival(): int {
		return $this->minStayArrival;
	}

	public function setMinStayArrival( int $minStayArrival ): Availability {
		$this->minStayArrival = $minStayArrival;

		return $this;
	}

	public function isNoOta(): bool {
		return $this->noOta;
	}

	public function setNoOta( bool $noOta ): Availability {
		$this->noOta = $noOta;

		return $this;
	}

}