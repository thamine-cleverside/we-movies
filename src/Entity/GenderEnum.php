<?php declare(strict_types=1);

namespace App\Entity;

enum GenderEnum: string
{
    case ADVENTURE = 'aventure';
    case ACTION = 'action';
    case COMEDIA = 'comedie';
    case FANTASY = 'fantastique';
}
