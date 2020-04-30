<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Option;
use App\Form\OptionType;
use App\Entity\Collection;
class PropertySearch
{
   
    
    private $maxPrice;

    
    private $minSurface;
    private $options;
    public function __construct()
    {
        
        $this->options = new ArrayCollection();
    }
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(int $maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }
public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(ArrayCollection $options)
    {
        $this->options=$options;
    }
}
