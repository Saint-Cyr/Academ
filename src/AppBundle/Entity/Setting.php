<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingRepository")
 */
class Setting
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var dateTime
     *
     * @ORM\Column(name="councilDate", type="datetime")
     */
    private $councilDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="schoolName", type="string", length=255, nullable=true)
     */
    private $schoolName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="academicYear", type="string", length=255, nullable=true)
     */
    private $academicYear;
    
    /**
     * @ORM\OneToOne(targetEntity="Sequence")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sequence;


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
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sequence
     *
     * @param \AppBundle\Entity\Sequence $sequence
     *
     * @return Setting
     */
    public function setSequence(\AppBundle\Entity\Sequence $sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return \AppBundle\Entity\Sequence
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Setting
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
     * Set schoolName
     *
     * @param string $schoolName
     *
     * @return Setting
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }

    /**
     * Set academicYear
     *
     * @param string $academicYear
     *
     * @return Setting
     */
    public function setAcademicYear($academicYear)
    {
        $this->academicYear = $academicYear;

        return $this;
    }

    /**
     * Get academicYear
     *
     * @return string
     */
    public function getAcademicYear()
    {
        return $this->academicYear;
    }

    /**
     * Set councilDate
     *
     * @param \DateTime $councilDate
     *
     * @return Setting
     */
    public function setCouncilDate($councilDate)
    {
        $this->councilDate = $councilDate;

        return $this;
    }

    /**
     * Get councilDate
     *
     * @return \DateTime
     */
    public function getCouncilDate()
    {
        return $this->councilDate;
    }
}
