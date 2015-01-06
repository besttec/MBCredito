<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChamadaCliente
 *
 * @ORM\Table(name="chamada_cliente", indexes={@ORM\Index(name="fk_chamada_cliente_status1_idx", columns={"status_id_status"}), @ORM\Index(name="fk_chamada_cliente_user1_idx", columns={"user_id_user"}), @ORM\Index(name="fk_chamada_cliente_clientes1_idx", columns={"clientes_id_cliente"}), @ORM\Index(name="fk_chamada_cliente_subrotinas1_idx", columns={"subrotinas_id_subrotina"})})
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
     * @var boolean
     *
     * @ORM\Column(name="status_pendencia", type="boolean", nullable=true)
     */
    private $statusPendencia;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="status_chamada", type="boolean", nullable=true)
     */
    private $statusChamada;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="data_chamada", type="datetime", nullable=true)
     */
    private $dataChamada;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="data_pendencia", type="datetime", nullable=false)
     */
    private $dataPendencia;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="SerBinario\MBCredito\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Clientes
     *
     * @ORM\ManyToOne(targetEntity="Clientes", inversedBy="chamadaCliente")
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
     * @param \SerBinario\MBCredito\UserBundle\Entity\User $user
     * @return ChamadaCliente
     */
    public function setUser(\SerBinario\MBCredito\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get callcenterCallcenter
     *
     * @return \SerBinario\MBCredito\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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
    
    /**
     * 
     * @return type
     */
    public function getStatusPendencia() 
    {
        return $this->statusPendencia;
    }

    /**
     * 
     * @param type $statusPendencia
     */
    public function setStatusPendencia($statusPendencia) 
    {
        $this->statusPendencia = $statusPendencia;
    }
    
    /**
     * 
     * @return type
     */
    public function getStatusChamada()
    {
        return $this->statusChamada;
    }

    /**
     * 
     * @param type $statusChamada
     */
    public function setStatusChamada($statusChamada) 
    {
        $this->statusChamada = $statusChamada;
    }
    
    /**
     * 
     * @return type
     */
    public function getDataChamada() 
    {
        return $this->dataChamada;
    }
    
    /**
     * 
     * @param type $dataChamada
     */
    public function setDataChamada($dataChamada) 
    {
        $this->dataChamada = $dataChamada;
    }
    
    /**
     * 
     * @return type
     */
    public function getDataPendencia() 
    {
        return $this->dataPendencia;
    }

    /**
     * 
     * @param type $dataPendencia
     */
    public function setDataPendencia($dataPendencia) 
    {
        $this->dataPendencia = $dataPendencia;
    }


}
