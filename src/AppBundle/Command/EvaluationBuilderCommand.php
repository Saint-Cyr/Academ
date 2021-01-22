<?php
namespace AppBundle\Command;

use AppBundle\Entity\Evaluation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Component\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface as OutputOutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EvaluationBuilderCommand extends Command
{
    private $em;
    
    public function __construct(EntityManagerInterface $em) 
    {
        parent::__construct();
        $this->em = $em;
        
    }

    public function configure()
    {
        $this
            ->setName('evaluation:create')
            ->setDescription('some description of the command go here....')
            ->setHelp('This command make it possible for building evaluations')
            ->addArgument('level', InputArgument::REQUIRED, 'The level #ID or Name');
    }

    protected function interact(InputInterface $input, OutputOutputInterface $outPut)
    {
        //$this->setHelp('help1');
        $helper = $this->getHelp();
        //$helper2 = $this->getHelper('help1');
        
    }

    public function execute(InputInterface $input, OutputOutputInterface $outPut)
    {
        $io = new SymfonyStyle($input, $outPut);
        //Get the level based on its #ID
        $levelId = $input->getArgument('level');
        $level = $this->em->getRepository('AppBundle:Level')->find($levelId);
        //variable to hold the number of affectedprogram built
        $evaluationBuiltNumber = 0;
        //variable to hold the number of the section concerned by the built evaluations
        $sectionBuiltNumber = 0;
        $devoir = $this->em->getRepository('AppBundle:EvaluationType')->findOneBy(array('name' => 'Devoir'));
        $composition = $this->em->getRepository('AppBundle:EvaluationType')->findOneBy(array('name' => 'Composition'));
        if(!$level){
            $io->error('Level of #ID :'.$levelId.' not found in DB');
        }elseif(!$level->getAffectedProgramsBuilt()){
            $io->error('The affected Programs of level '.$level.' have to be created before creating the related evaluation');
        }elseif($level->getEvaluationsBuilt()){
            $io->error('The evaluations of all the sections related to the level :'.$level.' have been created already');
        }else{

            foreach($level->getSections() as $section)
            {
                //Build the evaluations for each affected Program
                foreach($section->getAffectedPrograms() as $affectedProgram){
                    //Get all the sequences from the DB
                    $sequences = $this->em->getRepository('AppBundle:Sequence')->findAll();
                    foreach($sequences as $seq){
                        //Create the 1er Devoir
                        $dev1 = new Evaluation();
                        $dev1->setName('1er Devoir');
                        $dev1->setSection($section);
                        $dev1->setSequence($seq);
                        $dev1->setAffectedProgram($affectedProgram);
                        $dev1->setEvaluationType($devoir);
                        //Create the 2em Devoir
                        $dev2 = new Evaluation();
                        $dev2->setName('2em Devoir');
                        $dev2->setSection($section);
                        $dev2->setSequence($seq);
                        $dev2->setAffectedProgram($affectedProgram);
                        $dev2->setEvaluationType($devoir);
                        //Create the 3em Devoir
                        $dev3 = new Evaluation();
                        $dev3->setName('3em Devoir');
                        $dev3->setSection($section);
                        $dev3->setSequence($seq);
                        $dev3->setAffectedProgram($affectedProgram);
                        $dev3->setEvaluationType($devoir);
                        //Create the Composition
                        $comp = new Evaluation();
                        $comp->setName('Composition');
                        $comp->setSection($section);
                        $comp->setSequence($seq);
                        $comp->setAffectedProgram($affectedProgram);
                        $comp->setEvaluationType($composition);
                        
                        $this->em->persist($dev1);
                        $this->em->persist($dev2);
                        $this->em->persist($dev3);
                        $this->em->persist($comp);

                        $evaluationBuiltNumber++;
                    }
                }
                $sectionBuiltNumber++;
            }
            //Lock the level.
            $level->setEvaluationsBuilt(true);
            $this->em->persist($level);
            $this->em->flush();
            $io->success($evaluationBuiltNumber.' Evaluation(s) built successfully for '.$sectionBuiltNumber.' section(s) related to the level '.$level->getName());
        }

    }
    
    
}