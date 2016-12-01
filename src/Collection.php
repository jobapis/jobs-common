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
     * Append a collection to this collection.
     *
     * @param Collection $collection
     *
     * @return $this
     */
    public function addCollection(Collection $collection)
    {
        // If there are jobs, add them to the collection
        if ($collection->count()) {
            foreach ($collection->all() as $job) {
                $this->add($job);
            }
        }
        // If there are errors, add them to the collection
        if ($collection->getErrors()) {
            foreach ($collection->getErrors() as $error) {
                $this->addError($error);
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
     * Filter items by a field having a specific value.
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function filter($field, $value, $operator = '=')
    {
        $this->items = array_filter(
            $this->items,
            function ($item) use ($field, $value, $operator) {
                if (!isset($item->{$field})) {
                    throw new \Exception("Property not defined.");
                }
                if ($operator == '>') {
                    return $item->{$field} > $value;
                } elseif ($operator == '<') {
                    return $item->{$field} < $value;
                } elseif ($operator == '=') {
                    return $item->{$field} == $value;
                }
                return false;
            }
        );

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

    /**
     * Order items by a field value.
     *
     * @param string $orderBy
     * @param string $order
     *
     * @return $this
     */
    public function orderBy($orderBy, $order = 'desc')
    {
        usort(
            $this->items,
            function ($item1, $item2) use ($orderBy, $order) {
                if (!isset($item1->{$orderBy}) || !isset($item2->{$orderBy})) {
                    throw new \Exception("Property not defined.");
                }
                // If the two items are equal, return 0
                if ($item1->{$orderBy} == $item2->{$orderBy}) {
                    return 0;
                }
                // If ascending, test whether Item 1 is less than Item 2
                if ($order === 'asc') {
                    return $item1->{$orderBy} < $item2->{$orderBy} ? -1 : 1;
                }
                // Else assuming descending.
                return $item1->{$orderBy} > $item2->{$orderBy} ? -1 : 1;
            }
        );

        return $this;
    }

    /**
     * Truncate the items to a maximum number of results.
     *
     * @param null $max
     *
     * @return $this
     */
    public function truncate($max = null)
    {
        if ($max) {
            $this->items = array_slice($this->items, 0, $max);
        }

        return $this;
    }
}
