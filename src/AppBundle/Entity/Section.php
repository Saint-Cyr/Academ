<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SectionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Section
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
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="collected_image", type="string", length=255, unique=false, nullable=true)
     */
    private $collectedImage;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="collected_image_updated", type="boolean", unique=false, nullable=true)
     */
    private $collectedImageUpdated;

    /**
    * Get file.
    *
    * @return UploadedFile
    */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function lifecycleFileUpload()
    {   
        $this->upload();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function refreshUpdated()
    {
        if($this->getFile()){
            $this->setCollectedImageUpdated(true);
            $this->setCollectedImage($this->getName().'.'.$this->getFile()->guessExtension());
        }
        
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUPdate()
    {
        //Check whether the file exists first
        if (file_exists(getcwd().'/upload/section/'.$this->getImage())){
            //Remove it
            @unlink(getcwd().'/upload/section/'.$this->getImage());
            
        }
        
        return;
    }
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        
        // move takes the target directory and target filename as params
        $this->getFile()->move(getcwd().'/upload/section', $this->getName().'.csv');
        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }
    
    /**
    * Sets file.
    *
    * @param UploadedFile $file
    */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        if((substr($this->image, -4) == 'jpeg')||(substr($this->image, -3) == 'jpg')||(substr($this->image, -3) == 'png')){
            return $this->getId().'.'.$this->image;
        }else{
            return null;
        }
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Section
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Set collectedImage
     *
     * @param string $collectedImage
     *
     * @return Person
     */
    public function setCollectedImage($collectedImage)
    {
        $this->collectedImage = $collectedImage;

        return $this;
    }

    /**
     * Get collectedImage
     *
     * @return string
     */
    public function getCollectedImage()
    {
        return $this->collectedImage;
        
    }

    /**
     * Set collectedImageUpdated
     *
     * @param boolean $collectedImageUpdated
     *
     * @return Person
     */
    public function setCollectedImageUpdated($collectedImageUpdated)
    {
        $this->collectedImageUpdated = $collectedImageUpdated;

        return $this;
    }

    /**
     * Get collectedImageUpdated
     *
     * @return boolean
     */
    public function isCollectedImageUpdated()
    {
        return $this->collectedImageUpdated;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, unique=false, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="MainTeacher", inversedBy="sections")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mainTeacher;
    
    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;


    /**
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="section")
     */
    private $evaluations;
    
    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="section")
     */
    private $students;

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
     * @return the total value of all coefficients
     */
    public function getTotalCoefficient()
    {
        $coefValue = null;
        
        foreach ($this->getLevel()->getPrograms() as $program){
            if($program->getCoefficient()->getValue()){
                $coefValue = $coefValue + $program->getCoefficient()->getValue();
            }
        }
        
        return $coefValue;
    }

    /**
     * @return the student leader (delegue) for the current Section
     */
    public function getStudentLeader()
    {
        $studentLeaderName = null;
        foreach($this->getStudents() as $std)
        {
            if($std->isLeader()){
                $studentLeaderName = $std->getname();
            }
        }

        return $studentLeaderName;
    }
    
    /**
     * @return the total number of students for
     * the current section
     */
    public function getStudentNumber()
    {
        return count($this->getStudents());
    }
    
    public function __toString() {
        if($this->name){
            return $this->name;
        }else{
            return 'New Section';
        }
        
        //return 'New Section';
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Section
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
     * Set mainTeacher
     *
     * @param \AppBundle\Entity\MainTeacher $mainTeacher
     *
     * @return Section
     */
    public function setMainTeacher(\AppBundle\Entity\MainTeacher $mainTeacher = null)
    {
        $this->mainTeacher = $mainTeacher;

        return $this;
    }

    /**
     * Get mainTeacher
     *
     * @return \AppBundle\Entity\MainTeacher
     */
    public function getMainTeacher()
    {
        return $this->mainTeacher;
    }

    /**
     * Add evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return Section
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

    /**
     * Add student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return Section
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
     * Set level
     *
     * @param \AppBundle\Entity\Level $level
     *
     * @return Section
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
}
