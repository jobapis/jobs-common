<?php namespace JobApis\Jobs\Client;

use Countable;

/**
* Class for storing a collection of items. Basically this adds functionality
* and security to an array.
*/
class Collection implements Countable
{
    /**
     * Items
     *
     * @var array
     */
    protected $items = [];

    /**
     * Errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Add item to collection, at specific key if given
     *
     * @param   mixed          $item
     * @param   integer|string $key Optional
     *
     * @return  Collection
     */
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

    /**
     * Add error to collection
     *
     * @param   string $message
     *
     * @return  Collection
     */
    public function addError($message)
    {
        if (isset($message)) {
            $this->errors[] = $message;
        } else {
            $this->errors[] = "Invalid error mesage.";
        }

        return $this;
    }

    /**
     * Get all items from collection
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get count of items in collection
     *
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Delete item from collection at specific key
     *
     * @param  integer|string $key
     *
     * @return Collection
     */
    public function delete($key)
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            return $this->addError("Invalid key $key.");
        }

        return $this;
    }

    /**
     * Get item from collection at specific key
     *
     * @param  integer|string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            $this->addError("Invalid key $key.");
        }

        return null;
    }

    /**
     * Get all errors from Collection
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
