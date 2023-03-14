<?php

declare(strict_types=1);

namespace App\Domain\Model;

abstract class AbstractModel
{
    public function fromArray($data):void
    {
        $attributes = get_object_vars($data);
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = (is_int($this->$attribute) ? (int) $data[$attribute] : $data[$attribute]);
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

}
