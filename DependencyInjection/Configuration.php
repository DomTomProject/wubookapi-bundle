<?php

namespace Kamwoz\WubookAPIBundle\DependencyInjection;

use Kamwoz\WubookAPIBundle\Model\Availability;
use Kamwoz\WubookAPIBundle\Model\Reservation;
use Kamwoz\WubookAPIBundle\Model\Room;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wubook_api');

        $rootNode
                ->children()
			        ->scalarNode('room_model')
				        ->defaultValue(Room::class)
				        ->cannotBeEmpty()
			        ->end()
			        ->scalarNode('availability_model')
				        ->defaultValue(Availability::class)
				        ->cannotBeEmpty()
			        ->end()
	                ->scalarNode('reservation_model')
		                ->defaultValue(Reservation::class)
		                ->cannotBeEmpty()
	                ->end()
	                ->scalarNode('url')
	                    ->defaultValue('https://wubook.net/xrws/')
	                ->end()
                ->end()
        ;

        return $treeBuilder;
    }

}
