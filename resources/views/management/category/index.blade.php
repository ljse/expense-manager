@extends('layouts.app')
@section('page-title', 'Expense Category')
@section('expcats', 'active')
@section('title', 'Expense Categories')
@section('dash-content')
	<div class="col-12">
		<a href="#" class="btn btn-info float-right mb-3" data-toggle="modal" data-target="#exampleModalCenter">Add Category</a>
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
					@if ($cats->count() > 0)
						@foreach ($cats as $cat)
							<tr data-toggle="modal" data-target="#exampleModalCenter-{{ $cat->slug }}">
								<td>{{ ucwords($cat->name) }}</td>
								<td>{{ ucfirst($cat->description) }}</td>
								<td>{{ Carbon\carbon::parse($cat->created_at)->format('M d, Y') }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="3" class="text-center">No Registered Category Yet!</td>
						</tr>
					@endif
				</tbody>
			</table>
			{{ $cats->links() }}
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
					<form method="post" action="{{ route('users.cats.store') }}">
						@csrf
						<div class="form-group">
							<label for="name">Category name</label>
							<input type="text" name="name" class="form-control" placeholder="Category Name" value="{{ old('name') }}"  autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<input type="text" name="description" class="form-control" placeholder="Description" value="{{ old('description') }}"  autocomplete="off" required>
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

@foreach ($cats as $cat)
	<!-- Modal Add -->
	<div class="modal fade" id="exampleModalCenter-{{ $cat->slug }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add Role</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="{{ route('users.cats.update', ['category' => $cat->slug]) }}">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Category name</label>
							<input type="text" name="name" class="form-control" placeholder="Category Name" value="{{ $cat->name }}"  autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<input type="text" name="description" class="form-control" placeholder="Description" value="{{ $cat->description }}"  autocomplete="off" required>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
					<form method="post" action="{{ route('users.cats.delete', ['expenseCategories' => $cat->slug]) }}" style="margin-top: -53px;">
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