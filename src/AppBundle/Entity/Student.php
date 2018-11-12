<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Program as Program;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student
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
     * @ORM\ManyToOne(targetEntity="StudentParent", inversedBy="students")
     * @ORM\JoinColumn(nullable=true)
     */
    private $studentParent;
    
    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="students")
     * @ORM\JoinColumn(nullable=true)
     */
    private $section;
    
    /**
     * @ORM\OneToMany(targetEntity="AbsenceCompter", mappedBy="student")
     */
    private $absenceCompters;
    
    /**
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="student", cascade="remove")
     */
    private $marks;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    private $barcode;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getBarcodeValue()
    {
        return str_pad($this->getId(),5,"0",STR_PAD_LEFT);
    }
    
    public function __toString() {
        
        if($this->name){
            return $this->name;
        }
        
        return 'New Student';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Student
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
    }

    /**
     * Set studentParent
     *
     * @param \AppBundle\Entity\StudentParent $studentParent
     *
     * @return Student
     */
    public function setStudentParent(\AppBundle\Entity\StudentParent $studentParent = null)
    {
        $this->studentParent = $studentParent;

        return $this;
    }

    /**
     * Get studentParent
     *
     * @return \AppBundle\Entity\StudentParent
     */
    public function getStudentParent()
    {
        return $this->studentParent;
    }

    /**
     * Add absenceCompter
     *
     * @param \AppBundle\Entity\AbsenceCompter $absenceCompter
     *
     * @return Student
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
     * Set section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Student
     */
    public function setSection(\AppBundle\Entity\Section $section = null)
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

    /**
     * Add mark
     *
     * @param \AppBundle\Entity\Mark $mark
     *
     * @return Student
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

   
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    
    public function getBarcode()
    {
        return $this->barcode;
    }
    
    /*
     * @deprecated since 0.5.1
     * This method suppose to get only marks
     *  for the current student that are related to a given
     * Sequence and a given program
     * 
     */
    public function getMarksBySequenceByProgram(Sequence $sequence, Program $program)
    {
        //Prepare a tab to store filtered marks
        $marksTab = array();
        //Filter marks by theire sequence: going firstly by Evaluation
        //and then by sequence
        foreach ($this->getMarks() as $mark){
            //Make sure the current mark is related to $sequence
            if($mark->getEvaluation()->getSequence()->getId() == $sequence->getId()
                    && 
                $mark->getEvaluation()->getProgram()->getId() == $program->getId()){
                
                $marksTab[] = $mark;
            }
        }
        
        return $marksTab;
    }
}
