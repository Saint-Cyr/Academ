<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sequence
 *
 * @ORM\Table(name="sequence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SequenceRepository")
 */
class Sequence
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
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="sequence")
     */
    private $evaluations;

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
    
    public function __toString() {
        if($this->name){
            return $this->name;
        };
        
        return 'New Sequence';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Sequence
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
        $this->evaluations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return Sequence
     */
    public function addEvaluation(\AppBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluations[] = $evaluation;

        return $this;
    }

    /**
     * Remove evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     */
    public function removeEvaluation(\AppBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluations->removeElement($evaluation);
    }

    /**
     * Get evaluations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }
}
