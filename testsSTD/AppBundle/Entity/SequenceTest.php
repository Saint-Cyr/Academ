<?php

/*
 * This file is part of Components of Academ project
 * By contributor S@int-Cyr MAPOUKA
 * (c) Tinzapa <mapoukacyr@yahoo.fr>
 * For the full copyrght and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SequenceTest extends WebTestCase
{
    private $em;
    private $application;
    private $utils;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        
        $this->application = new Application(static::$kernel);
        $this->em = $this->application->getKernel()->getContainer()->get('doctrine.orm.entity_manager');
        $this->utils = $this->application->getKernel()->getContainer()->get('app.utils');
    }
    
    /*
     * this is valid for fixture STD1.yml
     */
    public function testGetEvaluationsOfOneProgram()
    {
        //Get the sequence from the fixture
        $sequence = $this->em->getRepository('AppBundle:Sequence')->find(1);
        //Get the program from the fixture
        $program = $this->em->getRepository('AppBundle:Program')->find(1);
        $program2 = $this->em->getRepository('AppBundle:Program')->find(3);
        $this->assertEquals($program2->getName(), "Phys. Chimie 2nd C");
        $program3 = $this->em->getRepository('AppBundle:Program')->find(8);
        $this->assertEquals($program3->getName(), "Hist/Geo 2nd C");
       
        $outPut1 = $sequence->getEvaluationsOfOneProgram($program);
        $outPut2 = $sequence->getEvaluationsOfOneProgram($program2);
        $outPut3 = $sequence->getEvaluationsOfOneProgram($program3);
        $this->assertEquals(count($outPut1), 4);
        $this->assertEquals(count($outPut2), 2);
        $this->assertEquals(count($outPut3), 0);
        
    }
}

