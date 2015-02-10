<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Clientes
 *
 * @ORM\Table(name="clientes", indexes={@ORM\Index(name="IDX_50FE07D7221C05FD", columns={"ag_id_ag"}), @ORM\Index(name="IDX_50FE07D75B0025D3", columns={"super_regional_id_super_regional"}), @ORM\Index(name="IDX_50FE07D7A3EB2A0F", columns={"sexos_id_sexo"}), @ORM\Index(name="IDX_50FE07D7A892A8ED", columns={"super_estadual_id_super_estadual"})})
 * @ORM\Entity
 */
class Clientes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cliente", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCliente;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Nome do cliente não informado")
     * @Assert\Length(max=50, maxMessage="Valor ultrapassa limete de caracteres em nome do cliente")
     * @Assert\Type(type="string", message="Valor inválido para nome do cliente")
     * 
     * @ORM\Column(name="nome_cliente", type="string", length=50, nullable=false)
     */
    private $nomeCliente;    

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Cpf do cliente não informado")
     * @Assert\Length(max=11, maxMessage="Cpf do cliente inválido")
     * 
     * @ORM\Column(name="cpf_cliente", type="string", length=11, nullable=false)
     */
    private $cpfCliente;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="limite de crédito do cliente não informado")
     * @Assert\Length(max=50, maxMessage="Valor de limite ultrapassa a quantidade de caracteres permitidas")
     * 
     * @ORM\Column(name="limite_credito_cliente", type="string", length=50, nullable=false)
     */
    private $limiteCreditoCliente;

    /**
     * @var string
     *
     * @Assert\Length(max=5, maxMessage="Valor do ddd do fone residencial do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     * 
     * @ORM\Column(name="ddd_fone_resid_cliente", type="string", length=5, nullable=true)
     */
    private $dddFoneResidCliente;

    /**
     * @var string
     *
     * @Assert\Length(max=10, maxMessage="Valor do fone residencial do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     * 
     * @ORM\Column(name="fone_resid_cliente", type="string", length=10, nullable=true)
     */
    private $foneResidCliente;

    /**
     * @var string
     *
     * @Assert\Length(max=5, maxMessage="Valor do ddd do fone comercial do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     * 
     * @ORM\Column(name="ddd_fone_comer_cliente", type="string", length=5, nullable=true)
     */
    private $dddFoneComerCliente;

    /**
     * @var string
     * 
     * @Assert\Length(max=10, maxMessage="Valor do fone comercial do cliente
     *  ultrapassa a quantidade de caracteres permitidas")     * 
     *
     * @ORM\Column(name="fone_comer_cliente", type="string", length=10, nullable=true)
     */
    private $foneComerCliente;

    /**
     * @var string
     * 
     * @Assert\Length(max=5, maxMessage="Valor do ddd do fone celular do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     *
     * @ORM\Column(name="ddd_fone_cel_cliente", type="string", length=5, nullable=true)
     */
    private $dddFoneCelCliente;

    /**
     * @var string
     *  
     * @Assert\Length(max=10, maxMessage="Valor do fone celular do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     *
     * @ORM\Column(name="fone_cel_cliente", type="string", length=10, nullable=true)
     */
    private $foneCelCliente;

    /**
     * @var string
     * 
     * @Assert\Length(max=5, maxMessage="Valor do ddd do fone preferencial do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     *
     * @ORM\Column(name="ddd_fone_pref_cliente", type="string", length=5, nullable=true)
     */
    private $dddFonePrefCliente;

    /**
     * @var string
     * 
     * @Assert\Length(max=10, maxMessage="Valor do fone preferencial do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     *
     * @ORM\Column(name="fone_pref_cliente", type="string", length=10, nullable=true)
     */
    private $fonePrefCliente;

    /**
     * @var string
     * 
     * @Assert\Length(max=20, maxMessage="Valor do código do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     *
     * @ORM\Column(name="cod_cliente", type="string", length=20, nullable=true)
     */
    private $codCliente;

    /**
     * @var \DateTime
     * 
     * @Assert\Date(message="Valor da data de nascimento do cliente inválido")
     *
     * @ORM\Column(name="data_nasc_cliente", type="date", nullable=true)
     */
    private $dataNascCliente;

    /**
     * @var string
     *
     * @Assert\Length(max=20, maxMessage="Valor do número do benefício do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     * 
     * @ORM\Column(name="num_beneficio_cliente", type="string", length=20, nullable=true)
     */
    private $numBeneficioCliente;

    /**
     * @var string
     * 
     *@Assert\Length(max=1, maxMessage="Valor do dígito do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     * 
     * @ORM\Column(name="dv_cliente", type="string", length=1, nullable=true)
     */
    private $dvCliente;
    
    /**
     * @var string
     * 
     * @Assert\Length(max=45, maxMessage="Valor do número do benefício complementar do cliente
     *  ultrapassa a quantidade de caracteres permitidas")
     *
     * @ORM\Column(name="num_beneficio_comp_cliente", type="string", length=45, nullable=true)
     */
    private $numBeneficioComp;
    
    /**
     *
     * @var integer
     * 
     * @Assert\Type(type="integer", message="Valor informado para quantidade de consultas inválido")
     * 
     * @ORM\Column(name="qtd_consulta_cliente", type="integer")
     */
    private $qtdConsultas;    
    
    /**
     * @var boolean
     * 
     * @Assert\Type(type="bool", message="Valor informado para status da chamada do cliente é inválido")
     *
     * @ORM\Column(name="status_emChamada", type="boolean", nullable=true)
     */
    private $statusEmChamada;
                
    /**
     * @var \SuperEstadual
     * 
     * @Assert\Type(type="object", message="Valor informado para SuperEstadual não é um objeto")
     *
     * @ORM\ManyToOne(targetEntity="SuperEstadual", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="super_estadual_id_super_estadual", referencedColumnName="id_super_estadual")
     * })
     */
    private $superEstadualSuperEstadual;

    /**
     * @var \Ag
     *
     * @Assert\Type(type="object", message="Valor informado para Ag não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="Ag", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ag_id_ag", referencedColumnName="id_ag")
     * })
     */
    private $agAg;

    /**
     * @var \SuperRegional
     * 
     * @Assert\Type(type="object", message="Valor informado para SuperRegional não é um objeto")
     *
     * @ORM\ManyToOne(targetEntity="SuperRegional", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="super_regional_id_super_regional", referencedColumnName="id_super_regional")
     * })
     */
    private $superRegionalSuperRegional;

    /**
     * @var \Sexos
     * 
     * @Assert\Type(type="object", message="Valor informado para Sexo não é um objeto")
     *
     * @ORM\ManyToOne(targetEntity="Sexos", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sexos_id_sexo", referencedColumnName="id_sexo")
     * })
     */
    private $sexosSexo;
    
    /**
     * @var Convenio
     *
     * @Assert\Type(type="object", message="Valor informado para Convenio não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="Convenio", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="convenio_id", referencedColumnName="id")
     * })
     */
    private $convenio;
    
    /**
     * @ORM\OneToMany(targetEntity="ConsultaCliente", mappedBy="clientesCliente")
     **/
    private $consultas;
    
    
    /**
     * 
     */
    public function __construct() 
    {
        $this->features = new ArrayCollection();
    }



    /**
     * Get idCliente
     *
     * @return integer 
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * Set nomeCliente
     *
     * @param string $nomeCliente
     * @return Clientes
     */
    public function setNomeCliente($nomeCliente)
    {
        $this->nomeCliente = $nomeCliente;

        return $this;
    }

    /**
     * Get nomeCliente
     *
     * @return string 
     */
    public function getNomeCliente()
    {
        return $this->nomeCliente;
    }

    /**
     * Set cpfCliente
     *
     * @param string $cpfCliente
     * @return Clientes
     */
    public function setCpfCliente($cpfCliente)
    {
        $this->cpfCliente = $cpfCliente;

        return $this;
    }

    /**
     * Get cpfCliente
     *
     * @return string 
     */
    public function getCpfCliente()
    {
        return $this->cpfCliente;
    }

    /**
     * Set limiteCreditoCliente
     *
     * @param string $limiteCreditoCliente
     * @return Clientes
     */
    public function setLimiteCreditoCliente($limiteCreditoCliente)
    {
        $this->limiteCreditoCliente = $limiteCreditoCliente;

        return $this;
    }

    /**
     * Get limiteCreditoCliente
     *
     * @return string 
     */
    public function getLimiteCreditoCliente()
    {
        return $this->limiteCreditoCliente;
    }

    /**
     * Set dddFoneResidCliente
     *
     * @param string $dddFoneResidCliente
     * @return Clientes
     */
    public function setDddFoneResidCliente($dddFoneResidCliente)
    {
        $this->dddFoneResidCliente = $dddFoneResidCliente;

        return $this;
    }

    /**
     * Get dddFoneResidCliente
     *
     * @return string 
     */
    public function getDddFoneResidCliente()
    {
        return $this->dddFoneResidCliente;
    }

    /**
     * Set foneResidCliente
     *
     * @param string $foneResidCliente
     * @return Clientes
     */
    public function setFoneResidCliente($foneResidCliente)
    {
        $this->foneResidCliente = $foneResidCliente;

        return $this;
    }

    /**
     * Get foneResidCliente
     *
     * @return string 
     */
    public function getFoneResidCliente()
    {
        return $this->foneResidCliente;
    }

    /**
     * Set dddFoneComerCliente
     *
     * @param string $dddFoneComerCliente
     * @return Clientes
     */
    public function setDddFoneComerCliente($dddFoneComerCliente)
    {
        $this->dddFoneComerCliente = $dddFoneComerCliente;

        return $this;
    }

    /**
     * Get dddFoneComerCliente
     *
     * @return string 
     */
    public function getDddFoneComerCliente()
    {
        return $this->dddFoneComerCliente;
    }

    /**
     * Set foneComerCliente
     *
     * @param string $foneComerCliente
     * @return Clientes
     */
    public function setFoneComerCliente($foneComerCliente)
    {
        $this->foneComerCliente = $foneComerCliente;

        return $this;
    }

    /**
     * Get foneComerCliente
     *
     * @return string 
     */
    public function getFoneComerCliente()
    {
        return $this->foneComerCliente;
    }

    /**
     * Set dddFoneCelCliente
     *
     * @param string $dddFoneCelCliente
     * @return Clientes
     */
    public function setDddFoneCelCliente($dddFoneCelCliente)
    {
        $this->dddFoneCelCliente = $dddFoneCelCliente;

        return $this;
    }

    /**
     * Get dddFoneCelCliente
     *
     * @return string 
     */
    public function getDddFoneCelCliente()
    {
        return $this->dddFoneCelCliente;
    }

    /**
     * Set foneCelCliente
     *
     * @param string $foneCelCliente
     * @return Clientes
     */
    public function setFoneCelCliente($foneCelCliente)
    {
        $this->foneCelCliente = $foneCelCliente;

        return $this;
    }

    /**
     * Get foneCelCliente
     *
     * @return string 
     */
    public function getFoneCelCliente()
    {
        return $this->foneCelCliente;
    }

    /**
     * Set dddFonePrefCliente
     *
     * @param string $dddFonePrefCliente
     * @return Clientes
     */
    public function setDddFonePrefCliente($dddFonePrefCliente)
    {
        $this->dddFonePrefCliente = $dddFonePrefCliente;

        return $this;
    }

    /**
     * Get dddFonePrefCliente
     *
     * @return string 
     */
    public function getDddFonePrefCliente()
    {
        return $this->dddFonePrefCliente;
    }

    /**
     * Set fonePrefCliente
     *
     * @param string $fonePrefCliente
     * @return Clientes
     */
    public function setFonePrefCliente($fonePrefCliente)
    {
        $this->fonePrefCliente = $fonePrefCliente;

        return $this;
    }

    /**
     * Get fonePrefCliente
     *
     * @return string 
     */
    public function getFonePrefCliente()
    {
        return $this->fonePrefCliente;
    }

    /**
     * Set codCliente
     *
     * @param string $codCliente
     * @return Clientes
     */
    public function setCodCliente($codCliente)
    {
        $this->codCliente = $codCliente;

        return $this;
    }

    /**
     * Get codCliente
     *
     * @return string 
     */
    public function getCodCliente()
    {
        return $this->codCliente;
    }

    /**
     * Set dataNascCliente
     *
     * @param \DateTime $dataNascCliente
     * @return Clientes
     */
    public function setDataNascCliente($dataNascCliente)
    {
        $this->dataNascCliente = $dataNascCliente;

        return $this;
    }

    /**
     * Get dataNascCliente
     *
     * @return \DateTime 
     */
    public function getDataNascCliente()
    {
        return $this->dataNascCliente;
    }

    /**
     * Set numBeneficioCliente
     *
     * @param string $numBeneficioCliente
     * @return Clientes
     */
    public function setNumBeneficioCliente($numBeneficioCliente)
    {
        $this->numBeneficioCliente = $numBeneficioCliente;

        return $this;
    }

    /**
     * Get numBeneficioCliente
     *
     * @return string 
     */
    public function getNumBeneficioCliente()
    {
        return $this->numBeneficioCliente;
    }

    /**
     * Set dvCliente
     *
     * @param string $dvCliente
     * @return Clientes
     */
    public function setDvCliente($dvCliente)
    {
        $this->dvCliente = $dvCliente;

        return $this;
    }

    /**
     * Get dvCliente
     *
     * @return string 
     */
    public function getDvCliente()
    {
        return $this->dvCliente;
    }

    /**
     * Set superEstadualSuperEstadual
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual $superEstadualSuperEstadual
     * @return Clientes
     */
    public function setSuperEstadualSuperEstadual(\SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual $superEstadualSuperEstadual = null)
    {
        $this->superEstadualSuperEstadual = $superEstadualSuperEstadual;

        return $this;
    }

    /**
     * Get superEstadualSuperEstadual
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual 
     */
    public function getSuperEstadualSuperEstadual()
    {
        return $this->superEstadualSuperEstadual;
    }

    /**
     * Set agAg
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Ag $agAg
     * @return Clientes
     */
    public function setAgAg(\SerBinario\MBCredito\MBCreditoBundle\Entity\Ag $agAg = null)
    {
        $this->agAg = $agAg;

        return $this;
    }

    /**
     * Get agAg
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Ag 
     */
    public function getAgAg()
    {
        return $this->agAg;
    }

    /**
     * Set superRegionalSuperRegional
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional $superRegionalSuperRegional
     * @return Clientes
     */
    public function setSuperRegionalSuperRegional(\SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional $superRegionalSuperRegional = null)
    {
        $this->superRegionalSuperRegional = $superRegionalSuperRegional;

        return $this;
    }

    /**
     * Get superRegionalSuperRegional
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional 
     */
    public function getSuperRegionalSuperRegional()
    {
        return $this->superRegionalSuperRegional;
    }

    /**
     * Set sexosSexo
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos $sexosSexo
     * @return Clientes
     */
    public function setSexosSexo(\SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos $sexosSexo = null)
    {
        $this->sexosSexo = $sexosSexo;

        return $this;
    }

    /**
     * Get sexosSexo
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos 
     */
    public function getSexosSexo()
    {
        return $this->sexosSexo;
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
     * @param type $statusConsulta
     */
    public function setStatusConsulta($statusConsulta) 
    {
        $this->statusConsulta = $statusConsulta;
    }
    
    /**
     * 
     * @return type
     */
    public function getNumBeneficioComp() 
    {
        return $this->numBeneficioComp;
    }

    /**
     * 
     * @param type $numBeneficioComp
     */
    public function setNumBeneficioComp($numBeneficioComp) 
    {
        $this->numBeneficioComp = $numBeneficioComp;
    }
    
    /**
     * 
     * @return type
     */
    public function getConsultas() 
    {
        return $this->consultas;
    }
    
    
    /**
     * 
     * @param type $consultas
     */
    public function setConsultas($consultas) 
    {
        $this->consultas = $consultas;
    }
    
    /**
     * 
     * @param type $statusErro
     */
    public function setStatusErro($statusErro) 
    {
        $this->statusErro = $statusErro;
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
     * Add consultas
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consultas
     * @return Clientes
     */
    public function addConsulta(\SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consultas)
    {
        $this->consultas[] = $consultas;

        return $this;
    }

    /**
     * Remove consultas
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consultas
     */
    public function removeConsulta(\SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consultas)
    {
        $this->consultas->removeElement($consultas);
    }
    
    /**
     * 
     * @return type
     */
    public function getStatusEmChamada() 
    {
        return $this->statusEmChamada;
    }
    
    /**
     * 
     * @param type $statusEmChamada
     */
    public function setStatusEmChamada($statusEmChamada) 
    {
        $this->statusEmChamada = $statusEmChamada;
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
     * @param type $statusLigacao
     */
    public function setStatusLigacao($statusLigacao) 
    {
        $this->statusLigacao = $statusLigacao;
    }
    
    /**
     * 
     * @return type
     */
    public function getConvenio() 
    {
        return $this->convenio;
    }

    /**
     * 
     * @param Convenio $convenio
     */
    public function setConvenio(Convenio $convenio) 
    {
        $this->convenio = $convenio;
    }
    
    /**
     * 
     * @return type
     */
    public function getQtdConsultas() 
    {
        return $this->qtdConsultas;
    }

    /**
     * 
     * @param type $qtdConsultas
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes
     */
    public function setQtdConsultas($qtdConsultas) 
    {
        $this->qtdConsultas = $qtdConsultas;
        return $this;
    }



   
}