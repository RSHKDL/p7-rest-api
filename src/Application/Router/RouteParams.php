<?php

namespace App\Application\Router;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class RouteParams
 * @author ereshkidal
 */
final class RouteParams
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection|array
     */
    private $parameters;

    /**
     * @var string|null
     */
    private $filter;

    /**
     * RouteParams constructor.
     * @param string $routeName The Route name
     * @param array $parameters The Route parameters
     * @param string|null $filter The Route filter
     */
    public function __construct(string $routeName, array $parameters, ?string $filter = null)
    {
        $this->name = $routeName;
        $this->parameters = new ArrayCollection($parameters);
        $this->filter = $filter;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    /**
     * @return string|null
     */
    public function getFilter(): ?string
    {
        return $this->filter;
    }
}
