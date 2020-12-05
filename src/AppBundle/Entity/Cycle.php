<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cycle
 *
 * @ORM\Table(name="cycle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CycleRepository")
 */
class Cycle
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
     * @ORM\OneToMany(targetEntity="Level", mappedBy="cycle")
     */
    private $levels;

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
     * @return Cycle
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
    
    public function __toString() {
        if($this->name){
            return $this->name;
        }else{
            return 'New Level';
        };
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->levels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add level
     *
     * @param \AppBundle\Entity\Level $level
     *
     * @return Cycle
     */
    public function addLevel(\AppBundle\Entity\Level $level)
    {
        $this->levels[] = $level;

        return $this;
    }

    /**
     * Remove level
     *
     * @param \AppBundle\Entity\Level $level
     */
    public function removeLevel(\AppBundle\Entity\Level $level)
    {
        $this->levels->removeElement($level);
    }

    /**
     * Get levels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLevels()
    {
        return $this->levels;
    }
}
