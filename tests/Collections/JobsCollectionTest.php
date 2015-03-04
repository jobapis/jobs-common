<?php
/**
 *  Uses PHPUnit to test methods and properties set in
 *  the JobsCollection class.
 */

use Jobs\Collections\JobsCollection;

class JobsCollectionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->collection = new JobsCollection();
    }

    public function testItUpdatesAttributes()
    {
        //
    }
}
