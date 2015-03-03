<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * SuperEstadual
 *
 * @ORM\Table(name="super_estadual")
 * @ORM\Entity
 */
class SuperEstadual
{
    /**
     * @var integer
     *
     * @Assert\Type(type="integer", message="Valor informado para id de SuperEstadual é inválido")
     * 
     * @ORM\Column(name="id_super_estadual", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSuperEstadual;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Valor de código de SuperEstadual não informado")
     * @Assert\Length(max=10, maxMessage="Valor informado para código SuperEstadual 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="cod_super_estadual", type="string", length=10, nullable=false)
     */
    private $codSuperEstadual;

    /**
     * @var string
     *
     * @Assert\Length(max=50, maxMessage="Valor informado para nome SuperEstadual 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="nome_super_estadual", type="string", length=50, nullable=true)
     */
    private $nomeSuperEstadual;

    /**
     * Get idSuperEstadual
     *
     * @return integer 
     */
    public function getIdSuperEstadual()
    {
        return $this->idSuperEstadual;
    }

    /**
     * Set codSuperEstadual
     *
     * @param string $codSuperEstadual
     * @return SuperEstadual
     */
    public function setCodSuperEstadual($codSuperEstadual)
    {
        $this->codSuperEstadual = $codSuperEstadual;

        return $this;
    }

    /**
     * Get codSuperEstadual
     *
     * @return string 
     */
    public function getCodSuperEstadual()
    {
        return $this->codSuperEstadual;
    }

    /**
     * Set nomeSuperEstadual
     *
     * @param string $nomeSuperEstadual
     * @return SuperEstadual
     */
    public function setNomeSuperEstadual($nomeSuperEstadual)
    {
        $this->nomeSuperEstadual = $nomeSuperEstadual;

        return $this;
    }

    /**
     * Get nomeSuperEstadual
     *
     * @return string 
     */
    public function getNomeSuperEstadual()
    {
        return $this->nomeSuperEstadual;
    }

    /**
     * Set uf
     *
     * @param string $uf
     * @return SuperEstadual
     */
    public function setUf($uf)
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get uf
     *
     * @return string 
     */
    public function getUf()
    {
        return $this->uf;
    }
}
