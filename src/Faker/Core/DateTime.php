<?php

namespace Faker\Core;

use Faker\Extension\DateTimeExtension;
use Faker\Extension\GeneratorAwareExtension;
use Faker\Extension\GeneratorAwareExtensionTrait;

/**
 * @experimental
 *
 * @since 1.19.0
 */
final class DateTime implements DateTimeExtension, GeneratorAwareExtension
{
    use GeneratorAwareExtensionTrait;

    /**
     * @var string
     */
    private $defaultTimezone = null;

    /**
     * Get the POSIX-timestamp of a DateTime, int or string.
     *
     * @param \DateTime|float|int|string $until
     *
     * @return false|int
     */
    protected function getTimestamp($until = 'now')
    {
        if (is_numeric($until)) {
            return (int) $until;
        }

        if ($until instanceof \DateTime) {
            return $until->getTimestamp();
        }

        return strtotime(empty($max) ? 'now' : $max);
    }

    /**
     * Get a DateTime created based on a POSIX-timestamp.
     *
     * @param int $timestamp the UNIX / POSIX-compatible timestamp
     */
    protected function getTimestampDateTime(int $timestamp): \DateTime
    {
        return new \DateTime('@' . $timestamp);
    }

    protected function setDefaultTimezone(string $timezone = null): void
    {
        $this->defaultTimezone = $timezone;
    }

    protected function getDefaultTimezone(): ?string
    {
        return $this->defaultTimezone;
    }

    protected function resolveTimezone(?string $timezone): string
    {
        if ($timezone !== null) {
            return $timezone;
        }

        return null === $this->defaultTimezone ? date_default_timezone_get() : $this->defaultTimezone;
    }

    /**
     * Internal method to set the timezone on a DateTime object.
     */
    protected function setTimezone(\DateTime $dateTime, ?string $timezone): \DateTime
    {
        $timezone = $this->resolveTimezone($timezone);

        return $dateTime->setTimezone(new \DateTimeZone($timezone));
    }

    public function dateTime($until = 'now', string $timezone = null): \DateTime
    {
        return $this->setTimezone(
            $this->getTimestampDateTime($this->unixTime($until)),
            $timezone
        );
    }

    public function dateTimeAD($until = 'now', string $timezone = null): \DateTime
    {
        $min = (PHP_INT_SIZE > 4) ? -62135597361 : -PHP_INT_MAX;

        return $this->setTimezone(
            $this->getTimestampDateTime($this->generator->numberBetween($min, $this->getTimestamp($until))),
            $timezone
        );
    }

    public function dateTimeBetween($from = '-30 years', $until = 'now', string $timezone = null): \DateTime
    {
        $start = $this->getTimestamp($from);
        $end = $this->getTimestamp($until);

        if ($start > $end) {
            throw new \InvalidArgumentException('"$from" must be anterior to "$until".');
        }

        $timestamp = $this->generator->numberBetween($start, $end);

        return $this->setTimezone(
            $this->getTimestampDateTime($timestamp),
            $timezone
        );
    }

    public function dateTimeInInterval($from = '-30 years', string $interval = '+5 days', string $timezone = null): \DateTime
    {
        $intervalObject = \DateInterval::createFromDateString($interval);
        $datetime = $from instanceof \DateTime ? $from : new \DateTime($from);

        $other = (clone $datetime)->add($intervalObject);

        $begin = min($datetime, $other);
        $end = $datetime === $begin ? $other : $datetime;

        return $this->dateTimeBetween($begin, $end, $timezone);
    }

    public function dateTimeThisWeek($until = 'now', string $timezone = null): \DateTime
    {
        return $this->dateTimeBetween('-1 week', $timezone);
    }

    public function dateTimeThisMonth($until = 'now', string $timezone = null): \DateTime
    {
        // TODO: Implement dateTimeThisMonth() method.
    }

    public function dateTimeThisYear($until = 'now', string $timezone = null): \DateTime
    {
        // TODO: Implement dateTimeThisYear() method.
    }

    public function dateTimeThisDecade($until = 'now', string $timezone = null): \DateTime
    {
        // TODO: Implement dateTimeThisDecade() method.
    }

    public function dateTimeThisCentury($until = 'now', string $timezone = null): \DateTime
    {
        // TODO: Implement dateTimeThisCentury() method.
    }

    public function date(string $format = 'Y-m-d', $until = 'now'): string
    {
        // TODO: Implement date() method.
    }

    public function time(string $format = 'Y-m-d', $until = 'now'): string
    {
        // TODO: Implement time() method.
    }

    public function unixTime($until = 'now'): int
    {
        // TODO: Implement unixTime() method.
    }

    public function iso8601($until = 'now'): string
    {
        // TODO: Implement iso8601() method.
    }

    public function amPm($until = 'now'): string
    {
        // TODO: Implement amPm() method.
    }

    public function dayOfMonth($until = 'now'): string
    {
        // TODO: Implement dayOfMonth() method.
    }

    public function dayOfWeek($until = 'now'): string
    {
        // TODO: Implement dayOfWeek() method.
    }

    public function month($until = 'now'): string
    {
        // TODO: Implement month() method.
    }

    public function monthName($until = 'now'): string
    {
        // TODO: Implement monthName() method.
    }

    public function year($until = 'now'): string
    {
        // TODO: Implement year() method.
    }

    public function century(): string
    {
        // TODO: Implement century() method.
    }

    public function timezone(): string
    {
        // TODO: Implement timezone() method.
    }
}
