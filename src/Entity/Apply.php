<?php

namespace App\Entity;

use App\Enum\ApplyStatus;
use App\Repository\ApplyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplyRepository::class)]
class Apply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'applies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CandidateProfile $candidateProfile = null;

    #[ORM\ManyToOne(inversedBy: 'applies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offer $offer = null;

    #[ORM\Column(length: 255)]
    private ?string $mailSubject = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $mailBody = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $coverLetter = null;

    #[ORM\Column(enumType: ApplyStatus::class)]
    private ?ApplyStatus $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidateProfile(): ?CandidateProfile
    {
        return $this->candidateProfile;
    }

    public function setCandidateProfile(?CandidateProfile $candidateProfile): static
    {
        $this->candidateProfile = $candidateProfile;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): static
    {
        $this->offer = $offer;

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

    public function getCoverLetter(): ?string
    {
        return $this->coverLetter;
    }

    public function setCoverLetter(string $coverLetter): static
    {
        $this->coverLetter = $coverLetter;

        return $this;
    }

    public function getStatus(): ?ApplyStatus
    {
        return $this->status;
    }

    public function setStatus(ApplyStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}