@extends('layouts.app')
@section('page-title', 'Roles')
@section('role', 'active')
@section('title', 'Roles')
@section('dash-content')
	<div class="col-12">
		<a href="#" class="btn btn-info float-right mb-3" data-toggle="modal" data-target="#exampleModalCenter">Add Role</a>
	</div>
	<div class="container-fluid">
		<div class="table-hover">
			<table class="table">
				<thead class="thead-light">
					<th>Name</th>
					<th>Description</th>
					<th>Date</th>
				</thead>
				<tbody>
					@if ($roles->count() > 0)
						@foreach ($roles as $role)
							<tr {{ ($role->role != 'Administrator') ? 'data-toggle=modal data-target=#update-'.$role->id.'' : '' }} >
								<td>{{ ucwords($role->role) }}</td>
								<td>{{ ucfirst($role->description) }}</td>
								<td>{{ Carbon\carbon::parse($role->created_at)->format('M d, Y') }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="3" class="text-center">No Registered Role Yet!</td>
						</tr>
					@endif
				</tbody>
			</table>
			{{ $roles->links() }}
		</div>
	</div>

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add Role</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('admin.role.store') }}">
					@csrf
					<div class="form-group">
						<label for="role">Role</label>
						<input type="text" name="role" class="form-control" placeholder="role Name" value="{{ old('role') }}"  autocomplete="off" required>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<input type="text" name="description" class="form-control" placeholder="description Name" value="{{ old('description') }}"  autocomplete="off" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@foreach ($roles as $update)
	<!-- Modal Update -->
	<div class="modal fade" id="update-{{ $update->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Update Role</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="{{ route('admin.role.update', ['role' => $update->id]) }}">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="role">Role</label>
							<input type="text" name="role" class="form-control @error('role') border border-danger @enderror" placeholder="role Name" value="{{ $update->role }}"  autocomplete="off" required>
							@error('role') <small class="text-danger">{{ $message }}</small> @enderror
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<input type="text" name="description" class="form-control @error('description') border border-danger @enderror" placeholder="description Name" value="{{ $update->description }}"  autocomplete="off" required>
							@error('description') <small class="text-danger">{{ $message }}</small> @enderror
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
					<form method="post" action="{{ route('admin.role.delete', ['role' => $update->id]) }}" style="margin-top: -53px;">
						@csrf
						@method('DELETE')
						<button class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endforeach

@include('layouts.includes.errors')

@if (session('delete_error'))
	<div class="alert alert-danger">{{ session('delete_error') }}</div>
@endif

@endsection