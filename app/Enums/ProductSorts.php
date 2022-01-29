<?php

namespace App\Enums;

enum ProductSorts: string
{
    /**
     * The name asc sort.
     *
     * @var string
     */
    case NameAsc = 'name';

    /**
     * The name desc sort.
     *
     * @var string
     */
    case NameDesc = '-name';

    /**
     * The price asc sort.
     *
     * @var string
     */
    case PriceAsc = 'price';

    /**
     * The price desc sort.
     *
     * @var string
     */
    case PriceDesc = '-price';

    /**
     * Get all sorts.
     *
     * @return array
     */
    public static function all()
    {
        return [
            ProductSorts::NameAsc->value => 'Назва (А - Я)',
            ProductSorts::NameDesc->value => 'Назва (Я - А)',
            ProductSorts::PriceAsc->value => 'Ціна (Низька > Висока)',
            ProductSorts::PriceDesc->value => 'Ціна (Висока > Низька)',
        ];
    }
}
