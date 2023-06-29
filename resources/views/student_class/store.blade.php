@extends('master')

@section('title', '')

@section('content')

	<?php 
		use Yajra\Datatables\Datatables; 
		use App\Model\User\User;

		// get user auth
		$user = Auth::user();
	?>

	<form method="post" action="{{ route('store-student-class') }}">

		@csrf

		<div class="form-group">
			<label>Kelas</label>
			<input type="text" class="form-control" value="" name="class_name">
			@if ($errors->has('class_name'))
			    <div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('class_name') }}</p></div>
			@endif
		</div>
		@if($user->account_type == User::ACCOUNT_TYPE_CREATOR || $user->account_type == User::ACCOUNT_TYPE_ADMIN)
			<div class="form-group">
				<label>Guru</label>
				<select class="js-example-basic-single form-control" id="guru" name="teacher_id" style="width: 100%"></select>
				@if ($errors->has('teacher_id'))
					<div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('teacher_id') }}</p></div>
				@endif
			</div>
		@endif
		<div class="form-group">
			<label>Jurusan</label>
            <select class="form-control" id="jurusan" name="jurusan" style="width: 100%">
            	<option value="TKJ">TKJ</option>
	   	        <option value="AK">AK</option>
                <option value="AP">AP</option>
                <option value="PM">PM</option>
            </select>
            @if ($errors->has('jurusan'))
			    <div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('teacher_id') }}</p></div>
			@endif
        </div>
		<div class="form-group">
            <label>Kelas</label>
            <select class="form-control" name="kelas">
				<option value="10">10</option>
	   	        <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>
		<div class="form-group">
			<label>Catatan</label>
			<input type="text" class="form-control" value="" name="note" maxlength="30">
			@if ($errors->has('note'))
			    <div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('note') }}</p></div>
			@endif
		</div>
		<div class="form-group">
			<button type="submit" class="ui huge inverted primary button"> TAMBAH </button>
		</div>
	</form>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
	    $('#guru').select2({
	    	allowClear: true,
			placeholder: 'Masukkan Nama Guru',
			ajax: {
				url: base_url + '/student-class/get-user-teacher',
				dataType: 'json',
				data: function(params) {
				    return {
				      search: params.term
				    }
				},
				processResults: function (data, page) {
				    return {
				        results: data
				    };
				}
			}
	    });
	});
</script>
@endpush