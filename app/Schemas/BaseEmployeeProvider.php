<?php

namespace App\Schemas;

abstract class BaseEmployeeProvider
{
    protected static string $providerName;

    abstract public static function mapTrackTikAttributes($data): array;

    abstract public static function getCreateValidationRules(): array;

    abstract public static function getUpdateValidationRules(): array;


}
