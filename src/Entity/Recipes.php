<?php

namespace App\Entity;

use App\Repository\RecipesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipesRepository::class)]
#[Vich\Uploadable]
class Recipes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull()]
    private ?\DateTimeInterface $prepaTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cookingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $restTime = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Assert\NotNull()]
    public array $diet = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    public ?array $allergen = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Assert\NotNull()]
    private array $ingredient = [];

    #[ORM\Column(type: Types::ARRAY)]
    #[Assert\NotNull()]
    private array $stage = [];

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    private ?int $score = null;


    #[Vich\UploadableField(mapping: "recipe_images", fileNameProperty: "imageName")]
    private ?File $imageFile = null;

    
    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    private ?int $user = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Commentary::class, orphanRemoval: true)]
    private Collection $commentaries;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->commentaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrepaTime(): ?\DateTimeInterface
    {
        return $this->prepaTime;
    }

    public function setPrepaTime(\DateTimeInterface $prepaTime): static
    {
        $this->prepaTime = $prepaTime;

        return $this;
    }

    public function getCookingTime(): ?\DateTimeInterface
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?\DateTimeInterface $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getRestTime(): ?\DateTimeInterface
    {
        return $this->restTime;
    }

    public function setRestTime(?\DateTimeInterface $restTime): static
    {
        $this->restTime = $restTime;

        return $this;
    }

    public function getDiet(): array
    {
        return $this->diet;
    }

    public function setDiet(array $diet): static
    {
        $this->diet = $diet;

        return $this;
    }

    public function getAllergen(): ?array
    {
        return $this->allergen;
    }

    public function setAllergen(?array $allergen): static
    {
        $this->allergen = $allergen;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIngredient(): array
    {
        return $this->ingredient;
    }

    public function setIngredient(array $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getStage(): array
    {
        return $this->stage;
    }

    public function setStage(array $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?int $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): static
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries->add($commentary);
            $commentary->setRecipe($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): static
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getRecipe() === $this) {
                $commentary->setRecipe(null);
            }
        }

        return $this;
    }
}
