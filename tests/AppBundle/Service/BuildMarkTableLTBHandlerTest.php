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

class BuildMarkTableLTBHandlerTest extends WebTestCase
{
    private $em;
    private $application;
    private $buildMarkTableLTBHandler;

   

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        
        $this->application = new Application(static::$kernel);
        $this->em = $this->application->getKernel()->getContainer()->get('doctrine.orm.entity_manager');
        $this->buildMarkTableLTBHandler = $this->application->getKernel()->getContainer()->get('AppBundle\Service\BuildMarkTableLTBHandler');
    }
    
    /*This is the main intrance of the algorithm that suppose to generate 
     * markTable for LTB as design on physical Doc.
     * return a Matrix (array()) of markTables that suppose to be printed as pdf later
    */
    public function testGenerateMarkTableLTB()
    {
        //Prepare the required parameters (section & sequence)
        $section = $this->em->getRepository('AppBundle:Section')->find(2);
        $sequence = $this->em->getRepository('AppBundle:Sequence')->find(1);
        $this->assertEquals($section->getName(), 'Sec 1ere G3B');
        $this->assertEquals($sequence->getName(), '1er Trimestre');
        //Get all student for the given section based on fixture, they have to be two
        $students = $section->getStudents();
        $this->assertEquals($students[0]->getName(), 'KOYASSANGOU Ursula');
        $this->assertEquals($students[1]->getName(), 'GAZAMBETI');
        //Test it now
        $outPut = $this->buildMarkTableLTBHandler->generateMarkTableLTB($section, $sequence);
        //Make sure it return array
        $this->assertEquals(count($outPut), 2);
        $this->assertEquals($outPut['parameters'], array());
    }
    
    public function testBuildMarkTableOneStudentLTB()
    {
        //Make sure fixture load the right student
        $sequence = $this->em->getRepository('AppBundle:Sequence')->find(1);
        $this->assertEquals($sequence->getName(), '1er Trimestre');
        $student2 = $this->em->getRepository('AppBundle:Student')->find(2);
        $student1 = $this->em->getRepository('AppBundle:Student')->find(1);
        //Make sure student is KOYASSANGOU
        $this->assertEquals($student1->getName(), 'KOYASSANGOU Ursula');
        $section = $student1->getSection();
        //Make sure section is for KOYASSANGOU (Sec 1ere G3B)
        $this->assertEquals($section->getName(), 'Sec 1ere G3B');
        //The selected programs have to be only for the right level: 1ere G3B
        $programs = $section->getLevel()->getPrograms();
        $this->assertEquals($programs[0]->getName(), 'Prog Info 1ere G3');
        $this->assertEquals($programs[1]->getName(), 'Prog Maths 1ere G3');
        //For the current version of LTB.yml only 2 items in $programs
        $this->assertEquals(count($programs), 2);
        $this->assertEquals('KOYASSANGOU Ursula', $student1->getName());
        
        //Now call the method and check MarkTable values for KOYASSANGOU
        $markTableOneStudent = $this->buildMarkTableLTBHandler->buildMarkTableOneStudentLTB($student1, $sequence);
        //Make sure the mark table is for KOYANSSANGOU
        $this->assertEquals($markTableOneStudent['student_name'], 'KOYASSANGOU Ursula');
        //Make sure $markTableOneStudent have 3 items (two rows + student name) because there are two programs
        $this->assertEquals(count($markTableOneStudent), 2);
        $this->assertEquals(count($markTableOneStudent['rows']), 2);
        //Check the first row (program => 'Prog 1ere G3B', coef => 2, ...) for
        $this->assertEquals($markTableOneStudent['rows'][0]['program_name'], 'Prog Info 1ere G3');
        $this->assertEquals($markTableOneStudent['rows'][0]['coefficient'], 2);
        $this->assertEquals($markTableOneStudent['rows'][0]['mark'], 10.5);
        $this->assertEquals($markTableOneStudent['rows'][0]['mark_coefficient'], 21);
        $this->assertEquals($markTableOneStudent['rows'][0]['teacher'], 'MAPOUKA Saint-Cyr');
        
        //Now call the method and check MarkTable values for KOYASSANGOU
        $markTableOneStudent2 = $this->buildMarkTableLTBHandler->buildMarkTableOneStudentLTB($student2, $sequence);
        //Make sure the mark table for KOYANSSANGOU is right at this point
        //Make sure $markTableOneStudent have 3 items (two rows + student_name) because there are two programs
        $this->assertEquals(count($markTableOneStudent2), 2);
        //Check the first row (program => 'Prog 1ere G3B', coef => 2, ...) for
        $this->assertEquals($markTableOneStudent2['rows'][0]['program_name'], 'Prog Info 1ere G3');
        $this->assertEquals($markTableOneStudent2['rows'][0]['coefficient'], 2);
        $this->assertEquals($markTableOneStudent2['rows'][0]['mark'], 12.75);
        $this->assertEquals($markTableOneStudent2['rows'][0]['mark_coefficient'], 25.5);
        $this->assertEquals($markTableOneStudent2['rows'][0]['teacher'], 'MAPOUKA Saint-Cyr');
        //Check the second row (program => 'Prog 1ere G3B', coef => 2, ...) for
        $this->assertEquals($markTableOneStudent2['rows'][1]['program_name'], 'Prog Maths 1ere G3');
        $this->assertEquals($markTableOneStudent2['rows'][1]['coefficient'], 3);
        $this->assertEquals($markTableOneStudent2['rows'][1]['mark'], 7.5);
        $this->assertEquals($markTableOneStudent2['rows'][1]['mark_coefficient'], 22.5);
        $this->assertEquals($markTableOneStudent2['rows'][1]['teacher'], 'SARKO');
        $this->assertEquals($markTableOneStudent2['rows'][1]['appreciation'], 'Faible');
    }
}

