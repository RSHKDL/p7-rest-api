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
     * RouteParams constructor.
     * @param string $routeName The Route name
     * @param array $parameters The Route parameters
     */
    public function __construct(string $routeName, array $parameters)
    {
        $this->name = $routeName;
        $this->parameters = new ArrayCollection($parameters);
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
}
