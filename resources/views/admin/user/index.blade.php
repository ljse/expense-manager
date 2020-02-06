@extends('layouts.app')
@section('page-title', 'Users')
@section('user', 'active')
@section('title', 'Users')
@section('dash-content')

	<div class="container-fluid">
		<div class="table-hover">
			<table class="table">
				<thead class="thead-light">
					<th>Name</th>
					<th>Email</th>
					<th>role</th>
					<th>Date</th>
				</thead>
				<tbody>
					@if ($users->count() > 0)
						@foreach ($users as $user)
							<tr {{ (@$user->role->role != 'Administrator') ? 'data-toggle=modal data-target=#addRole-'.$user->id.'' : '' }}>
								<td>{{ ucwords($user->name) }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ ($user->role == null) ? 'No Role Yet!': $user->role->role }}</td>
								<td>{{ Carbon\carbon::parse($user->created_at)->format('M d, Y') }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4" class="text-center">No Registered User Yet!</td>
						</tr>
					@endif
				</tbody>
			</table>
			{{ $users->links() }}
		</div>
	</div>

@foreach ($users as $user)
	<!-- Modal Add -->
	<div class="modal fade" id="addRole-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add Role To User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="{{ route('admin.user.update', ['user' => $user->id]) }}">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" placeholder="Name" value="{{ ucwords($user->name) }}" autocomplete="off" required disabled>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" placeholder="Email" value="{{ $user->email }}" autocomplete="off" required disabled>
						</div>
						<div class="form-group">
							<label for="role">
								<select name="role_id" id="role_id" class="form-control" {{ (@$user->role->role == 'Administrator' || @$user->role->role == 'administrator') ? 'disabled' : '' }}>
									@if ($user->role != null)
										<option value="{{ $user->role->id }}" disabled selected="true">{{ ucwords($user->role->role) }}</option>
									@else
										<option value="" disabled selected="true">Select Role</option>
									@endif
									@foreach ($roles as $role)
										<option value="{{ $role->id }}">{{ ucwords($role->role) }}</option>
									@endforeach
								</select>
							</label>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
					@if (@$user->role->role != 'Administrator')
						<form method="post" action="{{ route('admin.role.removeRole', ['user' => $user->id]) }}" style="margin-top: -53px;">
							@csrf
							@method('PUT')
							<button class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
						</form>
					@endif
				</div>
			</div>
		</div>
	</div>
@endforeach

@include('layouts.includes.errors')

@endsection