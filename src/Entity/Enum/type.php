<?php
namespace App\Entity\Enum;
abstract class type {
    const NO_VAT_PAYER= 1;
    const VAT_PAYER = 2;
    const PARTIAL_VAT_PAYER = 3;
}