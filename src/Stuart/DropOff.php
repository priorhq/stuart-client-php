<?php

namespace Stuart;

class DropOff extends Location
{
    private $packageType;
    private $packageDescription;
    private $clientReference;

    public function setPackageType($packageType)
    {
        $this->packageType = $packageType;
        return $this;
    }

    public function setPackageDescription($packageDescription)
    {
        $this->packageDescription = $packageDescription;
        return $this;
    }

    public function setClientReference($clientReference)
    {
        $this->clientReference = $clientReference;
        return $this;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), array(
            'package_type' => $this->packageType,
            'package_description' => $this->packageDescription,
            'client_reference' => $this->clientReference,
        ));
    }
}