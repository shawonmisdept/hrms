<!-- resources/views/bonus_assign/partials/assigned_policies.blade.php -->
@foreach($assignedPolicies as $assigned)
    <div>
        <strong>{{ $assigned->employee->name }}</strong> - {{ $assigned->policyMaster->name }}
    </div>
@endforeach
