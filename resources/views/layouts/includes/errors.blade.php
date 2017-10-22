<div class="messages">
    @if(Session::has('flash_message'))
        @include('layouts.includes.error', ['type' => 'success', 'message' => Session::get('flash_message') ])
    @endif
    @if (!isset($displayErrors) || $displayErrors)
        @if(Session::has('flash_error'))
            @include('layouts.includes.error', ['message' => Session::get('flash_error')])
        @endif
        @if (isset($errors) && count($errors) > 0)
            @foreach ($errors->all() as $error)
                    @include('layouts.includes.error', ['message' => $error])
            @endforeach
        @endif
    @endif
    @isset($laravelDbNotifications)
        @foreach ($laravelDbNotifications as $type => $notifications)
                @foreach ($notifications as $notification)
                    @include('layouts.includes.error', ['type' => $type, 'message' => $notification])
                @endforeach
        @endforeach
    @endisset
</div>