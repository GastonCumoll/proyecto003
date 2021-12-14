<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    
    private $plainPassword;
    /**
     * @ORM\OneToMany(targetEntity=Publicacion::class, mappedBy="usuarioCreador", orphanRemoval=true)
     */
    private $publicacionesDeUsuario;

    /**
     * @ORM\OneToMany(targetEntity=Edicion::class, mappedBy="usuarioCreador", orphanRemoval=true)
     */
    private $ediciones;



    public function __toString() {
        return $this->email;
    }
    public function __construct()
    {
        $this->publicacionesDeUsuario = new ArrayCollection();
        $this->ediciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Publicacion[]
     */
    public function getPublicacionesDeUsuario(): Collection
    {
        return $this->publicacionesDeUsuario;
    }

    public function addPublicacionesDeUsuario(Publicacion $publicacionesDeUsuario): self
    {
        if (!$this->publicacionesDeUsuario->contains($publicacionesDeUsuario)) {
            $this->publicacionesDeUsuario[] = $publicacionesDeUsuario;
            $publicacionesDeUsuario->setUsuarioCreador($this);
        }

        return $this;
    }

    public function removePublicacionesDeUsuario(Publicacion $publicacionesDeUsuario): self
    {
        if ($this->publicacionesDeUsuario->removeElement($publicacionesDeUsuario)) {
            // set the owning side to null (unless already changed)
            if ($publicacionesDeUsuario->getUsuarioCreador() === $this) {
                $publicacionesDeUsuario->setUsuarioCreador(null);
            }
        }

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
            $edicione->setUsuarioCreador($this);
        }

        return $this;
    }

    public function removeEdicione(Edicion $edicione): self
    {
        if ($this->ediciones->removeElement($edicione)) {
            // set the owning side to null (unless already changed)
            if ($edicione->getUsuarioCreador() === $this) {
                $edicione->setUsuarioCreador(null);
            }
        }

        return $this;
    }

    

    
}
