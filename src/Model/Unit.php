<?php

namespace App\Model;

/**
 * Created by PhpStorm.
 * User: d.kandia
 * Date: 15/02/2018
 * Time: 08:02
 */
class Unit
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $quantity;

    /**
     * @var Unit
     */
    private $referenceUnit;

    /**
     * Unit constructor.
     *
     * @param string $name
     * @param string $quantity
     * @param Unit   $referenceUnit
     */
    public function __construct($name, $quantity, Unit $referenceUnit = null)
    {
        $this->name          = $name;
        $this->quantity      = $quantity;
        $this->referenceUnit = $referenceUnit;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return Unit
     */
    public function getReferenceUnit()
    {
        return $this->referenceUnit;
    }

    /**
     * @param Unit $referenceUnit
     */
    public function setReferenceUnit($referenceUnit)
    {
        $this->referenceUnit = $referenceUnit;
    }
}