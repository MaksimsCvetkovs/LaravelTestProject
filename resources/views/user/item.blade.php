<div class="d-flex m-2 p-2">
    <div class="flex-grow-1 ms-3">
        <h4>{{ $user->name }}</h4>
        @isset($canDeleteInRole)
        <a class="btn btn-danger" href="{{ route('user.manf.role.user.delete', ['manfId' => $manf->id, 'roleId' => $role->id, 'userId' => $user->id]) }}">@lang("manf.role.user.delete")</a>
        @endif
        @isset($canAddUserInRole)
        <a class="btn btn-primary" href="{{ route('user.manf.role.user.add', ['manfId' => $manf->id, 'roleId' => $role->id, 'userId' => $user->id]) }}">@lang("manf.role.user.add")</a>
        @endif
    </div>
</div>