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
    $principal->setTipoCategoria(Categorias::$GALERIA);
    $principal->setPosicion(1);
        
    $em->persist($principal);
    $em->flush();
 

  }
 
  public function getOrder()
  {
    return 1; // the order in which fixtures will be loaded
  }
}