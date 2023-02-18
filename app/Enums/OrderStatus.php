<?php

namespace App\Enums;

enum OrderStatus: string
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
     */
    public function badge(): string
    {
        return match ($this) {
            OrderStatus::New => 'primary',
            OrderStatus::Pending => 'warning',
            OrderStatus::Done => 'success',
        };
    }

    /**
     * Get all statuses.
     */
    public static function all(): array
    {
        return array_map(fn (OrderStatus $status) => $status->value, OrderStatus::cases());
    }
}
