<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Program
 *
 * @ORM\Table(name="program")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgramRepository")
 */
class Program
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
     * @ORM\OneToMany(targetEntity="AffectedProgram", mappedBy="program")
     */
    private $affectedPrograms;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Coefficient", inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coefficient;
    
    /**
     * @var type 
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $field;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=true, length=255)
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
    
    public function __toString() {
        if($this->name){
            return $this->name." #".$this->getLevel();
        };
        
        return 'New Program';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Program
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
        $this->evaluations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set level
     *
     * @param \AppBundle\Entity\Level $level
     *
     * @return Program
     */
    public function setLevel(\AppBundle\Entity\Level $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \AppBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set coefficient
     *
     * @param \AppBundle\Entity\Coefficient $coefficient
     *
     * @return Program
     */
    public function setCoefficient(\AppBundle\Entity\Coefficient $coefficient = null)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return \AppBundle\Entity\Coefficient
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set field
     *
     * @param \AppBundle\Entity\Field $field
     *
     * @return Program
     */
    public function setField(\AppBundle\Entity\Field $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \AppBundle\Entity\Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Add affectedProgram.
     *
     * @param \AppBundle\Entity\AffectedProgram $affectedProgram
     *
     * @return Program
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
