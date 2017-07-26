<?php

namespace Kamwoz\WubookAPIBundle\Model;

use DateTime;
use DomTomProject\EasyRestBundle\Traits\FillableEntityTrait;

class Reservation implements ReservationInterface {

	use FillableEntityTrait;

    private $amount;
    private $customer;
    private $dateFrom;
    private $dateTo;
    private $guests;
    private $reservationCode;
    private $origin;
    private $ccard;
    private $ancillary;
    private $ignoreRestriction;
    private $ignoreAvailability;
    private $rooms;

    public function __construct() {
        $this->origin = null;
        $this->ancillary = 0;
        $this->ccard = null;
        $this->guests = null;
        $this->ignoreRestriction = 0;
        $this->ignoreAvailability = 0;
    }

    public function getAmount(): ?int {
        return $this->amount;
    }

    public function getCustomer(): ?Customer {
        return $this->customer;
    }

    public function getDateFrom(): ?DateTime {
        return $this->dateFrom;
    }

    public function getGuests(): ?array {
        return $this->guests;
    }

    public function getReservationCode(): ?int {
        return $this->reservationCode;
    }

    public function getDateTo(): ?DateTime {
        return $this->dateTo;
    }

    public function setAmount(int $amount) {
        $this->amount = $amount;
        return $this;
    }

    public function setCustomer(Customer $from) {
        $this->customer = $from;
        return $this;
    }

    public function setDateFrom(DateTime $dateFrom) {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    public function setGuests(?array $guests) {
        $this->guests = $guests;
        return $this;
    }

    public function setReservationCode(int $reservationCode) {
        $this->reservationCode = $reservationCode;
        return $this;
    }

    public function setDateTo(DateTime $from) {
        $this->dateTo = $from;
        return $this;
    }

    public function getAncillary(): int {
        return $this->ancillary;
    }

    public function getCcard() {
        return $this->ccard;
    }

    public function getIgnoreAvailability(): int {
        return $this->ignoreAvailability;
    }

    public function getIgnoreRestriction(): int {
        return $this->ignoreRestriction;
    }

    public function getOrigin() {
        return $this->origin;
    }

    public function setAncillary(int $ancillary) {
        $this->ancillary = $ancillary;
        return $this;
    }

    public function setCcard($ccard) {
        $this->ccard = $ccard;
        return $this;
    }

    public function setIgnoreAvailability(int $ignoreAvailability) {
        $this->ignoreAvailability = $ignoreAvailability;
        return $this;
    }

    public function setIgnoreRestriction(int $ignoreRestriction) {
        $this->ignoreRestriction = $ignoreRestriction;
        return $this;
    }

    public function setOrigin($origin) {
        $this->origin = $origin;
        return $this;
    }
    
    public function getRooms(): array {
        return $this->rooms;
    }

    public function setRooms(array $rooms) {
        $this->rooms = $rooms;
        return $this;
    }


}
