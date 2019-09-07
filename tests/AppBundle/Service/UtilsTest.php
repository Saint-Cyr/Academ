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
use AppBundle\Entity\Teacher;

class UtilsTest extends WebTestCase
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
     * this is valid for fixture LTB1.yml
     */
    public function testComputedMark()
    {
        //Test the avarage of Angela as prepared in fixtures
        $student = $this->em->getRepository('AppBundle:Student')->find(2);
        //Make sure student is GAZAMBETI
        $this->assertEquals($student->getName(), 'GAZAMBETI');
        //Make sure program is Info 1ere G3
        $program = $this->em->getRepository('AppBundle:Program')->find(1);
        $this->assertEquals($program->getName(), 'Prog Info 1ere G3');
        //Get all the marks
        $marks = $student->getMarks();
        //Make sure it is three as in the fixture
        $this->assertEquals(count($marks), 3);
        //Make sure mark values are right as in fixture
        $this->assertEquals($marks[0]->getValue(), 14.5);
        $this->assertEquals($marks[1]->getValue(), 11);
        $this->assertEquals($marks[2]->getValue(), 7.5);
        //test the avarage computing methode now
        $avarage = $this->utils->getComputedMark($student, $program);
        $this->assertEquals($avarage, 12.75);
        //Test the avarage of Student name_1 as prepared in fixtures
        $student2 = $this->em->getRepository('AppBundle:Student')->find(3);
        //Make sure student is Student name_1
        $this->assertEquals($student2->getName(), 'Eleve name_1');
        //Make sure no division by zero
        $avarage2 = $this->utils->getComputedMark($student2, $program);
        $this->assertEquals($student2->getName(), 'Eleve name_1');
        $this->assertEquals($avarage2, 8);
    }
    
    public function testGetAppreciation()
    {
        $outPut = $this->utils->getAppreciation(3.5);
        $this->assertEquals('Null', $outPut);
        
        $outPut = $this->utils->getAppreciation(5);
        $this->assertEquals('Tres-Faible', $outPut);
        
        $outPut = $this->utils->getAppreciation(7.5);
        $this->assertEquals('Faible', $outPut);
        
        $outPut = $this->utils->getAppreciation(8);
        $this->assertEquals('Insuffisant', $outPut);
        
        $outPut = $this->utils->getAppreciation(11);
        $this->assertEquals('Passable', $outPut);
        
        $outPut = $this->utils->getAppreciation(18);
        $this->assertEquals('Tres-Bien', $outPut);
        
        $outPut = $this->utils->getAppreciation(20);
        $this->assertEquals('Excellent', $outPut);
    }
    
    public function testGetGlobalAppreciation()
    {
        //Test the result of the global appreciation
        //Case of 3.5   
        $outPut = $this->utils->getGlobalAppreciation(3.5);
        $this->assertEquals(false, $outPut['th_congratulation']);
        $this->assertEquals(false, $outPut['th_encouragement']);
        $this->assertEquals(false, $outPut['th']);
        $this->assertEquals(true, $outPut['exclusion']);
        //Case of 5
        $outPut = $this->utils->getGlobalAppreciation(5);
        $this->assertEquals(false, $outPut['th_congratulation']);
        $this->assertEquals(false, $outPut['th_encouragement']);
        $this->assertEquals(false, $outPut['th']);
        $this->assertEquals(false, $outPut['exclusion']);
        //Case of 12
        $outPut = $this->utils->getGlobalAppreciation(12);
        $this->assertEquals(false, $outPut['th_congratulation']);
        $this->assertEquals(false, $outPut['th_encouragement']);
        $this->assertEquals(true, $outPut['th']);
        $this->assertEquals(false, $outPut['exclusion']);
        //Case of 14
        $outPut = $this->utils->getGlobalAppreciation(14);
        $this->assertEquals(true, $outPut['th_congratulation']);
        $this->assertEquals(true, $outPut['th_encouragement']);
        $this->assertEquals(true, $outPut['th']);
        $this->assertEquals(false, $outPut['exclusion']);
    }
}

