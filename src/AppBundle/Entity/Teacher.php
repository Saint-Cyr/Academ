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
     * @ORM\OneToMany(targetEntity="AffectedProgram", mappedBy="teacher")
     */
    private $affectedPrograms;
    
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
     * @var string
     *
     * @ORM\Column(name="contractualized", type="boolean", nullable=true)
     */
    private $contractualized;

    /**
     * @var string
     *
     * @ORM\Column(name="age", type="integer", length=3, nullable=true)
     */
    private $age;
    
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

    public function isMainTeacher()
    {
        if(count($this->getMainTeachers()) !== 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function __toString() {
        if($this->name){
            return $this->name;
        }else{
            return 'New Teacher';
        };
    }
    
    /**
     * @deprecated since alpha1.2
     * 
     */
    public function setPrograms($programs)
    {
        if (count($programs) > 0) {
            foreach ($programs as $p) {
                $this->addProgram($p);
            }
        }

        return $this;
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
        $this->mainTeachers = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return Teacher
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
     * @return Teacher
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
     * @param string $firstName
     *
     * @return Teacher
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set adress.
     *
     * @param string $adress
     *
     * @return Teacher
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress.
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set sex.
     *
     * @param bool $sex
     *
     * @return Teacher
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex.
     *
     * @return bool
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set contractualized.
     *
     * @param bool $contractualized
     *
     * @return Teacher
     */
    public function setContractualized($contractualized)
    {
        $this->contractualized = $contractualized;

        return $this;
    }

    /**
     * Get contractualized.
     *
     * @return bool
     */
    public function getContractualized()
    {
        return $this->contractualized;
    }

    /**
     * Set age.
     *
     * @param int $age
     *
     * @return Teacher
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age.
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Add affectedProgram.
     *
     * @param \AppBundle\Entity\AffectedProgram $affectedProgram
     *
     * @return Teacher
     */
    public function addAffectedProgram(\AppBundle\Entity\AffectedProgram $affectedProgram)
    {
        $this->affectedPrograms[] = $affectedProgram;

        return $this;
    }

    /**
     * Remove affectedProgram.
     *
     * @param \AppBundle\Entity\AffectedProgram $affectedProgram
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAffectedProgram(\AppBundle\Entity\AffectedProgram $affectedProgram)
    {
        return $this->affectedPrograms->removeElement($affectedProgram);
    }

    /**
     * Get affectedPrograms.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAffectedPrograms()
    {
        return $this->affectedPrograms;
    }
}
