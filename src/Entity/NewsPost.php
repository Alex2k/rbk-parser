<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Table(name="news_post")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\NewsPostRepository")
 */
class NewsPost
{
    use DateTimeTrait;

    /**
     * @ORM\Column(type="integer")
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $subtitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $image;

    /**
     * @ORM\Column(name="published_at", type="datetime")
     */
    private ?DateTimeInterface $publishedAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $remoteId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $remoteUrl;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $gatewayName;

    public function __construct(
        ?string $title = null,
        ?string $subtitle = null,
        ?string $description = null,
        ?string $image = null,
        ?DateTimeInterface $publishedAt = null,
        ?string $remoteId = null,
        ?string $remoteUrl = null,
        ?string $gatewayName = null
    ) {
        $this
            ->setTitle($title)
            ->setSubtitle($subtitle)
            ->setDescription($description)
            ->setImage($image)
            ->setPublishedAt($publishedAt)
            ->setRemoteId($remoteId)
            ->setRemoteUrl($remoteUrl)
            ->setGatewayName($gatewayName)
        ;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getRemoteId(): ?string
    {
        return $this->remoteId;
    }

    public function setRemoteId(?string $remoteId): self
    {
        $this->remoteId = $remoteId;

        return $this;
    }

    public function getRemoteUrl(): ?string
    {
        return $this->remoteUrl;
    }

    public function setRemoteUrl(?string $remoteUrl): self
    {
        $this->remoteUrl = $remoteUrl;

        return $this;
    }

    public function getGatewayName(): ?string
    {
        return $this->gatewayName;
    }

    public function setGatewayName(?string $gatewayName): self
    {
        $this->gatewayName = $gatewayName;

        return $this;
    }
}
