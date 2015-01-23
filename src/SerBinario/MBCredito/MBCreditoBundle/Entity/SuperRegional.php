<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * SuperRegional
 *
 * @ORM\Table(name="super_regional")
 * @ORM\Entity
 */
class SuperRegional
{
    /**
     * @var integer
     *
     * @Assert\Type(type="integer", message="Valor informado para id de SeperRegional é inválido")
     * 
     * @ORM\Column(name="id_super_regional", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSuperRegional;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Valor de código de SuperRegional não informado")
     * @Assert\Length(max=10, maxMessage="Valor informado para código SuperRegional 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="cod_super_regional", type="string", length=10, nullable=false)
     */
    private $codSuperRegional;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Valor de nome de SuperRegional não informado")
     * @Assert\Length(max=10, maxMessage="Valor informado para nome SuperRegional 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="nome_super_regional", type="string", length=50, nullable=false)
     */
    private $nomeSuperRegional;



    /**
     * Get idSuperRegional
     *
     * @return integer 
     */
    public function getIdSuperRegional()
    {
        return $this->idSuperRegional;
    }

    /**
     * Set codSuperRegional
     *
     * @param string $codSuperRegional
     * @return SuperRegional
     */
    public function setCodSuperRegional($codSuperRegional)
    {
        $this->codSuperRegional = $codSuperRegional;

        return $this;
    }

    /**
     * Get codSuperRegional
     *
     * @return string 
     */
    public function getCodSuperRegional()
    {
        return $this->codSuperRegional;
    }

    /**
     * Set nomeSuperRegional
     *
     * @param string $nomeSuperRegional
     * @return SuperRegional
     */
    public function setNomeSuperRegional($nomeSuperRegional)
    {
        $this->nomeSuperRegional = $nomeSuperRegional;

        return $this;
    }

    /**
     * Get nomeSuperRegional
     *
     * @return string 
     */
    public function getNomeSuperRegional()
    {
        return $this->nomeSuperRegional;
    }
}
