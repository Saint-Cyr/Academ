<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Program;
use AppBundle\Entity\Sequence;
use AppBundle\Entity\AffectedProgram;

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
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="student", cascade="remove")
     */
    private $marks;

    /**
     * @ORM\OneToMany(targetEntity="Absence", mappedBy="student", cascade="remove")
     */
    private $absences;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="frist_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="last_school_institution", type="string", length=255, nullable=true)
     */
    private $lastSchoolInstitution;

    /**
     * @var string
     *
     * @ORM\Column(name="leader", type="boolean", nullable=true)
     */
    private $leader;
    
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
    
    /**
     * return array() of marks for a given sequence
     * @param $markType can be 'devoir' or 'composition'
     */
    public function getMarksByAffectedProgramAndSequence(AffectedProgram $affectedProgram, Sequence $sequence, $markType)
    {
        //prepare the the variable to store all the marks
        $selectedMarks = [];
        //Set of marks provides by the affectedProgram
        $marksFromAffectedProgram = $affectedProgram->getMarksBySequence($sequence, $markType);
        foreach($this->getMarks() as $markFromStd){
            //Check wther this mark is part of the set provided by the affectedProgram marks
            foreach($marksFromAffectedProgram as $mFAP){
                if($markFromStd->getId() == $mFAP->getId()){
                    $selectedMarks [] = $mFAP;
                }
            }
        }

        return $selectedMarks;
    }
    
    public function getBarcodeValue()
    {
        return $this->getId()+10000;
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
    

    /**
     * Set leader.
     *
     * @param bool $leader
     *
     * @return Student
     */
    public function setLeader($leader)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * Get leader.
     *
     * @return bool
     */
    public function isLeader()
    {
        return $this->leader;
    }

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return Student
     */
    public function setFirstName($firstName = null)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set phoneNumber.
     *
     * @param string|null $phoneNumber
     *
     * @return Student
     */
    public function setPhoneNumber($phoneNumber = null)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set adress.
     *
     * @param string|null $adress
     *
     * @return Student
     */
    public function setAdress($adress = null)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress.
     *
     * @return string|null
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Student
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lastSchoolInstitution.
     *
     * @param string|null $lastSchoolInstitution
     *
     * @return Student
     */
    public function setLastSchoolInstitution($lastSchoolInstitution = null)
    {
        $this->lastSchoolInstitution = $lastSchoolInstitution;

        return $this;
    }

    /**
     * Get lastSchoolInstitution.
     *
     * @return string|null
     */
    public function getLastSchoolInstitution()
    {
        return $this->lastSchoolInstitution;
    }

    /**
     * Get leader.
     *
     * @return bool|null
     */
    public function getLeader()
    {
        return $this->leader;
    }
}
