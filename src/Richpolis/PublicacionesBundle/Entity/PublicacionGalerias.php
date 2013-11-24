<?php

namespace Richpolis\PublicacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicacion
 *
 * @ORM\Table(name="publicacion_galerias")
 * @ORM\Entity(repositoryClass="Richpolis\PublicacionesBundle\Repository\PublicacionGaleriasRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PublicacionGalerias
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Richpolis\PublicacionesBundle\Entity\Publicacion")
     */
    protected $publicacion;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Richpolis\CategoriasGaleriaBundle\Entity\Categorias")
     */
    protected $galeria;
 

    /**
     * Set publicacion
     *
     * @param \Richpolis\PublicacionesBundle\Entity\Publicacion $proyecto
     *
     * @return PublicacionGalerias
     */
    public function setPublicacion(\Richpolis\PublicacionesBundle\Entity\Publicacion $publicacion)
    {
        $this->publicacion = $publicacion;

        return $this;
    }

    /**
     * Get publicacion
     *
     * @return \Richpolis\PublicacionesBundle\Entity\Publicacion 
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * Set galeria
     *
     * @param \Richpolis\CategoriasGaleriaBundle\Entity\Categorias $galeria
     *
     * @return PublicacionGalerias
     */
    public function setGaleria(\Richpolis\CategoriasGaleriaBundle\Entity\Categorias $galeria)
    {
        $this->galeria = $galeria;

        return $this;
    }

    /**
     * Get galeria
     *
     * @return \Richpolis\CategoriasGaleriaBundle\Entity\Categorias 
     */
    public function getGaleria()
    {
        return $this->galeria;
    }
}
