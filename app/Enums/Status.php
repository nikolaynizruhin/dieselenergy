<?php

namespace App\Enums;

enum Status: string
{
    /**
     * The new order status.
     *
     * @var string
     */
    case New = 'Новий';

    /**
     * The pending order status.
     *
     * @var string
     */
    case Pending = 'В очікуванні';

    /**
     * The done order status.
     *
     * @var string
     */
    case Done = 'Зроблено';

    /**
     * Get badge.
     *
     * @return string
     */
    public function badge()
    {
        return match ($this) {
            Status::New => 'primary',
            Status::Pending => 'warning',
            Status::Done => 'success',
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
