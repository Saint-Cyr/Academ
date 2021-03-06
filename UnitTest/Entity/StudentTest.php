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
     * the purpose of this method is to return marks that
     * belongs to one sequence and one particular program
     */
    public function testGetMarksByAffectedProgramAndSequence()
    {
        //Get the student from the fixture
        $student = $this->em->getRepository('AppBundle:Student')->findOneBy(array('name' => 'Eleve1 6em1'));
        //Get the sequence from the fixture
        $sequence1 = $this->em->getRepository('AppBundle:Sequence')->findOneBy(array('name' => '1er Trimestre'));
        //Get the affectedProgram from the fixture
        $affectedProgramFrancais = $this->em->getRepository('AppBundle:AffectedProgram')->findOneBy(array('name' => 'Francais'));
        //Collect only marks for devoir
        $devoirMarks = $student->getMarksByAffectedProgramAndSequence($affectedProgramFrancais, $sequence1, 'Devoir');
        //Collect only marks for Composition
        $compositionMarks = $student->getMarksByAffectedProgramAndSequence($affectedProgramFrancais, $sequence1, 'Composition');
        $this->assertEquals(count($devoirMarks), 3);
        $this->assertEquals(count($compositionMarks), 1);
    }

    /**
     * this method aims to test the validation method of a student 
     * in order to make sure only one student at a time should be a leader
     * in a given section
     */
    public function testIsLeader()
    {
        //Get the student_2 from the section 6em 1
        $student_1 = $this->em->getRepository('AppBundle:Student')->findOneBy(['name' => 'Eleve1 6em1']);
        $student_2 = $this->em->getRepository('AppBundle:Student')->findOneBy(['name' => 'Eleve1 6em1']);
        $student_3 = $this->em->getRepository('AppBundle:Student')->findOneBy(['name' => 'Eleve1 2ndC1']);
        $student_2->setLeader(false);
        //1st case : the section 6em 1 already have a student leader (Eleve1 6em 1)
        $this->assertEquals($student_1->isStudentLeaderValid(), true);
        //2nd case : trying to test the validity for a section with o student
        $this->assertEquals($student_3->isStudentLeaderValid(), true);
    }
}

