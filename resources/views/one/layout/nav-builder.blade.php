    <div class="c-sidebar-brand"><img class="c-sidebar-brand-full" src="{{ env('APP_URL', '') }}/assets/brand/coreui-base-white.svg" width="118" height="46" alt="CoreUI Logo">
        <img class="c-sidebar-brand-minimized" src="../../assets/brand/coreui-signet-white.svg" width="118" height="46" alt="CoreUI Logo">
        </div>
      <!-- <nav class="c-sidebar-nav"> -->
        <ul class="c-sidebar-nav">
        @if(isset($appMenus['hits api']))
            @foreach($appMenus['hits api'] as $menuel)
            @if($menuel->type == 'link')
                @if(count($menuel->children) > 0)
                     <li class="{{$menuel->icon}} c-sidebar-nav-icon">
                            {{ $menuel->title }}
                    </li>
                    @foreach($menuel->children as $sublink)
                        @if($menuel->id == $sublink->parent_id)
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link" href="">
                            <i class="c-sidebar-nav-icon"></i>
                                {{ $sublink->title }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                @else
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ env('APP_URL', '').$menuel->url }}">
                            <i class="{{$menuel->icon}} c-sidebar-nav-icon"></i>
                            {{ $menuel->title }}
                        </a>
                    </li>
                @endif
            @elseif($menuel->type == 'group')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="{{$menuel->icon}} c-sidebar-nav-icon"></i>
                    {{ $menuel->title }}
                </a>
                @foreach($menuel->children as $menuels)
                    @if($menuel->id == $menuels->parent_id)
                        <ul class="c-sidebar-nav-dropdown-items">
                            <li class="c-sidebar-nav-item">
                                <a class="c-sidebar-nav-link" href="{{ env('APP_URL', '').$menuels->url}}">
                                <span class="c-sidebar-nav-icon"></span>{{ $menuels->title }}</a></li>
                                
                            </li>
                        </ul>
                    @endif
                @endforeach
            </li>
            @elseif($menuel->type == 'title')
                <li class="c-sidebar-nav-title">
                    {{ $menuel->title }}
                </li>
            @endif
            @endforeach
        @endif
        </ul>
      <!-- </nav> -->
      <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>