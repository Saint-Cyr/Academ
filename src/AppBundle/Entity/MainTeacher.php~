<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MainTeacher
 *
 * @ORM\Table(name="main_teacher")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MainTeacherRepository")
 */
class MainTeacher
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
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="mainTeachers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;


    /**
     * @ORM\OneToMany(targetEntity="Section", mappedBy="mainTeacher")
     */
    private $sections;

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
     * @return MainTeacher
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
        $this->sections = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set teacher
     *
     * @param \AppBundle\Entity\Teacher $teacher
     *
     * @return MainTeacher
     */
    public function setTeacher(\AppBundle\Entity\Teacher $teacher)
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
     * Add section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return MainTeacher
     */
    public function addSection(\AppBundle\Entity\Section $section)
    {
        $this->sections[] = $section;

        return $this;
    }

    /**
     * Remove section
     *
     * @param \AppBundle\Entity\Section $section
     */
    public function removeSection(\AppBundle\Entity\Section $section)
    {
        $this->sections->removeElement($section);
    }

    /**
     * Get sections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSections()
    {
        return $this->sections;
    }
}
