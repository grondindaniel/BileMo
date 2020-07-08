<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;



/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_clients_id",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true,
 *      )
 * )
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Serializer\Groups({"listClients"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "The firstname must be at least {{ limit }} characters long",
     *      maxMessage = "The firstname cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "The lastname must be at least {{ limit }} characters long",
     *      maxMessage = "The lastname cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @Serializer\Groups({"listClients"})
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    private $streetNumber;

    /**
     * @Serializer\Groups({"listClients"})
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "The street name must be at least {{ limit }} characters long",
     *      maxMessage = "The street name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $street;

    /**
     * @Serializer\Groups({"listClients"})
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *      min = 3,
     *      max = 5,
     *      minMessage = "The postal code must be at least {{ limit }} characters long",
     *      maxMessage = "The postal code cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $cp;

    /**
     * @Serializer\Groups({"listClients"})
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "The city name must be at least {{ limit }} characters long",
     *      maxMessage = "The city name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $city;

    /**
     * @Serializer\Groups({"listClients"})
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 5,
     *      minMessage = "The phone number must be at least {{ limit }} characters long",
     *      maxMessage = "The phone number cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $phoneNumber;

    /**
     * @Serializer\Groups({"listClients"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="clients")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
