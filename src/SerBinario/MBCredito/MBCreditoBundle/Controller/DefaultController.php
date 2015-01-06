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
use SerBinario\MBCredito\MBCreditoBundle\DAO\ConsultaClienteDAO;

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
                    
                    $sexoDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SexoDAO($this->getDoctrine()->getManager());
                    $sexo    = $sexoDAO->findNomeExtenso($columns[0]);
                    
                    $cliente->setSexosSexo($sexo[0]);
                    $cliente->setMciEmpCliente($columns[1]);
                    $cliente->setLimiteCreditoCliente($columns[2]);
                    
                    $superEstadual    = null;
                    $superEstadualDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SuperEstadualDAO($this->getDoctrine()->getEntityManager());
                    $objEstadual      = $superEstadualDAO->findCod($columns[4]);
                    
                    if($objEstadual) {
                        $superEstadual = $objEstadual[0];
                    } else {
                        $superEstadual = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual();
                        $superEstadual->setUf($columns[3]);
                        $superEstadual->setCodSuperEstadual($columns[4]);
                        $superEstadual->setNomeSuperEstadual($columns[5]);
                    }            
                    
                    $cliente->setSuperEstadualSuperEstadual($superEstadual);
                    
                    $superRegional    = null;
                    $superRegionalDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SuperRegionalDAO($this->getDoctrine()->getEntityManager());
                    $objRegional      = $superRegionalDAO->findCod(trim($columns[6]));
                    
                    if($objRegional) {
                       $superRegional =  $objRegional[0];
                    } else {
                        $superRegional = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional();
                        $superRegional->setCodSuperRegional($columns[6]);
                        $superRegional->setNomeSuperRegional($columns[7]);
                    }           
                    
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
                    $cliente->setStatusErro(false);
                    $cliente->setStatusEmChamada(false);
                    $cliente->setStatusConsulta(false);
                    $cliente->setStatusLigacao(false);
                    
                    $numBeneficio                       = $columns[23] . ((int) $columns[24]);
                    $qtdNumBeneficio                    = strlen($numBeneficio);

                    if($qtdNumBeneficio < 10) {
                        $numBeneficio = str_repeat("0", 10 - $qtdNumBeneficio) .  $numBeneficio;
                    }                    
                    
                    $cliente->setNumBeneficioComp($numBeneficio);
                    $cliente->setStatusConsulta(false);
                    
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
            $eventosArray         = array();
            $parametros           = $request->request->all();
            
            //if (! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            //    $parametros['length'] = 1;
            //}              

            $entity               = "SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes"; 
            $columnWhereMain      = "";
            $whereValueMain       = "";
            
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
                
                $situacao = "Não consultado";
                
                if($resultCliente[$i]->getStatusConsulta()) {
                    $situacao = "Consultado";
                }
                
                $eventosArray[$i]['situacao']       =  $situacao;                
                $numBeneficio                       =  $resultCliente[$i]->getNumBeneficioCliente();
                $dvCliente                          =  $resultCliente[$i]->getDvCliente();
                             
                $eventosArray[$i]['numBeneficio']   =  $resultCliente[$i]->getNumBeneficioComp();                
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
            
            $columns = array("a.valorBruto",
                "a.valorDescontos",
                "a.valorLiquido",
                "a.qtdEmprestimos",
                "a.nomeSegurado",
                "a.competencia",
                "a.pagtoAtravez",
                "a.periodoIni",
                "a.periodoFin",
                "a.especie",
                "a.banco",
                "a.agencia",
                "a.codigoAgencia",
                "a.enderecoBanco",
                "b.dataNascCliente",
                "b.codCliente",
                "b.agAg"        
                );

            $entityJOIN = array("clientesCliente",); 

            $eventosArray        = array();
            $parametros          = $request->request->all();        
            $entity              = "SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente"; 
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
                $eventosArray[$i]['DT_RowId']       =  "row_".$resultCliente[$i]->getClientesCliente()->getIdCliente();
                $eventosArray[$i]['nome']           =  $resultCliente[$i]->getNomeSegurado();
                $eventosArray[$i]['valorBruto']     =  $resultCliente[$i]->getValorBruto();
                
                $cpf                                = $resultCliente[$i]->getClientesCliente()->getCpfCliente();
                $cpfLen                             = strlen($cpf);
                
                if($cpfLen < 11) {
                    $cpf = str_repeat("0", 11 - $cpfLen) .  $cpf;
                }             
                
                $eventosArray[$i]['cpf']                    =  $cpf;
                $eventosArray[$i]['valorDescontos']         =  $resultCliente[$i]->getValorDescontos();
                $eventosArray[$i]['valorLiquido']           =  $resultCliente[$i]->getValorLiquido();
                $eventosArray[$i]['qtdEmprestimos']         =  $resultCliente[$i]->getQtdEmprestimos();
                $eventosArray[$i]['competencia']            =  $resultCliente[$i]->getCompetencia();
                $eventosArray[$i]['pagtoAtravez']           =  $resultCliente[$i]->getPagtoAtravez();
                
                if($resultCliente[$i]->getPeriodoIni()){
                    $eventosArray[$i]['periodoIni']         =  $resultCliente[$i]->getPeriodoIni()->format('d/m/Y');
                }else {
                    $eventosArray[$i]['periodoIni']         =  "";
                }
                
                if($resultCliente[$i]->getPeriodoFin()){
                    $eventosArray[$i]['periodoFin']         =  $resultCliente[$i]->getPeriodoFin()->format('d/m/Y');
                } else {
                    $eventosArray[$i]['periodoFin']         = "";
                }
                
                $eventosArray[$i]['especie']                =  $resultCliente[$i]->getEspecie();
                $eventosArray[$i]['banco']                  =  $resultCliente[$i]->getBanco();
                $eventosArray[$i]['agencia']                =  $resultCliente[$i]->getAgencia();
                $eventosArray[$i]['codigoAgencia']          =  $resultCliente[$i]->getCodigoAgencia();
                $eventosArray[$i]['enderecoBanco']          =  $resultCliente[$i]->getEnderecoBanco();
                $eventosArray[$i]['obsCliente']             =  $resultCliente[$i]->getObsCliente();
                
                $numBeneficio                       = $resultCliente[$i]->getClientesCliente()->getNumBeneficioCliente();
                $dvCliente                          = $resultCliente[$i]->getClientesCliente()->getDvCliente();
                $numBeneficio                       = $numBeneficio . $dvCliente;
                $qtdNumBeneficio                    = strlen($numBeneficio);
                
                if($qtdNumBeneficio < 10) {
                    $numBeneficio = str_repeat("0", 10 - $qtdNumBeneficio) .  $numBeneficio;
                }
                
                $emprestimos = array();
                
                foreach ($resultCliente[$i]->getEmprestimos() as $index => $emprestimo) {
                   $emprestimos[$index]['nome']  =  $emprestimo->getEmprestimo();
                   $emprestimos[$index]['valor']    =  $emprestimo->getValor();
                   $emprestimos[$index]['id']    =  $emprestimo->getIdEmprestimo();
                   $emprestimos[$index]['status']    =  $emprestimo->getStatusBBEmprestimo();
                }
                
                $eventosArray[$i]['emprestimos']    =  $emprestimos;
                $eventosArray[$i]['numBeneficio']   =  $numBeneficio;                
                $eventosArray[$i]['Sexo']           =  $resultCliente[$i]->getClientesCliente()->getSexosSexo()->getNomeExtensoSexo();
                $eventosArray[$i]['dtNascimento']   =  $resultCliente[$i]->getClientesCliente()->getDataNascCliente()->format('d/m/Y');
                $eventosArray[$i]['obsErro']        =  $resultCliente[$i]->getClientesCliente()->getObsErro();
                $eventosArray[$i]['statusErro']     =  $resultCliente[$i]->getClientesCliente()->getStatusErro();
                $eventosArray[$i]['ag']             =  $resultCliente[$i]->getClientesCliente()->getAgAg()->getCcAg();
                $eventosArray[$i]['prefixo_ag']     =  $resultCliente[$i]->getClientesCliente()->getAgAg()->getPrefixoAg();
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
        
        $nomeSegurado   = trim($dados['nomeSegurado']);
        $codBenefi      = trim($dados['codBenefi']);
        $competencia    = trim($dados['competencia']);
        $pCredito       = trim($dados['pCredito']);
        $tipoPagamento  = trim($dados['tipoPagamento']);
        $especie        = trim($dados['especie']);
        $banco          = trim($dados['banco']);
        $agencia        = trim($dados['agencia']);
        $codAgencia     = trim($dados['codAgencia']);
        $endBanco       = trim($dados['endBanco']);
        $disRecebimento = trim($dados['disRecebimento']);
        $vBruto         = trim($dados['vBruto']);
        
        $source         = array('.', ',');
        $replace        = array('', '.');
        
        $vBruto         = str_replace($source, $replace, $vBruto);
        
        $vDesconto      = trim($dados['vDesconto']);
        $vDesconto      = str_replace($source, $replace, $vDesconto);
        
        $vLiquido       = trim($dados['vLiquido']);
        $vLiquido       = str_replace($source, $replace, $vLiquido);
        
        $qtdEmprestimo  = trim($dados['qtdEmprestimo']);
        
        if(isset($dados['nomeEmprestimo'])) {
            $nomeEmp        = $dados['nomeEmprestimo'];
        }
        if(isset($dados['valorEmprestimo'])) {
            $valoresEmp     = $dados['valorEmprestimo'];
        }      
        $statusErro     = $dados['erro'];
        $obsErro        = $dados['msgerro'];
        
        $clienteDAO = new ClienteDAO($this->getDoctrine()->getManager());
        $codBenefi  = str_replace(array(".","-"), "", $codBenefi);
                
        $cliente    = $clienteDAO->findNumBeneficio($codBenefi);
        
        $consultaCliente = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente();
        $consultaClienteDAO = new ConsultaClienteDAO($this->getDoctrine()->getManager());
        
        if(count($cliente) > 0) {
            $cliente[0]->setStatusConsulta(true);
            
            if($statusErro === '1') {
                $cliente[0]->setStatusErro(true);
                $cliente[0]->setObsErro($obsErro);
                $consultaCliente->setNomeSegurado($nomeSegurado);
                $consultaCliente->setClientesCliente($cliente[0]);
                $conf =  $consultaClienteDAO->update($consultaCliente);
                
                if($conf) {
                    $this->get("session")->getFlashBag()->add('success', "Dados Salvos com sucesso!");     
                } else {
                    $this->get("session")->getFlashBag()->add('danger', "Error ao salvar os dados!");     
                }
                
                return $this->redirect($this->generateUrl("inserirDados"));
            }           
            
            $consultaCliente->setNomeSegurado($nomeSegurado);
            $consultaCliente->setCompetencia($competencia);
            
            $arrayPeriodo = explode("a", $pCredito);
            
            $consultaCliente->setPeriodoIni(\DateTime::createFromFormat("d/m/Y", trim($arrayPeriodo[0]), new \DateTimeZone("America/Recife")));
            $consultaCliente->setPeriodoFin(\DateTime::createFromFormat("d/m/Y", trim($arrayPeriodo[1]), new \DateTimeZone("America/Recife")));
            $consultaCliente->setPagtoAtravez($tipoPagamento);
            $consultaCliente->setEspecie($especie);
            $consultaCliente->setBanco($banco);
            $consultaCliente->setAgencia($agencia);
            $consultaCliente->setCodigoAgencia($codAgencia);
            $consultaCliente->setEnderecoBanco($endBanco);
            
            $arrayDisp = explode("a", $disRecebimento);
            
            $consultaCliente->setDisponibilidadeIni(\DateTime::createFromFormat("d/m/Y", trim($arrayDisp[0]), new \DateTimeZone("America/Recife")));
            $consultaCliente->setDisponibilidadeFin(\DateTime::createFromFormat("d/m/Y", trim($arrayDisp[1]), new \DateTimeZone("America/Recife")));
            $consultaCliente->setValorBruto($vBruto);
            $consultaCliente->setValorDescontos($vDesconto);
            $consultaCliente->setValorLiquido($vLiquido);
            $consultaCliente->setQtdEmprestimos($qtdEmprestimo);
           
            //$emprestimos = array_combine(array_values($nomeEmp), array_values($valoresEmp));
            
            for ($i = 0; $i < count($nomeEmp); $i++) {
                $emprestimo     = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos();
                $emprestimo->setEmprestimo($nomeEmp[$i]);
                
                $valoresEmp[$i] = str_replace($source, $replace, $valoresEmp[$i]);
                $emprestimo->setValor($valoresEmp[$i]);
                
                $consultaCliente->addEmprestimo($emprestimo);
            }
            
            $consultaCliente->setClientesCliente($cliente[0]);
            //var_dump($consultaCliente);exit;
            $result = $consultaClienteDAO->insert($consultaCliente);
            
            if($result) {
                 $this->get("session")->getFlashBag()->add('success', "Dados Salvos com sucesso!");     
            } else {
                 $this->get("session")->getFlashBag()->add('danger', "Error ao salvar os dados!");     
            }
            
        } else {
             $this->get("session")->getFlashBag()->add('danger', "Cliente não encontrado!");     
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
    
    /**
     * @Route("/savarInfoAdicionais", name="savarInfoAdicionais")
     * @Template()
     * @Method({"POST"})
     */
    public function savarInfoAdicionaisAction(Request $request)
    {
        $req = $request->request->all();
        
        $obs          = trim($req['obs']);
        $id           = trim($req['idCliente']);
        
        if(isset($req['emprestimo'])) {
            $emprestimos  = $req['emprestimo'];
        } else {
            $emprestimos = null;
        }
        
        if(isset($req['statusAtivo'])) {
            $statusAtivo  = $req['statusAtivo'];
        } else {
            $statusAtivo = null;
        }
        
        $consultaClienteDAO = new ConsultaClienteDAO($this->getDoctrine()->getManager());
        $emprestimoDAO      = new \SerBinario\MBCredito\MBCreditoBundle\DAO\EmprestimoDAO($this->getDoctrine()->getManager());
        
        if($obs || $emprestimos || $statusAtivo){
            
            //Primeito o cliente é consultado
            $cliente = $consultaClienteDAO->findConsultaCliente($id);
            
            //Verifica se o cliente existe
            if($cliente) {
                
                if($statusAtivo){
                    $cliente[0]->getClientesCliente()->setStatusLigacao(true);
                } else {
                    $cliente[0]->getClientesCliente()->setStatusLigacao(false);
                }
                //Seta o valor do campo observação para o cliente
                $cliente[0]->setObsCliente($obs);
                //Conta quantos emprestimos o cliete possue
                $countEmp = count($emprestimos);
                
                //verifica se o cliente tem pelo menos 1 emprestimo
                if($countEmp >= 1) {
                    
                    //faz um loop para alterar o status do emprestimos para BB
                    for($i = 0; $i < $countEmp; $i++){
                        //Seleciona os emprestimo a ser alterado
                        $emp = $emprestimoDAO->findEmprestimo($emprestimos[$i]);
                        $emp[0]->setStatusBBEmprestimo(true);
                        $emprestimoDAO->update($emp[0]);
                    }
                   
                }
                
                //faz a atualização do cliente
                $result = $consultaClienteDAO->update($cliente[0]);
                
                if($result) {
                     $this->get("session")->getFlashBag()->add('success', "Dados Salvos com sucesso!");
                     echo "sucesso";
                } else {
                    $this->get("session")->getFlashBag()->add('danger', "Error ao salvar os dados!");
                     echo "falha";
                }
                
            } else {
                $this->get("session")->getFlashBag()->add('danger', "Cliente não encontrado!");  
            }
            
        } else {
            $this->get("session")->getFlashBag()->add('danger', "Pelo menos um campo deve ser preenchido");  
        }
        
        return $this->redirect($this->generateUrl("viewGridDados"));
    }
    
    /**
     * @Route("/viewDiscagem", name="viewDiscagem")
     * @Template()
     */
    public function viewDiscagemAction()
    {
        $usuario      = $this->get("security.context")->getToken()->getUser();
        $clienteDAO   = new ClienteDAO($this->getDoctrine()->getManager());
        $cliente      = null;
        
        $statusDAO    = new \SerBinario\MBCredito\MBCreditoBundle\DAO\StatusDAO($this->getDoctrine()->getManager());
        $status       = $statusDAO->findAll();  
        
        $chamada      = $clienteDAO->findCallPen($usuario);
        
        if(! is_null($chamada)) {
            $cliente = $chamada->getClientesCliente();
        } else {
            $cliente      = $clienteDAO->findNotUse();
       
            if($cliente) {
                $cliente->setStatusEmChamada(true);                              
                $clienteDAO->updateCliente($cliente);                

                $chamadaCliente = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente();
                $chamadaCliente->setStatusPendencia(true);
                $chamadaCliente->setStatusChamada(false);
                $chamadaCliente->setDataPendencia(new \DateTime("now", new \DateTimeZone("America/Recife")));
                $chamadaCliente->setClientesCliente($cliente);
                $chamadaCliente->setUser($usuario);

                $em = $this->getDoctrine()->getManager();
                $em->persist($chamadaCliente);
                $em->flush();       
            } else {
                $this->get("session")->getFlashBag()->add('danger', "Não existe cliente disponível"); 
                 
                return $this->redirect($this->generateUrl("inserirDados"));
            }
        }      
        
        $calls   = $clienteDAO->findCallsCliente($cliente);
        
        return array("cliente" => $cliente, "status" => $status, "calls" => $calls);
    }
 }
