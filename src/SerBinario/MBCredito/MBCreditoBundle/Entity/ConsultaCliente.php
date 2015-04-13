<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Antecipacao13;

/**
 * ConsultaCliente
 *
 * @ORM\Table(name="consulta_cliente")
 * @ORM\Entity
 */
class ConsultaCliente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var decimal
     * 
     * @Assert\Type(type="double", message="Valor informado para valor bruto é inválido")
     *
     * @ORM\Column(name="valor_bruto", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorBruto;

    /**
     * @var decimal
     *
     * @Assert\Type(type="double", message="Valor informado para valor de desconto é inválido")
     * 
     * @ORM\Column(name="valor_descontos", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorDescontos;

    /**
     * @var double
     * 
     * @Assert\Type(type="double", message="Valor informado para valor liquido é inválido")
     *
     * @ORM\Column(name="valor_liquido", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorLiquido;

    /**
     * @var integer
     * 
     * @Assert\Type(type="integer", message="Valor informado para qunatidade de emprestimos é inválido")
     *
     * @ORM\Column(name="qtd_emprestimos", type="integer", nullable=true)
     */
    private $qtdEmprestimos;

    /**
     * @var string
     *
     * @Assert\Length(max=50, maxMessage="Valor informado para nome do segurado
     * ultrapassa a quantidade máxima de caracteres permitidas")
     * @Assert\Type(type="string", message="Valor informado para nome do segurado é inválido")
     * 
     * @ORM\Column(name="nome_segurado", type="string", length=50, nullable=true)
     */
    private $nomeSegurado;

    /**
     * @var string
     *
     * @Assert\Length(max=30, maxMessage="Valor informado para nome do segurado
     * ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="competencia", type="string", length=30, nullable=true)
     */
    private $competencia;

    /**
     * @var string
     *
     * @Assert\Length(max=50, maxMessage="Valor informado para pagamento atravez
     * ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="pagto_atravez", type="string", length=50, nullable=true)
     */
    private $pagtoAtravez;

    /**
     * @var \DateTime
     *
     * @Assert\Date(message="Valor informado para o período inicial é inválido")
     * 
     * @ORM\Column(name="periodo_ini", type="date", nullable=true)
     */
    private $periodoIni;

    /**
     * @var \DateTime
     *
     * @Assert\Date(message="Valor informado para o período final é inválido")
     * 
     * @ORM\Column(name="periodo_fin", type="date", nullable=true)
     */
    private $periodoFin;
    
    /**
     * @var \DateTime
     *
     * @Assert\Date(message="Valor informado para o data da consulta é inválido")
     * 
     * @ORM\Column(name="data_consulta", type="date", nullable=true)
     */
    private $dataConsulta;

    /**
     * @var string
     *
     * @Assert\Length(max=50, maxMessage="Valor informado para espécie
     * ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="especie", type="string", length=50, nullable=true)
     */
    private $especie;

    /**
     * @var string
     * 
     * @Assert\Length(max=50, maxMessage="Valor informado para banco
     * ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="banco", type="string", length=50, nullable=true)
     */
    private $banco;

    /**
     * @var string
     *
     * @Assert\Length(max=50, maxMessage="Valor informado para agência
     * ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="agencia", type="string", length=50, nullable=true)
     */
    private $agencia;

    /**
     * @var string
     * 
     * @Assert\Length(max=50, maxMessage="Valor informado para código agência
     * ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="codigo_agencia", type="string", length=50, nullable=true)
     */
    private $codigoAgencia;

    /**
     * @var string
     * 
     * @Assert\Length(max=50, maxMessage="Valor informado para endereço do banco
     * ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="endereco_banco", type="string", length=50, nullable=true)
     */
    private $enderecoBanco;

    /**
     * @var \DateTime
     * 
     * @Assert\Date(message="Valor informado para disponibilidade inicial é inválido")
     *
     * @ORM\Column(name="disponibilidade_ini", type="date", nullable=true)
     */
    private $disponibilidadeIni;

    /**
     * @var \DateTime
     *
     * @Assert\Date(message="Valor informado para disponibilidade final é inválido")
     * 
     * @ORM\Column(name="disponibilidade_fin", type="date", nullable=true)
     */
    private $disponibilidadeFin;
    
    /**
     * @var string
     *
     * @Assert\Length(max=65535, maxMessage="Valor informado para observação do cliente
     * ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="obs_cliente", type="text", length=65535, nullable=true)
     */
    private $obsCliente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="margem_cliente", type="string", length=100, nullable=true)
     */
    private $margemCliente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="valor_disponivel_cliente", type="string", length=100, nullable=true)
     */
    private $valorDisponivelCliente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_credito_cliente", type="string", length=1, nullable=true)
     */
    private $tipoCreditoCliente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo_credito_consignado", type="string", length=1, nullable=true)
     */
    private $tipoCreditoConsignado;
    
     /**
     * @var boolean
     *
     * @Assert\Type(type="bool", message="Valor informado para status de ligação do cliente é inválido")
     * 
     * @ORM\Column(name="status_ligacao_cliente", type="boolean", nullable=true, options={"comment":"Define o status em caso de disponível"})
     */
    private $statusLigacao;
    
    /**
     * @var boolean
     *
     * @Assert\Type(type="bool", message="Valor informado para status da consulta do cliente é inválido")
     * 
     * @ORM\Column(name="status_consulta", type="boolean", nullable=true)
     */
    private $statusConsulta;
    
    /**
     * @var boolean
     *
     * @Assert\Type(type="bool", message="Valor informado para status de data de validade do cliente é inválido")
     * 
     * @ORM\Column(name="status_validade_consulta", type="boolean", nullable=true, options={"comment":"Define o status em caso de disponível"})
     */
    private $statusPendencia;
    
    /**
     * @var boolean
     *
     * @Assert\Type(type="bool", message="Valor informado para status da consulta do cliente é inválido")
     * 
     * @ORM\Column(name="status_arquivo_retorno", type="boolean", nullable=true)
     */
    private $statusGerarArquiRetorno;
    
    /**
     * @var boolean
     * 
     * @Assert\Type(type="bool", message="Valor informado para status de erro da consulta é inválido")
     *
     * @ORM\Column(name="status_erro_consulta", type="boolean", nullable=true, options={"comment":"Define o status em caso de erro ao consultar o cliente"})
     */
    private $statusErro;
    
    /**
     * @var String
     *
     * @Assert\Length(max=65535, maxMessage="Valor informado para observação de erro
     *  do cliente ultrapassa a quantidade máxima de caracteres permitida")
     * 
     * @ORM\Column(name="obs_erro_consulta", type="text", length=65535, nullable=true)
     */
    private $obsErro;

    /**
     * @var \Clientes
     *
     * @Assert\Type(type="objeto", message="O valor informado para Clientes não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="Clientes", inversedBy="consultas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientes_id_cliente", referencedColumnName="id_cliente")
     * })
     */
    private $clientesCliente;
    
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
     * @ORM\OneToMany(targetEntity="ChamadaCliente", mappedBy="consultaCliente")
     **/
    private $chamadasCliente;
    
    /**
     * @ORM\OneToMany(targetEntity="Emprestimos", mappedBy="consultaClienteClientesCliente",  cascade={"persist", "remove"})
     **/
    private $emprestimos;
    
    /**
     * @ORM\OneToMany(targetEntity="Antecipacao13", mappedBy="consulta", cascade={"all"})
     */
    private $antecipacoes13;

    /**
     * 
     */
    public function __construct() 
    {
        $this->emprestimos    = new ArrayCollection();
        $this->antecipacoes13 = new ArrayCollection();
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
    
    /**
     * 
     * @param type $obsCliente
     */
    public function setObsCliente($obsCliente) 
    {
        $this->obsCliente = $obsCliente;
    }
    
     /**
     * 
     * @return type
     */
    public function getObsCliente() 
    {
        return $this->obsCliente;
    }


    /**
     * Remove emprestimos
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos $emprestimos
     */
    public function removeEmprestimo(\SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos $emprestimos)
    {
        $this->emprestimos->removeElement($emprestimos);
    }
    
    /**
     * 
     * @return type
     */
    public function getId() 
    {
        return $this->id;
    }
    
    /**
     * 
     * @param type $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }
    
    /**
     * 
     * @return type
     */
    public function getMargemCliente() 
    {
        return $this->margemCliente;
    }
    
    /**
     * 
     * @return type
     */
    function getValorDisponivelCliente() {
        return $this->valorDisponivelCliente;
    }
    
    /**
     * 
     * @return type
     */
    public function getTipoCreditoCliente() 
    {
        return $this->tipoCreditoCliente;
    }
    
    /**
     * 
     * @param type $margemCliente
     */
    public function setMargemCliente($margemCliente) 
    {
        $this->margemCliente = $margemCliente;
    }
    
    /**
     * 
     * @param type $valorDisponivelCliente
     */
    public function setValorDisponivelCliente($valorDisponivelCliente) 
    {
        $this->valorDisponivelCliente = $valorDisponivelCliente;
    }
    
    /**
     * 
     * @param type $tipoCreditoCliente
     * 
     */
    public function setTipoCreditoCliente($tipoCreditoCliente) 
    {
        $this->tipoCreditoCliente = $tipoCreditoCliente;
    }

    /**
     * 
     * @return type
     */
    public function getChamadasCliente() 
    {
        return $this->chamadasCliente;
    }

    /**
     * 
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente $chamadasCliente
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setChamadasCliente(\SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente $chamadasCliente)
    {
        $this->chamadasCliente = $chamadasCliente;
        return $this;
    }
    
    /**
     * 
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente $chamadasCliente
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function addChamada(\SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente $chamadasCliente)
    {       
        $chamadasCliente->setConsultaCliente($this);
        
        $this->chamadasCliente[] = $chamadasCliente;        
        
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getStatusLigacao() 
    {
        return $this->statusLigacao;
    }

    /**
     * 
     * @return type
     */
    public function getStatusConsulta() 
    {
        return $this->statusConsulta;
    }

    /**
     * 
     * @param type $statusLigacao
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setStatusLigacao($statusLigacao) 
    {
        $this->statusLigacao = $statusLigacao;
        
        return $this;
    }

    /**
     * 
     * @param type $statusConsulta
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setStatusConsulta($statusConsulta) 
    {
        $this->statusConsulta = $statusConsulta;
        
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getStatusErro() 
    {
        return $this->statusErro;
    }
    
    /**
     * 
     * @return type
     */
    public function getObsErro() 
    {
        return $this->obsErro;
    }
    
    /**
     * 
     * @param type $statusErro
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setStatusErro($statusErro) 
    {
        $this->statusErro = $statusErro;
        
        return $this;
    }

    /**
     * 
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\String $obsErro
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setObsErro($obsErro) 
    {
        $this->obsErro = $obsErro;
        
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    function getTipoCreditoConsignado() {
        return $this->tipoCreditoConsignado;
    }
    
    /**
     * 
     * @param type $tipoCreditoConsignado
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    function setTipoCreditoConsignado($tipoCreditoConsignado) {
        $this->tipoCreditoConsignado = $tipoCreditoConsignado;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getStatusGerarArquiRetorno()
    {
        return $this->statusGerarArquiRetorno;
    }
    
    /**
     * 
     * @param type $statusGerarArquiRetorno
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setStatusGerarArquiRetorno($statusGerarArquiRetorno)
    {
        $this->statusGerarArquiRetorno = $statusGerarArquiRetorno;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getAntecipacoes13() 
    {
        return $this->antecipacoes13->toArray();
    }
    
    /**
     * 
     * @param ArrayCollection $antecipacoes13
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setAntecipacoes13(ArrayCollection $antecipacoes13) 
    {
        foreach($antecipacoes13 as $antecipacao13) {
            $antecipacao13->setConsulta($this);
        }
        
        $this->antecipacoes13 = $antecipacoes13;
        $this->removeAllAntecipacao();
        
        return $this;
    }
    
    /**
     * 
     * @param Antecipacao13 $antecipacoes13
     */
    public function addAntecipacao13(Antecipacao13 $antecipacoes13) 
    {
        $antecipacoes13->setConsulta($this);
        
        $this->antecipacoes13[] = $antecipacoes13;
        return $this;
    }
    
    /**
     * 
     */
    public function removeAllAntecipacao()
    {
        $this->antecipacoes13->clear();
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
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setStatusPendencia($statusPendencia) 
    {
        $this->statusPendencia = $statusPendencia;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getDataConsulta() 
    {
        return $this->dataConsulta;
    }

    /**
     * 
     * @param type $dataConsulta
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente
     */
    public function setDataConsulta($dataConsulta) 
    {
        $this->dataConsulta = $dataConsulta;
        return $this;
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
}