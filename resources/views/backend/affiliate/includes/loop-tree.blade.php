<li>{{ $user->email }}
    @if($user->referrers->count() > 0)
        <ul>
            @foreach($user->referrers as $user)
                @include('backend.affiliate.includes.loop-tree', ['user' => $user])
            @endforeach
        </ul>
    @endif
</li>