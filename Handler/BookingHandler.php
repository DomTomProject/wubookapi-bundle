<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;
use Kamwoz\WubookAPIBundle\Model\ReservationInterface;
use DateTime;
use Reflection;
use LogicException;
use ReflectionClass;

class BookingHandler extends BaseHandler {

    private $model;

    public function __construct(string $model) {
        $this->model = $model;
    }

    /**
     * Fetch reservations from wubook
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param int $byReservationDate
     * @param int $ancillary
     *
     * @return array|null
     * @throws WubookException
     */
    public function fetchBookings(DateTime $dateFrom, DateTime $dateTo, $byReservationDate = 1, $ancillary = 0) {
        $args = [
            $dateFrom->format('d/m/Y'),
            $dateTo->format('d/m/Y'),
            $byReservationDate,
            $ancillary
        ];

        $reflection = new ReflectionClass($this->model);
        if (!$reflection->implementsInterface(ReservationInterface::class)) {
            throw new LogicException('Reservation model must implements ' . ReservationInterface::class);
        }

        $allData = parent::defaultRequestHandler('fetch_bookings', $args);
        if (empty($allData)) {
            return [];
        }

        foreach ($allData as &$reservationData) {
            $reservationData = $this->model::createFromData($reservationData);
        }

        return $allData;
    }

    /**
     * @param ReservationInterface $reservation
     * 
     * @return null
     * @throws WubookException
     */
    public function fetchBooking(int $reservationId, int $ancillary = 0) {
//        $res = parent::defaultRequestHandler('fetch_booking', [$reservationId, $ancillary]);
//
//        $reflection = new ReflectionClass($this->model);
//        if (!$reflection->implementsInterface(ReservationInterface::class)) {
//            throw new LogicException('Reservation model must implements ' . ReservationInterface::class);
//        }
//
//        $data = $res[0];
//        if (!empty($data)) {
//            $data = $this->model->createFromData($data);
//        }
//
//        return $data;
	    return parent::defaultRequestHandler('fetch_booking', [$reservationId, $ancillary]);
    }


    /**
     * @param ReservationInterface $reservation
     * @return string new reservation id
     * @throws WubookException
     */
    public function newReservation(ReservationInterface $reservation): string {

        return parent::defaultRequestHandler('new_reservation', [
			        $reservation->getDateFrom()->format('d/m/Y'),
			        $reservation->getDateTo()->format('d/m/Y'),
	                $reservation->getRooms(),
					$reservation->getCustomer()->generateDataArray(),
                    $reservation->getAmount(),
			        $reservation->getOrigin(),
	                $reservation->getCcard(),
			        $reservation->getAncillary(),
                    $reservation->getGuests(),
			        $reservation->getIgnoreRestriction(),
			        $reservation->getIgnoreAvailability()
        ]);
    }

    /**
     * Reservation cancelation
     * @param ReservationInterface $reservation
     *
     * @return bool false on success and exception on failure
     * @throws WubookException
     */
    public function cancelReservation(int $reservationCode) {
        parent::defaultRequestHandler('cancel_reservation', [$reservationCode]);

        return false;
    }

    /**
     * @param int $ancillary
     * @param int $mark
     * @return mixed
     * @throws WubookException
     */
    public function fetchNewBooking($ancillary = 0, $mark = 1) {
        $args = [
            $ancillary,
            $mark
        ];

        return parent::defaultRequestHandler('fetch_new_bookings', $args);
    }

    /**
     * @param $url
     *
     * @return mixed
     * @throws WubookException
     */
    public function pushActivation($url) {
        return parent::defaultRequestHandler('push_activation', [$url]);
    }

    /**
     * @return mixed
     * @throws WubookException
     */
    public function pushURL() {
        return parent::defaultRequestHandler('push_url', []);
    }

    /**
     * @param $reservations
     *
     * @return mixed
     * @throws WubookException
     */
    public function markBookings($reservations) {
        return parent::defaultRequestHandler('mark_bookings', [$reservations]);
    }

}
