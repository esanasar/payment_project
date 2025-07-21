@extends('layouts.app')

@section('content')
    <h2>درخواست‌های تایید شده (آماده پرداخت)</h2>
    <div id="alert-container"></div>
    <form id="pay-form">
        <button type="button" id="pay-selected-btn" class="btn btn-primary mb-3">پرداخت انتخاب شده‌ها</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th>کاربر</th>
                <th>مبلغ</th>
                <th>شماره شبا</th>
                <th>وضعیت پرداخت</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td><input type="checkbox" class="expense-checkbox" name="expense_ids[]" value="{{ $expense->id }}" @if($expense->payment) disabled @endif></td>
                    <td>{{ $expense->user->name }}</td>
                    <td>{{ number_format($expense->amount) }}</td>
                    <td>{{ $expense->shaba_number }}</td>
                    <td>
                        @if($expense->payment)
                            <span class="badge bg-{{ $expense->payment->status === 'success' ? 'success' : 'danger' }}">
                                {{ $expense->payment->status }}
                            </span>
                        @else
                            <span class="badge bg-secondary">در انتظار پرداخت</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">هیچ درخواست تایید شده‌ای وجود ندارد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function(e) {
        document.querySelectorAll('.expense-checkbox:not(:disabled)').forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });

    const payExpenses = (expenseIds) => {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = '';
        const btn = document.getElementById('pay-selected-btn');
        btn.disabled = true;
        btn.innerText = 'در حال ارسال به صف...';

        fetch('/api/payments/process-selected', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ expense_ids: expenseIds })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message || 'خطایی رخ داد.') });
            }
            return response.json();
        })
        .then(data => {
            alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            setTimeout(() => window.location.reload(), 2000);
        })
        .catch(error => {
            alertContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
            btn.disabled = false;
            btn.innerText = 'پرداخت انتخاب شده‌ها';
        });
    };

    document.getElementById('pay-selected-btn').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.expense-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) {
            alert('لطفا حداقل یک درخواست را انتخاب کنید.');
            return;
        }
        payExpenses(selectedIds);
    });
</script>
@endpush 