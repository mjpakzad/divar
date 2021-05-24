<?php
if (!function_exists('image_resize')) {
    /**
     * Retrieves a path of image along with it's final size.
     *
     * @param string $imagePath The full path of an image. e.g: "storage/images/categories/2018/11/image.jpg
     * @param string|array $size string means a name passes to the parameter and array means there is at least one of width or height index
     * @return bool if an error happens then return false
     */
    function image_resize($image, $size) {
        return \App\ImageManager::resize(ltrim($image, '/'), $size);
    }
}
