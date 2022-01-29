<x-layout>
    <div class="row text-center mb-5">
        <h1>Company Price History</h1>
    </div>
    <form action="{{ route('company.store') }}" method="POST">
        {{ csrf_field() }}
        <div class="mb-3">
            <label for="symbol" class="form-label">Company Name</label>
            <select name="symbol" id="symbol" class="form-select">
                @foreach($data as $symbol => $company)
                    <option value="{{ $symbol }}">{{ $symbol }} - {{ $company }}</option>
                @endforeach
            </select>
            @error('symbol')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="from_date" class="form-label">From Date</label>
            <input type="text" name="from_date" value="{{ old('from_date') }}" class="form-control" id="from_date"
                   required>
            @error('from_date')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="to_date" class="form-label">To Date</label>
            <input type="text" name="to_date" value="{{ old('to_date') }}" class="form-control" id="to_date"
                   required>
            @error('to_date')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" value="{{ old('email') }}" name="email" class="form-control"
                   required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @if(session('status-error'))
        <div class="alert alert-danger mt-5" role="alert">
            {{ session('status-error') }}
        </div>
    @endif
    <x-slot name="javascript">
        <script>
            $(function () {
                $("#from_date").datepicker({
                    dateFormat: "yy-mm-dd",
                    maxDate: new Date(),
                    onSelect: function (date) {
                        var selectedDate = new Date(date);
                        $("#to_date").datepicker("option", "minDate", selectedDate)
                    }
                });
                $("#to_date").datepicker({
                    dateFormat: "yy-mm-dd",
                    maxDate: new Date(),
                });
            });
        </script>
    </x-slot>
</x-layout>
