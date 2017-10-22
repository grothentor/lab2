@php($type = isset ($type) && 'success' === $type ? 'success' : 'danger')
<div class="alert alert-{{ $type }} flash-messages">
    <span class="glyphicon text-{{ $type }} glyphicon-remove" style=""></span>
    {{ $message }}
</div>