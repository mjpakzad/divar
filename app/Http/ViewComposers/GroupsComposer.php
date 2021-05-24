<?php
namespace App\Http\ViewComposers;

use App\Models\Group;
use Illuminate\Contracts\View\View;

class GroupsComposer
{
    public function compose(View $view)
    {
        $groups = Group::with('activeChildren.activeChildren')->main()->published()->get();
        $view->with('blog_groups', $groups);
    }
}
