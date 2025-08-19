{-- Backpack sidebar menu items --}
{-- Auto-generated from routes/backpack/custom.php --}
<x-backpack::menu-item title="Dashboard" icon="la la-home" route="backpack.dashboard" />

<x-backpack::menu-dropdown title="Gestión" icon="la la-database">
    <x-backpack::menu-dropdown-item title="Attendance" :link="backpack_url('attendance')" />
    <x-backpack::menu-dropdown-item title="Club" :link="backpack_url('club')" />
    <x-backpack::menu-dropdown-item title="Clubsession" :link="backpack_url('clubsession')" />
    <x-backpack::menu-dropdown-item title="Member" :link="backpack_url('member')" />
    <x-backpack::menu-dropdown-item title="Sessionfunctionaryroleassignment" :link="backpack_url('sessionfunctionaryroleassignment')" />
    <x-backpack::menu-dropdown-item title="Speech" :link="backpack_url('speech')" />
    <x-backpack::menu-dropdown-item title="Tabletopic" :link="backpack_url('tabletopic')" />
    <x-backpack::menu-dropdown-item title="Visitor" :link="backpack_url('visitor')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-item title="Reportes" icon="la la-chart-bar" :link="route('admin.reports.overview')" />
