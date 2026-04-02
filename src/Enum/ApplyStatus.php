<?php

namespace App\Enum;

enum ApplyStatus: string
{
    case ENVOYEE = 'envoyee';
    case EN_COURS = 'en_cours';
    case ENTRETIEN = 'entretien';
    case REFUSEE = 'refusee';
    case ACCEPTEE = 'acceptee';
}