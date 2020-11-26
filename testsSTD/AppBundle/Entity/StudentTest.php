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

class StudentTest extends WebTestCase
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
    }
    
    /*
     * this is valid for fixture STD1.yml
     */
    public function testGetDevoirMarksBySequenceByProgram()
    {
        //Get the student from the fixture
        $student = $this->em->getRepository('AppBundle:Student')->find(1);
        //Get the sequence from the fixture
        $sequence = $this->em->getRepository('AppBundle:Sequence')->find(1);
        //Get the program from the fixture
        $program = $this->em->getRepository('AppBundle:Program')->find(1);
        $marks = $student->getDevoirMarksBySequenceByProgram($sequence, $program);
        $this->assertEquals($marks, 10.83);
    }
}

