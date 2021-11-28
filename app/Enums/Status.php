<?php

namespace App\Enums;

enum Status: string
{
    /**
     * The new order status.
     *
     * @var string
     */
    case NEW = 'Новий';

    /**
     * The pending order status.
     *
     * @var string
     */
    case PENDING = 'В очікуванні';

    /**
     * The done order status.
     *
     * @var string
     */
    case DONE = 'Зроблено';

    /**
     * Get badge.
     *
     * @return string
     */
    public function badge()
    {
        return match($this) {
            Status::NEW => 'primary',
            Status::PENDING => 'warning',
            Status::DONE => 'success',
        };
    }

    /**
     * Get all statuses.
     *
     * @return array
     */
    public static function all()
    {
        return array_map(fn (Status $status) => $status->value, Status::cases());
    }
}
