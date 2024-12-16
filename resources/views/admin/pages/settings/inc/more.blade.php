<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
    @foreach ($data as $item)
        <li class="nav-item">
            <a class="nav-link {{ ($loop->index == 0)? 'Not Suspended': '' }}" data-bs-toggle="tab" href="#{{ str_replace(' ','_',$item['title']) }}" role="tab">
                <span class="d-none d-sm-block">{{ __($item['title']) }}</span> 
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content p-3 text-muted">
    @foreach ($data as $item)
        <div class="tab-pane {{ ($loop->index == 0)? 'Not Suspended': '' }}" id="{{ str_replace(' ','_',$item['title']) }}" role="tabpanel">
            @isset($item['form']['lang'])
                @includeIf('admin.pages.settings.inc.lang',['form'=>$item['form'],'group_by'=>$group_by,'sub'=>true])
            @endisset
            @includeIf('admin.pages.settings.inc.inputs',['form'=>$item['form']])
        </div>
    @endforeach
</div>