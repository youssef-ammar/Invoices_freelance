<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
   

#[ApiResource()]
#[ORM\Entity(repositoryClass: UserRepository::class)]


class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;




    #[ORM\Column]
    private array $roles = [];



    /**
     * @var string The hashed password
     * 
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column]
    private ?bool $mailConfirmed = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Company::class)]
    private Collection $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isMailConfirmed(): ?bool
    {
        return $this->mailConfirmed;
    }

    public function setMailConfirmed(bool $mailConfirmed): self
    {
        $this->mailConfirmed = $mailConfirmed;

        return $this;
    }


    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompanies(Company $companies): self
    {
        if (!$this->companies->contains($companies)) {
            $this->companies->add($companies);
            $companies->setUser($this);
        }

        return $this;
    }

    public function removeCompanies(Company $companies): self
    {
        if ($this->companies->removeElement($companies)) {
            // set the owning side to null (unless already changed)
            if ($companies->getUser() === $this) {
                $companies->setUser(null);
            }
        }

        return $this;
    }
    
}

