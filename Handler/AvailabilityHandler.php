<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;
use Kamwoz\WubookAPIBundle\Model\Availability;
use Kamwoz\WubookAPIBundle\Model\AvailabilityInterface;
use LogicException;
use ReflectionClass;

class AvailabilityHandler extends BaseHandler
{

	private $availabilityModel;

	public function __construct(string $availabilityModel) {
		$this->availabilityModel = $availabilityModel;
	}


	/**
     * Fetch availability
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param array $rooms array with room ids (integers)
     *
     * @return array|null
     * @throws WubookException
     */
    public function fetchRoomValues(\DateTime $dateFrom, \DateTime $dateTo, $rooms = array()) :? array {

    	$availabilityReflection = new ReflectionClass($this->availabilityModel);

    	if (!$availabilityReflection->implementsInterface(AvailabilityInterface::class)) {
		    throw new LogicException('Availability model must implements ' . AvailabilityInterface::class);
	    }

	    $args = [
		    $dateFrom->format('d/m/Y'),
		    $dateTo->format('d/m/Y'),
		    $rooms
	    ];

	    $fetchedRoomsVaules = parent::defaultRequestHandler('fetch_rooms_values', $args);

	    if (empty($fetchedRoomsVaules)) {
	    	return [];
	    }

	    foreach ($fetchedRoomsVaules as $roomId => &$roomAvailabilities) {
	    	foreach ($roomAvailabilities as &$roomAvailability) {
			    $roomAvailability = $this->availabilityModel::createFromData($roomAvailability);
		    }
	    }

        return $fetchedRoomsVaules;
    }

    /**
     * @param $dateFrom \DateTime
     * @param $roomDays
     *
     * @return array
     * @throws WubookException
     */
    public function updateAvail(\DateTime $dateFrom, $roomDays)
    {
        $args = [
            $dateFrom->format('d/m/Y'),
            $roomDays
        ];

        return parent::defaultRequestHandler('update_avail', $args);
    }

    /**
     * @param $rooms
     *
     * @return array
     * @throws WubookException
     */
    public function updateSparseAvail($rooms)
    {
        return parent::defaultRequestHandler('update_sparse_avail', [$rooms]);
    }
}