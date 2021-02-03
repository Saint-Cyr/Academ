<?php
/*
 * This file is part of Components of Academ project
 * By contributor S@int-Cyr MAPOUKA
 * (c) Tinzapa <mapoukacyr@yahoo.fr>
 * For the full copyrght and license information, please view the LICENSE
 * file that was distributed with this source code
 */
namespace Tests\AppBundle\Service;

use AppBundle\Entity\Mark;
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

    public function testGetMarkAverage()
    {
        //Get an affected program
        $affectedProgram = $this->em->getRepository('AppBundle:AffectedProgram')->findOneBy(array('name' => 'Francais'));
        $sequence1 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('name' => '1er Trimestre'));
        //Get marks of a student_1 6em from fixture and calculate their average
        $student_1_6em1 = $this->em->getRepository('AppBundle:Student')->findOneBy(array('name' => 'Eleve 6em 1'));
        $marks = $student_1_6em1->getMarksByAffectedProgramAndSequence($affectedProgram, $sequence1, 'Devoir');
        $average = $this->utils->getMarksAverage($marks);
        $this->assertEquals($average, 10.00);
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

