<?php

/**
 * Build a CSV from the supplied data.
 *
 * @param  array  $data
 * @return \League\Csv $csv
 */
function buildCSV($data)
{
    $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

    foreach ($data as $row) {
        $csv->insertOne($row);
    }

    return $csv;
}

/**
 * Handle message output for forms and default messages.
 *
 * @param  array|\Gladiator\Models\Message  $message
 * @param  string  $field
 * @return string
 */
function correspondence($message = null, $field = null)
{
    $correspondence = app(Gladiator\Http\Utilities\Correspondence::class);

    if (func_num_args() === 0) {
        return $correspondence;
    }

    return $correspondence->get($message, $field);
}

/**
 * Check if the waiting room signup period ended.
 *
 * @param  date  $signupDate
 * @return bool
 */
function hasSignupPeriodEnded($signupDate)
{
    return time() - (60 * 60 * 24) >= strtotime($signupDate);
}

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
