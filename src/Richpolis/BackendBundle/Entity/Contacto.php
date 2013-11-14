<?php
// src/Blogger/BlogBundle/Entity/Enquiry.php

namespace Richpolis\BackendBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;


class Contacto
{
    protected $name;

    protected $email;

    protected $subject;
    
    protected $telefono;
    
    protected $body;
    
    public function __contruct(){
        $this->subject="De la pagina";
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

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
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

        /*$metadata->addPropertyConstraint('subject', new NotBlank(array(
            'message' => 'Ingresar un asunto'
        )));*/
        
        $metadata->addPropertyConstraint('telefono', new NotBlank(array(
            'message' => 'Ingresar un telefono'
        )));
        
        $metadata->addPropertyConstraint('body', new NotBlank(array(
            'message' => 'Ingresar un mensaje'
        )));
        $metadata->addPropertyConstraint('body', new Length(array(
            'min'        => 3,
            'minMessage' => 'The message must be at least {{ limit }} characters length',
        )));
    }
}