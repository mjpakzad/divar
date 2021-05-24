@if(session()->has('callout'))
    @foreach(session()->get('callout') as $callout)
    <div class="pad margin no-print">
        <div class="callout callout-{{ $callout['type'] }}" style="margin-bottom: 0!important;">
            @unless(is_null($callout['title']) && is_null($callout['icon']))
            <h4>
                @unless($callout['icon'] === null)
                <i class="fa fa-{{ $callout['icon'] }}"></i>
                @endunless
                @unless($callout['title'] === null)
                {{ $callout['title'] }}
                @endunless
            </h4>
            @endunless
            <div class="row">
                <div class="col-md-10">
                {{ $callout['message'] }}
                </div>
                @if($callout['button'])
                <div class="col-md-2">
                    <button class="btn btn-{{ $callout['type'] }} pull-right close-callout" data-dismiss="alert" aria-hidden="true">فهمیدم</button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@endif
