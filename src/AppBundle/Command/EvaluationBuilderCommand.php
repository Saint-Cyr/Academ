<?php
namespace AppBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Component\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface as OutputOutputInterface;
use Doctrine\ORM\EntityManagerInterface;

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
        $level = $input->getArgument('level');

        $outPut->writeln([
            'Evaluation creation first line',
            '=================== 2nd line',
            '3rd line',
            $level,
        ]);

    }
    
    
}