<?php

namespace App\Enums;

enum Role: string
{
    // a person responsible for deactivating parties, accounts, and overseeing roles and permissions
    case ADMIN     = 'admin';

    // a person maintaining the content and user interactions who approves/disapproves any user-submitted content
    case MODERATOR = 'moderator';

    // a person representing a particular party, their Goals, their participation in the platform
    case MANAGER   = 'manager';

    // a political member, a person who is a part of the Bulgarian political structure regardless of having an Account
    case MEMBER    = 'member';

    // a commoner, a person expressing their right to be heard
    case VOTER     = 'voter';

    // a viewer, external browsing is restricted to browsing political parties
    case GUEST     = 'guest';
}
