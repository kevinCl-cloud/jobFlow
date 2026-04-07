<?php

namespace App\Entity;

use App\Enum\RelanceStatus;
use App\Repository\RelanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelanceRepository::class)]
class Relance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Apply $apply = null;

    #[ORM\Column(length: 255)]
    private ?string $mailSubject = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $mailBody = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $scheduledAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $sentAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(enumType: RelanceStatus::class)]
    private ?RelanceStatus $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApply(): ?Apply
    {
        return $this->apply;
    }

    public function setApply(?Apply $apply): static
    {
        $this->apply = $apply;

        return $this;
    }

    public function getMailSubject(): ?string
    {
        return $this->mailSubject;
    }

    public function setMailSubject(string $mailSubject): static
    {
        $this->mailSubject = $mailSubject;

        return $this;
    }

    public function getMailBody(): ?string
    {
        return $this->mailBody;
    }

    public function setMailBody(string $mailBody): static
    {
        $this->mailBody = $mailBody;

        return $this;
    }

    public function getScheduledAt(): ?\DateTimeImmutable
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(\DateTimeImmutable $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getSentAt(): ?\DateTimeImmutable
    {
        return $this->sentAt;
    }

    public function setSentAt(?\DateTimeImmutable $sentAt): static
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getStatus(): ?RelanceStatus
    {
        return $this->status;
    }

    public function setStatus(RelanceStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}