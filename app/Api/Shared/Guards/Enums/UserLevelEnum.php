<?php

namespace App\Api\Shared\Guards\Enums;

enum UserLevelEnum: int
{
	case OPERATOR = 0;
	case ADMIN = 1;
	case ALL = 2;
}
