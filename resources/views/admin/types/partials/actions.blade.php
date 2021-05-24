<form method="post" action="{{ route('admin.commercials.destroy', $commercial->slug) }}" style="display: inline-block;">
    @csrf
    @method('DELETE')
    {{--<a href="{{ route('admin.sms.show', $commercial->slug) }}" class="btn btn-default btn-xs">
        <span class="fa fa-commenting"></span> sms
    </a>--}}
    <a href="{{ route('admin.commercials.edit', $commercial->slug) }}" class="btn btn-primary btn-xs">
        <span class="fa fa-pencil"></span> ویرایش
    </a>
    <button type="submit" name="delete" class="btn btn-danger btn-xs" onclick="return confirm('آیا از حذف این آگهی اطمینان دارید؟');">
        <span class="fa fa-trash"></span> حذف
    </button>
</form>
