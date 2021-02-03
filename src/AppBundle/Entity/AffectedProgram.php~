<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Sequence;

/**
 * AffectedProgram
 *
 * @ORM\Table(name="affected_program")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AffectedProgramRepository")
 */
class AffectedProgram
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="affectedPrograms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="affectedPrograms")
     * @ORM\JoinColumn(nullable=true)
     */
    private $teacher;

    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="affectedPrograms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $program;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="affectedProgram")
     */
    private $evaluations;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * return marks related to a sequence
     * @param $markType can be either 'devoir' or composition
     */
    public function getMarksBySequence(Sequence $sequence, $markType)
    {
        $selectedMark = [];
        foreach($this->getEvaluations() as $evaluation){
            //Make sure to fetch only the evaluation for the right type
            if($evaluation->getEvaluationType()->getName() == $markType)
            {
                $markFromEvaluations = $evaluation->getMarks();
                foreach($markFromEvaluations as $mFE){
                    if($mFE->getEvaluation()->getSequence()->getName() == $sequence->getName())
                    {
                        $selectedMark[] = $mFE;
                    }
                }

            }
        }

        return $selectedMark;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return AffectedProgram
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evaluations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evaluation.
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return AffectedProgram
     */
    public function addEvaluation(\AppBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluations[] = $evaluation;

        return $this;
    }

    /**
     * Remove evaluation.
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEvaluation(\AppBundle\Entity\Evaluation $evaluation)
    {
        return $this->evaluations->removeElement($evaluation);
    }

    /**
     * Get evaluations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * Set section.
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return AffectedProgram
     */
    public function setSection(\AppBundle\Entity\Section $section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section.
     *
     * @return \AppBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }
}
