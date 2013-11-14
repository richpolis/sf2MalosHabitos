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
    $principal = new CategoriasPublicacion();
    $principal->setCategoria('Proyectos');
    $principal->setTipoCategoria(CategoriasPublicacion::$PROYECTOS);
    $principal->setPosicion(1);
 
    
    $em->persist($principal);
    
    
    $em->flush();
 

  }
 
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}