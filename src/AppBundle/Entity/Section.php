<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SectionRepository")
 */
class Section
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
     * @ORM\ManyToOne(targetEntity="MainTeacher", inversedBy="sections")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mainTeacher;
    
    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;


    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="section")
     */
    private $evaluations;
    
    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="section")
     */
    private $students;

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
     * @return the total value of all coefficients
     */
    public function getTotalCoefficient()
    {
        $coefValue = null;
        
        foreach ($this->getLevel()->getPrograms() as $program){
            if($program->getCoefficient()->getValue()){
                $coefValue = $coefValue + $program->getCoefficient()->getValue();
            }
        }
        
        return $coefValue;
    }
    
    /**
     * @return the total number of students for
     * the current section
     */
    public function getStudentNumber()
    {
        return count($this->getStudents());
    }
    
    public function __toString() {
        if($this->name){
            return $this->name;
        };
        
        //return 'New Section';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Section
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
        $this->evaluations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set mainTeacher
     *
     * @param \AppBundle\Entity\MainTeacher $mainTeacher
     *
     * @return Section
     */
    public function setMainTeacher(\AppBundle\Entity\MainTeacher $mainTeacher = null)
    {
        $this->mainTeacher = $mainTeacher;

        return $this;
    }

    /**
     * Get mainTeacher
     *
     * @return \AppBundle\Entity\MainTeacher
     */
    public function getMainTeacher()
    {
        return $this->mainTeacher;
    }

    /**
     * Add evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return Section
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
     * Add student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return Section
     */
    public function addStudent(\AppBundle\Entity\Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \AppBundle\Entity\Student $student
     */
    public function removeStudent(\AppBundle\Entity\Student $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Set level
     *
     * @param \AppBundle\Entity\Level $level
     *
     * @return Section
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
}
