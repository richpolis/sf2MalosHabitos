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
use Richpolis\BackendBundle\Entity\Pedido;
use Richpolis\BackendBundle\Form\PedidoType;
use Richpolis\CategoriasGaleriaBundle\Entity\Categorias;

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
        $em = $this->getDoctrine()->getManager();
       
        $contacto = new Contacto();
        $form = $this->createForm(new ContactoType(), $contacto);
        
        $about = $em->getRepository('BackendBundle:Configuraciones')->findOneBySlug('about'); 
        $contacto = $em->getRepository('BackendBundle:Configuraciones')->findOneBySlug('contacto'); 
        
        return $this->render("FrontendBundle:Default:index.html.twig",array(
          "about"=>$about,
          "contacto"=>$contacto,
          "form"=>$form->createView()  
        ));
    }

    /**
     * Lists all news.
     *
     * @Route("/noticias", name="noticias")
     * @Method({"GET"})
     * @Template()
     */
    public function noticiasAction()
    {
        $em = $this->getDoctrine()->getManager();

        /*$query = $em->getRepository('CategoriasGaleriaBundle:Categorias')
                            ->getQueryCategoriasPorTipoYActivas(Categorias::$GALERIA_NOTICIAS,true);*/
        $query = $em->getRepository('CategoriasGaleriaBundle:Categorias')
                            ->getQueryCategoriasGaleriaActivas(Categorias::$GALERIA_NOTICIAS,false);
        
        
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('pageNoticias', 1),
            2,
            array('distinct' => false)
        );

        $data = $pagination->getPaginationData();

        //var_dump($data);

        return array(
            'pagination' => $pagination,
            'data'=>$data,
        );
    }

    /**
     * Lista las imagenes de una noticia.
     *
     * @Route("/imagenes/noticias/{id}", name="imagenes_noticias")
     */
    public function imagenesNoticiasAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $imagenes = $em->getRepository('CategoriasGaleriaBundle:Galerias')
                        ->getGaleriaPorCategoriaYStatus($id,true);

        $arreglo = array();
        for($cont=0;$cont<count($imagenes);$cont++){
            $arreglo['imagenes'][$cont]=$imagenes[$cont]->getWebPath();
            $arreglo['titulos'][$cont]=""; //$imagenes[$cont]->getTitulo();
            $arreglo['descripciones'][$cont]=""; //$imagenes[$cont]->getDescripcion();
        }
        
        $response = new Response(json_encode($arreglo));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
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
     * Lista todos los artistas.
     *
     * @Route("/artistas", name="artistas")
     * @Template()
     */
    public function artistasAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artistas = $em->getRepository('CategoriasGaleriaBundle:Categorias')
                            ->getCategoriasPorTipoYActivas(Categorias::$GALERIA_ARTISTAS,false);
        
        return array(
            'artistas' => $artistas,
        );
    }
    
    /**
     * Envia los datos de un artista.
     *
     * @Route("/artista/{id}", name="show_artista")
     * @Method({"GET"})
     */
    public function getArtistaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $artista = $em->getRepository('CategoriasGaleriaBundle:Categorias')
                      ->getCategoriaConGaleriaPorId($id, true);
        
        return $this->render("FrontendBundle:Default:artista.html.twig",array(
            'artista'=>$artista,
        ));

    }
    
    /**
     * Lista todos los productos.
     *
     * @Route("/productos/{tipo}", name="productos", defaults={"tipo"="discos"})
     * @Template()
     */
    public function productosAction($tipo)
    {
        $em = $this->getDoctrine()->getManager();
        
        if($tipo=="discos"){
            $tipoCategoria = Categorias::$GALERIA_PRODUCTOS_DISCOS;
        }else{
            $tipoCategoria = Categorias::$GALERIA_PRODUCTOS_ROPA;
        }

        $productos = $em->getRepository('CategoriasGaleriaBundle:Categorias')
                            ->getCategoriasPorTipoYActivas($tipoCategoria,false);
        
        return array(
            'productos' => $productos,
        );
    }
    
    /**
     * Envia los datos de un producto.
     *
     * @Route("/producto/{id}", name="show_producto")
     * @Method({"GET"})
     */
    public function getProductoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $producto = $em->getRepository('CategoriasGaleriaBundle:Categorias')
                      ->getCategoriaConGaleriaPorId($id, true);
        
        $pedido = new Pedido();
        $pedido->setProducto($id);
        $pedido->setSubject("Para cotizacion");
        $form = $this->createForm(new PedidoType(), $pedido);
        
        
        return $this->render("FrontendBundle:Default:producto.html.twig",array(
            'producto'=>$producto,
            'form'=>$form->createView(),
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
        
        return $this->render("FrontendBundle:Default:contacto.html.twig",array(
              'form' => $form->createView(),
              'ok'=>$ok,
              'error'=>$error,
              'mensaje'=>$mensaje,
        ));
    }
    
    /**
     * @Route("/pedido", name="frontend_pedido")
     * @Method({"GET", "POST"})
     */
    public function pedidoAction() {
        $pedido = new Pedido();
        $form = $this->createForm(new PedidoType(), $pedido);
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $datos=$form->getData();
                $producto = $em->getRepository('CategoriasGaleriaBundle:Categorias')
                               ->findOneBy(array('id'=>$datos->getProducto()));
                $datos->setStringProducto($producto->getCategoria());
                
                $message = \Swift_Message::newInstance()
                        ->setSubject($datos->getSubject())
                        ->setFrom($this->container->getParameter('richpolis.emails.to_email'))
                        ->setTo($datos->getEmail())
                        ->setBody($this->renderView('BackendBundle:Default:pedidoEmail.html.twig', array('datos' => $datos)), 'text/html');
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('noticia', 'Gracias por enviar tu correo, nos comunicaremos a la brevedad posible!');

                // Redirige - Esto es importante para prevenir que el usuario
                // reenvíe el formulario si actualiza la página
                $ok=true;
                $error=false;
                $mensaje="El mensaje ha sido enviado";
                $pedido = new Pedido();
                $form = $this->createForm(new PedidoType(), $pedido);
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
        
        return $this->render("FrontendBundle:Default:pedido.html.twig",array(
              'form' => $form->createView(),
              'ok'=>$ok,
              'error'=>$error,
              'mensaje'=>$mensaje,
        ));
    }
    
}

?>
