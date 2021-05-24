<?php
if(!function_exists('callout')) {
    /**
     * Prepares flash data to use in panel.layout.partials.blade template.
     *
     * This function helps you to create appropriate Callout boxes. Every call create one callout.
     * you can hide icon by passing null values to the third argument of this function.
     *
     * @param string $message Sets a message for the callout
     * @param string|null $title Sets a title for the callout. pass null to remove it
     * @param string|null $type Sets a title for the callout. pass null to remove ir or pass on of the following values: info, warning, danger, success
     * @param string $button Sets it true to show a button
     */
    function callout($message, $title = 'توجه', $type = 'info', $button = false) {

        if ($title !== null)
        {
            $title .= ': ';
        }

        switch ($type)
        {
            case 'success':
                $icon = 'check';
                break;
            case 'warning':
                $icon = 'exclamination-triangle';
                break;
            case 'danger':
                $icon = 'close';
                break;
            case null:
                $icon = null;
                break;
            case 'info':
            default:
                $icon = 'info';
        }

        if (!in_array($type, ['info', 'danger', 'warning', 'success'])) {
            $type = 'info';
        }

        if (session()->has('callout'))
        {
            $callouts = session()->get('callout');
        }

        if ($button !== true)
        {
            $button = false;
        }

        $callouts[] = [
            'message'   => $message,
            'title'     => $title,
            'type'      => $type,
            'icon'      => $icon,
            'button'    => $button,
        ];

        session()->flash('callout', $callouts);
    }
}

if (!function_exists('dash2comma')) {
    /**
     * Converts hyphen (-) to comma (,) with removing whitespaces.
     *
     * @param $string string The string you want to convert
     * @return bool|string FALSE if not string and converted string if string
     */
    function dash2comma($string) {
        if (!is_string($string) OR is_null($string)) {
            return NULL;
        }
        $array = explode('-', $string);
        $array = array_map('trim', $array);
        return implode(',', $array);
    }
}

if (!function_exists('comma2dash')) {
    /**
     * Converts comma (,) to hyphen (-) with removing whitespaces.
     *
     * @param $string string The string you want to convert
     * @return bool|string FALSE if not string and converted string if string
     */
    function comma2dash($string) {
        if (!is_string($string)OR is_null($string)) {
            return NULL;
        }
        $array = explode(',', $string);
        $array = array_map('trim', $array);
        return implode('-', $array);
    }
}

if (!function_exists('count_unicode_words')) {
    /**
     * The function to count words in Unicode  strings.
     *
     * First remove all the punctuation marks & digits,
     * Then replace all the whitespaces (tabs, new lines, multiple spaces) by single space,
     * The words are now separated by single spaces and can be splitted to an array,
     * I have included \n\r\t here as well, but only space will also suffice,
     * Now we can get the word count by counting array elements.
     *
     * @see https://gist.github.com/abhineetmittal/d250083def7c356bbf161ff74444ebcc
     * @param $unicode_string
     * @return int
     */
    function count_unicode_words($unicode_string){
        $unicode_string = preg_replace('/[[:punct:][:digit:]]/', '', $unicode_string);
        $unicode_string = preg_replace('/[[:space:]]/', ' ', $unicode_string);
        $words_array = preg_split( "/[\n\r\t ]+/", $unicode_string, 0, PREG_SPLIT_NO_EMPTY );

        return count($words_array);
    }
}

if(!function_exists('reading_time')) {
    /**
     * Estimates the approximate time of reading a content.
     *
     * @param string $content text to calculate time of reading
     * @param bool $second calculate second or not
     * @return array|float returns minutes if $second set false, returns an array include minutes and seconds if $second set to true
     */
    function reading_time($content, $second = false) {
        $words      = count_unicode_words(strip_tags($content));
        $minutes    = floor($words / 200);
        if ($second) {
            $seconds = floor($words % 200 / (200 / 60));
            return compact('minutes', 'seconds');
        }
        return $minutes;
    }
}

if(!function_exists('make_slug')) {
    /**
     * Pass alphanumeric characters and remove other characters.
     *
     * @param $string
     * @param string $separator
     * @return bool|mixed|null|string|string[]
     */
    function make_slug($string, $separator = '-') {
        if (is_null($string)) {
            return "";
        }

        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // Convert slash to space
        $string = str_replace('/', ' ', $string);

        // Convert back slash to space
        $string = str_replace('\\', ' ', $string);

        // Remove slashes from the string. At this time it doesn't apply on string.
        $string = stripslashes($string);

        // Lower case everything
        // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: http://goo.gl/QL2tzK
        $string = mb_strtolower($string, "UTF-8");;

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and arabic charactrs as well
        $string = preg_replace("/[^a-zA-Z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);

        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string . '-' . uniqid();
    }
}

if(!function_exists('restructure_category')) {
    /**
     * Make an array for arranging categories,
     * @param  \App\Models\City  $city
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    function restructure_category($city, $category) {
        if(!is_null($category->parent_id)) {
            $allCategories['parent'] = $category->parent_id;
        }
        $allCategories['type'] = $category->activeChildren->count() ? 'parent' : 'child';
        $allCategories['name'] = $category->name;
        if($category->activeChildren->count() == 0) {
            $allCategories['href'] = route('frontend.commercials.create', [$city->slug, $category->slug]);
        }
        return $allCategories;
    }
}

if (! function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}