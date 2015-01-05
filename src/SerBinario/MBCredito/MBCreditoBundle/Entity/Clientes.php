<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente;

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
     * @ORM\Column(name="nome_cliente", type="string", length=50, nullable=false)
     */
    private $nomeCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="mci_emp_cliente", type="string", length=10, nullable=true)
     */
    private $mciEmpCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf_cliente", type="string", length=11, nullable=false)
     */
    private $cpfCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="limite_credito_cliente", type="string", length=50, nullable=false)
     */
    private $limiteCreditoCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="ddd_fone_resid_cliente", type="string", length=5, nullable=true)
     */
    private $dddFoneResidCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="fone_resid_cliente", type="string", length=10, nullable=true)
     */
    private $foneResidCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="ddd_fone_comer_cliente", type="string", length=5, nullable=true)
     */
    private $dddFoneComerCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="fone_comer_cliente", type="string", length=10, nullable=true)
     */
    private $foneComerCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="ddd_fone_cel_cliente", type="string", length=5, nullable=true)
     */
    private $dddFoneCelCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="fone_cel_cliente", type="string", length=10, nullable=true)
     */
    private $foneCelCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="ddd_fone_pref_cliente", type="string", length=5, nullable=true)
     */
    private $dddFonePrefCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="fone_pref_cliente", type="string", length=10, nullable=true)
     */
    private $fonePrefCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_cliente", type="string", length=20, nullable=true)
     */
    private $codCliente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_nasc_cliente", type="date", nullable=true)
     */
    private $dataNascCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="num_beneficio_cliente", type="string", length=20, nullable=true)
     */
    private $numBeneficioCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="dv_cliente", type="string", length=45, nullable=true)
     */
    private $dvCliente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="num_beneficio_comp_cliente", type="string", length=45, nullable=true)
     */
    private $numBeneficioComp;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="$status_consulta_cliente", type="boolean", nullable=true)
     */
    private $statusConsulta;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="$status_erro_cliente", type="boolean", nullable=true)
     */
    private $statusErro;
    
    /**
     * @var String
     *
     * @ORM\Column(name="$obs_erro_cliente", type="string", length=100, nullable=true)
     */
    private $obsErro;

    /**
     * @var \SuperEstadual
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
     * @ORM\ManyToOne(targetEntity="Ag", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ag_id_ag", referencedColumnName="id_ag")
     * })
     */
    private $agAg;

    /**
     * @var \SuperRegional
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
     * @ORM\ManyToOne(targetEntity="Sexos", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sexos_id_sexo", referencedColumnName="id_sexo")
     * })
     */
    private $sexosSexo;
    
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
     * Set mciEmpCliente
     *
     * @param string $mciEmpCliente
     * @return Clientes
     */
    public function setMciEmpCliente($mciEmpCliente)
    {
        $this->mciEmpCliente = $mciEmpCliente;

        return $this;
    }

    /**
     * Get mciEmpCliente
     *
     * @return string 
     */
    public function getMciEmpCliente()
    {
        return $this->mciEmpCliente;
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
     * 
     * @param type $obsErro
     */
    public function setObsErro($obsErro) 
    {
        $this->obsErro = $obsErro;
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
}
