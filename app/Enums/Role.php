<?php

namespace App\Enums;

enum Role: string
{
    case ASSIGNEE = 'assignee';
    case ASSIGNOR = 'assignor';
}
