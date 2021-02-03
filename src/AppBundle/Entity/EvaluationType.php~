<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluationType
 *
 * @ORM\Table(name="evaluation_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvaluationTypeRepository")
 */
class EvaluationType
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
        
        return 'New EvaluationType';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EvaluationType
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
}
