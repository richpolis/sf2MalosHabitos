<?php


namespace Richpolis\CategoriasGaleriaBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Richpolis\CategoriasGaleriaBundle\Entity\Categorias;
 
class LoadCategoriasData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    $principal = new Categorias();
    $principal->setCategoria('Galeria Principal');
    $principal->setTipoCategoria(Categorias::$GALERIA_PRINCIPAL);
    $principal->setPosicion(1);
 
    $proyecto = new Categorias();
    $proyecto->setCategoria('Galeria para proyecto');
    $proyecto->setTipoCategoria(Categorias::$GALERIA_PROYECTOS);
    $proyecto->setPosicion(2);
    
        
    $em->persist($principal);
    $em->persist($proyecto);
    $em->flush();
 

  }
 
  public function getOrder()
  {
    return 1; // the order in which fixtures will be loaded
  }
}