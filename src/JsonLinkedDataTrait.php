<?php namespace JobBrander\Jobs\Client;

trait JsonLinkedDataTrait
{
    /**
     * Serialize object as array
     *
     * @param  string  $serializeSetting
     *
     * @return array
     */
    protected function serialize($serializeSetting = self::SERIALIZE_STANDARD)
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
        $ref = new \ReflectionClass($object);
        $properties = $ref->getProperties();

        $array = [];

        if ($this->settingIsLinkedData($serializeSetting)) {
            $array["@type"] = $ref->getShortName();
        }

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $name = $property->getName();
            $value = $property->getValue($object);
            if ($property->class != Job::class || !$this->settingIsCoreSchema($serializeSetting)) {
                if (!is_object($value)) {
                    $array[$name] = $value;
                } else {
                    if ($value instanceof \DateTime) {
                        $array[$name] = date_format($value, 'Y-m-d');
                    } else {
                        $array[$name] = $this->createSerializedArrayFromObject(
                            $value,
                            $serializeSetting
                        );
                    }
                }
            }
        }

        return $array;
    }

    /**
     * Check if setting indicates if only core schema should be included
     *
     * @param  string $setting
     *
     * @return boolean
     */
    private function settingIsCoreSchema($setting)
    {
        return in_array($setting, [self::SERIALIZE_CORE_SCHEMA_LD]);
    }

    /**
     * Check if setting indicates if Linked Data support should be provided
     *
     * @param  string $setting
     *
     * @return boolean
     */
    private function settingIsLinkedData($setting)
    {
        return in_array($setting, [self::SERIALIZE_STANDARD_LD, self::SERIALIZE_CORE_SCHEMA_LD]);
    }
}
