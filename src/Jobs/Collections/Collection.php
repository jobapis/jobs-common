<?php namespace Jobs\Collections;

class Collection
{
    /**
    * Class for storing a collection of items. Basically this adds functionality
    * and security to an array.
    */
    protected $items = [];
    protected $errors = [];

    public function add($item, $key = null)
    {
        if ($key == null) {
            $this->items[] = $item;
        } else {
            if (isset($this->items[$key])) {
                return $this->addError("Invalid key $key.");
            } else {
                $this->items[$key] = $item;
            }
        }
        return $this;
    }

    public function delete($key)
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            return $this->addError("Invalid key $key.");
        }
        return $this;
    }

    public function get($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            return $this->addError("Invalid key $key.");
        }
    }

    public function all()
    {
        return $this->items;
    }

    public function addError($message)
    {
        if (isset($message)) {
            $this->errors[] = $message;
        } else {
            $this->errors[] = "Invalid error mesage.";
        }
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
