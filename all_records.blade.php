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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Laravel CRUD Example</h1>
                    <div class="add-button">
                        <a class="btn btn-dark" href="{{ route('add.new.record') }}">Add New Record</a>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($all_records as $key => $record)
                    <div class="col">
                        <div class="card shadow-sm">
                            <img src="/images/{{ $record->image }}"  class="card-img-top" style="height: 100px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $record->name }}</h5>
                                <strong>Name:</strong> {{ $record->fruits }}<br>
                                <p><strong>Email:</strong> {{ $record->email }}</p>
                                <p><strong>Age:</strong> {{ $record->date }}</p>
                                <p><strong>Gender:</strong> {{ $record->gender }}</p>   
                                <p><strong>Occupation:</strong> {{ $record->occupation }}</p>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('edit.record', $record->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="{{ route('delete.record', $record->id) }}" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
