<?php
/**
 * Photos entity.
 */
namespace App\Entity;

use App\Repository\PhotosRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Photos.
 *
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 * @ORM\Table(name="Photos")
 */
class Photos
{
    /**
     * Primary key.
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
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
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $title;

    /**
     * Text.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=Galleries::class, fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gallery;
    /**
     * Getter for Id.
     *
     * @return int|null Result
     *
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
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    /**
     * Getter for Text.
     *
     * @return string Text
     */
    public function getText(): ?string
    {
        return $this->text;
    }
    /**
     * Setter for Text.
     *
     * @param string $text Text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getGalleries(): ?Galleries
    {
        return $this->gallery;
    }

    public function setGalleries(?Galleries $gallery): void
    {
        $this->gallery = $gallery;
    }

}
