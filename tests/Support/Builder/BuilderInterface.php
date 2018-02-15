<?php

declare(strict_types=1);

namespace Tests\Support\Builder;

interface BuilderInterface
{
    /**
     * Create the builder.
     *
     * @return mixed
     */
    public static function create();

    /**
     * Build and return the object the builder takes care of.
     *
     * @return mixed
     */
    public function build();
}
