<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Emprestimos
 *
 * @ORM\Table(name="emprestimos", indexes={@ORM\Index(name="fk_emprestimos_consulta_cliente1_idx", columns={"consulta_cliente_id"})})
 * @ORM\Entity
 */
class Emprestimos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_emprestimo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmprestimo;

    /**
     * @var string
     *
     * @Assert\Length(max=50, maxMessage="Valor informado para emprestimo ultrapassa 
     * a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="emprestimo", type="string", length=50, nullable=false)
     */
    private $emprestimo;

    /**
     * @var decimal
     *
     * @Assert\Type(type="double", message="Valor informado para valor é inválido")
     * 
     * @ORM\Column(name="valor_", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valor;
    
    /**
     * @var boolean
     * 
     * @Assert\Type(type="bool", message="Valor informado para status do emprestimo é inválido")
     *
     * @ORM\Column(name="$status_bb_emprestimo", type="boolean", nullable=true)
     */
    private $statusBBEmprestimo;

    /**
     * @var \ConsultaCliente
     *
     * @Assert\Type(type="object", message="Valor informado para ConsultaCliente não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="ConsultaCliente", inversedBy="emprestimos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="consulta_cliente_id", referencedColumnName="id")
     * })
     */
    private $consultaClienteClientesCliente;



    /**
     * Get idEmprestimo
     *
     * @return integer 
     */
    public function getIdEmprestimo()
    {
        return $this->idEmprestimo;
    }

    /**
     * Set emprestimo
     *
     * @param string $emprestimo
     * @return Emprestimos
     */
    public function setEmprestimo($emprestimo)
    {
        $this->emprestimo = $emprestimo;

        return $this;
    }

    /**
     * Get emprestimo
     *
     * @return string 
     */
    public function getEmprestimo()
    {
        return $this->emprestimo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return Emprestimos
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }
    
    /**
     * Set statusBBEmprestimo
     *
     * @param string $statusBBEmprestimo
     * @return Emprestimos
     */
    public function setStatusBBEmprestimo($statusBBEmprestimo)
    {
        $this->statusBBEmprestimo = $statusBBEmprestimo;

        return $this;
    }
    
     /**
     * Get statusBBEmprestimo
     *
     * @return string 
     */
    public function getStatusBBEmprestimo()
    {
        return $this->statusBBEmprestimo;
    }

    /**
     * Set consultaClienteClientesCliente
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consultaClienteClientesCliente
     * @return Emprestimos
     */
    public function setConsultaClienteClientesCliente(\SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consultaClienteClientesCliente = null)
    {
        $this->consultaClienteClientesCliente = $consultaClienteClientesCliente;

        return $this;
    }

    /**
     * Get consultaClienteClientesCliente
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente 
     */
    public function getConsultaClienteClientesCliente()
    {
        return $this->consultaClienteClientesCliente;
    }
}
