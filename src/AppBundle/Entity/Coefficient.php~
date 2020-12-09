<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coefficient
 *
 * @ORM\Table(name="coefficient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoefficientRepository")
 */
class Coefficient
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
     * @ORM\OneToMany(targetEntity="Program", mappedBy="coefficient")
     */
    private $programs;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;


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
     * Set value
     *
     * @param integer $value
     *
     * @return Coefficient
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->programs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add program
     *
     * @param \AppBundle\Entity\Program $program
     *
     * @return Coefficient
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
}
