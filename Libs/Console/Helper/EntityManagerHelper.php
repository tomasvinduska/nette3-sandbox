<?php declare(strict_types = 1);

namespace Libs\Console\Helper;

class EntityManagerHelper extends \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper
{

    public function getName(): string
    {
        return 'em';
    }

}
