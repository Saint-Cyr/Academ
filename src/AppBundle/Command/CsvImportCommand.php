<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Entity\Student;
use AppBundle\Entity\Section;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Level;
use AppBundle\Entity\Cycle;

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
            ->setName('csv:import')
            ->setDescription('Import a mock csv file')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->writeln('File Processing...');
        $io->title('==== <options=bold;fg=blue>Academ®</></> is a trademark of iSTech. All rights reserved. || © 2020 ==============');
        //Instatiate the csv reader library
        $reader = \League\Csv\Reader::createFromPath('%kernel.root_dir%/../web/data/STUDENT.csv');
        $results = $reader->fetchAssoc();
        $io->progressStart(150);
        //Count the number of the recorded student
        $recordedStudent = 0;
        foreach ($results as $row){
            //create student object
            $student = new Student();
            $student->setName($row['name']);
            //$student->setBarcode($row['barcode']);
            
            //Check if #id for section exist both from csv and DB
            if($row['section']){
                //fetch it from DB
                $section = $this->em->getRepository('AppBundle:Section')->find($row['section']);
                if($section){
                    //we can now set the relationship
                    $student->setSection($section);
                    $this->em->persist($section);
                }
            }
            
            $this->em->persist($student);
            $recordedStudent++;
            $io->progressAdvance();
        }
        
        $io->progressFinish();
        
        $this->em->flush();
        
        $io->success($recordedStudent.' student(s) have been recorded successfully.');
    }
}