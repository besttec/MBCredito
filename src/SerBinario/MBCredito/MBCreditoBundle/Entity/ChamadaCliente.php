<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChamadaCliente
 *
 * @ORM\Table(name="chamada_cliente", indexes={@ORM\Index(name="fk_chamada_cliente_status1_idx", columns={"status_id_status"}), @ORM\Index(name="fk_chamada_cliente_callcenter1_idx", columns={"callcenter_id_callcenter"}), @ORM\Index(name="fk_chamada_cliente_clientes1_idx", columns={"clientes_id_cliente"}), @ORM\Index(name="fk_chamada_cliente_subrotinas1_idx", columns={"subrotinas_id_subrotina"})})
 * @ORM\Entity
 */
class ChamadaCliente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_chamada_cliente", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idChamadaCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=false)
     */
    private $observacao;

    /**
     * @var \Status
     *
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_status", referencedColumnName="id_status")
     * })
     */
    private $statusStatus;

    /**
     * @var \Callcenter
     *
     * @ORM\ManyToOne(targetEntity="Callcenter")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="callcenter_id_callcenter", referencedColumnName="id_callcenter")
     * })
     */
    private $callcenterCallcenter;

    /**
     * @var \Clientes
     *
     * @ORM\ManyToOne(targetEntity="Clientes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientes_id_cliente", referencedColumnName="id_cliente")
     * })
     */
    private $clientesCliente;

    /**
     * @var \Subrotinas
     *
     * @ORM\ManyToOne(targetEntity="Subrotinas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subrotinas_id_subrotina", referencedColumnName="id_subrotina")
     * })
     */
    private $subrotinasSubrotina;



    /**
     * Get idChamadaCliente
     *
     * @return integer 
     */
    public function getIdChamadaCliente()
    {
        return $this->idChamadaCliente;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return ChamadaCliente
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get observacao
     *
     * @return string 
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set statusStatus
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Status $statusStatus
     * @return ChamadaCliente
     */
    public function setStatusStatus(\SerBinario\MBCredito\MBCreditoBundle\Entity\Status $statusStatus = null)
    {
        $this->statusStatus = $statusStatus;

        return $this;
    }

    /**
     * Get statusStatus
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Status 
     */
    public function getStatusStatus()
    {
        return $this->statusStatus;
    }

    /**
     * Set callcenterCallcenter
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Callcenter $callcenterCallcenter
     * @return ChamadaCliente
     */
    public function setCallcenterCallcenter(\SerBinario\MBCredito\MBCreditoBundle\Entity\Callcenter $callcenterCallcenter = null)
    {
        $this->callcenterCallcenter = $callcenterCallcenter;

        return $this;
    }

    /**
     * Get callcenterCallcenter
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Callcenter 
     */
    public function getCallcenterCallcenter()
    {
        return $this->callcenterCallcenter;
    }

    /**
     * Set clientesCliente
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes $clientesCliente
     * @return ChamadaCliente
     */
    public function setClientesCliente(\SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes $clientesCliente = null)
    {
        $this->clientesCliente = $clientesCliente;

        return $this;
    }

    /**
     * Get clientesCliente
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes 
     */
    public function getClientesCliente()
    {
        return $this->clientesCliente;
    }

    /**
     * Set subrotinasSubrotina
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Subrotinas $subrotinasSubrotina
     * @return ChamadaCliente
     */
    public function setSubrotinasSubrotina(\SerBinario\MBCredito\MBCreditoBundle\Entity\Subrotinas $subrotinasSubrotina = null)
    {
        $this->subrotinasSubrotina = $subrotinasSubrotina;

        return $this;
    }

    /**
     * Get subrotinasSubrotina
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Subrotinas 
     */
    public function getSubrotinasSubrotina()
    {
        return $this->subrotinasSubrotina;
    }
}
