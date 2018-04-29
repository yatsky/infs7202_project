<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $register_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $acct_balance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="owner")
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Photo", inversedBy="users")
     */
    private $liked_photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->liked_photos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->register_date;
    }

    public function setRegisterDate(\DateTimeInterface $register_date): self
    {
        $this->register_date = $register_date;

        return $this;
    }

    public function getAcctBalance(): ?int
    {
        return $this->acct_balance;
    }

    public function setAcctBalance(int $acct_balance): self
    {
        $this->acct_balance = $acct_balance;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setOwner($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getOwner() === $this) {
                $photo->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getLikedPhotos(): Collection
    {
        return $this->liked_photos;
    }

    public function addLikedPhoto(Photo $likedPhoto): self
    {
        if (!$this->liked_photos->contains($likedPhoto)) {
            $this->liked_photos[] = $likedPhoto;
        }

        return $this;
    }

    public function removeLikedPhoto(Photo $likedPhoto): self
    {
        if ($this->liked_photos->contains($likedPhoto)) {
            $this->liked_photos->removeElement($likedPhoto);
        }

        return $this;
    }
}
