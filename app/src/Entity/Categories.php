<?php
/**
 * Categories entity.
 */
namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * * Class Categories.
 *
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 * @ORM\Table (name="Categories")
 */
class Categories
{
    /**
     *  Primary key.
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
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    private $title;
    /**
     * Getter for Id.
     *
     * @return int|null Result
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
}
