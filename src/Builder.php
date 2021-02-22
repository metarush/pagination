<?php

declare(strict_types=1);

namespace MetaRush\Pagination;

class Builder extends Config
{
    public function build(): Pagination
    {
        return new Pagination($this);
    }

}