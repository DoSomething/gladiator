<?php

use Carbon\Carbon;

/**
 * Build a CSV from the supplied data.
 *
 * @param  array  $data
 * @return \League\Csv $csv
 */
function build_csv($data)
{
    $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
    $csv->insertAll($data);
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
 * Format a Carbon date if available to a simplified format
 * for form input element. Uses old data if available.
 *
 * @param  \Illuminate\Database\Eloquent\Model  $model
 * @param  string  $field
 * @param  string  $defaut
 * @return string
 */
function format_date_form_field($model, $field, $defaut = 'MM/DD/YYYY')
{
    $oldDate = old($field);

    if ($oldDate) {
        return $oldDate;
    }

    $attribute = $model->getAttribute($field);

    if ($attribute && $attribute instanceof Carbon) {
        return $attribute->format('Y-m-d');
    }

    return $default;
}

/**
 * Check if the waiting room signup period ended.
 *
 * @param  date  $signupDate
 * @return bool
 */
function has_signup_period_ended($signupDate)
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
function match_email_domain($email, $domain = 'dosomething.org')
{
    $pieces = explode('@', $email);

    if (is_array($pieces) && count($pieces) > 1) {
        return $pieces[1] === $domain ? true : false;
    }

    return false;
}

/**
 * Given an integer representing a day of the week, return the string that represents
 * that day.
 *
 * @param int $day
 */
function get_day_of_week($day)
{
    return jddayofweek($day, 1);
}
