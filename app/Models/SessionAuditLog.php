<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'action',
        'action_type',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // العلاقات
    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope للبحث
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByActionType($query, $actionType)
    {
        return $query->where('action_type', $actionType);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Helper methods
    public function getActionDisplayName()
    {
        $actions = [
            'create' => 'إنشاء',
            'update' => 'تحديث',
            'delete' => 'حذف',
            'add_drink' => 'إضافة مشروب',
            'remove_drink' => 'حذف مشروب',
            'toggle_payment' => 'تغيير حالة الدفع',
            'update_internet_cost' => 'تحديث تكلفة الإنترنت',
            'end_session' => 'إنهاء الجلسة',
            'session_cancelled' => 'إلغاء الجلسة',
            'create_payment' => 'إنشاء مدفوعة',
            'update_payment' => 'تحديث مدفوعة',
            'full_bank_payment' => 'دفع بنكي كامل',
            'update_drink_date' => 'تحديث تاريخ المشروب',
            'update_drink_price' => 'تحديث سعر المشروب',
            'generate_invoice' => 'إنشاء ملف PDF للفاتورة',
        ];

        return $actions[$this->action] ?? $this->action;
    }

    public function getActionTypeDisplayName()
    {
        $types = [
            'session' => 'الجلسة',
            'payment' => 'الدفع',
            'drink' => 'المشروب',
            'internet_cost' => 'تكلفة الإنترنت',
            'drink_invoice' => 'فاتورة المشروبات',
        ];

        return $types[$this->action_type] ?? $this->action_type;
    }

    public function getFormattedDescription()
    {
        return $this->description;
    }

    public function hasAuditChanges()
    {
        return !empty($this->old_values) || !empty($this->new_values);
    }

    public function getChangesSummary()
    {
        if (!$this->hasAuditChanges()) {
            return null;
        }

        $changes = [];
        
        // Ensure old_values and new_values are arrays
        $oldValues = is_string($this->old_values) ? json_decode($this->old_values, true) : $this->old_values;
        $newValues = is_string($this->new_values) ? json_decode($this->new_values, true) : $this->new_values;
        
        // Ensure they are arrays (not null or other types)
        $oldValues = is_array($oldValues) ? $oldValues : [];
        $newValues = is_array($newValues) ? $newValues : [];
        
        if (!empty($oldValues) && !empty($newValues)) {
            foreach ($newValues as $key => $newValue) {
                $oldValue = $oldValues[$key] ?? null;
                if ($oldValue !== $newValue) {
                    $changes[] = "تغيير $key من '$oldValue' إلى '$newValue'";
                }
            }
        }

        return implode(', ', $changes);
    }
}
