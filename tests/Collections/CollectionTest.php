<?php
/**
 *  Uses PHPUnit to test methods and properties set in
 *  the generic Collection class.
 */

use Jobs\Collections\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->collection = new Collection();
    }

    public function testItAddsItemToCollectionWithoutKey()
    {
        $item = "New Item for Collection";

        $this->collection->add($item);
        $allItems = $this->collection->all();

        $this->assertEquals($item, end($allItems));
    }

    public function testItAddsItemToCollectionWithKey()
    {
        $item = "New Item for Collection";
        $key = "1";

        $this->collection->add($item, $key);

        $this->assertEquals($item, $this->collection->get($key));
    }

    public function testItFailsToAddItemToCollectionWithUsedKey()
    {
        $item = "New Item for Collection";
        $key = "1";
        $error = "Invalid key $key.";

        $this->collection->add($item, $key);

        $item = "Another new Item for Collection";
        $this->collection->add($item, $key);

        $errors = $this->collection->getErrors();

        $this->assertEquals($error, end($errors));
    }

    public function testItFailsToAddErrorWithoutMessage()
    {
        $error = NULL;
        $message = "Invalid error mesage.";

        $this->collection->addError($error);
        $errors = $this->collection->getErrors();

        $this->assertEquals($message, end($errors));
    }
}
