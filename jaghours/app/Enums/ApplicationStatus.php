<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 * 
 */
final class ApplicationStatus extends Enum
{
    const Pending = 'Pendiente';
    const Accepted = 'Aceptado';
    const Rejected = 'No Aceptado';

}
