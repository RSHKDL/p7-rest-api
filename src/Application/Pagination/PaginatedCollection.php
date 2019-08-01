<?php

namespace App\Application\Pagination;

/**
 * Class PaginatedCollection
 * @author ereshkidal
 */
final class PaginatedCollection
{
    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     */
    private $itemsTotal;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var array
     */
    private $_links = [];

    /**
     * PaginatedCollection constructor.
     * @param array $items
     * @param int $itemsTotal
     */
    public function __construct(array $items, int $itemsTotal)
    {
        $this->items = $items;
        $this->itemsTotal = $itemsTotal;
        $this->itemsPerPage = count($items);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getItemsTotal(): int
    {
        return $this->itemsTotal;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->_links;
    }

    /**
     * @param string $ref
     * @param string $url
     */
    public function addLink(string $ref, string $url): void
    {
        $this->_links[$ref] = $url;
    }
}
