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
     * @ORM\Column(name="descripcion_corta", type="text" )
     */
    private $descripcionCorta;  
    
    /**
     * @var string
     *
     * @ORM\Column(name="cliente", type="string", length=255)
     */
    private $cliente;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_cliente", type="text" )
     */
    private $descripcionCliente;    

    /**
     * @var string
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_fecha", type="text" )
     */
    private $descripcionFecha;    

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_location", type="text" )
     */
    private $descripcionLocation;    

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
     * @var \CategoriasPublicacion
     *
     * @ORM\ManyToOne(targetEntity="CategoriasPublicacion", inversedBy="publicaciones" )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;

    
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
     * Set descripcionCorta
     *
     * @param string $descripcionCorta
     * @return Publicacion
     */
    public function setDescripcionCorta($descripcionCorta)
    {
        $this->descripcionCorta = $descripcionCorta;

        return $this;
    }

    /**
     * Get descripcionCorta
     *
     * @return string 
     */
    public function getDescripcionCorta()
    {
        return $this->descripcionCorta;
    }

    /**
     * Set cliente
     *
     * @param string $cliente
     * @return Publicacion
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return string 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set descripcionCliente
     *
     * @param string $descripcionCliente
     * @return Publicacion
     */
    public function setDescripcionCliente($descripcionCliente)
    {
        $this->descripcionCliente = $descripcionCliente;

        return $this;
    }

    /**
     * Get descripcionCliente
     *
     * @return string 
     */
    public function getDescripcionCliente()
    {
        return $this->descripcionCliente;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Publicacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set descripcionFecha
     *
     * @param string $descripcionFecha
     * @return Publicacion
     */
    public function setDescripcionFecha($descripcionFecha)
    {
        $this->descripcionFecha = $descripcionFecha;

        return $this;
    }

    /**
     * Get descripcionFecha
     *
     * @return string 
     */
    public function getDescripcionFecha()
    {
        return $this->descripcionFecha;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Publicacion
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set descripcionLocation
     *
     * @param string $descripcionLocation
     * @return Publicacion
     */
    public function setDescripcionLocation($descripcionLocation)
    {
        $this->descripcionLocation = $descripcionLocation;

        return $this;
    }

    /**
     * Get descripcionLocation
     *
     * @return string 
     */
    public function getDescripcionLocation()
    {
        return $this->descripcionLocation;
    }

    
}
