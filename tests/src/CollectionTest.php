<?php namespace JobApis\Jobs\Client\Tests;

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

    public function testItCanAddCollectionWhenCollectionHasItemsAndErrors()
    {
        $error = uniqid();

        // Add an item to the test collection
        $this->collection->add($this->getItem());

        // Create a new collection with 2 items and 1 error
        $collection = (new Collection())
            ->add($this->getItem())
            ->add($this->getItem())
            ->addError($error);

        $this->collection->addCollection($collection);

        $this->assertEquals(3, $this->collection->count());
        $this->assertEquals($error, $this->collection->getErrors()[0]);
    }

    public function testItCanAddCollectionWhenCollectionHasNoItems()
    {
        $error = uniqid();

        // Add an item to the test collection
        $this->collection->add($this->getItem());

        // Create a new collection with 1 error
        $collection = (new Collection())
            ->addError($error);

        $this->collection->addCollection($collection);

        $this->assertEquals(1, $this->collection->count());
        $this->assertEquals($error, $this->collection->getErrors()[0]);
    }

    public function testItCanFilterItemsWhenFieldExists()
    {
        // Add some items to the test collection
        $item = $this->getItem();
        $this->collection->add($item)
            ->add($this->getItem());

        // Filter
        $this->collection->filter('id', $item->id);

        // Test the results
        $this->assertEquals(1, $this->collection->count());
        $this->assertEquals($item, $this->collection->get(0));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Property not defined.
     */
    public function testItCannotFilterItemsWhenFieldNotExists()
    {
        // Add some items to the test collection
        $item = $this->getItem();
        $this->collection->add($item)
            ->add($this->getItem());

        // Filter
        $this->collection->filter(uniqid(), $item->id);
    }

    public function testItCanOrderItemsWhenFieldExists()
    {
        // Add some items to the test collection
        $this->collection
            ->add($this->getItem())
            ->add($this->getItem())
            ->add($this->getItem());

        // Filter
        $this->collection->orderBy('id');

        // Test the results
        $this->assertEquals(3, $this->collection->count());
        $prevItem = null;
        foreach($this->collection->all() as $item) {
            if ($prevItem) {
                $this->assertLessThan($prevItem, $item);
            }
            $prevItem = $item;
        }
    }

    public function testItCanOrderItemsAscWhenFieldExists()
    {
        // Add some items to the test collection
        $this->collection
            ->add($this->getItem())
            ->add($this->getItem())
            ->add($this->getItem());

        // Filter
        $this->collection->orderBy('id', 'asc');

        // Test the results
        $this->assertEquals(3, $this->collection->count());
        $prevItem = null;
        foreach($this->collection->all() as $item) {
            if ($prevItem) {
                $this->assertGreaterThan($prevItem, $item);
            }
            $prevItem = $item;
        }
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Property not defined.
     */
    public function testItCannotOrderItemsWhenFieldNotExists()
    {
        // Add some items to the test collection
        $this->collection
            ->add($this->getItem())
            ->add($this->getItem())
            ->add($this->getItem());

        // Filter
        $this->collection->orderBy(uniqid());
    }

    public function testItCanTruncateCollection()
    {
        // Add some items to the test collection
        $this->collection
            ->add($this->getItem())
            ->add($this->getItem())
            ->add($this->getItem());

        // Filter
        $this->collection->truncate(1);

        // Test the results
        $this->assertEquals(1, $this->collection->count());
    }

    private function getItem()
    {
        return (object) [
            'id' => uniqid(),
        ];
    }
}
