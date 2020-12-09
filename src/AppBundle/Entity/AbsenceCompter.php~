<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbsenceCompter
 *
 * @ORM\Table(name="absence_compter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbsenceCompterRepository")
 */
class AbsenceCompter
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
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="absenceCompters")
     * @ORM\JoinColumn(nullable=true)
     */
    private $student;


    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="absenceCompters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $program;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;


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
     * @param integer $value
     *
     * @return AbsenceCompter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
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
     * @return AbsenceCompter
     */
    public function setStudent(\AppBundle\Entity\Student $student = null)
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
     * Set program
     *
     * @param \AppBundle\Entity\Program $program
     *
     * @return AbsenceCompter
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
}
