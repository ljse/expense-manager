@extends('layouts.app')
@section('page-title', 'Expenses')
@section('exp', 'active')
@section('title', 'Expenses')
@section('dash-content')
	@if (Auth::user()->role != null)
		<div class="col-12">
			<a href="#" class="btn btn-info float-right mb-3" data-toggle="modal" data-target="#exampleModalCenter">Add Expense</a>
		</div>
	@else
		<div class="alert alert-warning">Please Contact Administrator to be able to set a role for you!</div>
	@endif

	<div class="container-fluid">
		<div class="table-hover">
			<table class="table">
				<thead class="thead-light">
					<th>Expense Category</th>
					<th>Amount</th>
					<th>Entry Date</th>
					<th>Created at</th>
				</thead>
				<tbody>
					@if ($expenses->count() > 0)
						@foreach ($expenses as $expense)
							<tr data-toggle="modal" data-target="#update-{{ $expense->id }}">
								<td>{{ $expense->expcats->name }}</td>
								<td>${{ $expense->amount }}</td>
								<td>{{ Carbon\carbon::parse($expense->entry_date)->format('M d, Y') }}</td>
								<td>{{ Carbon\carbon::parse($expense->created_at)->format('M d, Y') }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4" class="text-center">No expenses yet!</td>
						</tr>
					@endif
				</tbody>
			</table>
			{{ $expenses->links() }}
		</div>
	</div>

	<!-- Modal Add -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add Expense</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="{{ route('users.exp.store') }}">
						@csrf
						<div class="form-group">
							<input type="hidden" name="user_id" value="{{ Auth::id() }}">
							<label for="name">Expense Category</label>
							<select name="category_id" id="category_id" class="form-control @error('category_id') border border-danger @enderror" required>
								<option value="" disabled selected="true">Select Category</option>
								@foreach ($cats as $cat)
									<option value="{{ $cat->id }}">{{ ucwords($cat->name) }}</option>
								@endforeach
							</select>
							@error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
						</div>
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="number" name="amount" class="form-control @error('amount') border border-danger @enderror" placeholder="amount" value="{{ old('amount') }}"  autocomplete="off" required>
							@error('amount') <small class="text-danger">{{ $message }}</small> @enderror
						</div>
						<div class="form-group">
							<label for="entry_date">Entry Date</label>
							<input type="date" name="entry_date" class="form-control @error('entry_date') border border-danger @enderror" value="{{ old('entry_date') }}"  autocomplete="off" required>
							@error('entry_date') <small class="text-danger">{{ $message }}</small> @enderror
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

@foreach ($expenses as $expense)
	<!-- Modal update -->
	<div class="modal fade" id="update-{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add Expense</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="{{ route('users.exp.update', ['expense' => $expense->id]) }}">
						@csrf
						@method('PUT')
						<div class="form-group">
							<input type="hidden" name="user_id" value="{{ Auth::id() }}">
							<label for="name">Expense Category</label>
							<select name="category_id" id="category_id" class="form-control">
								@if ($expense->expcats != null)
									<option value="{{ $expense->category_id }}" selected="true">{{ $expense->expcats->name }}</option>
								@else
									<option value="" disabled selected="true">Select Category</option>
								@endif
								@foreach ($cats as $cat)
									<option value="{{ $cat->id }}">{{ ucwords($cat->name) }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="number" name="amount" class="form-control" placeholder="amount" value="{{ $expense->amount }}"  autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for="entry_date">Entry Date</label>
							<input type="date" name="entry_date" class="form-control" value="{{ $expense->entry_date }}"  autocomplete="off" required>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
					<form method="post" action="{{ route('users.exp.destroy', ['expense' => $expense->id]) }}" style="margin-top: -53px;">
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
@endsection