<?php

namespace App\Entity\Post;

use App\Entity\Post\Post;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use App\Repository\Post\ThumbnailRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ThumbnailRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Thumbnail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Vich\UploadableField(mapping: 'post_thumbnail', fileNameProperty :'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string')]
    private  ?string $imageName =null;

    #[ORM\Column(type: 'integer')]
    private  ?int $imageSize =null;

    #[ORM\Column]

    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\OneToOne(mappedBy: 'thumbnail', targetEntity: Post::class )]
    private Post $post;


    public function __construct()
    {
        $this->updateAt = new \DateTimeImmutable();
    }
    #[ORM\PreUpdate]
    public function preUpdate()
    {
        $this->updateAt = new \DateTimeImmutable();
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updateAt = new \DateTimeImmutable();
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

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get the value of post
     *
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * Set the value of post
     *
     * @param Post $post
     *
     * @return self
     */
    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }

}
