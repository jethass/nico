<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=true)
     */
    protected $categoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    protected $picture;
    
    /**
     * @var string
     *
     * @ORM\Column(name="second_picture", type="string", length=255, nullable=true)
     */
    protected $secondPicture;
    
    /**
     * @var string
     *
     * @ORM\Column(name="poso_sup", type="text", nullable=true)
     */
    protected $posoSup;
    
    /**
     * @var string
     *
     * @ORM\Column(name="poso_inf", type="text", nullable=true)
     */
    protected $posoInf;
    
    /**
     * @var Choice
     *
     * @ORM\ManyToOne(targetEntity="Choice", inversedBy="products")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="choice_id", referencedColumnName="id")
     * })
     */
    protected $choice;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Set categoryName
     *
     * @param string $categoryName
     * @return Product
     */
    public function setCategoryName($categoryName)
    {
    	$this->categoryName = $categoryName;
    
    	return $this;
    }
    
    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
    	return $this->categoryName;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Product
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }
    
    /**
     * Set secondPicture
     *
     * @param string $secondPicture
     * @return Product
     */
    public function setSecondPicture($secondPicture)
    {
    	$this->secondPicture = $secondPicture;
    
    	return $this;
    }
    
    /**
     * Get secondPicture
     *
     * @return string
     */
    public function getSecondPicture()
    {
    	return $this->secondPicture;
    }
    
    /**
     * Set posoSup
     *
     * @param string $posoSup
     * @return Product
     */
    public function setPosoSup($posoSup)
    {
    	$this->posoSup = $posoSup;
    
    	return $this;
    }
    
    /**
     * Get posoSup
     *
     * @return string
     */
    public function getPosoSup()
    {
    	return $this->posoSup;
    }
    
    /**
     * Set posoInf
     *
     * @param string $posoInf
     * @return Product
     */
    public function setPosoInf($posoInf)
    {
    	$this->posoInf = $posoInf;
    
    	return $this;
    }
    
    /**
     * Get posoInf
     *
     * @return string
     */
    public function getPosoInf()
    {
    	return $this->posoInf;
    }
    
    /**
     * Set Choice
     *
     * @param Choice $choice
     * @return Product
     */
    public function setChoice($choice) {
    	$this->choice = $choice;
    	return $this;
    }
    
    /**
     * Get Choice
     *
     * @return string
     */
    public function getChoice() {
    	return $this->choice;
    }
}
