<?php namespace JobApis\Jobs\Client\Test;

use JobApis\Jobs\Client\Collection;

/**
 *  Uses PHPUnit to test methods and properties set in
 *  the generic Collection class.
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
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

    public function testItDeletesItemFromCollectionWithValidKey()
    {
        $item = "New Item for Collection";
        $key = "1";
        $error = "Invalid key $key.";

        $result = $this->collection->add($item, $key)->delete($key)->get($key);
        $errors = $this->collection->getErrors();

        $this->assertEquals($error, end($errors));
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

    public function testItFailsToGetItemWithoutValidKey()
    {
        $key = uniqid();
        $message = "Invalid key $key.";

        $this->collection->get($key);
        $errors = $this->collection->getErrors();

        $this->assertEquals($message, end($errors));
    }

    public function testItFailsToDeleteItemWithoutValidKey()
    {
        $key = uniqid();
        $message = "Invalid key $key.";

        $this->collection->delete($key);
        $errors = $this->collection->getErrors();

        $this->assertEquals($message, end($errors));
    }
}
