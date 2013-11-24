<?php
// src/Blogger/BlogBundle/Entity/Enquiry.php

namespace Richpolis\BackendBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;


class Pedido
{
    protected $name;

    protected $email;

    protected $subject;
    
    protected $telefono;
    
    protected $producto;
    
    protected $stringProducto;
    
    public function __contruct(){
        $this->subject="Para cotizacion";
    }
    

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    public function getProducto()
    {
        return $this->producto;
    }
    
    public function setStringProducto($producto)
    {
        $this->stringProducto = $producto;
    }

    public function getStringProducto()
    {
        return $this->stringProducto;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank(array(
            'message' => 'Ingresar su nombre'
        )));
        $metadata->addPropertyConstraint('name', new Length(array(
            'min'        => 2,
            'max'        => 256,
            'minMessage' => 'Your first name must be at least {{ limit }} characters length',
            'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters length',
        )));
        
        $metadata->addPropertyConstraint('email', new NotBlank(array(
            'message' => 'Ingresar su email'
        )));
        $metadata->addPropertyConstraint('email', new Email(array(
            'message' => 'Ingresar un email correcto'
        )));

        $metadata->addPropertyConstraint('subject', new NotBlank(array(
            'message' => 'Ingresar un asunto'
        )));
        
        /*$metadata->addPropertyConstraint('telefono', new NotBlank(array(
            'message' => 'Ingresar un telefono'
        )));*/
        
        $metadata->addPropertyConstraint('producto', new NotBlank(array(
            'message' => 'Debe tener un producto seleccionado'
        )));
        
    }
}