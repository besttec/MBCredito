<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Documento;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/importarArquivo")
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
        
        if(count($erros)) {
            
        }
        
    }
    
    /**
     * @Route("/inserirDados")
     * @Template()
     */
    public function viewInserirDadosAction()
    {
        return array();
    }
    
    /**
     * @Route("/inserirDados")
     * @Method({"POST"})
     * @Template("")
     */
    public function testeGridAction()
    {
        $Array = array();
        $Array[1]['DT_RowId'] =  1;
        $Array[1]["casa"]     = "casa";
        $Array[1]["Carro"]    = "Carro";
        $Array[1]["onibus"]   = "Ônibus";
        
        $columns = array(         
            'data' => $Array               
        );
        
        return new JsonResponse($columns);
    }
    
    
}
