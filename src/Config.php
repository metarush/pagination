<?php

declare(strict_types=1);

namespace MetaRush\Pagination;

class Config
{
    private int $totalItems;
    private int $itemsPerPage;
    private int $currentPage;
    private string $path;
    private string $pageLink = '<a href="{{path}}{{page}}">{{page}}</a>';
    private string $prevLink = '<a href="{{path}}{{page}}">Prev</a>';
    private string $nextLink = '<a href="{{path}}{{page}}">Next</a>';
    private string $disabledPrevLink = 'Prev';
    private string $disabledNextLink = 'Next';
    private string $activeLink = '{{page}}';
    private string $ellipsis = '...';
    private int $pagesCutoff = 7;

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getPageLink(): string
    {
        $pageLink = \str_replace('{{path}}', $this->getPath(), $this->pageLink);

        return $pageLink;
    }

    public function getPrevLink(): string
    {
        $prevLink = \str_replace('{{path}}', $this->getPath(), $this->prevLink);

        return $prevLink;
    }

    public function getNextLink(): string
    {
        $nextLink = \str_replace('{{path}}', $this->getPath(), $this->nextLink);

        return $nextLink;
    }

    public function getDisabledPrevLink(): string
    {
        return $this->disabledPrevLink;
    }

    public function getDisabledNextLink(): string
    {
        return $this->disabledNextLink;
    }

    public function getActiveLink(): string
    {
        $activeLink = \str_replace('{{path}}', $this->getPath(), $this->activeLink);

        return $activeLink;
    }

    public function getEllipsis(): string
    {
        return $this->ellipsis;
    }

    public function getPagesCutoff(): ?int
    {
        return $this->pagesCutoff;
    }

    public function setTotalItems(int $totalItems): self
    {
        $this->totalItems = $totalItems;
        return $this;
    }

    public function setItemsPerPage(int $itemsPerPage): self
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    public function setCurrentPage(int $currentPage): self
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function setPageLink(string $pageLink): self
    {
        $this->pageLink = $pageLink;
        return $this;
    }

    public function setPrevLink(string $prevLink): self
    {
        $this->prevLink = $prevLink;
        return $this;
    }

    public function setNextLink(string $nextLink): self
    {
        $this->nextLink = $nextLink;
        return $this;
    }

    public function setDisabledPrevLink(string $disabledPrevLink): self
    {
        $this->disabledPrevLink = $disabledPrevLink;
        return $this;
    }

    public function setDisabledNextLink(string $disabledNextLink): self
    {
        $this->disabledNextLink = $disabledNextLink;
        return $this;
    }

    public function setActiveLink(string $activeLink): self
    {
        $this->activeLink = $activeLink;
        return $this;
    }

    public function setEllipsis(string $ellipsis): self
    {
        $this->ellipsis = $ellipsis;
        return $this;
    }

    public function setPagesCutoff(int $pagesCutoff): self
    {
        $this->pagesCutoff = $pagesCutoff;
        return $this;
    }

}