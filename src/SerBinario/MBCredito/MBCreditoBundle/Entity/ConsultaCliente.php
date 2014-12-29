<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos;

/**
 * ConsultaCliente
 *
 * @ORM\Table(name="consulta_cliente")
 * @ORM\Entity
 */
class ConsultaCliente
{
    /**
     * @var string
     *
     * @ORM\Column(name="valor_bruto", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorBruto;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_descontos", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorDescontos;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_liquido", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorLiquido;

    /**
     * @var integer
     *
     * @ORM\Column(name="qtd_emprestimos", type="integer", nullable=true)
     */
    private $qtdEmprestimos;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_segurado", type="string", length=50, nullable=true)
     */
    private $nomeSegurado;

    /**
     * @var string
     *
     * @ORM\Column(name="competencia", type="string", nullable=true)
     */
    private $competencia;

    /**
     * @var string
     *
     * @ORM\Column(name="pagto_atravez", type="string", length=50, nullable=true)
     */
    private $pagtoAtravez;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="periodo_ini", type="date", nullable=true)
     */
    private $periodoIni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="periodo_fin", type="date", nullable=true)
     */
    private $periodoFin;

    /**
     * @var string
     *
     * @ORM\Column(name="especie", type="string", length=50, nullable=true)
     */
    private $especie;

    /**
     * @var string
     *
     * @ORM\Column(name="banco", type="string", length=50, nullable=true)
     */
    private $banco;

    /**
     * @var string
     *
     * @ORM\Column(name="agencia", type="string", length=50, nullable=true)
     */
    private $agencia;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_agencia", type="string", length=50, nullable=true)
     */
    private $codigoAgencia;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco_banco", type="string", length=50, nullable=true)
     */
    private $enderecoBanco;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="disponibilidade_ini", type="date", nullable=true)
     */
    private $disponibilidadeIni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="disponibilidade_fin", type="date", nullable=true)
     */
    private $disponibilidadeFin;

    /**
     * @var \Clientes
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Clientes", inversedBy="consultas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientes_id_cliente", referencedColumnName="id_cliente")
     * })
     */
    private $clientesCliente;
    
    /**
     * @ORM\OneToMany(targetEntity="Emprestimos", mappedBy="consultaClienteClientesCliente",  cascade={"persist", "remove"})
     **/
    private $emprestimos;

    /**
     * 
     */
    public function __construct() 
    {
        $this->emprestimos = new ArrayCollection();
    }

    /**
     * Set valorBruto
     *
     * @param string $valorBruto
     * @return ConsultaCliente
     */
    public function setValorBruto($valorBruto)
    {
        $this->valorBruto = $valorBruto;

        return $this;
    }

    /**
     * Get valorBruto
     *
     * @return string 
     */
    public function getValorBruto()
    {
        return $this->valorBruto;
    }

    /**
     * Set valorDescontos
     *
     * @param string $valorDescontos
     * @return ConsultaCliente
     */
    public function setValorDescontos($valorDescontos)
    {
        $this->valorDescontos = $valorDescontos;

        return $this;
    }

    /**
     * Get valorDescontos
     *
     * @return string 
     */
    public function getValorDescontos()
    {
        return $this->valorDescontos;
    }

    /**
     * Set valorLiquido
     *
     * @param string $valorLiquido
     * @return ConsultaCliente
     */
    public function setValorLiquido($valorLiquido)
    {
        $this->valorLiquido = $valorLiquido;

        return $this;
    }

    /**
     * Get valorLiquido
     *
     * @return string 
     */
    public function getValorLiquido()
    {
        return $this->valorLiquido;
    }

    /**
     * Set qtdEmprestimos
     *
     * @param integer $qtdEmprestimos
     * @return ConsultaCliente
     */
    public function setQtdEmprestimos($qtdEmprestimos)
    {
        $this->qtdEmprestimos = $qtdEmprestimos;

        return $this;
    }

    /**
     * Get qtdEmprestimos
     *
     * @return integer 
     */
    public function getQtdEmprestimos()
    {
        return $this->qtdEmprestimos;
    }

    /**
     * Set nomeSegurado
     *
     * @param string $nomeSegurado
     * @return ConsultaCliente
     */
    public function setNomeSegurado($nomeSegurado)
    {
        $this->nomeSegurado = $nomeSegurado;

        return $this;
    }

    /**
     * Get nomeSegurado
     *
     * @return string 
     */
    public function getNomeSegurado()
    {
        return $this->nomeSegurado;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return ConsultaCliente
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;

        return $this;
    }

    /**
     * Get competencia
     *
     * @return string 
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set pagtoAtravez
     *
     * @param string $pagtoAtravez
     * @return ConsultaCliente
     */
    public function setPagtoAtravez($pagtoAtravez)
    {
        $this->pagtoAtravez = $pagtoAtravez;

        return $this;
    }

    /**
     * Get pagtoAtravez
     *
     * @return string 
     */
    public function getPagtoAtravez()
    {
        return $this->pagtoAtravez;
    }

    /**
     * Set periodoIni
     *
     * @param \DateTime $periodoIni
     * @return ConsultaCliente
     */
    public function setPeriodoIni($periodoIni)
    {
        $this->periodoIni = $periodoIni;

        return $this;
    }

    /**
     * Get periodoIni
     *
     * @return \DateTime 
     */
    public function getPeriodoIni()
    {
        return $this->periodoIni;
    }

    /**
     * Set periodoFin
     *
     * @param \DateTime $periodoFin
     * @return ConsultaCliente
     */
    public function setPeriodoFin($periodoFin)
    {
        $this->periodoFin = $periodoFin;

        return $this;
    }

    /**
     * Get periodoFin
     *
     * @return \DateTime 
     */
    public function getPeriodoFin()
    {
        return $this->periodoFin;
    }

    /**
     * Set especie
     *
     * @param string $especie
     * @return ConsultaCliente
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;

        return $this;
    }

    /**
     * Get especie
     *
     * @return string 
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * Set banco
     *
     * @param string $banco
     * @return ConsultaCliente
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return string 
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set agencia
     *
     * @param string $agencia
     * @return ConsultaCliente
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;

        return $this;
    }

    /**
     * Get agencia
     *
     * @return string 
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * Set codigoAgencia
     *
     * @param string $codigoAgencia
     * @return ConsultaCliente
     */
    public function setCodigoAgencia($codigoAgencia)
    {
        $this->codigoAgencia = $codigoAgencia;

        return $this;
    }

    /**
     * Get codigoAgencia
     *
     * @return string 
     */
    public function getCodigoAgencia()
    {
        return $this->codigoAgencia;
    }

    /**
     * Set enderecoBanco
     *
     * @param string $enderecoBanco
     * @return ConsultaCliente
     */
    public function setEnderecoBanco($enderecoBanco)
    {
        $this->enderecoBanco = $enderecoBanco;

        return $this;
    }

    /**
     * Get enderecoBanco
     *
     * @return string 
     */
    public function getEnderecoBanco()
    {
        return $this->enderecoBanco;
    }

    /**
     * Set disponibilidadeIni
     *
     * @param \DateTime $disponibilidadeIni
     * @return ConsultaCliente
     */
    public function setDisponibilidadeIni($disponibilidadeIni)
    {
        $this->disponibilidadeIni = $disponibilidadeIni;

        return $this;
    }

    /**
     * Get disponibilidadeIni
     *
     * @return \DateTime 
     */
    public function getDisponibilidadeIni()
    {
        return $this->disponibilidadeIni;
    }

    /**
     * Set disponibilidadeFin
     *
     * @param \DateTime $disponibilidadeFin
     * @return ConsultaCliente
     */
    public function setDisponibilidadeFin($disponibilidadeFin)
    {
        $this->disponibilidadeFin = $disponibilidadeFin;

        return $this;
    }

    /**
     * Get disponibilidadeFin
     *
     * @return \DateTime 
     */
    public function getDisponibilidadeFin()
    {
        return $this->disponibilidadeFin;
    }

    /**
     * Set clientesCliente
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes $clientesCliente
     * @return ConsultaCliente
     */
    public function setClientesCliente(\SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes $clientesCliente)
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
     * 
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos $emprestimo
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function addEmprestimo(Emprestimos $emprestimo)
    {
        $this->emprestimos[] = $emprestimo;
        $emprestimo->setConsultaClienteClientesCliente($this);
        
        return $this;
    }
    
    
    /**
     * 
     * @return type
     */
    public function getEmprestimos() 
    {
        return $this->emprestimos;
    }

    /**
     * 
     * @param type $emprestimos
     */
    public function setEmprestimos($emprestimos) 
    {
        $this->emprestimos = $emprestimos;
    }

}
