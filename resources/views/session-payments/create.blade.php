@extends('layouts.app')

@section('title', 'إضافة مدفوعة جلسة جديدة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إضافة مدفوعة جلسة جديدة</h1>
    <div>
        <a href="{{ route('session-payments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> العودة للقائمة
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">تفاصيل المدفوعة</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('session-payments.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="session_id" class="form-label">الجلسة <span class="text-danger">*</span></label>
                    <select class="form-select @error('session_id') is-invalid @enderror" 
                            id="session_id" name="session_id" required>
                        <option value="">اختر الجلسة</option>
                        @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ (old('session_id') == $session->id || (isset($selectedSessionId) && $selectedSessionId == $session->id)) ? 'selected' : '' }}>
                            #{{ $session->id }} - {{ $session->user->name }} 
     
                            {{ $session->start_at->format('Y-m-d H:i') }}
                        </option>
                        @endforeach
                    </select>
                    @error('session_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">اختر الجلسة التي تريد إضافة مدفوعة لها</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="total_price" class="form-label">السعر الإجمالي <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0" 
                               class="form-control @error('total_price') is-invalid @enderror" 
                               id="total_price" name="total_price" value="{{ old('total_price') }}" required>
                        @error('total_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        <i class="bi bi-info-circle"></i>
                        يجب أن يكون: <strong>سعر الإنترنت + إجمالي المشروبات</strong>
                    </small>
                    <div id="suggested_total_info" class="alert alert-info mt-2 py-2" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <small>
                                <i class="bi bi-lightbulb"></i>
                                <strong>اقتراح:</strong> 
                                <span id="suggested_calculation"></span> = 
                                <strong id="suggested_total_amount">$0.00</strong>
                            </small>
                            <button type="button" class="btn btn-sm btn-outline-info" 
                                    onclick="setSuggestedTotal()">
                                <i class="bi bi-check-circle"></i> استخدم هذا المبلغ
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount_bank" class="form-label">المبلغ المدفوع بنكياً</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0" 
                               class="form-control @error('amount_bank') is-invalid @enderror" 
                               id="amount_bank" name="amount_bank" value="{{ old('amount_bank', 0) }}">
                        @error('amount_bank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">المبلغ المدفوع عبر البنك أو التحويل الإلكتروني</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="amount_cash" class="form-label">المبلغ المدفوع كاش</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0" 
                               class="form-control @error('amount_cash') is-invalid @enderror" 
                               id="amount_cash" name="amount_cash" value="{{ old('amount_cash', 0) }}">
                        @error('amount_cash')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">المبلغ المدفوع نقداً</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label">حالة الدفع <span class="text-danger">*</span></label>
                    <select class="form-select @error('payment_status') is-invalid @enderror" 
                            id="payment_status" name="payment_status" required>
                        <option value="">اختر حالة الدفع</option>
                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>مدفوعة بالكامل</option>
                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                        <option value="cancelled" {{ old('payment_status') == 'cancelled' ? 'selected' : '' }}>ملغية</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">سيتم تحديث الحالة تلقائياً بناءً على المبالغ المدفوعة</small>
                </div>
                
            </div>

            <!-- ملخص المدفوعات -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-white">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-exclamation-triangle"></i>
                                المبلغ المتبقي
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="h3 text-danger fw-bold mb-2" id="remaining_amount_display">
                                $0.00
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-calculator"></i>
                                محسوب تلقائياً
                            </small>
                            <input type="hidden" id="remaining_amount" value="0">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-check-circle"></i>
                                إجمالي المدفوع
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="h3 text-success fw-bold mb-2" id="total_paid_display">
                                $0.00
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-calculator"></i>
                                محسوب تلقائياً
                            </small>
                            <input type="hidden" id="total_paid" value="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- المبلغ المستحق للزبون -->
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-cash-coin"></i>
                                المبلغ المستحق للزبون
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="h5 text-primary mb-1" id="session_total_display">$0.00</div>
                                    <small class="text-muted">إجمالي تكلفة الجلسة</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="h5 text-warning mb-1" id="total_paid_display_wallet">$0.00</div>
                                    <small class="text-muted">إجمالي المدفوع</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="h5 text-success mb-1" id="refund_amount_display">$0.00</div>
                                    <small class="text-muted" id="refund_status_text">المبلغ المستحق للزبون</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>الحساب:</strong> إجمالي المدفوع - إجمالي تكلفة الجلسة = المبلغ المستحق للزبون
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- حقل الملاحظة -->
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="note" class="form-label">
                        ملاحظة الدفع
                        <span id="note_required_indicator" class="text-danger d-none">*</span>
                    </label>
                    <textarea class="form-control @error('note') is-invalid @enderror" 
                              id="note" name="note" rows="3" 
                              placeholder="اكتب ملاحظة حول الدفع (اختياري)">{{ old('note') }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted" id="note_help_text">
                        يمكنك إضافة ملاحظة حول الدفع أو أي تفاصيل إضافية
                    </small>
                    <small class="form-text text-danger d-none" id="note_required_text">
                        <i class="bi bi-exclamation-triangle"></i>
                        الملاحظة مطلوبة عندما يكون هناك مبلغ مستحق للزبون
                    </small>
                </div>
            </div>

            <!-- معلومات إضافية -->
            <div class="alert alert-info">
                <h6><i class="bi bi-info-circle"></i> ملاحظات مهمة:</h6>
                <ul class="mb-0">
                    <li>سيتم حساب المبلغ المتبقي تلقائياً</li>
                    <li>سيتم تحديث حالة الدفع تلقائياً بناءً على المبالغ المدفوعة</li>
                    <li>إذا كان إجمالي المبلغ المدفوع يساوي أو يزيد عن السعر الإجمالي، ستصبح الحالة "مدفوعة بالكامل"</li>
                    <li>إذا كان هناك مبلغ مدفوع ولكن أقل من الإجمالي، ستصبح الحالة "مدفوعة جزئياً"</li>
                </ul>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('session-payments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> إلغاء
                </a>
                <button type="submit" class="btn btn-primary" onclick="return validateForm()">
                    <i class="bi bi-save"></i> حفظ المدفوعة
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<style>
    .text-success {
        color: #198754 !important;
    }
    
    .text-secondary {
        color: #6c757d !important;
    }
    
    .text-muted.text-success {
        color: #198754 !important;
    }
    
    .text-muted.text-secondary {
        color: #6c757d !important;
    }
</style>
@endsection

@section('scripts')
<script>
// Session data for calculations
const sessionsData = @json($sessions->map(function($session) {
    return [
        'id' => $session->id,
        'internet_cost' => $session->calculateInternetCost(),
        'drinks_cost' => $session->drinks->sum('price'),
        'suggested_total' => $session->calculateInternetCost() + $session->drinks->sum('price')
    ];
}));

document.addEventListener('DOMContentLoaded', function() {
    const sessionSelect = document.getElementById('session_id');
    const totalPrice = document.getElementById('total_price');
    const amountBank = document.getElementById('amount_bank');
    const amountCash = document.getElementById('amount_cash');
    const remainingAmount = document.getElementById('remaining_amount');
    const paymentStatus = document.getElementById('payment_status');

    // Function to update suggested total when session changes
    function updateSuggestedTotal() {
        const selectedSessionId = sessionSelect.value;
        const suggestedInfo = document.getElementById('suggested_total_info');
        const suggestedCalculation = document.getElementById('suggested_calculation');
        const suggestedTotalAmount = document.getElementById('suggested_total_amount');
        
        // Elements for refund calculation
        const sessionTotalDisplay = document.getElementById('session_total_display');
        const totalPaidDisplayWallet = document.getElementById('total_paid_display_wallet');
        const refundAmountDisplay = document.getElementById('refund_amount_display');
        const refundStatusText = document.getElementById('refund_status_text');
        
        if (selectedSessionId) {
            const sessionData = sessionsData.find(s => s.id == selectedSessionId);
            if (sessionData) {
                // Update suggested total
                suggestedCalculation.textContent = `تكلفة الإنترنت ($${sessionData.internet_cost.toFixed(2)}) + المشروبات ($${sessionData.drinks_cost.toFixed(2)})`;
                suggestedTotalAmount.textContent = `$${sessionData.suggested_total.toFixed(2)}`;
                suggestedInfo.style.display = 'block';
                
                // Update refund calculation
                const sessionTotal = sessionData.suggested_total;
                const bankAmount = parseFloat(amountBank.value) || 0;
                const cashAmount = parseFloat(amountCash.value) || 0;
                const totalPaid = bankAmount + cashAmount;
                const refundAmount = Math.max(0, totalPaid - sessionTotal);
                
                sessionTotalDisplay.textContent = `$${sessionTotal.toFixed(2)}`;
                totalPaidDisplayWallet.textContent = `$${totalPaid.toFixed(2)}`;
                refundAmountDisplay.textContent = `$${refundAmount.toFixed(2)}`;
                
                // Change color based on refund amount
                if (refundAmount > 0) {
                    refundAmountDisplay.className = 'h4 text-success fw-bold mb-1';
                } else {
                    refundAmountDisplay.className = 'h4 text-danger fw-bold mb-1';
                }
                
                // Update refund status text
                if (refundStatusText) {
                    if (refundAmount > 0) {
                        refundStatusText.textContent = 'مستحق للزبون';
                        refundStatusText.className = 'text-muted text-success';
                    } else {
                        refundStatusText.textContent = 'لا يوجد مستحقات';
                        refundStatusText.className = 'text-muted text-secondary';
                    }
                }
                
                // Update note requirement
                updateNoteRequirement(refundAmount);
            }
        } else {
            suggestedInfo.style.display = 'none';
            sessionTotalDisplay.textContent = '$0.00';
            totalPaidDisplayWallet.textContent = '$0.00';
            refundAmountDisplay.textContent = '$0.00';
            
            // Reset refund status text
            if (refundStatusText) {
                refundStatusText.textContent = 'لا يوجد مستحقات';
                refundStatusText.className = 'text-muted text-secondary';
            }
        }
    }

    function calculateRemaining() {
        const total = parseFloat(totalPrice.value) || 0;
        const bank = parseFloat(amountBank.value) || 0;
        const cash = parseFloat(amountCash.value) || 0;
        
        // Force numeric values
        if (isNaN(bank)) amountBank.value = '0';
        if (isNaN(cash)) amountCash.value = '0';
        
        const totalPaid = bank + cash;
        const remaining = Math.max(0, total - totalPaid);
        
        // Update hidden inputs
        remainingAmount.value = remaining.toFixed(2);
        
        // Update display elements
        const remainingDisplay = document.getElementById('remaining_amount_display');
        const totalPaidDisplay = document.getElementById('total_paid_display');
        
        if (remainingDisplay) {
            remainingDisplay.textContent = '$' + remaining.toFixed(2);
            // Change color based on remaining amount
            if (remaining > 0) {
                remainingDisplay.className = 'h3 text-danger fw-bold mb-2';
            } else {
                remainingDisplay.className = 'h3 text-success fw-bold mb-2';
            }
        }
        
        if (totalPaidDisplay) {
            totalPaidDisplay.textContent = '$' + totalPaid.toFixed(2);
        }
        
        // Auto-update payment status
        if (total > 0) {
            if (totalPaid >= total) {
                paymentStatus.value = 'paid';
            } else if (totalPaid > 0) {
                paymentStatus.value = 'partial';
            } else {
                paymentStatus.value = 'pending';
            }
        }
    }

    // Add event listeners for real-time updates
    sessionSelect.addEventListener('change', updateSuggestedTotal);
    totalPrice.addEventListener('input', calculateRemaining);
    totalPrice.addEventListener('change', calculateRemaining);
    amountBank.addEventListener('input', function() {
        calculateRemaining();
        updateSuggestedTotal();
    });
    amountBank.addEventListener('change', function() {
        calculateRemaining();
        updateSuggestedTotal();
    });
    amountCash.addEventListener('input', function() {
        calculateRemaining();
        updateSuggestedTotal();
    });
    amountCash.addEventListener('change', function() {
        calculateRemaining();
        updateSuggestedTotal();
    });
    
    // Add event listeners for paste events
    amountBank.addEventListener('paste', function() {
        setTimeout(function() {
            calculateRemaining();
            updateSuggestedTotal();
        }, 100);
    });
    amountCash.addEventListener('paste', function() {
        setTimeout(function() {
            calculateRemaining();
            updateSuggestedTotal();
        }, 100);
    });

    // Initial calculations with delay to ensure DOM is ready
    setTimeout(function() {
        updateSuggestedTotal();
        calculateRemaining();
    }, 100);
});

// Function to set suggested total
function setSuggestedTotal() {
    const sessionSelect = document.getElementById('session_id');
    const totalPrice = document.getElementById('total_price');
    const selectedSessionId = sessionSelect.value;
    
    if (selectedSessionId) {
        const sessionData = sessionsData.find(s => s.id == selectedSessionId);
        if (sessionData) {
            totalPrice.value = sessionData.suggested_total.toFixed(2);
            
            // Trigger calculations immediately
            setTimeout(function() {
                calculateRemaining();
                updateSuggestedTotal();
            }, 10);
        }
    }
}

// Function to update note requirement
function updateNoteRequirement(refundAmount) {
    const noteField = document.getElementById('note');
    const noteRequiredIndicator = document.getElementById('note_required_indicator');
    const noteHelpText = document.getElementById('note_help_text');
    const noteRequiredText = document.getElementById('note_required_text');
    
    if (refundAmount > 0) {
        // Note is required
        noteField.required = true;
        noteRequiredIndicator.classList.remove('d-none');
        noteHelpText.classList.add('d-none');
        noteRequiredText.classList.remove('d-none');
        noteField.classList.add('border-warning');
        
        // Add validation on blur
        noteField.addEventListener('blur', validateNoteField);
    } else {
        // Note is optional
        noteField.required = false;
        noteRequiredIndicator.classList.add('d-none');
        noteHelpText.classList.remove('d-none');
        noteRequiredText.classList.add('d-none');
        noteField.classList.remove('border-warning', 'border-danger');
        noteField.classList.remove('is-invalid');
    }
}

// Function to validate note field
function validateNoteField() {
    const noteField = document.getElementById('note');
    const noteValue = noteField.value.trim();
    
    if (noteField.required && noteValue === '') {
        noteField.classList.add('is-invalid', 'border-danger');
        noteField.classList.remove('border-warning');
    } else {
        noteField.classList.remove('is-invalid', 'border-danger');
        if (noteField.required) {
            noteField.classList.add('border-warning');
        }
    }
}

// Function to validate form before submission
function validateForm() {
    const sessionSelect = document.getElementById('session_id');
    const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
    const amountBank = parseFloat(document.getElementById('amount_bank').value) || 0;
    const amountCash = parseFloat(document.getElementById('amount_cash').value) || 0;
    const noteField = document.getElementById('note');
    
    // Get session data
    const selectedSessionId = sessionSelect.value;
    const sessionData = sessionsData.find(s => s.id == selectedSessionId);
    
    if (!sessionData) {
        alert('يرجى اختيار جلسة');
        return false;
    }
    
    const totalPaid = amountBank + amountCash;
    const refundAmount = Math.max(0, totalPaid - sessionData.suggested_total);
    
    // Check if note is required but empty
    if (refundAmount > 0 && noteField.value.trim() === '') {
        noteField.classList.add('is-invalid', 'border-danger');
        noteField.classList.remove('border-warning');
        noteField.focus();
        
        // Show error message
        showCopyMessage('يرجى إدخال ملاحظة عندما يكون هناك مبلغ مستحق للزبون', 'danger');
        
        return false;
    }
    
    return true;
}

// Function to show copy message
function showCopyMessage(message, type = 'success') {
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    messageDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    messageDiv.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(messageDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 3000);
}
</script>
@endsection