<?php

namespace App\Entity;

use App\Repository\TipoPublicacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TipoPublicacionRepository::class)
 */
class TipoPublicacion
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
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=Publicacion::class, mappedBy="tipoPublicacion", orphanRemoval=true)
     */
    private $publicacions;

    public function __construct()
    {
        $this->publicacions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
    public function __toString() {
        return $this->nombre;
    }

    /**
     * @return Collection|Publicacion[]
     */
    public function getPublicacions(): Collection
    {
        return $this->publicacions;
    }

    public function addPublicacion(Publicacion $publicacion): self
    {
        if (!$this->publicacions->contains($publicacion)) {
            $this->publicacions[] = $publicacion;
            $publicacion->setTipoPublicacion($this);
        }

        return $this;
    }

    public function removePublicacion(Publicacion $publicacion): self
    {
        if ($this->publicacions->removeElement($publicacion)) {
            // set the owning side to null (unless already changed)
            if ($publicacion->getTipoPublicacion() === $this) {
                $publicacion->setTipoPublicacion(null);
            }
        }

        return $this;
    }
}
