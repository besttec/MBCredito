<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Documento;
use SerBinario\MBCredito\MBCreditoBundle\Util\GridClass;
use SerBinario\MBCredito\MBCreditoBundle\Util\MBCreditoUtil;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes;
use SerBinario\MBCredito\MBCreditoBundle\DAO\DocumentoDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ClienteDAO;

/**
 *  
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $req = $request->request->all();
        
        $login = $req['login'];
        $senha = $req['senha'];
        
        if(($login === "mbcredito") && ($senha === "12345")) {
            return $this->redirect($this->generateUrl("principal"));
        } else {
            $this->get("session")->getFlashBag()->add('error', "Erro ao fazer login e senha");
            return $this->redirect($this->generateUrl("homepage"));
        }
               
    }
    
    /**
     * @Route("/principal", name="principal")
     * @Template()
     */
    public function principalAction(Request $request)
    {        
        return array();
    }
     
    /**
     * @Route("/importarArquivo", name="importarArquivo")
     * @Template()
     */
    public function viewImportarArquivoAction()
    {
        return array();
    }
      
    /**
     * @Route("/saveArquivo", name="saveArquivo")
     */
    public function saveArquivoAction(Request $request)
    {
        $uploadfile = $request->files->get("arquivo");
        $nameFile   = sha1(uniqid(mt_rand(), true));
        $validator  = $this->get('validator');
        
        $documento = new Documento();
        $documento->setName($nameFile);
        $documento->setFile($uploadfile);
        $documento->setData(new \DateTime("now", new \DateTimeZone("America/Recife")));
        
        $erros = $validator->validate($documento);
        
        if(! count($erros)) {
            $documentoDAO = new DocumentoDAO($this->getDoctrine()->getManager());            
            $documento->upload();
            
            $result = $documentoDAO->save($documento);    
            
            if($result) {
                $fileString = file($documento->getWebPath());
     
                for($i = 0; $i < count($fileString); $i++) {
                    $columns = explode(";", $fileString[$i]);
                    
                    $cliente = new Clientes();
                    
                    $sexo = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos();
                    $sexo->setNomeExtensoSexo($columns[0]);
                    
                    $cliente->setSexosSexo($sexo);
                    $cliente->setMciEmpCliente($columns[1]);
                    $cliente->setLimiteCreditoCliente($columns[2]);
                    
                    $superEstadual = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual();
                    $superEstadual->setUf($columns[3]);
                    $superEstadual->setCodSuperEstadual($columns[4]);
                    $superEstadual->setNomeSuperEstadual($columns[5]);
                    
                    $cliente->setSuperEstadualSuperEstadual($superEstadual);
                    
                    $superRegional = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional();
                    $superRegional->setCodSuperRegional($columns[6]);
                    $superRegional->setNomeSuperRegional($columns[7]);
                    
                    $cliente->setSuperRegionalSuperRegional($superRegional);
                    
                    $ag = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Ag();
                    $ag->setPrefixoAg($columns[8]);
                    $ag->setNomeAg($columns[9]);
                    $ag->setCcAg($columns[10]);
                    
                    $cliente->setAgAg($ag);
                    $cliente->setNomeCliente($columns[11]);
                    $cliente->setCpfCliente($columns[12]);
                    $cliente->setDddFoneResidCliente($columns[13]);
                    $cliente->setFoneResidCliente($columns[14]);
                    $cliente->setDddFoneComerCliente($columns[15]);
                    $cliente->setFoneComerCliente($columns[16]);
                    $cliente->setDddFoneCelCliente($columns[17]);
                    $cliente->setFoneCelCliente($columns[18]);
                    $cliente->setDddFonePrefCliente($columns[19]);
                    $cliente->setFonePrefCliente($columns[20]);
                    $cliente->setCodCliente($columns[21]);
                    $cliente->setDataNascCliente(\DateTime::createFromFormat("d/m/Y", $columns[22], new \DateTimeZone("America/Recife")));
                    $cliente->setNumBeneficioCliente($columns[23]);
                    $cliente->setDvCliente((int) $columns[24]);
                    $clienteDAO = new ClienteDAO($this->getDoctrine()->getManager());
                    $clienteDAO->insertCliente($cliente);
                }
               
               $this->get("session")->getFlashBag()->add('success', "Arquivo importado com sucesso!");              
            } else {
               $this->get("session")->getFlashBag()->add('error', "Error ao importar o arquivo!"); 
            }
        }
        
        $this->get("session")->getFlashBag()->add('error', (string) $erros);
        
        return $this->redirect($this->generateUrl("importarArquivo"));
    }
    
    /**
     * @Route("/viewGridDados", name="viewGridDados")
     * @Template()
     */
    public function viewGridDadosAction()
    {      
        return array();
    }
    
    /**
     * @Route("/inserirDados", name="inserirDados")
     * @Template()
     */
    public function viewInserirDadosAction()
    {      
        return array();
    }
    
    /**
     * @Route("/grid")
     * @Method({"POST"})
     * @Template("MBCreditoBundle:Default:viewInserirDados.html.twig")
     */
    public function testeGridAction(Request $request)
    {
        
        if(GridClass::isAjax()) {
            
            $columns = array("a.nomeCliente",
                "a.mciEmpCliente",
                "a.cpfCliente",
                "a.dddFoneResidCliente",
                "a.foneResidCliente",
                "a.dddFoneComerCliente",
                "a.foneComerCliente",
                "a.dddFoneCelCliente",
                "a.foneCelCliente",
                "a.foneCelCliente",
                "a.numBeneficioCliente",
                "b.nomeExtensoSexo",
                "a.dataNascCliente"
                );

            $entityJOIN = array("sexosSexo"); 

            $eventosArray        = array();
            $parametros          = $request->request->all();        
            $entity              = "SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes"; 
            $columnWhereMain     = "";
            $whereValueMain      = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain);

            $resultCliente  = $gridClass->builderQuery();    
            $countTotal     = $gridClass->getCount();
            $countEventos   = count($resultCliente);

            for($i=0;$i < $countEventos; $i++)
            {
                $eventosArray[$i]['DT_RowId']       =  "row_".$resultCliente[$i]->getIdCliente();
                $eventosArray[$i]['nome']           =  $resultCliente[$i]->getNomeCliente();
                $eventosArray[$i]['mci']            =  $resultCliente[$i]->getMciEmpCliente();
                
                $cpf                                = $resultCliente[$i]->getCpfCliente();
                $cpfLen                             = strlen($cpf);
                
                if($cpfLen < 11) {
                    $cpf = str_repeat("0", 11 - $cpfLen) .  $cpf;
                }             
                
                $eventosArray[$i]['cpf']            =  $cpf;
                $eventosArray[$i]['dddFoneRes']     =  $resultCliente[$i]->getDddFoneResidCliente();
                $eventosArray[$i]['FoneRes']        =  $resultCliente[$i]->getFoneResidCliente();
                $eventosArray[$i]['dddFoneCom']     =  $resultCliente[$i]->getDddFoneComerCliente();
                $eventosArray[$i]['FoneCom']        =  $resultCliente[$i]->getFoneComerCliente();
                $eventosArray[$i]['dddFoneCel']     =  $resultCliente[$i]->getDddFoneCelCliente();
                $eventosArray[$i]['FoneCel']        =  $resultCliente[$i]->getFoneCelCliente();
                
                $numBeneficio                       = $resultCliente[$i]->getNumBeneficioCliente();
                $dvCliente                          = $resultCliente[$i]->getDvCliente();
                $numBeneficio                       = $numBeneficio . $dvCliente;
                $qtdNumBeneficio                    = strlen($numBeneficio);
                
                if($qtdNumBeneficio < 10) {
                    $numBeneficio = str_repeat("0", 10 - $qtdNumBeneficio) .  $numBeneficio;
                }
                
                $eventosArray[$i]['numBeneficio']   = $numBeneficio;                
                $eventosArray[$i]['Sexo']           =  $resultCliente[$i]->getSexosSexo()->getNomeExtensoSexo();
                $eventosArray[$i]['dtNascimento']   =  $resultCliente[$i]->getDataNascCliente()->format('d/m/Y');
            }

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }

            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countEventos}",
                'data'              => $eventosArray               
            );

            return new JsonResponse($columns);
        }else{            
            return array();            
        }
            
    }
    
    /**
     * @Route("/gridDados")
     * @Method({"POST"})
     * @Template("MBCreditoBundle:Default:viewGridDados.html.twig")
     */
    public function dadosGridAction(Request $request)
    {
        
        if(GridClass::isAjax()) {
            
            $columns = array("a.nomeCliente",
                "a.mciEmpCliente",
                "a.cpfCliente",
                "a.dddFoneResidCliente",
                "a.foneResidCliente",
                "a.dddFoneComerCliente",
                "a.foneComerCliente",
                "a.dddFoneCelCliente",
                "a.foneCelCliente",
                "a.foneCelCliente",
                "a.numBeneficioCliente",
                "b.nomeExtensoSexo",
                "a.dataNascCliente"
                );

            $entityJOIN = array("sexosSexo"); 

            $eventosArray        = array();
            $parametros          = $request->request->all();        
            $entity              = "SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes"; 
            $columnWhereMain     = "";
            $whereValueMain      = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain);

            $resultCliente  = $gridClass->builderQuery();    
            $countTotal     = $gridClass->getCount();
            $countEventos   = count($resultCliente);

            for($i=0;$i < $countEventos; $i++)
            {
                $eventosArray[$i]['DT_RowId']       =  "row_".$resultCliente[$i]->getIdCliente();
                $eventosArray[$i]['nome']           =  $resultCliente[$i]->getNomeCliente();
                $eventosArray[$i]['mci']            =  $resultCliente[$i]->getMciEmpCliente();
                
                $cpf                                = $resultCliente[$i]->getCpfCliente();
                $cpfLen                             = strlen($cpf);
                
                if($cpfLen < 11) {
                    $cpf = str_repeat("0", 11 - $cpfLen) .  $cpf;
                }             
                
                $eventosArray[$i]['cpf']            =  $cpf;
                $eventosArray[$i]['dddFoneRes']     =  $resultCliente[$i]->getDddFoneResidCliente();
                $eventosArray[$i]['FoneRes']        =  $resultCliente[$i]->getFoneResidCliente();
                $eventosArray[$i]['dddFoneCom']     =  $resultCliente[$i]->getDddFoneComerCliente();
                $eventosArray[$i]['FoneCom']        =  $resultCliente[$i]->getFoneComerCliente();
                $eventosArray[$i]['dddFoneCel']     =  $resultCliente[$i]->getDddFoneCelCliente();
                $eventosArray[$i]['FoneCel']        =  $resultCliente[$i]->getFoneCelCliente();
                
                $numBeneficio                       = $resultCliente[$i]->getNumBeneficioCliente();
                $dvCliente                          = $resultCliente[$i]->getDvCliente();
                $numBeneficio                       = $numBeneficio . $dvCliente;
                $qtdNumBeneficio                    = strlen($numBeneficio);
                
                if($qtdNumBeneficio < 10) {
                    $numBeneficio = str_repeat("0", 10 - $qtdNumBeneficio) .  $numBeneficio;
                }
                
                $eventosArray[$i]['numBeneficio']   = $numBeneficio;                
                $eventosArray[$i]['Sexo']           =  $resultCliente[$i]->getSexosSexo()->getNomeExtensoSexo();
                $eventosArray[$i]['dtNascimento']   =  $resultCliente[$i]->getDataNascCliente()->format('d/m/Y');
            }

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }

            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countEventos}",
                'data'              => $eventosArray               
            );

            return new JsonResponse($columns);
        }else{            
            return array();            
        }
            
    }
    
    /**
     * @Route("/captcha")
     * @Method({"POST"})
     */
    public function captchaAction()
    {
        $mbCredito = new MBCreditoUtil("http://www8.dataprev.gov.br/SipaINSS/pages/hiscre/hiscreInicio.xhtml");
        $this->get("session")->set('objMBCredito', $mbCredito);
        
        $result = array(
            "img" => $mbCredito->get_captcha()
        );
        
        return new JsonResponse($result);
    }
    
    /**
     * @Route("/consultar", name="consultar")
     * @Method({"POST"})
     */
    public function consultarAction(Request $request)
    {
        $dados        = $request->request->all();
        $objMBCredito = $this->get("session")->get('objMBCredito');
        
        $numBeneficio = $dados['numBeneficio'];
        $dtNascimento = $dados['dtNascimento'];
        $nome         = $dados['nome'];
        $cpf          = $dados['cpf'];
        $captcha      = $dados['captcha'];
        
        $result = "";
        
        if($objMBCredito) {
            $cliente = new Clientes();
            $cliente->setNumBeneficioCliente($numBeneficio);
            $cliente->setNomeCliente($nome);
            $cliente->setCpfCliente($cpf);
            $cliente->setDataNascCliente(\DateTime::createFromFormat("d/m/Y", $dtNascimento));
            
            $result = $objMBCredito->submitForm($cliente, $captcha);
        } else {
            $result = "Dados inválidos";
        }
        
        $resultArray = array(
            "result" => utf8_encode($result)
        );
        
        return new JsonResponse($resultArray);
    }
    
    /**
     * @Route("/savarConsultaCliente", name="savarConsultaCliente")
     * @Template()
     * @Method({"POST"})
     */
    public function savarConsultaClienteAction(Request $request)
    {
        $dados = $request->request->all(); 
        
        $nomeSegurado   = $dados['nomeSegurado'];
        $codBenefi      = $dados['codBenefi'];
        $competencia    = $dados['competencia'];
        $pCredito       = $dados['pCredito'];
        $tipoPagamento  = $dados['tipoPagamento'];
        $especie        = $dados['especie'];
        $banco          = $dados['banco'];
        $agencia        = $dados['agencia'];
        $codAgencia     = $dados['codAgencia'];
        $endBanco       = $dados['endBanco'];
        $disRecebimento = $dados['disRecebimento'];
        $vBruto         = $dados['vBruto'];
        $vDesconto      = $dados['vDesconto'];
        $vLiquido       = $dados['vLiquido'];
        $qtdEmprestimo  = $dados['qtdEmprestimo'];
        
        $clienteDAO = new ClienteDAO($this->getDoctrine()->getManager());
        $cliente    = $clienteDAO->findNumBeneficio($codBenefi);
        
        if(count($cliente) > 0) {
            $consultaCliente = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente();
            
            $consultaCliente->setNomeSegurado($nomeSegurado);
            $consultaCliente->setCompetencia($competencia);
            
            $arrayPeriodo = explode("a", $pCredito);
            
            $consultaCliente->setPeriodoIni(\DateTime::createFromFormat("d/m/Y", $arrayPeriodo[0], new \DateTimeZone("America\Recife")));
            $consultaCliente->setPeriodoFin(\DateTime::createFromFormat("d/m/Y", $arrayPeriodo[1], new \DateTimeZone("America\Recife")));
            $consultaCliente->setPagtoAtravez($tipoPagamento);
            $consultaCliente->setEspecie($especie);
            $consultaCliente->setBanco($banco);
            $consultaCliente->setAgencia($agencia);
            $consultaCliente->setCodigoAgencia($codAgencia);
            $consultaCliente->setEnderecoBanco($endBanco);
            
            $arrayDisp = explode("a", $disRecebimento);
            
            $consultaCliente->setDisponibilidadeIni(\DateTime::createFromFormat("d/m/Y", $arrayDisp[0], new \DateTimeZone("America\Recife")));
            $consultaCliente->setDisponibilidadeFin(\DateTime::createFromFormat("d/m/Y", $arrayDisp[1], new \DateTimeZone("America\Recife")));
            $consultaCliente->setValorBruto($vBruto);
            $consultaCliente->setValorDescontos($vDesconto);
            $consultaCliente->setValorLiquido($vLiquido);
            $consultaCliente->setQtdEmprestimos($qtdEmprestimo);
            
            $consultaCliente->setClientesCliente($cliente[0]);
            
            $consultaClienteDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\ConsultaClienteDAO($this->getDoctrine()->getManager());
            $result = $consultaClienteDAO->insert($consultaCliente);
            
            if($result) {
                 $this->get("session")->getFlashBag()->add('success', "Dados Salvos com sucessoS!");     
            } else {
                 $this->get("session")->getFlashBag()->add('error', "Error ao salvar os dados!");     
            }
            
        } else {
             $this->get("session")->getFlashBag()->add('error', "Cliente não encontrado!");     
        }
        
        return $this->redirect($this->generateUrl("inserirDados"));
    }
    
     /**
     * @Route("/teste")
     * @Template("")
     */
    public function testeAction()
    {
        return array();
    }
}
