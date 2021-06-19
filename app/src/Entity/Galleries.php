<?php
/**
 * Galleries entity.
 */
namespace App\Entity;

use App\Repository\GalleriesRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Galleries.
 *
 * @ORM\Entity(repositoryClass=GalleriesRepository::class)
 * @ORM\Table (name="Galleries")
 *
 */
class Galleries
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Title.
     *
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $title;
    /**
     * Getter for Id.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Galleries[] $Galleries Galleries
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Photos",mappedBy="Galleries",fetch="EXTRA_LAZY",)
     */
    private Collection $Photos;

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     *
     * @Gedmo\Slug(fields={"title"})
     */
    private $code;
    /**
     * Collection.
     *
     * @var
     *
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * Setter for Title.
     *
     * @param string $title Title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
    public function getPhotos(): Collection
    {
       return $this->Photos;
    }
    public function addPhotos(Photos $Photos): void
    {
        if (!$this->Photos->contains($Photos)){
            $this->Photos[] = $Photos;
            $Photos->setGalleries($this);
        }
    }
    public function removePhotos(Photos $Photos): void
    {
        if ($this->Photos->contains($Photos)){
            $this->Photos->remove($Photos);
            if ($Photos->getGalleries() === $this) {
                $Photos->setGalleries(null);
            }
        }
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
