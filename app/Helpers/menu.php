<?php
if (!(function_exists('user_has'))) {
    /**
     * Determine if the current user has any of the specific permissions.
     *
     * @param $permissions array permission needed to be check
     * @param $userPermissions array permissions of a specific user
     * @return bool
     */
    function user_has($permissions, $userPermissions)
    {
        return !empty(array_intersect($permissions, $userPermissions));
    }
}

if (!(function_exists('menu_build'))) {
    /**
     * @return array menu with items
     */
    function menu_build() {
        return \App\MenuFactory::build();
    }
}

if (!(function_exists('user_permissions'))) {
    /**
     * @return array permissions of user
     */
    function user_permissions() {
        return \App\MenuFactory::userPermissions();
    }
}

if(!(function_exists('user_roles'))) {
    function user_roles() {
        $user_roles_array = auth()->user()->roles->pluck('display_name');
        $user_roles = '';
        foreach ($user_roles_array as $index => $role) {
            $user_roles .= $role;
            ($index < count($user_roles_array) - 1) ? $user_roles .= ', ' : '';
        }
        return $user_roles;
    }
}