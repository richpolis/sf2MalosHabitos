<?php

namespace Richpolis\PublicacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicacion
 *
 * @ORM\Table(name="publicacion")
 * @ORM\Entity(repositoryClass="Richpolis\PublicacionesBundle\Repository\PublicacionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Publicacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255 )
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text" )
     */
    private $descripcion;  
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255,nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;    

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", nullable=false )
     */
    private $posicion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true )
     */
    private $isActive;
    
    
    /**
     * @ManyToMany(targetEntity="Richpolis\")
     * @JoinTable(name="users_groups",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     */
    private $galeria;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    public function __construct() {
       $this->isActive        =   true;
       $this->galeria = null;
    }
    
    public function __toString() {
        return $this->getTitulo();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @param string $locale 
     * @return Publicacion
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Publicacion
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;
    
        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Publicacion
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set categoria
     *
     * @param \Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion $categoria
     * @return Publicacion
     */
    public function setCategoria(\Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Publicacion
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Publicacion
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Publicacion
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /*
     * Slugable
     */
    
    /**
    * @ORM\PrePersist
    */
    public function setSlugAtValue()
    {
        $this->slug = \Richpolis\BackendBundle\Utils\Richsys::slugify($this->getTitulo());
    }
    
    /*
     * Timestable
     */
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
        if(!$this->getUpdatedAt())
        {
          $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
    
    /**
     * Regresa el titulo corto segun el maximo de caracteres solicitado
     * 
     * @return string
     * 
     */
    
    public function getTituloCorto($max=15){
        if($this->titulo)
            return substr($this->getTitulo(), 0, $max);
        else
            return "Sin titulo";
    }
    
    

    public function getDescripcionHtml(){
       $traduce=array('Á'=>'&Aacute;',
                    'á'=>'&aacute;',
                    'É'=>'&Eacute;',
                    'é'=>'&eacute;',
                    'Í'=>'&Iacute;',
                    'í'=>'&iacute;',
                    'Ó'=>'&Oacute;',
                    'ó'=>'&oacute;',
                    'Ú'=>'&Uacute;',
                    'ú'=>'&uacute;',
                    'Ü'=>'&Uuml;',
                    'ü'=>'&uuml;',
                    'Ṅ'=>'&Ntilde;',
                    'ñ'=>'&ntilde;',
                    '&'=>'&amp;',
                    '<'=>'&lt;',
                    '>'=>'&gt;',
                    "'"=>"\'");
       $sale=strtr( $this->getDescripcion() , $traduce );
       return $sale;

    }
   

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Publicacion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Publicacion
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Publicacion
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    
}
