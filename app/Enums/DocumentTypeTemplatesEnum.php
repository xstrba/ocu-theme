<?php

declare(strict_types=1);

namespace App\Enums;

enum DocumentTypeTemplatesEnum: string
{
    case YEARLY_PAGINATION = 'yearly_pagination';

    case NO_PAGINATION = 'no_pagination';

    /**
     * @return self
     */
    public static function getDefault(): self
    {
        return self::YEARLY_PAGINATION;
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public static function tryFromOrDefault(string $value): self
    {
        return self::tryFrom($value) ?: self::getDefault();
    }

    /**
     * @param \Closure(string): string $trans
     *
     * @return string
     */
    public function getLabel(\Closure $trans): string
    {
        return match ($this) {
            self::YEARLY_PAGINATION => $trans('Stránkovanie po rokoch'),
            self::NO_PAGINATION => $trans('Bez stránkovania'),
        };
    }

    /**
     * @return bool
     */
    public function usesYearlyFilter(): bool
    {
        return $this === self::YEARLY_PAGINATION;
    }
}
