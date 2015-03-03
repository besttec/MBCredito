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
use SerBinario\MBCredito\UserBundle\DAO\RoleDAO;
use SerBinario\MBCredito\UserBundle\DAO\UserDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ConvenioDAO;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio;
use SerBinario\MBCredito\MBCreditoBundle\RN\DiscagemRN;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Antecipacao13;
use SerBinario\MBCredito\MBCreditoBundle\Entity\LimiteCreditoNovo;
use SerBinario\MBCredito\MBCreditoBundle\DAO\LimiteCreditoNovoDAO;

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
    public function principalAction()
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
        $clienteDAO = new ClienteDAO($this->getDoctrine()->getManager());
        
        #Se o arquivo não for selecionado.
        if(! $uploadfile) {
           $this->get("session")->getFlashBag()->add('danger', "Você deve selecionar um arquivo");   
           
           return $this->redirect($this->generateUrl("importarArquivo")); 
        }
        
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
                    //var_dump($columns);exit;
                    $cliente = new Clientes();
                    $cliente->setCoc($columns[0]);
                    $cliente->setMciCorrespondente($columns[1]);
                    
                    $sexoDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SexoDAO($this->getDoctrine()->getManager());
                    $sexo    = $sexoDAO->findById($columns[2]);
                    
                    $cliente->setSexosSexo($sexo);
                    
                    $convenioDAO = new ConvenioDAO($this->getDoctrine()->getManager());
                    $resultMCI   = $convenioDAO->finByNumConvenio($columns[3]);
                    
                    if($resultMCI) {
                        $cliente->setConvenio($resultMCI[0]);
                    } else {
                        $convenio = new Convenio();
                        $convenio->setMciEmpCliente($columns[3]);
                        $convenio->setNomeConvenio($columns[3]);
                        $cliente->setConvenio($convenio);
                    }
                   
                    $limiteCreditoNovoDAO = new LimiteCreditoNovoDAO($this->getDoctrine()->getManager());
                    $resultlimiteCredito  = $limiteCreditoNovoDAO->findById($columns[4]);
                    
                    if($resultlimiteCredito) {
                        $cliente->setLimiteCreditoNovo($resultlimiteCredito);
                    } else {
                        $cliente->setLimiteCreditoNovo($limiteCreditoNovoDAO->findById(2));
                    }                   
                    
                    $superEstadual    = null;
                    $superEstadualDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SuperEstadualDAO($this->getDoctrine()->getManager());
                    $objEstadual      = $superEstadualDAO->findCod($columns[5]);
                    
                    if($objEstadual) {
                        $superEstadual = $objEstadual[0];
                    } else {
                        $superEstadual = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual();
                        $superEstadual->setUf($columns[5]);
                        $superEstadual->setCodSuperEstadual($columns[6]);
                    }            
                    
                    $cliente->setSuperEstadualSuperEstadual($superEstadual);
                    
                    $superRegional    = null;
                    $superRegionalDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SuperRegionalDAO($this->getDoctrine()->getManager());
                    $objRegional      = $superRegionalDAO->findCod(trim($columns[7]));
                    
                    if($objRegional) {
                       $superRegional =  $objRegional[0];
                    } else {
                        $superRegional = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional();
                        $superRegional->setCodSuperRegional($columns[7]);                       
                    }           
                    
                    $cliente->setSuperRegionalSuperRegional($superRegional);
                    
                    $ag = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Ag();
                    $ag->setPrefixoAg($columns[8]);
                    $ag->setCcAg($columns[9]);
                    
                    $cliente->setAgAg($ag);
                    $cliente->setNomeCliente($columns[10]);                    
                    $cliente->setCpfCliente($columns[11]);
                    $cliente->setMciCliente($columns[12]);
                    $cliente->setDddFoneResidCliente($columns[13]);
                    $cliente->setFoneResidCliente($columns[14]);
                    $cliente->setDddFoneComerCliente($columns[15]);
                    $cliente->setFoneComerCliente($columns[16]);
                    $cliente->setDddFoneCelCliente($columns[17]);
                    $cliente->setFoneCelCliente($columns[18]);
                    $cliente->setDddFonePrefCliente($columns[19]);
                    $cliente->setFonePrefCliente($columns[20]);
                    //$cliente->setCodCliente($columns[21]);                    
                    $cliente->setNumBeneficioCliente($columns[21]);  
                    $cliente->setDvCliente((int) $columns[22]);
                    
                    #Trantando a data
                    //$dataBrasil = \DateTime::createFromFormat("d/m/y", $columns[23]);                    
                    $cliente->setDataNascCliente(\DateTime::createFromFormat("Y-m-d", $columns[23], new \DateTimeZone("America/Recife")));                     
                    $cliente->setStatusEmChamada(false);                                       
                    
                    $numBeneficio     = $columns[24];
                    $qtdNumBeneficio  = strlen($numBeneficio);

                    if($qtdNumBeneficio < 10) {
                        $numBeneficio = str_repeat("0", 10 - $qtdNumBeneficio) .  $numBeneficio;
                    }                    
                    
                    $cliente->setNumBeneficioComp($numBeneficio);
                    $cliente->setStatusConsulta(false);
                  
                    #Valida o cliente
                    $clienteVal = $validator->validate($cliente);
                    
                    #Verifica se houve alguma violação na validação
                    if(count($clienteVal) === 0) {                        
                        $clienteDAO->insertCliente($cliente);
                    } else {
                        $this->get("session")->getFlashBag()->add('danger', (string) $clienteVal);
                        break;
                    }                   
                    
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
                "a.cpfCliente",
                "a.dddFoneResidCliente",
                "a.foneResidCliente",
                "a.qtdConsultas",
                "a.dddFoneComerCliente",
                "a.foneComerCliente",
                "a.dddFoneCelCliente",
                "a.foneCelCliente",
                "a.foneCelCliente",
                "a.numBeneficioCliente",
                "b.nomeExtensoSexo",
                "a.dataNascCliente",
                );

            $entityJOIN = array("sexosSexo");             
            $eventosArray         = array();
            $parametros           = $request->request->all();
            $count                = 0;
            $countNot             = 0;
            $statusLigacao        = false;
            
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
                $consultas = $resultCliente[$i]->getConsultas();                
                $consulta  = $consultas->last();
                
                if($consulta) {
                    $statusLigacao = $consulta->getStatusLigacao();
                }
                
                if( !$statusLigacao) {
                    $eventosArray[$count]['DT_RowId']       =  "row_".$resultCliente[$i]->getIdCliente();
                    $eventosArray[$count]['nome']           =  $resultCliente[$i]->getNomeCliente();
                    $eventosArray[$count]['mci']            =  is_null($resultCliente[$i]->getConvenio()) ? null : $resultCliente[$i]->getConvenio()->getMciEmpCliente();

                    $cpf                                    = $resultCliente[$i]->getCpfCliente();
                    $cpfLen                                 = strlen($cpf);

                    if($cpfLen < 11) {
                        $cpf = str_repeat("0", 11 - $cpfLen) .  $cpf;
                    }             
                    
                    $eventosArray[$count]['qtdConsultas']   =  $resultCliente[$i]->getQtdConsultas();
                    $eventosArray[$count]['cpf']            =  $cpf;
                    $eventosArray[$count]['dddFoneRes']     =  $resultCliente[$i]->getDddFoneResidCliente();
                    $eventosArray[$count]['FoneRes']        =  $resultCliente[$i]->getFoneResidCliente();
                    $eventosArray[$count]['dddFoneCom']     =  $resultCliente[$i]->getDddFoneComerCliente();
                    $eventosArray[$count]['FoneCom']        =  $resultCliente[$i]->getFoneComerCliente();
                    $eventosArray[$count]['dddFoneCel']     =  $resultCliente[$i]->getDddFoneCelCliente();
                    $eventosArray[$count]['FoneCel']        =  $resultCliente[$i]->getFoneCelCliente();

                    $numBeneficio                           =  $resultCliente[$i]->getNumBeneficioCliente();
                    $dvCliente                              =  $resultCliente[$i]->getDvCliente();

                    $eventosArray[$count]['numBeneficio']   =  $resultCliente[$i]->getNumBeneficioComp();                
                    $eventosArray[$count]['Sexo']           =  $resultCliente[$i]->getSexosSexo()->getNomeExtensoSexo();
                    $eventosArray[$count]['dtNascimento']   =  $resultCliente[$i]->getDataNascCliente()->format('d/m/Y'); 
                    
                    
                    $count++;
                } else {
                    $countNot++;
                }
                
                $statusLigacao = false;
            }

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal - $countNot;
            } else {
                $countEventos -= $countNot;
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
            
            $columns = array("a.id",
                "a.valorBruto",
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
                "a.margemCliente",
                "a.valorDisponivelCliente",
                "a.tipoCreditoCliente",
                "a.tipoCreditoConsignado",
                "a.statusGerarArquiRetorno",       
                );

            $entityJOIN = array(); 

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
            
            $consultaDAO = new ConsultaClienteDAO($this->getDoctrine()->getManager());
            
            for($i=0;$i < $countEventos; $i++)
            {
                $eventosArray[$i]['DT_RowId']       =  "row_".$resultCliente[$i]->getId();
                $eventosArray[$i]['nome']           =  $resultCliente[$i]->getNomeSegurado();
                $eventosArray[$i]['id']             =  $resultCliente[$i]->getNomeSegurado();
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
                $eventosArray[$i]['dataConsulta']           =  $resultCliente[$i]->getDataConsulta()->format("d/m/Y");
                
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
                $eventosArray[$i]['margem']                 =  $resultCliente[$i]->getMargemCliente();
                $eventosArray[$i]['vDisponivel']            =  $resultCliente[$i]->getValorDisponivelCliente();
                $eventosArray[$i]['tipoCredito']            =  $resultCliente[$i]->getTipoCreditoCliente();
                
                $tipoCredito = $resultCliente[$i]->getTipoCreditoCliente();
                if($tipoCredito == "3") {
                    $antecipacoes = $resultCliente[$i]->getAntecipacoes13();
                    if($antecipacoes && count($antecipacoes) >= "2") {
                        $eventosArray[$i]['DecTerUmValorD']     =  $antecipacoes[0]->getValorDisponivel();
                        $eventosArray[$i]['DecTerUmValorP']     =  $antecipacoes[0]->getValorPrestacao();
                        $eventosArray[$i]['DecTerUmDataV']      =  $antecipacoes[0]->getDataVencimento()->format('d/m/Y');
                        
                        $eventosArray[$i]['DecTerDoisValorD']   =  $antecipacoes[1]->getValorDisponivel();
                        $eventosArray[$i]['DecTerDoisValorP']   =  $antecipacoes[1]->getValorPrestacao();
                        $eventosArray[$i]['DecTerDoisDataV']    =  $antecipacoes[1]->getDataVencimento()->format('d/m/Y');
                    }
                }
                
                $eventosArray[$i]['bloqueioSalve'] = "0";
                
                $chamadas = $consultaDAO->ConsultaClienteChamadas($resultCliente[$i]->getId());
                
                if($chamadas && count($chamadas) > 0) {
                   $eventosArray[$i]['bloqueioSalve'] = "1";
                }
                //var_dump(count($chamadas));exit();
                               
                $eventosArray[$i]['CreditoConsignado']      =  $resultCliente[$i]->getTipoCreditoConsignado();
                $eventosArray[$i]['GerarArquiRetorno']      =  $resultCliente[$i]->getStatusGerarArquiRetorno();
               
                $numBeneficio                       = $resultCliente[$i]->getClientesCliente()->getNumBeneficioCliente();
                $dvCliente                          = $resultCliente[$i]->getClientesCliente()->getDvCliente();
                $numBeneficio                       = $numBeneficio . $dvCliente;
                $qtdNumBeneficio                    = strlen($numBeneficio);
                
                $countChamadas = count($resultCliente[$i]->getChamadasCliente());
                
                if($countChamadas > 0 && $resultCliente[$i]->getStatusLigacao() == false) {
                    $eventosArray[$i]['bloqueioAtivacao']       = "1";
                    $eventosArray[$i]['DisponibilidadeLigação'] = "NÂO";
                } else if($resultCliente[$i]->getStatusLigacao() == true) {
                    $eventosArray[$i]['bloqueioAtivacao']       = "2";
                    $eventosArray[$i]['DisponibilidadeLigação'] = "SIM";
                } else if ($resultCliente[$i]->getStatusLigacao() == false) {
                    $eventosArray[$i]['bloqueioAtivacao']       = "0";
                    $eventosArray[$i]['DisponibilidadeLigação'] = "NÃO";
                }
                
                if($qtdNumBeneficio < 10) {
                    $numBeneficio = str_repeat("0", 10 - $qtdNumBeneficio) .  $numBeneficio;
                }
                
                $emprestimos = array();
                
                foreach ($resultCliente[$i]->getEmprestimos() as $index => $emprestimo) {
                    
                   $emprestimos[$index]['nome']         =  $emprestimo->getEmprestimo();
                   $emprestimos[$index]['valor']        =  $emprestimo->getValor();
                   $emprestimos[$index]['id']           =  $emprestimo->getIdEmprestimo();
                   $emprestimos[$index]['status']       =  $emprestimo->getStatusBBEmprestimo();
                   
                }
                
                $eventosArray[$i]['emprestimos']        =  $emprestimos;
                $eventosArray[$i]['numBeneficio']       =  $numBeneficio;                
                $eventosArray[$i]['Sexo']               =  $resultCliente[$i]->getClientesCliente()->getSexosSexo()->getNomeExtensoSexo();
                $eventosArray[$i]['dtNascimento']       =  $resultCliente[$i]->getClientesCliente()->getDataNascCliente()->format('d/m/Y');
                $eventosArray[$i]['obsErro']            =  $resultCliente[$i]->getObsErro();
                $eventosArray[$i]['statusErro']         =  $resultCliente[$i]->getStatusErro();
                $eventosArray[$i]['ag']                 =  $resultCliente[$i]->getClientesCliente()->getAgAg()->getCcAg();
                $eventosArray[$i]['prefixo_ag']         =  $resultCliente[$i]->getClientesCliente()->getAgAg()->getPrefixoAg();
                $eventosArray[$i]['statusLigacao']      =  $resultCliente[$i]->getStatusLigacao();
            }
            
            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()) {
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
     * @Route("/viewGridDadosTwo", name="viewGridDadosTwo")
     * @Template()
     */
    public function viewGridDadosTwoAction()
    {      
        return array();
    }
    
    /**
     * @Route("/dadosGridTwo")
     * @Method({"POST"})
     * @Template("MBCreditoBundle:Default:viewGridDadosTwo.html.twig")
     */
    public function dadosGridTwoAction(Request $request)
    {
        
        if(GridClass::isAjax()) {
            
            $columns = array("a.id",
                "a.valorBruto",
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
                "a.margemCliente",
                "a.valorDisponivelCliente",
                "a.tipoCreditoCliente",
                "a.tipoCreditoConsignado",
                "a.statusGerarArquiRetorno",
                );

            $entityJOIN = array(); 

            $eventosArray        = array();
            $parametros          = $request->request->all();
            $count                = 0;
            $countNot             = 0;
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
            
            $consultaDAO = new ConsultaClienteDAO($this->getDoctrine()->getManager());
            
            for($i=0;$i < $countEventos; $i++)
            {
                $consultaChamada = $consultaDAO->ConsultaClienteChamadasGrid($resultCliente[$i]->getId());
                
                if(!$consultaChamada) {
                                   
                    $eventosArray[$count]['DT_RowId']       =  "row_".$resultCliente[$i]->getId();
                    $eventosArray[$count]['nome']           =  $resultCliente[$i]->getNomeSegurado();
                    $eventosArray[$count]['id']             =  $resultCliente[$i]->getNomeSegurado();
                    $eventosArray[$count]['valorBruto']     =  $resultCliente[$i]->getValorBruto();

                    $cpf                                    = $resultCliente[$i]->getClientesCliente()->getCpfCliente();
                    $cpfLen                                 = strlen($cpf);

                    if($cpfLen < 11) {
                        $cpf = str_repeat("0", 11 - $cpfLen) .  $cpf;
                    }             

                    $eventosArray[$count]['cpf']                    =  $cpf;
                    $eventosArray[$count]['valorDescontos']         =  $resultCliente[$i]->getValorDescontos();
                    $eventosArray[$count]['valorLiquido']           =  $resultCliente[$i]->getValorLiquido();
                    $eventosArray[$count]['qtdEmprestimos']         =  $resultCliente[$i]->getQtdEmprestimos();
                    $eventosArray[$count]['competencia']            =  $resultCliente[$i]->getCompetencia();
                    $eventosArray[$count]['pagtoAtravez']           =  $resultCliente[$i]->getPagtoAtravez();
                    $eventosArray[$count]['dataConsulta']           =  $resultCliente[$i]->getDataConsulta()->format("d/m/Y");

                    if($resultCliente[$i]->getPeriodoIni()){
                        $eventosArray[$count]['periodoIni']         =  $resultCliente[$i]->getPeriodoIni()->format('d/m/Y');
                    }else {
                        $eventosArray[$count]['periodoIni']         =  "";
                    }

                    if($resultCliente[$i]->getPeriodoFin()){
                        $eventosArray[$count]['periodoFin']         =  $resultCliente[$i]->getPeriodoFin()->format('d/m/Y');
                    } else {
                        $eventosArray[$count]['periodoFin']         = "";
                    }

                    $eventosArray[$count]['especie']                =  $resultCliente[$i]->getEspecie();
                    $eventosArray[$count]['banco']                  =  $resultCliente[$i]->getBanco();
                    $eventosArray[$count]['agencia']                =  $resultCliente[$i]->getAgencia();
                    $eventosArray[$count]['codigoAgencia']          =  $resultCliente[$i]->getCodigoAgencia();
                    $eventosArray[$count]['enderecoBanco']          =  $resultCliente[$i]->getEnderecoBanco();
                    $eventosArray[$count]['obsCliente']             =  $resultCliente[$i]->getObsCliente();
                    $eventosArray[$count]['margem']                 =  $resultCliente[$i]->getMargemCliente();
                    $eventosArray[$count]['vDisponivel']            =  $resultCliente[$i]->getValorDisponivelCliente();
                    $eventosArray[$count]['tipoCredito']            =  $resultCliente[$i]->getTipoCreditoCliente();

                    $tipoCredito = $resultCliente[$i]->getTipoCreditoCliente();
                    if($tipoCredito == "3") {
                        $antecipacoes = $resultCliente[$i]->getAntecipacoes13();
                        if($antecipacoes && count($antecipacoes) >= "2") {
                            $eventosArray[$count]['DecTerUmValorD']     =  $antecipacoes[0]->getValorDisponivel();
                            $eventosArray[$count]['DecTerUmValorP']     =  $antecipacoes[0]->getValorPrestacao();
                            $eventosArray[$count]['DecTerUmDataV']      =  $antecipacoes[0]->getDataVencimento()->format('d/m/Y');

                            $eventosArray[$count]['DecTerDoisValorD']   =  $antecipacoes[1]->getValorDisponivel();
                            $eventosArray[$count]['DecTerDoisValorP']   =  $antecipacoes[1]->getValorPrestacao();
                            $eventosArray[$count]['DecTerDoisDataV']    =  $antecipacoes[1]->getDataVencimento()->format('d/m/Y');
                        }
                    }

                    $eventosArray[$count]['bloqueioSalve'] = "0";

                    $chamadas = $consultaDAO->ConsultaClienteChamadas($resultCliente[$i]->getId());

                    if($chamadas && count($chamadas) > 0) {
                       $eventosArray[$count]['bloqueioSalve'] = "1";
                    }
                    //var_dump(count($chamadas));exit();

                    $eventosArray[$count]['CreditoConsignado']      =  $resultCliente[$i]->getTipoCreditoConsignado();
                    $eventosArray[$count]['GerarArquiRetorno']      =  $resultCliente[$i]->getStatusGerarArquiRetorno();

                    $numBeneficio                                   = $resultCliente[$i]->getClientesCliente()->getNumBeneficioCliente();
                    $dvCliente                                      = $resultCliente[$i]->getClientesCliente()->getDvCliente();
                    $numBeneficio                                   = $numBeneficio . $dvCliente;
                    $qtdNumBeneficio                                = strlen($numBeneficio);

                    $countChamadas = count($resultCliente[$i]->getChamadasCliente());

                    if($countChamadas > 0 && $resultCliente[$i]->getStatusLigacao() == false) {
                        $eventosArray[$count]['bloqueioAtivacao']       = "1";
                        $eventosArray[$count]['DisponibilidadeLigação'] = "NÂO";
                    } else if($resultCliente[$i]->getStatusLigacao() == true) {
                        $eventosArray[$count]['bloqueioAtivacao']       = "2";
                        $eventosArray[$count]['DisponibilidadeLigação'] = "SIM";
                    } else if ($resultCliente[$i]->getStatusLigacao() == false) {
                        $eventosArray[$count]['bloqueioAtivacao']       = "0";
                        $eventosArray[$count]['DisponibilidadeLigação'] = "NÃO";
                    }

                    if($qtdNumBeneficio < 10) {
                        $numBeneficio = str_repeat("0", 10 - $qtdNumBeneficio) .  $numBeneficio;
                    }

                    $emprestimos = array();

                    foreach ($resultCliente[$i]->getEmprestimos() as $index => $emprestimo) {

                       $emprestimos[$index]['nome']     =  $emprestimo->getEmprestimo();
                       $emprestimos[$index]['valor']    =  $emprestimo->getValor();
                       $emprestimos[$index]['id']       =  $emprestimo->getIdEmprestimo();
                       $emprestimos[$index]['status']   =  $emprestimo->getStatusBBEmprestimo();

                    }

                    $eventosArray[$count]['emprestimos']        =  $emprestimos;
                    $eventosArray[$count]['numBeneficio']       =  $numBeneficio;                
                    $eventosArray[$count]['Sexo']               =  $resultCliente[$i]->getClientesCliente()->getSexosSexo()->getNomeExtensoSexo();
                    $eventosArray[$count]['dtNascimento']       =  $resultCliente[$i]->getClientesCliente()->getDataNascCliente()->format('d/m/Y');
                    $eventosArray[$count]['obsErro']            =  $resultCliente[$i]->getObsErro();
                    $eventosArray[$count]['statusErro']         =  $resultCliente[$i]->getStatusErro();
                    $eventosArray[$count]['ag']                 =  $resultCliente[$i]->getClientesCliente()->getAgAg()->getCcAg();
                    $eventosArray[$count]['prefixo_ag']         =  $resultCliente[$i]->getClientesCliente()->getAgAg()->getPrefixoAg();
                    $eventosArray[$count]['statusLigacao']      =  $resultCliente[$i]->getStatusLigacao();

                    $count++;
                } else {
                    $countNot++;
                }
            }
            
            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal - $countNot;
            } else {
                $countEventos -= $countNot;
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
     * 
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
        } else {
            $nomeEmp = "";
        }
        
        if(isset($dados['valorEmprestimo'])) {
            $valoresEmp     = $dados['valorEmprestimo'];
        } else {
            $valoresEmp = "";
        }      
        $statusErro     = $dados['erro'];
        $obsErro        = $dados['msgerro'];
        
        $clienteDAO         = new ClienteDAO($this->getDoctrine()->getManager());
        $codBenefi          = str_replace(array(".","-"), "", $codBenefi);                
        $cliente            = $clienteDAO->findNumBeneficio($codBenefi);        
        $consultaCliente    = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente();
        $consultaCliente->setDataConsulta(new \DateTime("now"));
        $consultaClienteDAO = new ConsultaClienteDAO($this->getDoctrine()->getManager());
        
        if(count($cliente) > 0) {
            $consultaCliente->setStatusConsulta(true);
            $cliente[0]->setQtdConsultas(($cliente[0]->getQtdConsultas() + 1));
            
            if($statusErro === '1') {
                $consultaCliente->setStatusErro(true);
                $consultaCliente->setObsErro($obsErro);
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
            $consultaCliente->setStatusErro(false);
            $consultaCliente->setStatusPendencia(false);
            
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
           
            if($nomeEmp) {
                for ($i = 0; $i < count($nomeEmp); $i++) {
                    $emprestimo     = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos();
                    $emprestimo->setEmprestimo($nomeEmp[$i]);

                    $valoresEmp[$i] = str_replace($source, $replace, $valoresEmp[$i]);
                    $emprestimo->setValor($valoresEmp[$i]);

                    $consultaCliente->addEmprestimo($emprestimo);
                }
            }
            
            $consultaCliente->setClientesCliente($cliente[0]);            
            
            
            $validator = $this->get("validator");
            $valResult = $validator->validate($consultaClienteDAO);
            
            if(count($valResult) == 0) {
                $result = $consultaClienteDAO->insert($consultaCliente);
                
                if($result) {
                    $this->get("session")->getFlashBag()->add('success', "Dados Salvos com sucesso!");     
                } else {
                    $this->get("session")->getFlashBag()->add('danger', "Error ao salvar os dados!");     
                }
            } else {
                 $this->get("session")->getFlashBag()->add('danger', (string) $valResult);
            }
            
            
            
        } else {
             $this->get("session")->getFlashBag()->add('danger', "Cliente não encontrado!");     
        }
        
        return $this->redirect($this->generateUrl("inserirDados"));
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
        $margem       = trim($req['margem']);
        $vDisponivel  = trim($req['vDisponivel']);
        
        $antecipacao     = false;
        $antercipacao131 = new Antecipacao13();
        $antercipacao132 = new Antecipacao13();
        
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
        
        if(isset($req['tCreditoPess'])) {
            $tCreditoPess  = $req['tCreditoPess'];
            
            if($tCreditoPess == 3) {                
                $antercipacao131->setValorDisponivel($req['vDispon'][0]);
                $antercipacao131->setDataVencimento(\DateTime::createFromFormat("d/m/Y", $req['dataVecimento'][0]));
                $antercipacao131->setValorPrestacao($req['vPrest'][0]);
                
                $antercipacao132->setValorDisponivel($req['vDispon'][1]);
                $antercipacao132->setDataVencimento(\DateTime::createFromFormat("d/m/Y", $req['dataVecimento'][1]));
                $antercipacao132->setValorPrestacao($req['vPrest'][1]);
                
                $antecipacao = true;
            }
            
        } else {
            $tCreditoPess  = null;
        }
        
        
        
        $tCreditoCon = isset($req['tCreditoCon']) ? $req['tCreditoCon']: "";
        
        $statusArquivoRetorno = isset($req['statusArquivoRetorno']) ? $req['statusArquivoRetorno']: null;
        
        $consultaClienteDAO = new ConsultaClienteDAO($this->getDoctrine()->getManager());
        $emprestimoDAO      = new \SerBinario\MBCredito\MBCreditoBundle\DAO\EmprestimoDAO($this->getDoctrine()->getManager());
        
        if($obs || $emprestimos || $statusAtivo || $margem 
                || $vDisponivel || $tCreditoPess || $tCreditoCon || $statusArquivoRetorno){
            
            //Primeito o cliente é consultado
            $cliente = $consultaClienteDAO->findConsultaCliente($id);
            
            //Verifica se o cliente existe
            if($cliente) {              
                if($antecipacao) { 
                    $consultaClienteDAO->removeAllAntecipacoes($cliente[0]->getAntecipacoes13());
                    $cliente[0]->removeAllAntecipacao();
                    
                    $cliente[0]->addAntecipacao13($antercipacao131);
                    $cliente[0]->addAntecipacao13($antercipacao132);
                }                    
                
                #Verifica o status ativo.
                if(isset($req['statusAtivo'])) {
                    $cliente[0]->setStatusLigacao(true); 
                }
                
                //Seta o valor do campo observação para o cliente
                $cliente[0]->setObsCliente($obs);
                //
                $cliente[0]->setMargemCliente($margem);
                //
                $cliente[0]->setValorDisponivelCliente($vDisponivel);
                //
                if($tCreditoPess){                    
                    $cliente[0]->setTipoCreditoCliente($tCreditoPess);
                    $cliente[0]->setTipoCreditoConsignado(0);
                    
                    if($tCreditoPess != 3) {
                        $consultaClienteDAO->removeAllAntecipacoes($cliente[0]->getAntecipacoes13());
                    }
                }
                //
                if($tCreditoCon){
                    $cliente[0]->setTipoCreditoConsignado($tCreditoCon);
                    $cliente[0]->setTipoCreditoCliente(0);
                    $consultaClienteDAO->removeAllAntecipacoes($cliente[0]->getAntecipacoes13());
                }
                //
                if($statusArquivoRetorno) {
                    $cliente[0]->setStatusGerarArquiRetorno(true);
                } else {
                    $cliente[0]->setStatusGerarArquiRetorno(false);
                }
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
                } else {
                    $this->get("session")->getFlashBag()->add('danger', "Error ao salvar os dados!");                     
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
        #Recupera o usuário da sessão
        $usuario    = $this->get("security.context")->getToken()->getUser();
        
        #Recuperando o validator
        $validator  = $this->get("validator");
        
        #Instanciando a classe de regra de negócio
        $discagemRN = new DiscagemRN($this->getDoctrine()->getManager(), $usuario, $validator);
        
        #execuando a discagem
        $result = $discagemRN->discagem();
        
        #Verificando se houve algum erro retornado
        if( !is_null($result['error'])) {
            $this->get("session")->getFlashBag()->add($result['type'], (string) $result['error']);
        }
        
        #Retorno
        return $result;        
    }
    
    /**
     * @Route("/saveDiscagem", name="saveDiscagem")
     * @Method({"POST"})
     */
    public function saveDiscagemAction(Request $request)
    {
        #Recupera a requisição
        $dados  = $request->request->all();
        
        #Recupera o usuário da sessão
        $usuario    = $this->get("security.context")->getToken()->getUser();
        
        #Recuperando o validator
        $validator  = $this->get("validator");
        
        #Recupera os parâmetros da requisição
        $statusId     = $dados['status'];
        $subrotinaId  = $dados['subrotinas'];
        $dtProxLig    = $dados['dataProxLiguacao'];
        $obs          = $dados['obs'];
        $chamadaAtual = $dados['chamadaAtual'];
        $newDDD       = $dados['newDDD'];
        $newFone      = $dados['newFone'];
        $chamadaAnt   = $dados['chamadaAnterior'];
        
        #Criação de um objeto chamada
        $chamadaDados = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente();
        $chamadaDados->setObservacao($obs);
        $chamadaDados->setNovoDDD($newDDD);
        $chamadaDados->setNovoFone($newFone);
        
        #Criação do objeto discagemRN.
        $discagemRN  = new DiscagemRN($this->getDoctrine()->getManager(), $usuario, $validator);
        
        #Executando o método saveDiscagem para salvar a ligação
        $resultArray = $discagemRN->saveDiscagem($chamadaAtual, $chamadaDados, $statusId, $subrotinaId, $dtProxLig, $chamadaAnt);
        
        #Verificando se houve algum erro retornado
        if( !is_null($resultArray['error'])) {
            $this->get("session")->getFlashBag()->add($resultArray['type'], (string) $resultArray['error']);
        }
        
        #Retorno
        return $this->redirect($this->generateUrl("viewDiscagem"));     
    }    
    
    /**
     * @Route("/getSubrotinas", name="getSubrotinas")
     * @Method({"POST"})
     */
    public function getSubrotinasAction(Request $request)
    {
        $idStatus = $request->request->get("id");
        
        $subRotinasDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SubRotinasDAO($this->getDoctrine()->getManager());
        $subRotinas    = $subRotinasDAO->findByIdStatus($idStatus);
        
        $result = array(
            "subrotinas" => $subRotinas
        );
        
        return new JsonResponse($result);
    }
    
    /**
     * @Route("/viewSaveUser", name="viewSaveUser")
     * @Template("")
     * @Method({"GET"})
     */
    public function viewSaveUserAction()
    {
        $roleDAO  = new RoleDAO($this->getDoctrine()->getManager());
        $arrayObj = $roleDAO->getRoles();
        
        return array("roles" => $arrayObj);
    }
    
    /**
     * @Route("/viewEditUser/id/{id}", name="viewEditUser")
     * @Template("")
     * @Method({"GET"})
     */
    public function viewEditUserAction($id)
    {
        $roleDAO  = new RoleDAO($this->getDoctrine()->getManager());
        $arrayObj = $roleDAO->getRoles();
        
        $userDAO  = new UserDAO($this->getDoctrine()->getManager());
        $user     = $userDAO->findById($id);
        
        return array("roles" => $arrayObj, "user" => $user);
    }
    
    /**
     * @Route("/saveUser", name="saveUser")
     * @Method({"POST"})
     */
    public function saveUserAction(Request $request)
    {
        $dados = $request->request->all();
        
        $username = $dados['username'];
        $senha    = $dados['senha'];
        $email    = $dados['email'];
        $roleId   = $dados['perfil'];
        
        if(empty($roleId)) {
            $this->get("session")->getFlashBag()->add('danger', "Você deve informar um perfil"); 
            return $this->redirect($this->generateUrl("viewSaveUser"));
        }         
               
        $user = new \SerBinario\MBCredito\UserBundle\Entity\User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setIsActive(true);
        
        $factory   = $this->get('security.encoder_factory');
        $validator = $this->get('validator');
        
        $encoder  = $factory->getEncoder($user);
        $password = $encoder->encodePassword($senha, $user->getSalt());
        $user->setPassword($password);              
        
        $roleDAO  = new RoleDAO($this->getDoctrine()->getManager());        
        $role     = $roleDAO->getRole($roleId);
        
        $user->addRole($role);
        
        $userVal = $validator->validate($user);
        
        if( !count($userVal) > 0) {
            $userDAO = new UserDAO($this->getDoctrine()->getManager());
            
            $valUser  = $userDAO->findByEmailOrUsename($user->getUsername());
            $valEmail = $userDAO->findByEmailOrUsename($user->getEmail());
            
            if($valUser ||  $valEmail) {              
                $this->get("session")->getFlashBag()->add('danger', "Email ou Login já existentes!");
            } else {               
                $result  = $userDAO->save($user);            
                
                if($result) {
                    $this->get("session")->getFlashBag()->add('success', "Usuário cadastrado com sucesso!"); 
                } else {             
                    $this->get("session")->getFlashBag()->add('danger', "Erro ao cadastrar o usuário"); 
                }   
            }                
 
        } else {
            $this->get("session")->getFlashBag()->add('danger', (string) $userVal); 
        }
                
        return $this->redirect($this->generateUrl("viewGridListaUser"));
    }
    
    /**
     * @Route("/editUser", name="editUser")
     * @Method({"POST"})
     */
    public function editUserAction(Request $request)
    {
        $dados = $request->request->all();
        
        $username = $dados['username'];
        $senha    = $dados['senha'];
        $email    = $dados['email'];
        $roleId   = $dados['perfil'];
        $idUser   = $dados['userid'];
               
        $userDAO  = new UserDAO($this->getDoctrine()->getManager());
        
        $user     = $userDAO->findById($idUser);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setIsActive(true);
        
        if(!empty($senha)) {
            $factory  = $this->get('security.encoder_factory');
        
            $encoder  = $factory->getEncoder($user);
            $password = $encoder->encodePassword($senha, $user->getSalt());
            $user->setPassword($password);   
        }                  
        
        $roleDAO  = new RoleDAO($this->getDoctrine()->getManager());        
        $role     = $roleDAO->getRole($roleId);
        
        $user->removeAllRole();
        $user->addRole($role);
        
        $result  = $userDAO->update($user);
        
        if($result) {
            $this->get("session")->getFlashBag()->add('success', "Usuário cadastrado com sucesso!"); 
        } else {             
            $this->get("session")->getFlashBag()->add('danger', "Erro ao cadastrar o usuário"); 
        }        
        
        return $this->redirect($this->generateUrl("viewGridListaUser"));
    }
    
    /**
     * @Route("/viewGridListaUser", name="viewGridListaUser")
     * @Template()
     */
    public function viewGridListaUserAction(Request $request)
    {
        if(GridClass::isAjax()) {
            
            $columns = array(  
                    "a.username",
                    "a.email"
                );

            $entityJOIN = array(); 

            $convenioArray    = array();
            $parametros       = $request->request->all();        
            $entity           = "SerBinario\MBCredito\UserBundle\Entity\User"; 
            $columnWhereMain  = "";
            $whereValueMain   = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain);

            $resultConvenio     = $gridClass->builderQuery();    
            $countTotal         = $gridClass->getCount();
            $countConvenio      = count($resultConvenio);
            
            for($i=0;$i < $countConvenio; $i++)
            {
                $convenioArray[$i]['DT_RowId']       =  "row_".$resultConvenio[$i]->getId();
                $convenioArray[$i]['id']             =  $resultConvenio[$i]->getId();
                $convenioArray[$i]['name']           =  $resultConvenio[$i]->getUsername();
                $convenioArray[$i]['email']          =  $resultConvenio[$i]->getEmail();
                $convenioArray[$i]['roles']          = "";
                
                $countRoles = count($resultConvenio[$i]->getRoles());

                for($j = 0; $j < $countRoles; $j++){
                    $convenioArray[$i]['roles'] = $resultConvenio[$i]->getRoles()[$j]->getName();
                }
                
            }          
                        
            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()) {
                $countConvenio = $countTotal;
            } 
            
            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countConvenio}",
                'data'              => $convenioArray               
            );

            return new JsonResponse($columns);
        }else {            
            return array();            
        }
    }
    
    /**
     * @Route("/viewGridListaPa", name="viewGridListaPa")
     * @Template()
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function viewGridListaPaAction(Request $request)
    {   
        if(GridClass::isAjax()) {
            
            $columns = array(  
                    "a.username",
                    "a.email"
                );

            $entityJOIN = array(); 

            $userArray        = array();
            $boolPa           = false;
            $countBoolPa      = 0;
            $count            = 0;
            $parametros       = $request->request->all();        
            $entity           = "SerBinario\MBCredito\UserBundle\Entity\User"; 
            $columnWhereMain  = "";
            $whereValueMain   = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain);

            $resultUser     = $gridClass->builderQuery();    
            $countTotal     = $gridClass->getCount();
            $countUser      = count($resultUser);
            
            for($i=0;$i < $countUser; $i++)
            {
                $roles  = $resultUser[$i]->getRoles();
       
                foreach($roles as $role) {
                   if($role->getRole() === "ROLE_PA" || $role->getRole() === "ROLE_PA_CONSULTA") {
                       $boolPa = true;
                   }
                }
                
                if($boolPa) {
                    $userArray[$count]['DT_RowId']       =  "row_".$resultUser[$i]->getId();
                    $userArray[$count]['id']             =  $resultUser[$i]->getId();
                    $userArray[$count]['nome']           =  $resultUser[$i]->getUsername();
                    $userArray[$count]['email']          =  $resultUser[$i]->getEmail();  
                    
                    $convenioPaDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\ConvenioPaDAO($this->getDoctrine()->getManager());
                    $objConvenioPA = $convenioPaDAO->findByUserLast($resultUser[$i]); 
                    $estado        = "Nenhum estado anterior";
                    $nomeConvenio  = "Nenhum convênio anterior";
                   
                    if($objConvenioPA) {
                        $nomeConvenio  = $objConvenioPA->getConvenio()->getNomeConvenio();
                        $estado        = $objConvenioPA->getEstado();
                    }
                    
                    $userArray[$count]['nomeConvenio']   =  $nomeConvenio;
                    $userArray[$count]['estado']         =  $estado;
                                 
                    $count++;
                    $boolPa = false;
                } else {
                    $countBoolPa += 1;
                }                
                      
            }
            
            $countTotal -= $countBoolPa;            
            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()) {
                $countUser = $countTotal;
            } else {
                $countUser -= $countBoolPa;
            }
            
            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countUser}",
                'data'              => $userArray               
            );

            return new JsonResponse($columns);
        }else{  
            $convenioDAO      = new ConvenioDAO($this->getDoctrine()->getManager());
            $convenios        = $convenioDAO->findAll();
            
            $superEstadualDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\SuperEstadualDAO($this->getDoctrine()->getManager());
            $seperEstaduais   = $superEstadualDAO->findAll();
            
            return array("convenios" => $convenios, "estados" => $seperEstaduais);            
        }
    }
    
    /**
     * @Route("/saveConvenioPa", name="saveConvenioPa")
     */
    public function saveConvenioPaAction(Request $request) 
    {
        #Recuperando dados da requisição
        $dados = $request->request->all();
        
        $numConvenio = $dados['selectConvenio'];
        $estado      = $dados['selectUF'];
        $idPA        = $dados['idPa'];
      
        if($numConvenio != "") {
             #Recuperando o usuário
            $usuarioDAO = new UserDAO($this->getDoctrine()->getManager());
            $usuario    = $usuarioDAO->findById($idPA);       

            $convenioDAO = new ConvenioDAO($this->getDoctrine()->getManager());
            $convenio = $convenioDAO->finByNumConvenio($numConvenio);

            $convenioPA = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ConvenioPA();
            $convenioPA->setUser($usuario);
            $convenioPA->setData(new \DateTime("now"));
            $convenioPA->setConvenio($convenio[0]);
            $convenioPA->setEstado($estado);

            $convenioPaDAO = new \SerBinario\MBCredito\MBCreditoBundle\DAO\ConvenioPaDAO($this->getDoctrine()->getManager());

            $validator = $this->get("validator");
            $valResult = $validator->validate($convenioPA);

            if(count($valResult) == 0) {
                $result     = $convenioPaDAO->save($convenioPA);

                if($result) {
                     $this->get("session")->getFlashBag()->add('success', "Dados Salvos com sucesso!");                     
                } else {
                    $this->get("session")->getFlashBag()->add('danger', "Error ao salvar os dados!");                     
                }
            } else {
                $this->get("session")->getFlashBag()->add('danger', (string) $valResult);
            }
        } else {
            $this->get("session")->getFlashBag()->add('danger', "Você deve informar o convênio");
        }           
        
        return $this->redirect($this->generateUrl("viewGridListaPa"));
        
    }
    
    /**
     * @Route("/viewGridListaConvenio", name="viewGridListaConvenio")
     * @Template()
     */
    public function viewGridListaConvenioAction(Request $request)
    {
         if(GridClass::isAjax()) {
            
            $columns = array(  
                    "a.mciEmpCliente",
                    "a.nomeConvenio"
                );

            $entityJOIN = array(); 

            $convenioArray    = array();
            $parametros       = $request->request->all();        
            $entity           = "SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio"; 
            $columnWhereMain  = "";
            $whereValueMain   = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain);

            $resultConvenio     = $gridClass->builderQuery();    
            $countTotal         = $gridClass->getCount();
            $countConvenio      = count($resultConvenio);
            
            for($i=0;$i < $countConvenio; $i++)
            {
                $convenioArray[$i]['DT_RowId']       =  "row_".$resultConvenio[$i]->getId();
                $convenioArray[$i]['id']             =  $resultConvenio[$i]->getId();
                $convenioArray[$i]['numConvenio']    =  $resultConvenio[$i]->getMciEmpCliente();
                $convenioArray[$i]['nomeConvenio']   =  $resultConvenio[$i]->getNomeConvenio();              
                      
            }
                        
            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()) {
                $countConvenio = $countTotal;
            } 
            
            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countConvenio}",
                'data'              => $convenioArray               
            );

            return new JsonResponse($columns);
        }else {            
            return array();            
        }
    }
    
    /**
     * @Route("/viewUpdateConvenio/id/{id}", name="viewUpdateConvenio")
     * @Template()
     */
    public function viewUpdateConvenioAction($id)
    {   
        $convenioDAO = new ConvenioDAO($this->getDoctrine()->getManager());
        $convenio = $convenioDAO->findById($id);
        
        return array("convenio" => $convenio);
    } 
    
    /**
     * @Route("/updateConvenio", name="updateConvenio")
     */
    public function updateConvenioAction(Request $request)
    {   
        #Dados da requisição
        $dados = $request->request->all();
        
        #recuperado os parametros
        $numConvenio  = $dados['numConvenio'];
        $nomeConvenio = $dados['nomeConvenio'];
        
        #Instânciando o DAO e recuperando o Convenio corrente
        $convenioDAO = new ConvenioDAO($this->getDoctrine()->getManager());
        $convenio = $convenioDAO->finByNumConvenio($numConvenio);
        
        #Alterando o nome do convênio
        $convenio[0]->setNomeConvenio($nomeConvenio);
        
        
        $validator = $this->get("validator");
        $valResult = $validator->validate($convenio[0]);
        
        if(count($valResult) == 0) {
            #atualizando o convenio
            $result = $convenioDAO->update($convenio[0]);

            if($result) {
                 $this->get("session")->getFlashBag()->add('success', "Dados Salvos com sucesso!");                     
            } else {
                $this->get("session")->getFlashBag()->add('danger', "Error ao salvar os dados!");                     
            }
        } else {
            $this->get("session")->getFlashBag()->add('danger', (string) $valResult);
        }    
        
        return $this->redirect($this->generateUrl("viewGridListaConvenio"));
    }    
    
    /**
     * @Route("/viewGridHistorico", name="viewGridHistorico")
     * @Template()
     */
    public function viewGridHistoricoAction(Request $request)
    {
        if(GridClass::isAjax()) {
            
            $columns = array(  
                    "a.dataPendencia",
                    "a.dataChamada",                    
                    "b.nomeSegurado",
                    "c.username",
                );

            $entityJOIN = array("a.consultaCliente", "a.user"); 

            $chamadasArray    = array();
            $parametros       = $request->request->all();        
            $entity           = "SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente"; 
            $columnWhereMain  = "";
            $whereValueMain   = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain);

            $resultChamadas     = $gridClass->builderQuery();    
            $countTotal         = $gridClass->getCount();
            $countChamadas      = count($resultChamadas);
            
            for($i=0;$i < $countChamadas; $i++)
            {
                $chamadasArray[$i]['DT_RowId']      = "row_".$resultChamadas[$i]->getIdChamadaCliente();
                $chamadasArray[$i]['pendencia']     = $resultChamadas[$i]->getStatusPendencia() ? "SIM" : "NÂO";
                $chamadasArray[$i]['finalizada']    = $resultChamadas[$i]->getStatusChamada() ? "SIM" : "NÂO";
                $chamadasArray[$i]['dataChamada']   = is_object($resultChamadas[$i]->getDataChamada()) 
                        ? $resultChamadas[$i]->getDataChamada()->format("d/m/Y") : "VAZIO";
                $chamadasArray[$i]['dataPendencia'] = $resultChamadas[$i]->getDataPendencia()->format("d/m/Y");
                $chamadasArray[$i]['usuario']       = $resultChamadas[$i]->getUser()->getUsername();
                $chamadasArray[$i]['cliente']       = $resultChamadas[$i]->getConsultaCliente()->getClientesCliente()->getNomeCliente();
                $chamadasArray[$i]['observacao']    = $resultChamadas[$i]->getObservacao();
                
            }          
                        
            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()) {
                $countChamadas = $countTotal;
            } 
            
            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countChamadas}",
                'data'              => $chamadasArray               
            );

            return new JsonResponse($columns);
        }else {            
            return array();            
        }
    }
 
    /**
     * @Route("/consultaAgencia", name="consultaAgencia")
     * @Method({"POST"})
     */
    public function consultaAgenciaAction(Request $request)
    {
        $dado    = $request->request->all();
        $msg = "";
        
        $subcategoDAO = new SubcategoriasDAO($this->getDoctrine()->getManager());
        $subcategorias = $subcategoDAO->subcategoriaFindByCatego($dado['idCategoria']);
        
        if($subcategorias){
            $msg = "sucesso";
        } else {
            $msg = "erro";
        }
        
        $dados = array (
            "msg" => $msg,
            "dados" => $subcategorias
        );
        
        return new JsonResponse($dados);
    }
    
 }
