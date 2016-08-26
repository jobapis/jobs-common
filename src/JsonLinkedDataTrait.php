<?php namespace JobApis\Jobs\Client;

use Closure;
use ReflectionClass;
use ReflectionProperty;

trait JsonLinkedDataTrait
{
    /**
     * Serialize object as array
     *
     * @param  string  $serializeSetting
     *
     * @return array
     */
    protected function serialize($serializeSetting)
    {
        $array = [];

        if ($this->settingIsLinkedData($serializeSetting)) {
            $array["@context"] = "http://schema.org";
            $array["@type"] = "JobPosting";
        }

        $serializedArray = $this->createSerializedArrayFromObject(
            $this,
            $serializeSetting
        );

        $array = array_merge($serializedArray, $array);

        ksort($array);

        return $array;
    }

    /**
     * Create serialized array of given object, including recursion
     *
     * @param  object $object
     * @param  string $serializeSetting
     *
     * @return array
     */
    private function createSerializedArrayFromObject($object, $serializeSetting)
    {
        $ref = new ReflectionClass($object);
        $properties = $ref->getProperties();

        $array = [];

        if ($this->settingIsLinkedData($serializeSetting)) {
            $array["@type"] = $ref->getShortName();
        }

        $process = function ($property) use (&$array, $object, $serializeSetting) {
            if ($this->includeGivenProperty($property, $serializeSetting)) {
                $property->setAccessible(true);
                $name = $property->getName();
                $value = $property->getValue($object);

                $recursion = function ($value) use ($serializeSetting) {
                    return call_user_func_array(
                        [$this, 'createSerializedArrayFromObject'],
                        [$value, $serializeSetting]
                    );
                };

                $array = call_user_func_array(
                    [$this, 'mergeWithArray'],
                    [$array, $name, $value, $recursion]
                );
            }
        };

        array_map($process, $properties);

        return $array;
    }

    /**
     * Check if given property should be included in serialization
     *
     * @param  ReflectionProperty  $property
     * @param  string              $serializeSetting
     *
     * @return boolean
     */
    private function includeGivenProperty(ReflectionProperty $property, $serializeSetting)
    {
        return $property->class != Job::class
            || !$this->settingIsCoreSchema($serializeSetting);
    }

    /**
     * Attempt to merge a value with an existing array
     *
     * @param  array   $array
     * @param  string  $name
     * @param  mixed   $value
     * @param  Closure $recursion
     *
     * @return array
     */
    private function mergeWithArray(array $array, $name, $value, Closure $recursion)
    {
        if (!is_object($value)) {
            $array[$name] = $value;
        } elseif ($value instanceof \DateTime) {
            $array[$name] = date_format($value, 'Y-m-d');
        } else {
            $array[$name] = $recursion($value);
        }

        return $array;
    }

    /**
     * Get core schema types
     *
     * @return array
     */
    abstract public function getCoreSchemaTypes();

    /**
     * Check if setting indicates if only core schema should be included
     *
     * @param  string $setting
     *
     * @return boolean
     */
    private function settingIsCoreSchema($setting)
    {
        $coreTypes = $this->getCoreSchemaTypes();

        return in_array($setting, $coreTypes);
    }

    /**
     * Get linked data schema types
     *
     * @return array
     */
    abstract public function getLinkedDataSchemaTypes();

    /**
     * Check if setting indicates if Linked Data support should be provided
     *
     * @param  string $setting
     *
     * @return boolean
     */
    private function settingIsLinkedData($setting)
    {
        $linkedDataTypes = $this->getLinkedDataSchemaTypes();

        return in_array($setting, $linkedDataTypes);
    }
}
