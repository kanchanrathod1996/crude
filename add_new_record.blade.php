<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Laravel CRUD Example</title>
</head>
<body>
<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="title" style="float:left;">
                        <h1>{{ isset($record) ? 'Edit' : 'Add' }} Record</h1>
                    </div>
                    <div class="add-button" style="float:right;">
                        <a class="btn btn-dark" href="{{ route('all.records') }}">All Records</a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    @if(isset($record))
                    <form action="{{ route('update.record', $record->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT') <!-- Use PUT or PATCH for updating -->
                @else
                    <form action="{{ route('store.new.record') }}" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                
                        <!-- Form inputs go here -->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="mb-1">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ isset($record) ? $record->name : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ isset($record) ? $record->email : '' }}">
                                </div>
                            </div>
                            <div class="col-md-5 offset-md-1">
                                <div class="form-check-inline mb-3">
                                    <label class="form-check-label mb-1">Gender</label><br>
                                    <input class="form-check-input" type="radio" name="gender" value="Male" {{ isset($record) && $record->gender == 'Male' ? 'checked' : '' }}> Male
                                    <input class="form-check-input" type="radio" name="gender" value="Female" {{ isset($record) && $record->gender == 'Female' ? 'checked' : '' }}> Female
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1">occupation</label>
                                    <select name="occupation" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Engineer" {{ isset($record) && $record->occupation == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                        <option value="Doctor" {{ isset($record) && $record->occupation == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1">Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ isset($record) ? $record->date : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1">Which Fruit Do you Like?</label><br/>
                                    <input type="checkbox" name="fruits[]" value="Mango" {{ isset($record) && in_array('Mango', explode(',', $record->fruits)) ? 'checked' : '' }}> Mango<br>
                                    <input type="checkbox" name="fruits[]" value="Orange" {{ isset($record) && in_array('Orange', explode(',', $record->fruits)) ? 'checked' : '' }}> Orange<br>
                                    <input type="checkbox" name="fruits[]" value="Apple" {{ isset($record) && in_array('Apple', explode(',', $record->fruits)) ? 'checked' : '' }}> Apple<br>
                                    <input type="checkbox" name="fruits[]" value="Banana" {{ isset($record) && in_array('Banana', explode(',', $record->fruits)) ? 'checked' : '' }}> Banana<br>
                                    <input type="checkbox" name="fruits[]" value="Strawberry" {{ isset($record) && in_array('Strawberry', explode(',', $record->fruits)) ? 'checked' : '' }}> Strawberry<br>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
