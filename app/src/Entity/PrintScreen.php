<?php

namespace App\Entity;

use App\Repository\PrintScreenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrintScreenRepository::class)
 */
class PrintScreen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file_type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fail_on_error;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $scroll_to_element;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $selector;

    /**
     * @ORM\Column(type="boolean")
     */
    private $full_page;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lazy_load;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreateDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->file_type;
    }

    public function setFileType(?string $file_type): self
    {
        $this->file_type = $file_type;

        return $this;
    }

    public function getFailOnError(): ?bool
    {
        return $this->fail_on_error;
    }

    public function setFailOnError(bool $fail_on_error): self
    {
        $this->fail_on_error = $fail_on_error;

        return $this;
    }

    public function getScrollToElement(): ?string
    {
        return $this->scroll_to_element;
    }

    public function setScrollToElement(?string $scroll_to_element): self
    {
        $this->scroll_to_element = $scroll_to_element;

        return $this;
    }

    public function getSelector(): ?string
    {
        return $this->selector;
    }

    public function setSelector(?string $selector): self
    {
        $this->selector = $selector;

        return $this;
    }

    public function getFullPage(): ?bool
    {
        return $this->full_page;
    }

    public function setFullPage(bool $full_page): self
    {
        $this->full_page = $full_page;

        return $this;
    }

    public function getLazyLoad(): ?bool
    {
        return $this->lazy_load;
    }

    public function setLazyLoad(bool $lazy_load): self
    {
        $this->lazy_load = $lazy_load;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getUrl_Image(): ?string
    {
        return $this->url_image;
    }

    public function setUrlImage(?string $url_image): self
    {
        $this->url_image = $url_image;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->CreateDate;
    }

    public function setCreateDate(\DateTimeInterface $CreateDate): self
    {
        $this->CreateDate = $CreateDate;

        return $this;
    }
}
