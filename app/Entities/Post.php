<?php

namespace Test1\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $text;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="posts", cascade={"persist"})
     * @ORM\JoinTable(name="posts_tags")
     */
    private $tags;


    public function __construct($name, $text, $tags)
    {
    	$this->tags = new \Doctrine\Common\Collections\ArrayCollection($tags);
        $this->name = $name;
        $this->text = $text;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getTags()
    {
        return $this->tags;
    }

    private function getTagsNames()
    {
    	$tags = array();
        foreach ($this->tags as $tag) {
            $tags[] = $tag->getName();
        }
        return $tags;
    }

    public function toArray()
    {
    	return [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text,
            'tags' => $this->getTagsNames(),
        ];
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setTags($tags)
    {
    	$this->tags->clear();
    	foreach ($tags as $tag) {
    		$tag->addPost($this);
        	$this->tags[] = $tag;
    	}
    }

    public function addTag($newTag)
    {
        foreach ($this->tags as $tag) {
            if ($tag->getName() == $newTag->getName()) {
                return;
            }
        }
        $this->tags[] = $newTag;
    }
}