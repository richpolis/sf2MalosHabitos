<?php

namespace Richpolis\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="backend_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/navegar", name="backend_navegar")
     * @Template()
     */
    public function navegarAction()
    {
        return array();
    }
    
    /**
     * @Route("/seleccionar/galeria", name="backend_categorias")
     */
    public function categoriasAction()
    {
        return $this->forward('CategoriasGaleriaBundle:Categorias:select');
    }
    
    /**
     * @Route("/galeria/principal", name="backend_galerias_principal")
     */
    public function galeriaPrincipalAction()
    {
        return $this->forward('CategoriasGaleriaBundle:Categorias:galeriasPrincipal');
    }
    
    /**
     * @Route("/galeria/proyecto", name="backend_galerias_proyecto")
     */
    public function galeriaProyectoAction()
    {
        return $this->forward('CategoriasGaleriaBundle:Categorias:galeriasProyecto');
    }
    
    /**
     * @Route("/configuraciones", name="backend_configuraciones")
     */
    public function configuracionesAction()
    {
        return $this->forward('BackendBundle:Configuraciones:index');
    }
    
    /**
     * @Route("/publicacion/proyecto", name="publicaciones_proyecto")
     */
    public function publicacionesProyectoAction()
    {
        return $this->forward('PublicacionesBundle:Publicacion:publicacionesProyecto');
    }
    
    
    
    /**
     * @Route("/login", name="backend_login")
     * @Template()
     */
    
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'BackendBundle:Default:login.html.twig',
            array(
                // último nombre de usuario ingresado
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    /**
     * @Route("/login_check", name="backend_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="backend_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    
    
}
