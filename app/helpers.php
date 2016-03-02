<?php

/**
 * Match supplied email against a specific domain or default domain.
 *
 * @param  string  $email
 * @param  string  $domain
 * @return bool
 */
function matchEmailDomain($email, $domain = 'dosomething.org')
{
    $pieces = explode('@', $email);

    if (is_array($pieces) && count($pieces) > 1) {
        return $pieces[1] === $domain ? true : false;
    }

    return false;
}

function hasSignupPeriodEnded($signupDate)
{
    return time() - (60 * 60 * 24) >= strtotime($signupDate);
}
