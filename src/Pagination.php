<?php

declare(strict_types=1);

namespace MetaRush\Pagination;

use MetaRush\Pagination\Exception;

class Pagination
{
    private Config $cfg;
    private int $numberOfPages;

    public function __construct(Config $cfg)
    {
        $this->cfg = $cfg;
        $this->numberOfPages = (int) \ceil($cfg->getTotalItems() / $cfg->getItemsPerPage());
    }

    public function pageLinksUncut(): string
    {
        $currentPage = $this->cfg->getCurrentPage();
        $pageLink = $this->cfg->getPageLink();
        $activeLink = $this->cfg->getActiveLink();

        // ------------------------------------------------

        $pageLinks = '';

        for ($i = 1; $i <= $this->numberOfPages; $i++) {

            $link = \str_replace('{{page}}', (string) $i, $pageLink);

            $newActiveLink = \str_replace('{{page}}', (string) $i, $activeLink);

            $pageLinks .= ($i == $currentPage) ? $newActiveLink . ' ' : $link . ' ';
        }

        return \trim($pageLinks);
    }

    public function pageLinksAutoCut(): string
    {
        if (!$this->cfg->getPagesCutoff())
            throw new Exception('setPagesCutoff() config must be set');

        // ------------------------------------------------

        $currentPage = $this->cfg->getCurrentPage();
        $pagesPerSide = \floor($this->cfg->getPagesCutoff() / 2);
        $pageLink = $this->cfg->getPageLink();
        $ellipsis = $this->cfg->getEllipsis();
        $activeLink = $this->cfg->getActiveLink();
        $lastPage = $this->numberOfPages;

        // ------------------------------------------------

        $s = '';

        // ------------------------------------------------

        $leftSideStart = ($currentPage - $pagesPerSide);

        $leftSideEnd = $currentPage - 1;

        if ($currentPage >= $lastPage - $pagesPerSide)
            $leftSideStart = $leftSideStart - ($pagesPerSide - ($lastPage - $currentPage));

        if ($leftSideStart >= 2)
            $s .= \str_replace('{{page}}', '1', $pageLink) . ' ';

        if ($leftSideStart >= 3)
            $s .= "$ellipsis ";

        for ($i = $leftSideStart; $i <= $leftSideEnd; $i++)
            if ($i > 0)
                $s .= \str_replace('{{page}}', (string) $i, $pageLink) . ' ';

        // ------------------------------------------------

        $activeLink = \str_replace('{{page}}', (string) $currentPage, $activeLink);

        $s .= "$activeLink ";

        // ------------------------------------------------

        $rightSideStart = $currentPage + 1;

        $rightSideEnd = ($currentPage + $pagesPerSide);

        if ($currentPage <= $pagesPerSide)
            $rightSideEnd = $rightSideEnd + ($pagesPerSide - $currentPage + 1);

        for ($i = $rightSideStart; $i <= $rightSideEnd; $i++)
            if ($i <= $lastPage)
                $s .= \str_replace('{{page}}', (string) $i, $pageLink) . ' ';

        if ($rightSideEnd <= ($lastPage - 2))
            $s .= "$ellipsis ";

        if ($rightSideEnd <= ($lastPage - 1))
            $s .= \str_replace('{{page}}', (string) $lastPage, $pageLink);

        // ------------------------------------------------

        return \trim($s);
    }

    public function prevLink(): string
    {
        $prevNum = $this->cfg->getCurrentPage() - 1;

        $prevLink = \str_replace('{{page}}', (string) $prevNum, $this->cfg->getPrevLink());

        $prevLink = ($this->cfg->getCurrentPage() <= 1) ? $this->cfg->getDisabledPrevLink() : $prevLink;

        return $prevLink;
    }

    public function nextLink(): string
    {
        $nextNum = $this->cfg->getCurrentPage() + 1;

        $nextLink = \str_replace('{{page}}', (string) $nextNum, $this->cfg->getNextLink());

        $nextLink = ($this->cfg->getCurrentPage() >= $this->numberOfPages) ? $this->cfg->getDisabledNextLink() : $nextLink;

        return $nextLink;
    }

}