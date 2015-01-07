<?php
namespace SerBinario\MBCredito\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class DefaultController extends Controller
{    
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        return 
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            );

    }
    
    /**
     * @Route("/save", name="save")
     */
    public function saveUserAction()
    {
        $user = new \SerBinario\MBCredito\UserBundle\Entity\User();
        $user->setUsername("fabio");
        $user->setEmail("fabio@gmail.com");
        $user->setIsActive(true);
        
        $factory = $this->get('security.encoder_factory');
        
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('fabio', $user->getSalt());
        $user->setPassword($password);        
                
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        echo "dsadsa";
    }
    
     /**
     * @Route("/savePerfil", name="savePerfil")
     */
    public function savePerfilAction()
    {      
        $dados = array(
            array('ADMIN', 'ROLE_ADMIN'),
            array('USER', 'ROLE_USER')
        );
        
        for($i = 0; $i < count($dados); $i++){
            $perfil = new \SerBinario\MBCredito\UserBundle\Entity\Role();
            $perfil->setName($dados[$i][0]);
            $perfil->setRole($dados[$i][1]);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($perfil);
            $em->flush();
        };
        
        echo "sucesso";
    }
    
     /**
     * @Route("/saveSexo", name="saveSexo")
     */
    public function saveSexoAction()
    {      
        $dados = array(
            array('M', 'Masculino'),
            array('F', 'Feminino')
        );
              
        for($i = 0; $i < count($dados); $i++){
            $sexo = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos();
            $sexo->setNomeAbreviaturaSexo($dados[$i][0]);
            $sexo->setNomeExtensoSexo($dados[$i][1]);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($sexo);
            $em->flush();
        };
        
        echo "sucesso";
    }
    
    /**
     * @Route("/login_check", name="login_check")
     */
    public function login_checkAction()
    {        
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {        
    }
}
