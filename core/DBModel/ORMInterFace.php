<?php

namespace e2c\mvc\DBModel;

interface ORMInterFace
{
    /**
     * @return bool
     */
    public function save():bool;

    /**
     * @param array $data
     * @return array
     */
    public function create( array $data):array;

    /**
     * @param array $data
     * @return array
     */
    public function update( array $data):array;

    /**
     * @param array $data
     * @return bool
     */
    public function delete( array $data):bool;
}