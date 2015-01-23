<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="status")
 * @ORM\Entity
 */
class Status
{
    /**
     * @var integer
     * 
     * @Assert\Type(type="integer", message="Valor informado para id do status é inválido")
     *
     * @ORM\Column(name="id_status", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStatus;

    /**
     * @var string
     *
     * @Assert\Length(max=45, maxMessage="Valor informado para do status 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var string
     * 
     * @Assert\Length(max=2, maxMessage="Valor informado para código do status 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="codigo", type="string", length=2, nullable=false)
     */
    private $codigo;



    /**
     * Get idStatus
     *
     * @return integer 
     */
    public function getIdStatus()
    {
        return $this->idStatus;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Status
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
}
