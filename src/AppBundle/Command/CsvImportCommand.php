<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class CsvImportCommand extends Command
{
    
    private $em;
    
    public function __construct(EntityManagerInterface $em) 
    {
        parent::__construct();
        $this->em = $em;
        
    }
    
    protected function configure()
    {
        $this
            ->addArgument('sectionId', InputArgument::REQUIRED, 'The Section #ID')
            ->setName('csv:import')
            ->setDescription('Import a student list in .csv file')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln('.csv file Processing...');
        //Make sure Argument is valid
        $section = $this->em->getRepository('AppBundle:Section')->find($input->getArgument('sectionId'));
        //Make sure the .csv list of student exists
        if(!$section){
            $io->error('Section of #ID:'.$input->getArgument('sectionId').' not found in Data Base');    
        }elseif(!$section->getStudentCsvList()){
            $io->error('The section '.$section->getName().' has not yet a csv list of student');
        }elseif($section->getStudentNumber() >= 90){
            $io->warning('There are currently '.$section->getStudentNumber().' students in this section('.$section->getName().') If you want to add another list anymore, please add the option --force');       
        }else{
            $io->title('==== <options=bold;fg=blue>Academ®</></> is a trademark of iSTech. All rights reserved. || © 2021 ==============');
            //Instatiate the csv reader library
        $reader = \League\Csv\Reader::createFromPath('%kernel.root_dir%/../web/upload/section/'.$section->getId().'.csv');
        $results = $reader->fetchAssoc();
        $io->progressStart(150);
        //Count the number of the recorded student
        $recordedStudent = 0;
        foreach ($results as $row){
            //create student object
            $student = new Student();
            //Set student properties
            $student->setName($row['name']);
            $student->setFirstName($row['first_name']);
            $student->setSexe($row['sexe']);
            $student->setPhoneNumber($row['phone_number']);
            $student->setAdress($row['address']);
            $student->setEmail($row['email']);
            $student->setLastSchoolInstitution($row['last_school_name']);
            
            //Check if #id for section exist both from csv and DB
            //if($row['section']){
                //fetch it from DB
                $section = $this->em->getRepository('AppBundle:Section')->find($input->getArgument('sectionId'));
                if($section){
                    //we can now set the relationship
                    $student->setSection($section);
                    $this->em->persist($section);
                }
            //}
            
            $this->em->persist($student);
            $recordedStudent++;
            $io->progressAdvance();
        }
        
        $io->progressFinish();
        
        $this->em->flush();
        
        $io->success($recordedStudent.' student(s) have been recorded successfully.');
        }       
    }
}