<form style="display: inline-block;" action="{{ route('admin.users.destroy', $user->id) }}" method="post" class="form-horizontal">
    @method('DELETE')
    @csrf
    <a class="btn btn-default btn-xs" href="{{ route('admin.users.commercials', $user->id) }}">
        <span class="fa fa-bullhorn"></span>
        آگهی‌ها
    </a>
    <a class="btn btn-primary btn-xs" href="{{ route('admin.users.edit', ['id' => $user->id]) }}">
        <span class="fa fa-pencil"></span>
        ویرایش پروفایل
    </a>
    <button type="submit" class="btn btn-danger btn-xs" name="delete" value="1" title="حذف کاربر">
        <span class="fa fa-user-times"></span> حذف کاربر
    </button>
</form>