<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="student")
     */
    private $marks;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=255, unique=true)
     */
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

    /**
     * Set barcode
     *
     * @param string $barcode
     *
     * @return Student
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }
}
