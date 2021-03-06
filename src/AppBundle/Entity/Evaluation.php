<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="evaluation")
     */
    private $marks;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="EvaluationType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluationType;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="AffectedProgram", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $affectedProgram;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Sequence", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sequence;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->getId()."/".$this->getAffectedProgram()->getSection()->getId();
    }
    
    public function getAverage()
    {
        $markAverage = null;
        $nb = 0;
        foreach ($this->getMarks() as $mark){
            $nb = $nb + 1;
            $markAverage = $markAverage + $mark->getValue();
        }
        
        return $markAverage/$nb;
    }
    
    public function __toString() {
        if($this->name){
            return $this->name;
        }
        
        return 'Undefined Name';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Evaluation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
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
        $this->marks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Evaluation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add mark
     *
     * @param \AppBundle\Entity\Mark $mark
     *
     * @return Evaluation
     */
    public function addMark(\AppBundle\Entity\Mark $mark)
    {
        $this->marks[] = $mark;

        return $this;
    }

    /**
     * Remove mark
     *
     * @param \AppBundle\Entity\Mark $mark
     */
    public function removeMark(\AppBundle\Entity\Mark $mark)
    {
        $this->marks->removeElement($mark);
    }

    /**
     * Get all the related marks; ideally, it should be
     * marks of all the students that belong to the
     * the section targeted by the evaluation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * Set evaluationType
     *
     * @param \AppBundle\Entity\EvaluationType $evaluationType
     *
     * @return Evaluation
     */
    public function setEvaluationType(\AppBundle\Entity\EvaluationType $evaluationType)
    {
        $this->evaluationType = $evaluationType;

        return $this;
    }

    /**
     * Get evaluationType
     *
     * @return \AppBundle\Entity\EvaluationType
     */
    public function getEvaluationType()
    {
        return $this->evaluationType;
    }

    /**
     * Set sequence
     *
     * @param \AppBundle\Entity\Sequence $sequence
     *
     * @return Evaluation
     */
    public function setSequence(\AppBundle\Entity\Sequence $sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return \AppBundle\Entity\Sequence
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Set section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Evaluation
     */
    public function setSection(\AppBundle\Entity\Section $section)
    {
        $this->section = $section;

        return $this;
    }


    /**
     * Set affectedProgram.
     *
     * @param \AppBundle\Entity\AffectedProgram $affectedProgram
     *
     * @return Evaluation
     */
    public function setAffectedProgram(\AppBundle\Entity\AffectedProgram $affectedProgram)
    {
        $this->affectedProgram = $affectedProgram;

        return $this;
    }

    /**
     * Get affectedProgram.
     *
     * @return \AppBundle\Entity\AffectedProgram
     */
    public function getAffectedProgram()
    {
        return $this->affectedProgram;
    }
}
