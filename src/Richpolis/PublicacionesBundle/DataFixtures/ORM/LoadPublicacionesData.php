<?php


namespace Richpolis\PublicacionesBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion;
 
class LoadPublicacionesData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    $noticias = new CategoriasPublicacion();
    $noticias->setCategoria('Noticias');
    $noticias->setTipoCategoria(CategoriasPublicacion::$NOTICIAS);
    $noticias->setPosicion(1);
    
    $artistas = new CategoriasPublicacion();
    $artistas->setCategoria('Artistas');
    $artistas->setTipoCategoria(CategoriasPublicacion::$ARTISTAS);
    $artistas->setPosicion(2);
    
    $productosRopa = new CategoriasPublicacion();
    $productosRopa->setCategoria('Productos: Ropa');
    $productosRopa->setTipoCategoria(CategoriasPublicacion::$PRODUCTOS_ROPA);
    $productosRopa->setPosicion(3);
    
    $productosDiscos = new CategoriasPublicacion();
    $productosDiscos->setCategoria('Productos: Discos');
    $productosDiscos->setTipoCategoria(CategoriasPublicacion::$PRODUCTOS_DISCOS);
    $productosDiscos->setPosicion(4);
 
    
    $em->persist($noticias);
    $em->persist($artistas);
    $em->persist($productosRopa);
    $em->persist($productosDiscos);
    
    $em->flush();
 

  }
 
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}