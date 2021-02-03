<?php

/*
 * This file is part of Components of Academ project
 * By contributor S@int-Cyr MAPOUKA
 * (c) iSTech <med@itechcar.com>
 * For the full copyrght and license information, please view the LICENSE
 * file that was distributed with this source code
 */
namespace Tests\AppBundle\Service;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BuildMarkTableHandlerTest extends WebTestCase
{
    private $em;
    private $application;
    private $buildMarkTableHandler;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        
        $this->application = new Application(static::$kernel);
        $this->em = $this->application->getKernel()->getContainer()->get('doctrine.orm.entity_manager');
        $this->buildMarkTableHandler = $this->application->getKernel()->getContainer()->get('app.build_marktable_handler');
    }
    
    /*
     * Supported fixture: STD1.yml
     * This is the main intrance of the algorithm that suppose to generate 
     * markTable for standard as design on physical Doc.
     * return a Matrix (array()) of markTables that suppose to be printed as pdf later
    */
    public function testGenerateMarkTable()
    {
        //Prepare the required parameters (section & sequence) Notice the sequence is got from setting
        $section = $this->em->getRepository('AppBundle:Section')->find(1);
        $setting = $this->em->getRepository('AppBundle:Setting')->find(1);
        $this->assertEquals($section->getName(), '6em 1');
        $this->assertEquals($setting->getSequence()->getName(), '1er Trimestre');
        //Get all student for the given section based on fixture, they have to be two
        $students = $section->getStudents();
        $this->assertEquals($students[0]->getName(), 'Eleve 6em 1');
        $this->assertEquals($setting->getSequence()->getSequenceOrder(), 1);
    }
    
    public function testBuildMarkTableOneStudent()
    {
        //Make sure fixture load the right student
        $sequence = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('name' => '1er Trimestre'));
        $this->assertEquals($sequence->getName(), '1er Trimestre');
        $student1 = $this->em->getRepository('AppBundle:Student')->find(1);
        //Make sure student 1 is Eleve 6em 1
        $this->assertEquals($student1->getName(), 'Eleve 6em 1');
        $section = $student1->getSection();
        //Make sure section is section is (6em 1)
        $this->assertEquals($section->getName(), '6em 1');
        //Check fixture setup (STD1.yml)
        $this->assertEquals(count($student1->getMarks()), 28);
        $this->assertEquals($student1->getMarks()[0]->getValue(), 10);
        $this->assertEquals($student1->getMarks()[3]->getValue(), 9.5);
        
        $this->assertEquals($student1->getMarks()[0]->getEvaluation()->getEvaluationType()->getName(), 'Devoir');
        $this->assertEquals($student1->getMarks()[3]->getEvaluation()->getEvaluationType()->getName(), 'Composition');
        //The selected programs have to be only for the right level: 2nd C
        $programs = $section->getLevel()->getPrograms();
        //Make sure there are only 8 programs in 6em
        //$this->assertEquals(count($programs), 8);
        $this->assertEquals($programs[0]->getName(), 'Francais 6em');
        $this->assertEquals($programs[1]->getName(), 'Anglais 6em');
        
        //Now call the method and check MarkTable values for Melvi
        $markTableOneStudent = $this->buildMarkTableHandler->buildMarkTableOneStudent($student1, $sequence);
        $this->assertEquals($markTableOneStudent['param']['student_name'], 'Eleve 6em 1');
        //Make sure $markTableOneStudent have two main index (param & rows)
        $this->assertEquals(count($markTableOneStudent), 2);
        //Make sure $markTableOneStudent have 7 rows or programs
        $this->assertEquals(count($markTableOneStudent['rows']), 7);
        //Check the first row (program => 'Francais 6em', coef => 6, ...) for
        $this->assertEquals($markTableOneStudent['rows'][0]['program_name'], 'Francais 6em');
        $this->assertEquals($markTableOneStudent['rows'][0]['coefficient'], 6);
        $this->assertEquals($markTableOneStudent['rows'][0]['mark'], 10.00);
        $this->assertEquals($markTableOneStudent['rows'][0]['mark_composition'], 9.5);
        $this->assertEquals($markTableOneStudent['rows'][0]['average'], 9.67);
        $this->assertEquals($markTableOneStudent['rows'][0]['mark_coefficient'], 58.02);
        $this->assertEquals($markTableOneStudent['rows'][0]['teacher'], 'Prof Fr 1');
        $this->assertEquals($markTableOneStudent['rows'][0]['appreciation'], 'Insuffisant');
        //Check the first row (program => 'Anglais 6em', coef => 6, ...) for
        $this->assertEquals($markTableOneStudent['rows'][1]['program_name'], 'Anglais 6em');
        $this->assertEquals($markTableOneStudent['rows'][1]['coefficient'], 3);
        $this->assertEquals($markTableOneStudent['rows'][1]['mark'], 8.50);
        $this->assertEquals($markTableOneStudent['rows'][1]['mark_composition'], 10);
        $this->assertEquals($markTableOneStudent['rows'][1]['average'], 9.50);
        $this->assertEquals($markTableOneStudent['rows'][1]['mark_coefficient'], 28.5);
        $this->assertEquals($markTableOneStudent['rows'][1]['teacher'], 'Prof Ang 1');
        $this->assertEquals($markTableOneStudent['rows'][1]['appreciation'], 'Insuffisant');
        
        //$this->assertEquals($markTableOneStudent['param']['total_mark_coefficient'], 270.81);
        
        //Make sure the total mark for the sequence is right
        //$this->assertEquals($markTableOneStudent['param']['total_mark'], 9.67);
        //This is usefull to display in template
        //$this->assertEquals($markTableOneStudent['param']['marks_by_sequence']['first'], 9.67);
        //As we're generating markTable for 1st sequence, it's important to set other "N/A"
        //$this->assertEquals($markTableOneStudent['param']['marks_by_sequence']['two'], 'N/A');
        //$this->assertEquals($markTableOneStudent['param']['marks_by_sequence']['three'], 'N/A');
        //Check the seconde row
        //Check the first row (program => 'Prog 1ere G3B', coef => 2, ...) for
        //Check the global appreciation
        /*$this->assertEquals($markTableOneStudent['param']['total_coefficient'], 28);
        $this->assertEquals($markTableOneStudent['param']['global_appreciation'], array('th_congratulation' => false,
                                                                                        'th_encouragement' => false,
                                                                                        'th' => false,
                                                                                        'exclusion' => false,));

        //Second sequence
        $sequence = $this->em->getRepository('AppBundle:Sequence')->find(2);
        //Now call the method and check MarkTable values for Melvi
        $markTableOneStudent_2 = $this->buildMarkTableHandler->buildMarkTableOneStudent($student1, $sequence);
        $this->assertEquals($markTableOneStudent_2['rows'][0]['mark'], 9.17);
        $this->assertEquals($markTableOneStudent_2['rows'][0]['mark_composition'], 24);
        $this->assertEquals($markTableOneStudent_2['rows'][0]['average'], 11.06);
        $this->assertEquals($markTableOneStudent_2['rows'][0]['mark_coefficient'], 55.30);
        $this->assertEquals($markTableOneStudent_2['rows'][0]['teacher'], 'HAMINOU');
        $this->assertEquals($markTableOneStudent_2['rows'][0]['appreciation'], 'Passable');
        $this->assertEquals($markTableOneStudent_2['param']['marks_by_sequence']['first'], 9.67);
        //As we're generating markTable for 1st sequence, it's important to set other "N/A"
        $this->assertEquals($markTableOneStudent_2['param']['marks_by_sequence']['two'], 10.01);
        $this->assertEquals($markTableOneStudent_2['param']['marks_by_sequence']['three'], 'N/A');
        
        //Second sequence
        $sequence = $this->em->getRepository('AppBundle:Sequence')->find(3);
        //Now call the method and check MarkTable values for Melvi
        $markTableOneStudent_3 = $this->buildMarkTableHandler->buildMarkTableOneStudent($student1, $sequence);
        $this->assertEquals($markTableOneStudent_3['rows'][0]['mark'], 7.17);
        $this->assertEquals($markTableOneStudent_3['rows'][0]['mark_composition'], 22);
        $this->assertEquals($markTableOneStudent_3['rows'][0]['average'], 9.72);
        $this->assertEquals($markTableOneStudent_3['rows'][0]['mark_coefficient'], 48.60);
        $this->assertEquals($markTableOneStudent_3['rows'][0]['teacher'], 'HAMINOU');
        $this->assertEquals($markTableOneStudent_3['rows'][0]['appreciation'], 'Insuffisant');
        $this->assertEquals($markTableOneStudent_3['param']['marks_by_sequence']['first'], 9.67);
        //As we're generating markTable for 1st sequence, it's important to set other "N/A"
        $this->assertEquals($markTableOneStudent_3['param']['marks_by_sequence']['two'], 10.01);
        $this->assertEquals($markTableOneStudent_3['param']['marks_by_sequence']['three'], 9.57);*/
    }
}

