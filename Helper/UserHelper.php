<?php
class UserHelper
{
    /**
     * Resolve avatar URL for display.
     * - If $avatar is empty, return placeholder.
     * - If $avatar looks like an absolute URL, return as-is.
     * - Otherwise treat as filename under assets/img/avatars/ and return that path if file exists, else placeholder.
     */
    public static function avatar($avatar, $placeholder = 'https://via.placeholder.com/64')
    {
        $avatar = trim((string)$avatar);
        if (empty($avatar)) return $placeholder;

        // absolute URL
        if (preg_match('#^https?://#i', $avatar)) return $avatar;

        $localPath = 'assets/img/avatars/' . $avatar;
        // If running from web context, just return the local path; but check file existence for safety
        $fsPath = __DIR__ . '/../' . $localPath;
        if (file_exists($fsPath)) return $localPath;

        return $placeholder;
    }
}
