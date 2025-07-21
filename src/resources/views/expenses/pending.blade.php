@extends('layouts.app')

@section('content')
    <h2>درخواست‌های در انتظار تایید</h2>
    <div id="alert-container"></div>
    <form id="process-pending-form">
        <div class="mb-3">
            <button type="button" id="approve-btn" class="btn btn-success">تایید انتخاب شده‌ها</button>
            <div class="input-group d-inline-block w-auto">
                <input type="text" id="rejection-reason" class="form-control d-inline w-auto" placeholder="دلیل رد (اختیاری)">
                <button type="button" id="reject-btn" class="btn btn-danger">رد انتخاب شده‌ها</button>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>کاربر</th>
                    <th>نوع هزینه</th>
                    <th>مبلغ</th>
                    <th>شرح</th>
                    <th>پیوست</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td><input type="checkbox" class="expense-checkbox" name="expense_ids[]" value="{{ $expense->id }}"></td>
                        <td>{{ $expense->user->name }}</td>
                        <td>{{ $expense->category->title }}</td>
                        <td>{{ number_format($expense->amount) }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>
                            @foreach($expense->attachments as $attachment)
                                <a href="/api/attachments/{{ $attachment->id }}/download">دانلود</a>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">هیچ درخواست در انتظاری وجود ندارد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>
@endsection

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function(e) {
        document.querySelectorAll('.expense-checkbox').forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });

    const processExpenses = (url, body) => {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = ''; // Clear previous alerts

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(body)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message || 'خطایی رخ داد.') });
            }
            return response.json();
        })
        .then(data => {
            alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            setTimeout(() => window.location.reload(), 1000);
        })
        .catch(error => {
            alertContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        });
    };

    document.getElementById('approve-btn').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.expense-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) {
            alert('لطفا حداقل یک درخواست را انتخاب کنید.');
            return;
        }
        processExpenses('/api/expenses/approve', { expense_ids: selectedIds });
    });

    document.getElementById('reject-btn').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.expense-checkbox:checked')).map(cb => cb.value);
        const reason = document.getElementById('rejection-reason').value;
        if (selectedIds.length === 0) {
            alert('لطفا حداقل یک درخواست را انتخاب کنید.');
            return;
        }
        processExpenses('/api/expenses/reject', { expense_ids: selectedIds, rejection_reason: reason });
    });
</script>
@endpush 