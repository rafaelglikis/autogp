<?php
/**
 * Created by PhpStorm.
 * User: rafaelglikis
 * Date: 11/07/2017
 * Time: 2:38 ΜΜ
 */

namespace rafaelglikis\autogp\Datatypes;


class CopierCategory extends Category
{
    private $destinationCategories = array();

    public function __construct(string $sourceUrl, array $destinationCategories)
    {
        //parent::
        parent::__construct($sourceUrl);
        $this->destinationCategories = $destinationCategories;
    }

    public function getDestinationCategories(): array
    {
        return $this->destinationCategories;
    }

    public function setDestinationCategories(array $destinationCategories)
    {
        $this->destinationCategories = $destinationCategories;
    }
}