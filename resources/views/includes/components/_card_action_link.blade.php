<div class="panel panel-default" style="border-color: white; filter: drop-shadow(0px 2px 10px rgba(0, 0, 0, 0.1));">
    <a href="{{ $link }}">
        <div class="panel-body" title="{{ $title }}" style="padding: 6px; padding-left: 1.5rem; padding-right: 1.5rem;">
            <div style="display: flex; justify-content: space-between;">
                <!-- wrap -->
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div class="tri-br-1" style="width: 60px; height: 60px; background: {{ $color }}; display: flex; align-items: center; justify-content: center;">
                        <!-- icon -->
                        <div style="font-size: 2.5rem; color: white;">
                            {!! $icon !!}
                        </div>
                    </div>

                    {{-- text --}}
                    <div>
                        <h3 title="{{ $title }}" class="tri-fw-600 text-black card-action-title" style="font-size: 1.2rem; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ strlen($title) > 20 ? substr($title, 0, 20) . '...' : $title }}
                        </h3>

                        <h4 title="{{ $description }}" class="tri-fw-500 tri-txt-gray-400 card-action-description" style="font-size: 1rem; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            @if (!empty($description))
                                {{ strlen($description) > 20 ? substr($description, 0, 20) . '...' : $description }}
                            @else
                                Ver más
                            @endif
                        </h4>
                    </div>
                </div>

                {{-- button --}}
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 2rem;">
                        <a href="{{ $link }}" class="tri-px-1 tri-py-04 tri-gray-100 tri-br-04 text-black tri-border--none">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>