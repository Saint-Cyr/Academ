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

class AffectedProgramTest extends WebTestCase
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
     * the purpose of this method is to return marks that
     * belongs to one sequence and one particular program
     */
    public function testGetMarksBySequence()
    {
        //Get the sequence from the fixture
        $sequence1 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('name' => '1er Trimestre'));
        $sequence2 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('name' => '2em Trimestre'));
        //Get the sequence from the fixture
        $student = $this->em->getRepository('AppBundle:Student')->find(1);
        //Get the affectedProgram from the fixture
        $affectedProgramFrancais = $this->em->getRepository('AppBundle:AffectedProgram')->findOneBy(array('name' => 'Francais'));
        //Test the getMarksBySequence() method
        $marksForFirstSequence = $affectedProgramFrancais->getMarksBySequence($sequence1);
        //$marksForSecondSequence = $affectedProgram->getMarksBySequence($sequence2);
        $this->assertEquals(count($marksForFirstSequence), 4);
        //$this->assertEquals(count($marksForSecondSequence), 1);
        
    }
}

