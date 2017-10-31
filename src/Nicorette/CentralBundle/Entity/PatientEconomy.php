<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Accessor;

/**
 * PatientEconomy
 *
 * @ORM\Table(name="patient_economy")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\PatientEconomyRepository")
 * @ExclusionPolicy("all")
 */
class PatientEconomy
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="paquet_size", type="integer")
     * @Expose
     */
    private $paquetSize;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Expose
     */
    private $price;
    /**
     * @var Patient
     *
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="patientEconomys")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     * })
     */
    protected $patient;


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
     * Set paquetSize
     *
     * @param integer $paquetSize
     * @return PatientEconomy
     */
    public function setPaquetSize($paquetSize)
    {
        $this->paquetSize = $paquetSize;

        return $this;
    }

    /**
     * Get paquetSize
     *
     * @return integer 
     */
    public function getPaquetSize()
    {
        return $this->paquetSize;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return PatientEconomy
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param Patient $patient
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
    }

}
