<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentParent
 *
 * @ORM\Table(name="student_parent")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentParentRepository")
 */
class StudentParent
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
     * @ORM\OneToMany(targetEntity="Student", mappedBy="studentParent")
     */
    private $students;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="fristName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="boolean", nullable=true)
     */
    private $sex;


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
     * @return StudentParent
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

    public function __toString()
    {
        return $this->name;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return StudentParent
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
     * Set profession.
     *
     * @param string $profession
     *
     * @return StudentParent
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession.
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return StudentParent
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return StudentParent
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return StudentParent
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
     * Set adress.
     *
     * @param string|null $adress
     *
     * @return StudentParent
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
     * Set sex.
     *
     * @param bool|null $sex
     *
     * @return StudentParent
     */
    public function setSex($sex = null)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex.
     *
     * @return bool|null
     */
    public function getSex()
    {
        return $this->sex;
    }
}
