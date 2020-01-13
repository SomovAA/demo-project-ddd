<?php

namespace Application\Repository;

interface CUDRepositoryInterface
{
    /**
     * @param object $object
     *
     * @return void
     */
    public function create($object);

    /**
     * @param object $object
     *
     * @return void
     */
    public function update($object);

    /**
     * @param object $object
     *
     * @return void
     */
    public function delete($object);
}