<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table(name="absence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbsenceRepository")
 */
class Absence
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
     * @ORM\ManyToOne(targetEntity="AffectedProgram")
     * @ORM\JoinColumn(nullable=false)
     */
    private $affectedProgram;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="absences")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $student;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Absence
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set location.
     *
     * @param string|null $location
     *
     * @return Absence
     */
    public function setLocation($location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location.
     *
     * @return string|null
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set affectedProgram.
     *
     * @param \AppBundle\Entity\AffectedProgram $affectedProgram
     *
     * @return Absence
     */
    public function setAffectedProgram(\AppBundle\Entity\AffectedProgram $affectedProgram)
    {
        $this->affectedProgram = $affectedProgram;

        return $this;
    }

    /**
     * Get affectedProgram.
     *
     * @return \AppBundle\Entity\AffectedProgram
     */
    public function getAffectedProgram()
    {
        return $this->affectedProgram;
    }
}
