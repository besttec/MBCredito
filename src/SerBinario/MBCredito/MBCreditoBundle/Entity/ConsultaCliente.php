<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="valor_bruto", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valorBruto;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_descontos", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valorDescontos;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_liquido", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valorLiquido;

    /**
     * @var integer
     *
     * @ORM\Column(name="qtd_emprestimos", type="integer", nullable=true)
     */
    private $qtdEmprestimos;

    /**
     * @var \Clientes
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Clientes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clientes_id_cliente", referencedColumnName="id_cliente")
     * })
     */
    private $clientesCliente;



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
}
