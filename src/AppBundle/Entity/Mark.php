<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mark
 *
 * @ORM\Table(name="mark")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarkRepository")
 */
class Mark
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
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="marks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;


    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Evaluation", inversedBy="marks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    public function __toString()
    {
        return 'Mark';
    }


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
     * Set value
     *
     * @param float $value
     *
     * @return Mark
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return Mark
     */
    public function setStudent(\AppBundle\Entity\Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \AppBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return Mark
     */
    public function setEvaluation(\AppBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get evaluation
     *
     * @return \AppBundle\Entity\Evaluation
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }
}
