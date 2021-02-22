<?php

declare(strict_types=1);

namespace Tests;

use MetaRush\Pagination\Builder;

class BuilderTest extends Common
{
    private Builder $builder;

    public function setUp(): void
    {
        parent::setUp();

        // set minimum config
        $this->builder = (new Builder)
            ->setTotalItems(30)
            ->setItemsPerPage(5)
            ->setCurrentPage(1)
            ->setPath('x');
    }

    public function test_build_default_pass()
    {
        $p = $this->builder->build();

        // ------------------------------------------------

        $expected = '1 <a href="x2">2</a> <a href="x3">3</a> <a href="x4">4</a> <a href="x5">5</a> <a href="x6">6</a>';
        $actual = $p->pageLinksUncut();
        $this->assertEquals($expected, $actual);

        $this->assertEquals('Prev', $p->prevLink());
        $this->assertEquals('<a href="x2">Next</a>', $p->nextLink());
    }

    public function test_build_autoCut_pass()
    {
        $p = $this->builder
            ->setPagesCutoff(3)
            ->build();

        // ------------------------------------------------

        $expected = '1 <a href="x2">2</a> <a href="x3">3</a> ... <a href="x6">6</a>';
        $actual = $p->pageLinksAutoCut();

        $this->assertEquals($expected, $actual);
    }

    public function test_build_autoCutCustomLookAndLastPage_pass()
    {
        $p = $this->builder
            ->setPagesCutoff(3)
            ->setCurrentPage(6)
            ->setPageLink('<li><a href="{{path}}{{page}}">{{page}}</a></li>')
            ->setActiveLink('<li>{{page}}</li>')
            ->setDisabledPrevLink('<li>Prev</li>')
            ->setDisabledNextLink('<li>Next</li>')
            ->setEllipsis('<li>...</li>')
            ->setPrevLink('<li><a href="{{path}}{{page}}">Prev</a></li>')
            ->setNextLink('<li <a href="{{path}}{{page}}">Next</a></li>')
            ->build();

        // ------------------------------------------------

        $expected = '<li><a href="x1">1</a></li> <li>...</li> <li><a href="x4">4</a></li> <li><a href="x5">5</a></li> <li>6</li>';
        $actual = $p->pageLinksAutoCut();

        $this->assertEquals($expected, $actual);

        $this->assertEquals('<li>Next</li>', $p->nextLink());
    }

    public function test_build_autoCutButPagesCutoffIsNotSet_pass()
    {
        $this->expectExceptionMessageMatches('/setPagesCutoff/');

        // ------------------------------------------------

        $p = $this->builder
            ->setPagesCutoff(0) // set to 0 to trigger exception
            ->build();

        $p->pageLinksAutoCut();
    }

}