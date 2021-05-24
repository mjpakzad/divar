<form method="post" action="{{ route('admin.commercials.tags', $commercial->slug) }}" style="display:inline-block;">
    @csrf
    <button type="submit" class="btn btn-dark btn-xs">
        <span class="fa fa-tags"></span> همگام سازی
    </button>
</form>