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
    protected $proyecto;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Richpolis\CategoriasGaleriaBundle\Entity\Categorias")
     */
    protected $galeria;
 

    /**
     * Set proyecto
     *
     * @param \Richpolis\PublicacionesBundle\Entity\Publicacion $proyecto
     *
     * @return PublicacionGalerias
     */
    public function setProyecto(\Richpolis\PublicacionesBundle\Entity\Publicacion $proyecto)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \Richpolis\PublicacionesBundle\Entity\Publicacion 
     */
    public function getProyecto()
    {
        return $this->proyecto;
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
