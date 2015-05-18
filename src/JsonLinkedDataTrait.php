<?php namespace JobBrander\Jobs\Client;

trait JsonLinkedDataTrait
{
    /**
     * Serialize object as array
     *
     * @param  boolean  $useStrict
     *
     * @return array
     */
    protected function serialize($useStrict = false)
    {
        $array = ["@context" => "http://schema.org", "@type" => "JobPosting"];

        $serializedArray = $this->createSerializedArrayFromObject($this);

        $array = array_merge($serializedArray, $array);

        ksort($array);

        return $array;
    }

    /**
     * Create serialized array of given object, including recursion
     *
     * @param  object $object
     *
     * @return array
     */
    private function createSerializedArrayFromObject($object)
    {
        $ref = new \ReflectionClass($object);
        $properties = $ref->getProperties();

        $array = [
            "@type" => $ref->getShortName(),
        ];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $name = $property->getName();
            $value = $property->getValue($object);
            if (!is_object($value)) {
                $array[$name] = $value;
            } else {
                if ($value instanceof \DateTime) {
                    $array[$name] = date_format($value, 'Y-m-d');
                } else {
                    $array[$name] = $this->createSerializedArrayFromObject($value);
                }
            }
        }

        return $array;
    }
}
