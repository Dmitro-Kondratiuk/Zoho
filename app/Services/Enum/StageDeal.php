<?php

namespace App\Services\Enum;

enum StageDeal : string
{
    case QUALIFICATION = 'Qualification';
    case NEEDS_ANALYSIS = 'Needs Analysis';
    case VALUE_PROPOSITION = 'Value Proposition';
    case IDENTIFY_DECISION_MAKERS = 'Identify Decision Makers';
    case PROPOSAL_PRICE_QUOTE = 'Proposal/Price Quote';
    case CLOSED_LOST_TO_COMPETITION = 'Closed Lost to Competition';
    case CLOSED_LOST = 'Closed Lost';
    case CLOSED_WON = 'Closed Won';
    case NEGOTIATION_REVIEW = 'Negotiation/Review';
}
