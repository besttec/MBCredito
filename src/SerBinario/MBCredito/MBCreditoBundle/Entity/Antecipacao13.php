<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente;

/**
 * Clientes
 *
 * @ORM\Table(name="antecipacao13")
 * @ORM\Entity
 */
class Antecipacao13 
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
     * @Assert\Type(type="double", message="Valor informado para valor disponível é inválido")
     * 
     * @ORM\Column(name="valor_disponivel", type="decimal", scale=2, nullable=true)
     */
    private $valorDisponivel;
    
    /**
     * @var decimal
     *
     * @Assert\Type(type="double", message="Valor informado para valor da prestação é inválido")
     * 
     * @ORM\Column(name="valor_prestacao", type="decimal", scale=2, nullable=true)
     */
    private $valorPrestacao;
    
    /**
     * @var \DateTime
     * 
     * @Assert\Date(message="Valor da data de venciemento")
     *
     * @ORM\Column(name="data_vencimento", type="date", nullable=true)
     */
    private $dataVencimento;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="ConsultaCliente", inversedBy="antecipacoes13")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_consulta", referencedColumnName="id")
     * })
     */
    private $consulta;
    
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
     * @return type
     */
    public function getValorDisponivel()
    {
        return $this->valorDisponivel;
    }

    /**
     * 
     * @return type
     */
    public function getDataVencimento() 
    {
        return $this->dataVencimento;
    }
    
    /**
     * 
     * @param type $id
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Antecipacao13
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @param type $valorDisponivel
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Antecipacao13
     */
    public function setValorDisponivel($valorDisponivel) 
    {
        $this->valorDisponivel = $valorDisponivel;
        return $this;
    }

    /**
     * 
     * @param type $dataVencimento
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Antecipacao13
     */
    public function setDataVencimento($dataVencimento) 
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getConsulta() 
    {
        return $this->consulta;
    }

    /**
     * 
     * @param ConsultaCliente $consulta
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Antecipacao13
     */
    public function setConsulta(ConsultaCliente $consulta) 
    {
        $this->consulta = $consulta;
        
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getValorPrestacao() 
    {
        return $this->valorPrestacao;
    }
    
    /**
     * 
     * @param type $valorPrestacao
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Antecipacao13
     */
    public function setValorPrestacao($valorPrestacao) 
    {
        $this->valorPrestacao = $valorPrestacao;
        return $this;
    }




}