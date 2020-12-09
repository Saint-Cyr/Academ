<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Program
 *
 * @ORM\Table(name="program")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgramRepository")
 */
class Program
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
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="programs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $teacher;
    
    /**
     * @ORM\OneToMany(targetEntity="AbsenceCompter", mappedBy="program")
     */
    private $absenceCompters;
    
    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="program")
     */
    private $evaluations;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Coefficient", inversedBy="programs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $coefficient;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $field;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
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
     * @return Program
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
        $this->absenceCompters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evaluations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set level
     *
     * @param \AppBundle\Entity\Level $level
     *
     * @return Program
     */
    public function setLevel(\AppBundle\Entity\Level $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \AppBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set teacher
     *
     * @param \AppBundle\Entity\Teacher $teacher
     *
     * @return Program
     */
    public function setTeacher(\AppBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \AppBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Add absenceCompter
     *
     * @param \AppBundle\Entity\AbsenceCompter $absenceCompter
     *
     * @return Program
     */
    public function addAbsenceCompter(\AppBundle\Entity\AbsenceCompter $absenceCompter)
    {
        $this->absenceCompters[] = $absenceCompter;

        return $this;
    }

    /**
     * Remove absenceCompter
     *
     * @param \AppBundle\Entity\AbsenceCompter $absenceCompter
     */
    public function removeAbsenceCompter(\AppBundle\Entity\AbsenceCompter $absenceCompter)
    {
        $this->absenceCompters->removeElement($absenceCompter);
    }

    /**
     * Get absenceCompters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAbsenceCompters()
    {
        return $this->absenceCompters;
    }

    /**
     * Add evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return Program
     */
    public function addEvaluation(\AppBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluations[] = $evaluation;

        return $this;
    }

    /**
     * Remove evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     */
    public function removeEvaluation(\AppBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluations->removeElement($evaluation);
    }

    /**
     * Get evaluations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * Set coefficient
     *
     * @param \AppBundle\Entity\Coefficient $coefficient
     *
     * @return Program
     */
    public function setCoefficient(\AppBundle\Entity\Coefficient $coefficient = null)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return \AppBundle\Entity\Coefficient
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set field
     *
     * @param \AppBundle\Entity\Field $field
     *
     * @return Program
     */
    public function setField(\AppBundle\Entity\Field $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \AppBundle\Entity\Field
     */
    public function getField()
    {
        return $this->field;
    }
}
