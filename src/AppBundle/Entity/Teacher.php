<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 *
 * @ORM\Table(name="teacher")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeacherRepository")
 */
class Teacher
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
     * @ORM\OneToMany(targetEntity="Program", mappedBy="teacher")
     */
    private $programs;
    
    /**
     * @ORM\OneToMany(targetEntity="MainTeacher", mappedBy="teacher")
     */
    private $mainTeachers;

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

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Teacher
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
     * Set barcode
     *
     * @param string $barcode
     *
     * @return Teacher
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
   
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->programs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mainTeachers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add program
     *
     * @param \AppBundle\Entity\Program $program
     *
     * @return Teacher
     */
    public function addProgram(\AppBundle\Entity\Program $program)
    {
        $this->programs[] = $program;

        return $this;
    }

    /**
     * Remove program
     *
     * @param \AppBundle\Entity\Program $program
     */
    public function removeProgram(\AppBundle\Entity\Program $program)
    {
        $this->programs->removeElement($program);
    }

    /**
     * Get programs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrograms()
    {
        return $this->programs;
    }

    /**
     * Add mainTeacher
     *
     * @param \AppBundle\Entity\MainTeacher $mainTeacher
     *
     * @return Teacher
     */
    public function addMainTeacher(\AppBundle\Entity\MainTeacher $mainTeacher)
    {
        $this->mainTeachers[] = $mainTeacher;

        return $this;
    }

    /**
     * Remove mainTeacher
     *
     * @param \AppBundle\Entity\MainTeacher $mainTeacher
     */
    public function removeMainTeacher(\AppBundle\Entity\MainTeacher $mainTeacher)
    {
        $this->mainTeachers->removeElement($mainTeacher);
    }

    /**
     * Get mainTeachers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMainTeachers()
    {
        return $this->mainTeachers;
    }
}
