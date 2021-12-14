<?php

namespace App\Entity;


use App\Repository\PublicacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicacionRepository::class)
 */
class Publicacion
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
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipoPublicacion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaYHora;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="publicacionesDeUsuario")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarioCreador;

    /**
     * @ORM\OneToMany(targetEntity=Edicion::class, mappedBy="publicacion", orphanRemoval=true)
     */
    private $ediciones;

    public function __construct()
    {
        $this->ediciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function __toString(){
        return $this->titulo;
    }

    public function getTipoPublicacion(): ?string
    {
        return $this->tipoPublicacion;
    }

    public function setTipoPublicacion(string $tipoPublicacion): self
    {
        $this->tipoPublicacion = $tipoPublicacion;

        return $this;
    }

    public function getFechaYHora(): ?\DateTimeInterface
    {
        return $this->fechaYHora;
    }

    public function setFechaYHora(\DateTimeInterface $fechaYHora): self
    {
        $this->fechaYHora = $fechaYHora;

        return $this;
    }

    public function getUsuarioCreador(): ?User
    {
        return $this->usuarioCreador;
    }

    public function setUsuarioCreador(?User $usuarioCreador): self
    {
        $this->usuarioCreador = $usuarioCreador;

        return $this;
    }

    /**
     * @return Collection|Edicion[]
     */
    public function getEdiciones(): Collection
    {
        return $this->ediciones;
    }

    public function addEdicione(Edicion $edicione): self
    {
        if (!$this->ediciones->contains($edicione)) {
            $this->ediciones[] = $edicione;
            $edicione->setPublicacion($this);
        }

        return $this;
    }

    public function removeEdicione(Edicion $edicione): self
    {
        if ($this->ediciones->removeElement($edicione)) {
            // set the owning side to null (unless already changed)
            if ($edicione->getPublicacion() === $this) {
                $edicione->setPublicacion(null);
            }
        }

        return $this;
    }
}
