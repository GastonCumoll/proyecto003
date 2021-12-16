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
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="suscripcion")
     */
    private $usuarios;

    /**
     * @ORM\OneToMany(targetEntity=Publicacion::class, mappedBy="suscripcion")
     */
    private $publicacion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaSuscripcion;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->publicacion = new ArrayCollection();
    }

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

    /**
     * @return Collection|User[]
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(User $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios[] = $usuario;
            $usuario->setSuscripcion($this);
        }

        return $this;
    }

    public function removeUsuario(User $usuario): self
    {
        if ($this->usuarios->removeElement($usuario)) {
            // set the owning side to null (unless already changed)
            if ($usuario->getSuscripcion() === $this) {
                $usuario->setSuscripcion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Publicacion[]
     */
    public function getPublicacion(): Collection
    {
        return $this->publicacion;
    }

    public function addPublicacion(Publicacion $publicacion): self
    {
        if (!$this->publicacion->contains($publicacion)) {
            $this->publicacion[] = $publicacion;
            $publicacion->setSuscripcion($this);
        }

        return $this;
    }

    public function removePublicacion(Publicacion $publicacion): self
    {
        if ($this->publicacion->removeElement($publicacion)) {
            // set the owning side to null (unless already changed)
            if ($publicacion->getSuscripcion() === $this) {
                $publicacion->setSuscripcion(null);
            }
        }

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
}
