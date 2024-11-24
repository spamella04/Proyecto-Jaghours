<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class JobOportunityStatus extends Enum
{
    const Draft = 'Borrador';
    const Pending = 'Solicitud';
    const Published = 'Publicado';
    const Closed = 'Cerrado';
    const Rejected = 'Rechazada';
    const DirectEntry = 'Asignacion Directa';

    public static function fromValue($value): static
    {
        return parent::fromValue($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
