<?php

namespace App\Entity;

use App\Repository\SuscripcionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuscripcionRepository::class)
 */
class Suscripcion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo;





    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaSuscripcion;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="suscripciones")
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity=Publicacion::class, inversedBy="suscripciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $publicacion;


    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    
    public function getFechaSuscripcion(): ?\DateTimeInterface
    {
        return $this->fechaSuscripcion;
    }

    public function setFechaSuscripcion(\DateTimeInterface $fechaSuscripcion): self
    {
        $this->fechaSuscripcion = $fechaSuscripcion;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPublicacion(): ?Publicacion
    {
        return $this->publicacion;
    }

    public function setPublicacion(?Publicacion $publicacion): self
    {
        $this->publicacion = $publicacion;

        return $this;
    }
}
