<?php

namespace App\Data;
use Symfony\Component\Validator\Constraints as Assert;

class SendEmail
{


    
    #[Assert\Regex(
        pattern: '/[^a-zA-Z0-9 ]/',
        match:false,
        message:'Votre prénom ne peut contenir de caractères spécial',
    )]
    #[Assert\NotBlank(
        message:'prenom : ce champ ne peut réster vide.'
    )]
    private ?string $prenom;


    #[Assert\Regex(
        pattern: '/[^a-zA-Z0-9 ]/',
        match:false,
        message:'Votre nom ne peut contenir de caractères spécial',
    )]
    #[Assert\NotBlank(
        message:'nom : ce champ ne peut réster vide.'
    )]
    private ?string $nom;

    
    private ?string $sexe;

 
    private ?int $tel;


    #[Assert\Email(
        message:"cette e-mail n'est pas valide",
        mode:'strict'
    )]
    private ?string $email;


    private ?string $message;









    /**
     * getter setter nom
     */

    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }




    /**
     * getter setter prenom
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }


    /**
     * getter setter sexe
     */
    public function setSexe(string $sexe)
    {
        $this->sexe = $sexe;
    }

    public function getSexe(): string
    {
        return $this->sexe;
    }


    /**
     * getter setter telephone
     */
    public function setTel(int $tel)
    {
        $this->tel = $tel;
    }

    public function getTel(): int
    {
        return $this->tel;
    }


    /**
     * getter setter email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * getter setter message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
