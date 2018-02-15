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
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="EvaluationType", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluationType;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $program;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Sequence", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sequence;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

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
     * Get marks
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
     * Set program
     *
     * @param \AppBundle\Entity\Program $program
     *
     * @return Evaluation
     */
    public function setProgram(\AppBundle\Entity\Program $program)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return \AppBundle\Entity\Program
     */
    public function getProgram()
    {
        return $this->program;
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
     * Get section
     *
     * @return \AppBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }
}
