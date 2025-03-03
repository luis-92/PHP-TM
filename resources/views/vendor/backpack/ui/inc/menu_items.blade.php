{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Clubs" icon="la la-question" :link="backpack_url('club')" />
<x-backpack::menu-item title="Members" icon="la la-question" :link="backpack_url('member')" />
<x-backpack::menu-item title="Sessions" icon="la la-question" :link="backpack_url('session')" />
<x-backpack::menu-item title="Speeches" icon="la la-question" :link="backpack_url('speech')" />
<x-backpack::menu-item title="Session roles" icon="la la-question" :link="backpack_url('session-role')" />
<x-backpack::menu-item title="Evaluations" icon="la la-question" :link="backpack_url('evaluation')" />
<x-backpack::menu-item title="Votes" icon="la la-question" :link="backpack_url('vote')" />
<x-backpack::menu-item title="Toastmasters sessions" icon="la la-question" :link="backpack_url('toastmasters-session')" />
<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />