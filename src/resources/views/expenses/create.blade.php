@extends('layouts.app')

@section('content')
    <h2>ثبت درخواست هزینه جدید</h2>
    <div id="alert-container"></div>
    <form id="create-expense-form" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="national_code" class="form-label">کاربر (بر اساس کد ملی)</label>
            <select class="form-select" id="national_code" name="national_code" required>
                @foreach($users as $user)
                    <option value="{{ $user->national_code }}">{{ $user->name }} ({{ $user->national_code }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="expense_category_id" class="form-label">نوع هزینه</label>
            <select class="form-select" id="expense_category_id" name="expense_category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">مبلغ</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="shaba_number" class="form-label">شماره شبا</label>
            <input type="text" class="form-control" id="shaba_number" name="shaba_number" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">شرح</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="attachment" class="form-label">فایل پیوست</label>
            <input class="form-control" type="file" id="attachment" name="attachment">
        </div>
        <button type="submit" class="btn btn-primary">ثبت درخواست</button>
    </form>
@endsection

@push('scripts')
<script>
document.getElementById('create-expense-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = ''; // Clear previous alerts

    fetch('/api/expenses', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(errorData => {
                const message = errorData.message || 'خطای اعتبارسنجی';
                const errors = errorData.errors ? Object.values(errorData.errors).flat().join('<br>') : 'لطفا ورودی‌ها را بررسی کنید.';
                throw new Error(`${message}<br>${errors}`);
            });
        }
        return response.json();
    })
    .then(data => {
        alertContainer.innerHTML = `<div class="alert alert-success">درخواست با موفقیت ثبت شد.</div>`;
        this.reset();
    })
    .catch(error => {
        alertContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
    });
});
</script>
@endpush 