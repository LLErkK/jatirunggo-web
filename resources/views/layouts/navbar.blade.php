<nav>
    <ul>
        @foreach($thumbnails as $thumbnail)
            <li class="{{ $thumbnail->photos->isNotEmpty() ? 'dropdown' : '' }}">
                <a href="#">{{ $thumbnail->title }}</a>

                @if($thumbnail->photos->isNotEmpty())
                    <ul class="dropdown-content">
                        @foreach($thumbnail->photos as $photo)
                            <li>
                                <a href="#{{ Str::slug($photo->title) }}">{{ $photo->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
