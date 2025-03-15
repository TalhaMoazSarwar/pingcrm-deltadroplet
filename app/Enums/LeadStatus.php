<?php

namespace App\Enums;

enum LeadStatus: string
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case QUALIFIED = 'qualified';
    case PROPOSAL_SENT = 'proposal_sent';
    case WON = 'won';
    case LOST = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::CONTACTED => 'Contacted',
            self::QUALIFIED => 'Qualified',
            self::PROPOSAL_SENT => 'Proposal Sent',
            self::WON => 'Won',
            self::LOST => 'Lost',
        };
    }
}
