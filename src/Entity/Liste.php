<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ListeRepository::class)]
class Liste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['listes'])]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['listes'])]

    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'liste', targetEntity: Course::class)]
    #[Groups(['listes'])]

    private Collection $Course;

    #[ORM\ManyToMany(targetEntity: User::class, cascade:['persist'])]
    private Collection $invites;

    public function __construct()
    {
        $this->Course = new ArrayCollection();
      
        $this->invites = new ArrayCollection();
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



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourse(): Collection
    {
        return $this->Course;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->Course->contains($course)) {
            $this->Course->add($course);
            $course->setListe($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->Course->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getListe() === $this) {
                $course->setListe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getInvites(): Collection
    {
        return $this->invites;
    }

    public function addInvite(User $invite): static
    {
        if (!$this->invites->contains($invite)) {
            $this->invites->add($invite);
        }

        return $this;
    }

    public function removeInvite(User $invite): static
    {
        $this->invites->removeElement($invite);

        return $this;
    }
}
