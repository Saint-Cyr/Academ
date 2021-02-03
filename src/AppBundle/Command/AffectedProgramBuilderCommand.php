<?php
namespace AppBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Component\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface as OutputOutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Entity\AffectedProgram;
use Doctrine\ORM\EntityManagerInterface;

class AffectedProgramBuilderCommand extends Command
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
            ->setName('affectedprogram:create')
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
        $affectedProgramBuiltNumber = 0;
        //variable to hold the number of concerned section by the built
        $sectionBuiltNumber = 0;
        if(!$level){
            $io->error('Level of #ID :'.$levelId.' not found in DB');
        }elseif($level->getAffectedProgramsBuilt()){
            $io->error('The Affected Programs of all the sections related to the level :'.$level.' have been created all ready');
        }else{

            foreach($level->getSections() as $section)
            {
                
                foreach($section->getlevel()->getPrograms() as $program)
                {
                    $affectedProgram = new AffectedProgram();
                    $affectedProgram->setName($program->getName());
                    $affectedProgram->setProgram($program);
                    $affectedProgram->setSection($section);
                    $affectedProgramBuiltNumber++;
                    $this->em->persist($affectedProgram);
                }
                $sectionBuiltNumber++;
            }
            //Lock the level.
            $level->setAffectedProgramsBuilt(true);
            $this->em->persist($level);
            $this->em->flush();
            $io->success($affectedProgramBuiltNumber.' AffectedProgram(s) built successfully for '.$sectionBuiltNumber.' section(s) related to the level '.$level->getName());
        }

    }
    
    
}