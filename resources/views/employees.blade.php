@include('employees-layout')
@if (isset($employees))
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->salary }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
