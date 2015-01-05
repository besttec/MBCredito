<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Callcenter
 *
 * @ORM\Table(name="callcenter")
 * @ORM\Entity
 */
class Callcenter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_callcenter", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCallcenter;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_callcenter", type="string", length=45, nullable=false)
     */
    private $nomeCallcenter;

    /**
     * @var string
     *
     * @ORM\Column(name="num_pa_callcenter", type="string", length=10, nullable=true)
     */
    private $numPaCallcenter;



    /**
     * Get idCallcenter
     *
     * @return integer 
     */
    public function getIdCallcenter()
    {
        return $this->idCallcenter;
    }

    /**
     * Set nomeCallcenter
     *
     * @param string $nomeCallcenter
     * @return Callcenter
     */
    public function setNomeCallcenter($nomeCallcenter)
    {
        $this->nomeCallcenter = $nomeCallcenter;

        return $this;
    }

    /**
     * Get nomeCallcenter
     *
     * @return string 
     */
    public function getNomeCallcenter()
    {
        return $this->nomeCallcenter;
    }

    /**
     * Set numPaCallcenter
     *
     * @param string $numPaCallcenter
     * @return Callcenter
     */
    public function setNumPaCallcenter($numPaCallcenter)
    {
        $this->numPaCallcenter = $numPaCallcenter;

        return $this;
    }

    /**
     * Get numPaCallcenter
     *
     * @return string 
     */
    public function getNumPaCallcenter()
    {
        return $this->numPaCallcenter;
    }
}
