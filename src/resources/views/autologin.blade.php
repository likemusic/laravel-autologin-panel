@php

use Likemusic\Laravel\AutologinPanel\Helpers\UsersProvider;
use Likemusic\Laravel\AutologinPanel\Helpers\AutologinHelper;

/** @var UsersProvider $usersProvider */
$usersProvider = app(UsersProvider::class);
$users = $usersProvider->getOrderedAvailableUsers();

/** @var AutoLoginHelper $autoLoginHelper */
$autoLoginHelper = app(AutoLoginHelper::class);

@endphp
<div class="autologin closed">
  <div class="collapsible">
    <h1 class="header">Войти как:</h1>
    <ul class="users">
      @forelse ($users as $user)
        <li>
          <a href="{{ $autoLoginHelper->getRouteByUser($user) }}"
          >{{ $autoLoginHelper->getUserCaption($user) }}</a>
        </li>
      @empty
        <p>No Users</p>
        <p class="note">Set autologin config</p>
      @endforelse

    </ul>
    <a href="#" class="close">&#10006;</a>
  </div>
  <a class="icon" href="#"></a>
</div>
