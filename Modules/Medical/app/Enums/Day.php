<?php

namespace Modules\Medical\Enums;

enum Day: string
{
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';

    /**
     * Get all available days
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            self::MONDAY->value,
            self::TUESDAY->value,
            self::WEDNESDAY->value,
            self::THURSDAY->value,
            self::FRIDAY->value,
            self::SATURDAY->value,
            self::SUNDAY->value,
        ];
    }

    /**
     * Get all days as options for select with translations
     *
     * @return array
     */
    public static function options(): array
    {
        return [
            self::MONDAY->value => __('Monday') . ' - ' . __('الاثنين'),
            self::TUESDAY->value => __('Tuesday') . ' - ' . __('الثلاثاء'),
            self::WEDNESDAY->value => __('Wednesday') . ' - ' . __('الأربعاء'),
            self::THURSDAY->value => __('Thursday') . ' - ' . __('الخميس'),
            self::FRIDAY->value => __('Friday') . ' - ' . __('الجمعة'),
            self::SATURDAY->value => __('Saturday') . ' - ' . __('السبت'),
            self::SUNDAY->value => __('Sunday') . ' - ' . __('الأحد'),
        ];
    }

    /**
     * Get translated name of day including Arabic
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::MONDAY => __('Monday') . ' - ' . __('الاثنين'),
            self::TUESDAY => __('Tuesday') . ' - ' . __('الثلاثاء'),
            self::WEDNESDAY => __('Wednesday') . ' - ' . __('الأربعاء'),
            self::THURSDAY => __('Thursday') . ' - ' . __('الخميس'),
            self::FRIDAY => __('Friday') . ' - ' . __('الجمعة'),
            self::SATURDAY => __('Saturday') . ' - ' . __('السبت'),
            self::SUNDAY => __('Sunday') . ' - ' . __('الأحد'),
        };
    }
}
