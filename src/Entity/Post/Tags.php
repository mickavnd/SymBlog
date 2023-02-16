<?php

namespace App\Entity\Post;

use App\Entity\Trait\CategoryTagTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Post\TagsRepository;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug',message:'Ce slug existe deja')]
class Tags
{
  
    use CategoryTagTrait;

    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'tags')]
    #[JoinTable(name: 'tags_post')]
    private Collection $Post;

   

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->Post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->Post->contains($post)) {
            $this->Post->add($post);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->Post->removeElement($post);

        return $this;
    }
}
