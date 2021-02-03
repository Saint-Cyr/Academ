<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Coefficient
 *
 * @ORM\Table(name="coefficient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoefficientRepository")
 * @UniqueEntity(
 *     fields={"value"},
 *     message="This value is already in use."
 * )
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
     * @ORM\OneToMany(targetEntity="Program", mappedBy="coefficient", cascade={"persist"}, orphanRemoval=true)
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
    
    public function __toString() {
        
        if($this->value){
            return 'Coefficient: '.$this->value;
        }else{
            return 'New Coefficient';
        }
        
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
     * Add program
     *
     * @param \AppBundle\Entity\Program $program
     *
     * @return Coefficient
     */
    public function addProgram(\AppBundle\Entity\Program $program)
    {
        $program->setCoefficient($this);
        $this->programs->add($program);
        //$this->programs[] = $program;

        //return $this;
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
