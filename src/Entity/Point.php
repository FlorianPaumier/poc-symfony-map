<?php

namespace App\Entity;

use App\Repository\PointRepository;
use Doctrine\ORM\Mapping as ORM;
use Jsor\Doctrine\PostGIS\Types\PostGISType;

#[ORM\Entity(repositoryClass: PointRepository::class)]
class Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(
        type: PostGISType::GEOMETRY,
        options: ['geometry_type' => 'POINT']
    )]
    private ?string $geometry = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGeometry(): ?string
    {
        return $this->geometry;
    }

    public function setGeometry(?string $geometry): self
    {
        $this->geometry = $geometry;
        return $this;
    }


}
