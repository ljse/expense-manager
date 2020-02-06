<div class="col-12">
	<div class="list-group">
		<a href="#" class="list-group-item">{{ ucwords(Auth::user()->name) }} ( {{ (Auth::user()->role != null) ? Auth::user()->role->role : 'No Role Yet' }} ) </a>
		<a href="{{ route('home') }}" class="list-group-item list-group-item-action @yield('dash')">Dashboard</a>
		@if (Gate::check('isAdmin'))
			<a href="#" class="list-group-item">User Management</a>
			<a href="{{ route('admin.user.index') }}" class="list-group-item list-group-item-action @yield('user')">Users</a>
			<a href="{{ route('admin.role.index') }}" class="list-group-item list-group-item-action @yield('role')">Roles</a>
		@endif
		<a href="#" class="list-group-item">Expense Management</a>
		@if (Gate::check('isAdmin'))
			<a href="{{ route('users.cats.index') }}" class="list-group-item list-group-item-action @yield('expcats')">Expense Categories</a>
		@endif
		<a href="{{ route('users.exp.index') }}" class="list-group-item list-group-item-action @yield('exp')">Expenses</a>
	</div>
</div>