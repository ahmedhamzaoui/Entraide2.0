<?php

namespace Tests\CMEN\GoogleChartsBundle\GoogleCharts;

use CMEN\GoogleChartsBundle\GoogleCharts\Listener;

/**
 * @author Christophe Meneses
 */
class ListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \CMEN\GoogleChartsBundle\Exception\GoogleChartsException
     * @expectedExceptionMessage  badType is not a valid type of event.
     */
    public function testBadType()
    {
        new Listener('badType', 'functionName');
    }

    public function testGoodType()
    {
        $listener = new Listener('ready', 'functionName');

        $this->assertEquals('ready', $listener->getType());
        $this->assertEquals('functionName', $listener->getFunction());
    }
}
