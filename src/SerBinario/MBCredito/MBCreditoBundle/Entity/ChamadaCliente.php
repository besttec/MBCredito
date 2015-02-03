<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * ChamadaCliente
 *
 * @ORM\Table(name="chamada_cliente", indexes={@ORM\Index(name="fk_chamada_cliente_status1_idx", columns={"status_id_status"}), @ORM\Index(name="fk_chamada_cliente_user1_idx", columns={"user_id_user"}), @ORM\Index(name="fk_chamada_cliente_subrotinas1_idx", columns={"subrotinas_id_subrotina"})})
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
     * @Assert\Type(type="bool", message="Valor inválido para status da pendência")
     * 
     * @ORM\Column(name="status_pendencia", type="boolean", nullable=true)
     */
    private $statusPendencia;
    
    /**
     * @var boolean
     *
     * @Assert\Type(type="bool", message="Valor inválido para status da chamada")
     * 
     * @ORM\Column(name="status_chamada", type="boolean", nullable=true)
     */
    private $statusChamada;
    
    /**
     * @var string
     *
     * @Assert\Type(type="string", message="Valor inválido para novo ddd da chamada")
     * 
     * @ORM\Column(name="novo_ddd", type="string", length=3, nullable=true)
     */
    private $novoDDD;
    
    /**
     * @var string
     *
     * @Assert\Type(type="string", message="Valor inválido para novo fone da chamada")
     * 
     * @ORM\Column(name="novo_fone", type="string", length=8, nullable=true)
     */
    private $novoFone;
    
    /**
     * @var datetime
     * 
     * @Assert\DateTime(message="Valor inválido para Data da Chamada")
     *
     * @ORM\Column(name="data_chamada", type="datetime", nullable=true)
     */
    private $dataChamada;
    
    /**
     * @var datetime
     *
     * @Assert\DateTime(message="Valor inválido para Data da Pendência")
     * 
     * @ORM\Column(name="data_pendencia", type="datetime", nullable=false)
     */
    private $dataPendencia;

    /**
     * @var string
     *
     * @Assert\Length( max=65535, maxMessage="Valor ultrapassa o limete de caracteres em Observação")
     * 
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
     */
    private $observacao;

    /**
     * @var \Status
     * 
     * @Assert\Type(type="object", message="Valor informado para Status não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_status", referencedColumnName="id_status")
     * })
     */
    private $statusStatus;

    /**
     * @var \User
     *
     * @Assert\NotNull(message="Usuário não informado")
     * @Assert\Type(type="object", message="Valor informado para User não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="SerBinario\MBCredito\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \ConsultaClientes
     * 
     * @Assert\NotNull(message="ConsultaCliente não informado")
     * @Assert\Type(type="object", message="Valor informado para ConsultaCliente não é um objeto")
     *
     * @ORM\ManyToOne(targetEntity="ConsultaCliente", inversedBy="chamadaCliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_onsulta_cliente", referencedColumnName="id")
     * })
     */
    private $consultaCliente;

    /**
     * @var \Subrotinas
     * 
     * @Assert\Type(type="object", message="Valor informado para SubRotinas não é um objeto")
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
    
    /**
     * 
     * @return type
     */
    public function getNovoDDD() 
    {
        return $this->novoDDD;
    }
    
    /**
     * 
     * @return type
     */
    public function getNovoFone() 
    {
        return $this->novoFone;
    }
    
    /**
     * 
     * @param type $novoDDD
     */
    public function setNovoDDD($novoDDD) 
    {
        $this->novoDDD = $novoDDD;
    }

    /**
     * 
     * @param type $novoFone
     */
    public function setNovoFone($novoFone) 
    {
        $this->novoFone = $novoFone;
    }

    /**
     * 
     * @return type
     */
    public function getConsultaCliente() 
    {
        return $this->consultaCliente;
    }

    /**
     * 
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setConsultaCliente(\SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consultaCliente) 
    {
        $this->consultaCliente = $consultaCliente;
    }


}
