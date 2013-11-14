<?php

namespace Richpolis\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\BackendBundle\Entity\Contacto;
use Richpolis\BackendBundle\Form\ContactoType;
use Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion;
use Richpolis\CategoriasGaleriaBundle\Entity\Categorias;
use Richpolis\FrontendBundle\Entity\DiageoUsuarios;
use Richpolis\FrontendBundle\Form\DiageoUsuariosType;

/**
 * Frontend controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller {
    
    /**
     * Lists all Frontend entities.
     *
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        /*$em = $this->getDoctrine()->getManager();
       
        $galerias = $em->getRepository('CategoriasGaleriaBundle:Galerias')
                       ->getGaleriaPorTipoCategoria(Categorias::$GALERIA_PRINCIPAL);
        */
        return $this->render("FrontendBundle:Default:index.html.twig",array(
          /*"galerias"=>$galerias,*/
        ));

    }

    /**
     * Lista los ultimos tweets.
     *
     * @Route("/last-tweets/{username}/", name="last_tweets")
     */
    public function lastTweetsAction($username, $limit = 10, $age = null)
    {
        /* @var $twitter FetcherInterface */
        $twitter = $this->get('knp_last_tweets.last_tweets_fetcher');

        try {
            $tweets = $twitter->fetch($username, $limit);
        } catch (TwitterException $e) {
            $tweets = array();
        }

        $response = $this->render('FrontendBundle:Default:lastTweets.html.twig', array(
            'username' => $username,
            'tweets'   => $tweets,
        ));

        if ($age) {
            $response->setSharedMaxAge($age);
        }

        return $response;
    }
    
    /**
     * Envia los datos de un artista.
     *
     * @Route("/artista/{id}", name="show_artista")
     * @Method({"GET"})
     */
    public function getArtistaAction($id)
    {
        return $this->render("FrontendBundle:Default:artista.html.twig",array(
            'artista'=>array(),
        ));

    }
    
    /**
     * Envia los datos de un producto.
     *
     * @Route("/producto/{id}", name="show_producto")
     * @Method({"GET"})
     */
    public function getProductoAction($id)
    {
        return $this->render("FrontendBundle:Default:producto.html.twig",array(
            'producto'=>array(),
        ));

    }

    /**
     * @Route("/contacto", name="frontend_contacto")
     * @Method({"GET", "POST"})
     */
    public function contactoAction() {
        $contacto = new Contacto();
        $form = $this->createForm(new ContactoType(), $contacto);
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $datos=$form->getData();
                
                
                $message = \Swift_Message::newInstance()
                        ->setSubject('Contacto desde pagina')
                        ->setFrom($datos->getEmail())
                        ->setTo($this->container->getParameter('richpolis.emails.to_email'))
                        ->setBody($this->renderView('BackendBundle:Default:contactoEmail.html.twig', array('datos' => $datos)), 'text/html');
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('noticia', 'Gracias por enviar tu correo, nos comunicaremos a la brevedad posible!');

                // Redirige - Esto es importante para prevenir que el usuario
                // reenvíe el formulario si actualiza la página
                $ok=true;
                $error=false;
                $mensaje="El mensaje ha sido enviado";
                $contacto = new Contacto();
                $form = $this->createForm(new ContactoType(), $contacto);
            }else{
                $ok=false;
                $error=true;
                $mensaje="El mensaje no se ha podido enviar";
            }
        }else{
            $ok=false;
            $error=false;
            $mensaje="Violacion de acceso";
        }
        
        $em = $this->getDoctrine()->getManager();
        $contacto = $em->getRepository('BackendBundle:Configuraciones')->findOneBySlug('contacto'); 
        return $this->render("FrontendBundle:Default:contacto.html.twig",array(
              'contacto'=>$contacto,
              'form' => $form->createView(),
              'ok'=>$ok,
              'error'=>$error,
              'mensaje'=>$mensaje,
        ));
    }
    
    
    
}

?>
