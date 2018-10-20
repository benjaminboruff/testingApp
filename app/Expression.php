<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Expression
{
    protected $expression = '';

    public function make()
    {
        return new static;
    }

    public function find($value)
    {
        $value = $this->sanitize($value);
        return $this->add($value);
    }

    public function then($value)
    {
        return $this->find($value);
    }
  
    public function anything()
    {
        return $this->add('.*');
    }

    public function maybe($value)
    {
        $value = $this->sanitize($value);
        return $this->add("($value)?");
    }

    public function anythingBut($value)
    {
        $value = $this->sanitize($value);
        return $this->add("(?!$value).*?");
    }

    public function __toString()
    {
        $retString = '/' . $this->expression . '/';
        // var_dump($retString);
        return $retString;
    }

    public function sanitize($value)
    {
        return preg_quote($value, '/');
    }

    protected function add($value)
    {
        $this->expression .= $value;
        return $this;
    }
}
